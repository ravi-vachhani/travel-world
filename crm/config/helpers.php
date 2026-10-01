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

/**
 * Get an existing customer by mobile, or create one if none exists. This is the
 * single entry point every module should use so a customer is never duplicated
 * and the customer database stays clean.
 *
 * @param array $info  ['name'=>, 'phone'=>, 'email'=>, 'alt_phone'=>, 'city'=>, ...]
 * @return array ['id'=>customerId, 'customer'=>row, 'created'=>bool] or
 *               ['id'=>'', 'error'=>msg] when phone/name missing.
 */
function crm_get_or_create_customer(array $info): array {
    $phone = trim($info['phone'] ?? '');
    $name  = trim($info['name'] ?? '');
    $norm  = crm_normalize_mobile($phone);

    if ($norm === '') {
        return ['id' => '', 'created' => false, 'error' => 'A valid mobile number is required.'];
    }

    // 1) Reuse an existing customer with the same normalised mobile.
    $existing = crm_find_customer_by_mobile($phone);
    if ($existing) {
        // Backfill a missing normalised value / name on the legacy record.
        $patch = [];
        if (empty($existing['mobile_normalized'])) $patch['mobile_normalized'] = $norm;
        if (empty($existing['name']) && $name !== '') $patch['name'] = $name;
        if ($patch) supabase()->updateDocument(COL_CUSTOMERS, $existing['$id'], $patch);
        return ['id' => $existing['$id'], 'customer' => $existing, 'created' => false];
    }

    // 2) Create a new, clean customer record.
    if ($name === '') $name = 'Customer ' . $norm;   // never create nameless rows
    $data = [
        'name'              => $name,
        'phone'             => $phone,
        'mobile_normalized' => $norm,
        'email'             => trim($info['email'] ?? ''),
        'alt_phone'         => trim($info['alt_phone'] ?? ''),
        'city'              => trim($info['city'] ?? ''),
        'state'             => trim($info['state'] ?? ''),
        'country'           => trim($info['country'] ?? 'India'),
        'address'           => trim($info['address'] ?? ''),
        'enquiry_count'     => 0,
        'booking_count'     => 0,
    ];
    $res = supabase()->createDocument(COL_CUSTOMERS, $data);
    if (!empty($res['$id'])) {
        return ['id' => $res['$id'], 'customer' => $res, 'created' => true];
    }
    return ['id' => '', 'created' => false, 'error' => 'Could not create customer.'];
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
