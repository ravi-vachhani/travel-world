<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('documents.edit');

$id     = $_GET['id']     ?? '';
$status = $_GET['status'] ?? 'verified';
if (!$id || !in_array($status, ['verified','rejected','pending'])) {
    header('Location: /crm/documents/');
    exit;
}

$db = appwrite();
$db->updateDocument(COL_DOCUMENTS, $id, ['status' => $status]);
header('Location: /crm/documents/?updated=1');
exit;