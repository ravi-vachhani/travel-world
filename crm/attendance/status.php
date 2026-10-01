<?php
/** Returns the current user's open punch session (if any) as JSON. */
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();

$u   = crm_current_user();
$uid = $u['id'] ?? '';

$latest = supabase()->listDocuments(COL_ATTENDANCE, [
    'equal("user_id","' . addslashes($uid) . '")',
    'orderDesc("punch_in")',
    'limit(1)',
]);
$row = $latest['documents'][0] ?? null;

// A row counts as "open" only when punch_in is set and punch_out is empty/null.
$isOpen = $row && !empty($row['punch_in']) && empty($row['punch_out']);

crm_json([
    'open'     => (bool)$isOpen,
    'punch_in' => $isOpen ? ($row['punch_in'] ?? null) : null,
    'id'       => $isOpen ? ($row['$id'] ?? null) : null,
]);
