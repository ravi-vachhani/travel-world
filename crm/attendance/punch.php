<?php
/** Punch in or out for the current user. POST action=in|out. Returns status JSON. */
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    crm_json(['error' => 'method_not_allowed'], 405);
}

$u      = crm_current_user();
$uid    = $u['id'] ?? '';
$action = $_POST['action'] ?? '';

// Find the latest session to know current open/closed state.
$latest = supabase()->listDocuments(COL_ATTENDANCE, [
    'equal("user_id","' . addslashes($uid) . '")',
    'orderDesc("punch_in")',
    'limit(1)',
]);
$row    = $latest['documents'][0] ?? null;
$isOpen = $row && !empty($row['punch_in']) && empty($row['punch_out']);

if ($action === 'in') {
    if ($isOpen) {
        // Already punched in — just report current state.
        crm_json(['open' => true, 'punch_in' => $row['punch_in'], 'id' => $row['$id']]);
    }
    $now = date('c');
    $res = supabase()->createDocument(COL_ATTENDANCE, [
        'user_id'   => $uid,
        'user_name' => $u['name'] ?? '',
        'work_date' => date('Y-m-d'),
        'punch_in'  => $now,
        'punch_out' => null,
    ]);
    crm_json(['open' => true, 'punch_in' => $now, 'id' => $res['$id'] ?? null]);
}

if ($action === 'out') {
    if (!$isOpen) {
        crm_json(['open' => false, 'punch_in' => null, 'id' => null]);
    }
    $inTs  = strtotime($row['punch_in']);
    $outTs = time();
    $mins  = max(0, (int)round(($outTs - $inTs) / 60));
    supabase()->updateDocument(COL_ATTENDANCE, $row['$id'], [
        'punch_out'      => date('c', $outTs),
        'worked_minutes' => $mins,
    ]);
    crm_json(['open' => false, 'punch_in' => null, 'id' => null, 'worked_minutes' => $mins]);
}

crm_json(['error' => 'bad_action'], 400);
