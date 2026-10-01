<?php
/**
 * Customer lookup by mobile number (duplicate check + context).
 * GET ?mobile=98765 43210
 * Returns { found, customer:{id,name,phone,email,...}, counts:{...} } or { found:false }.
 */
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();

$mobile = $_GET['mobile'] ?? '';
$norm   = crm_normalize_mobile($mobile);

if (strlen($norm) < 10) {
    crm_json(['found' => false, 'normalized' => $norm]);
}

$customer = crm_find_customer_by_mobile($mobile);
if (!$customer) {
    crm_json(['found' => false, 'normalized' => $norm]);
}

$counts = crm_customer_counts($customer['$id']);

crm_json([
    'found'      => true,
    'normalized' => $norm,
    'customer'   => [
        'id'        => $customer['$id'],
        'name'      => $customer['name'] ?? '',
        'phone'     => $customer['phone'] ?? '',
        'alt_phone' => $customer['alt_phone'] ?? '',
        'email'     => $customer['email'] ?? '',
        'city'      => $customer['city'] ?? '',
        'state'     => $customer['state'] ?? '',
        'country'   => $customer['country'] ?? '',
        'address'   => $customer['address'] ?? '',
    ],
    'counts' => $counts,
]);
