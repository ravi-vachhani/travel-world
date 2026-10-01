<?php
/**
 * Shared small utilities used across the CRM.
 */

require_once __DIR__ . '/supabase.php';
require_once __DIR__ . '/supabase-client.php';

/**
 * Normalise an Indian mobile number to a canonical 10-digit form so the same
 * person is never stored/looked-up twice. Handles:
 *   9876543210, +91 9876543210, 919876543210, 98765 43210, 98765-43210, 0 prefix
 * Returns the last 10 digits (Indian subscriber number) or '' when < 10 digits.
 */
function crm_normalize_mobile(string $raw): string {
    $digits = preg_replace('/\D+/', '', $raw);   // keep digits only
    if ($digits === '') return '';
    // Strip common country/trunk prefixes.
    if (strlen($digits) > 10) {
        if (strpos($digits, '91') === 0 && strlen($digits) === 12) {
            $digits = substr($digits, 2);        // 91XXXXXXXXXX
        } elseif ($digits[0] === '0' && strlen($digits) === 11) {
            $digits = substr($digits, 1);        // 0XXXXXXXXXX
        } else {
            $digits = substr($digits, -10);      // fall back to last 10
        }
    }
    return $digits;
}

/** Pretty display form: +91 98765 43210 (falls back to raw for non-10-digit). */
function crm_format_mobile(string $raw): string {
    $n = crm_normalize_mobile($raw);
    if (strlen($n) === 10) {
        return '+91 ' . substr($n, 0, 5) . ' ' . substr($n, 5);
    }
    return $raw;
}

/**
 * Find an existing customer by (normalised) mobile. Returns the customer doc or
 * null. Checks the mobile_normalized column first, then falls back to a search
 * on the raw phone column for rows created before normalisation existed.
 */
function crm_find_customer_by_mobile(string $raw): ?array {
    $norm = crm_normalize_mobile($raw);
    if ($norm === '') return null;

    $res = supabase()->listDocuments(COL_CUSTOMERS, [
        'equal("mobile_normalized","' . $norm . '")',
        'limit(1)',
    ]);
    if (!empty($res['documents'][0])) return $res['documents'][0];

    // Legacy fallback: match the last 10 digits against the phone field.
    $res = supabase()->listDocuments(COL_CUSTOMERS, [
        'search("phone","' . $norm . '")',
        'limit(5)',
    ]);
    foreach (($res['documents'] ?? []) as $c) {
        if (crm_normalize_mobile($c['phone'] ?? '') === $norm) return $c;
    }
    return null;
}

/** Count related records for a customer (used by lookup + context panels). */
function crm_customer_counts(string $customerId): array {
    $count = function (string $table, string $field) use ($customerId): int {
        $r = supabase()->listDocuments($table, [
            'equal("' . $field . '","' . addslashes($customerId) . '")',
            'limit(1)',
        ]);
        return $r['total'] ?? count($r['documents'] ?? []);
    };
    return [
        'enquiries'  => $count(COL_ENQUIRIES,  'customer_id'),
        'quotations' => $count(COL_QUOTATIONS, 'customer_id'),
        'bookings'   => $count(COL_BOOKINGS,   'customer_id'),
        'followups'  => $count(COL_FOLLOWUPS,  'customer_id'),
    ];
}

/** JSON response helper for API endpoints. */
function crm_json($data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
