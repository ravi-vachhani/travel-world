<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/followups/'); exit; }

$db = appwrite();
$db->updateDocument(COL_FOLLOWUPS, $id, ['done' => true]);
header('Location: /crm/followups/?filter=today&done=1');
exit;