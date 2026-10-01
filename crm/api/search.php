<?php
/**
 * Debounced, server-side autocomplete for reference fields.
 * GET ?type=customer|enquiry|quotation|booking|user|destination&q=rah
 * Returns { results: [ {id,label,sub,data{...}} ] } — capped & indexed.
 */
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();

$type = $_GET['type'] ?? '';
$q    = trim($_GET['q'] ?? '');
$db   = supabase();
$out  = [];

if (strlen($q) < 2) {
    crm_json(['results' => []]);
}

$esc    = addslashes($q);
$digits = crm_normalize_mobile($q);
$limit  = 'limit(8)';

switch ($type) {

    case 'customer':
        // If the query looks like a number, search by mobile; else by name.
        if (preg_match('/^\+?\d[\d\s\-]+$/', $q) && strlen($digits) >= 4) {
            $rows = $db->listDocuments(COL_CUSTOMERS, ['search("phone","' . $digits . '")', $limit])['documents'] ?? [];
            if (!$rows && strlen($digits) === 10) {
                $rows = $db->listDocuments(COL_CUSTOMERS, ['equal("mobile_normalized","' . $digits . '")', $limit])['documents'] ?? [];
            }
        } else {
            $rows = $db->listDocuments(COL_CUSTOMERS, ['search("name","' . $esc . '")', $limit])['documents'] ?? [];
        }
        foreach ($rows as $r) {
            $out[] = [
                'id'    => $r['$id'],
                'label' => $r['name'] ?? '—',
                'sub'   => crm_format_mobile($r['phone'] ?? '') . ($r['city'] ? ' · ' . $r['city'] : ''),
                'data'  => [
                    'name' => $r['name'] ?? '', 'phone' => $r['phone'] ?? '',
                    'alt_phone' => $r['alt_phone'] ?? '', 'email' => $r['email'] ?? '',
                    'city' => $r['city'] ?? '', 'state' => $r['state'] ?? '',
                    'country' => $r['country'] ?? '', 'address' => $r['address'] ?? '',
                ],
            ];
        }
        break;

    case 'enquiry':
        $rows = $db->listDocuments(COL_ENQUIRIES, ['search("destination","' . $esc . '")', $limit])['documents'] ?? [];
        if (!$rows) $rows = $db->listDocuments(COL_ENQUIRIES, ['search("customer_name","' . $esc . '")', $limit])['documents'] ?? [];
        foreach ($rows as $r) {
            $out[] = [
                'id'    => $r['$id'],
                'label' => ($r['enquiry_id'] ?? substr($r['$id'],0,8)) . ' — ' . ($r['customer_name'] ?? '') . ' — ' . ($r['destination'] ?? ''),
                'sub'   => ucfirst($r['service_type'] ?? '') . ' · ' . ($r['travel_date'] ?? ''),
                'data'  => $r,
            ];
        }
        break;

    case 'quotation':
        $rows = $db->listDocuments(COL_QUOTATIONS, ['search("customer_name","' . $esc . '")', $limit])['documents'] ?? [];
        if (!$rows) $rows = $db->listDocuments(COL_QUOTATIONS, ['search("destination","' . $esc . '")', $limit])['documents'] ?? [];
        foreach ($rows as $r) {
            $out[] = [
                'id'    => $r['$id'],
                'label' => ($r['quotation_id'] ?? substr($r['$id'],0,8)) . ' — ' . ($r['customer_name'] ?? ''),
                'sub'   => ($r['destination'] ?? '') . ' · ₹' . number_format((float)($r['total'] ?? 0)),
                'data'  => $r,
            ];
        }
        break;

    case 'booking':
        $rows = $db->listDocuments(COL_BOOKINGS, ['search("customer_name","' . $esc . '")', $limit])['documents'] ?? [];
        if (!$rows) $rows = $db->listDocuments(COL_BOOKINGS, ['search("destination","' . $esc . '")', $limit])['documents'] ?? [];
        foreach ($rows as $r) {
            $out[] = [
                'id'    => $r['$id'],
                'label' => ($r['booking_id'] ?? substr($r['$id'],0,8)) . ' — ' . ($r['customer_name'] ?? ''),
                'sub'   => ($r['destination'] ?? '') . ' · ' . ($r['travel_date'] ?? ''),
                'data'  => $r,
            ];
        }
        break;

    case 'user':      // salesperson picker
        $rows = $db->listDocuments(COL_USERS, ['search("name","' . $esc . '")', $limit])['documents'] ?? [];
        foreach ($rows as $r) {
            $out[] = ['id' => $r['$id'], 'label' => $r['name'] ?? '', 'sub' => ucwords(str_replace('_',' ', $r['role'] ?? '')), 'data' => ['name' => $r['name'] ?? '']];
        }
        break;

    case 'destination':
        // Suggest from existing enquiries/bookings destinations (deduped).
        $seen = [];
        foreach ([COL_ENQUIRIES, COL_BOOKINGS] as $t) {
            $rows = $db->listDocuments($t, ['search("destination","' . $esc . '")', 'limit(15)'])['documents'] ?? [];
            foreach ($rows as $r) {
                $d = trim($r['destination'] ?? '');
                if ($d && !isset($seen[strtolower($d)])) {
                    $seen[strtolower($d)] = true;
                    $out[] = ['id' => $d, 'label' => $d, 'sub' => '', 'data' => ['destination' => $d]];
                }
            }
        }
        $out = array_slice($out, 0, 8);
        break;

    default:
        crm_json(['error' => 'unknown_type', 'results' => []], 400);
}

crm_json(['results' => $out]);
