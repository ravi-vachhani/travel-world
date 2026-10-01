<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('users.edit');

$pageTitle = 'Edit User';
$activeNav = 'Users';
$error = '';

$db = supabase();
$id = $_GET['id'] ?? '';
$u  = $db->getDocument(COL_USERS, $id);
if (empty($u['$id'])) { header('Location: /crm/users/'); exit; }

$roles = $db->listDocuments(COL_ROLES, ['orderAsc("label")', 'limit(100)'])['documents'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $role = $_POST['role'] ?? ($u['role'] ?? 'viewer');
    if ($name === '') {
        $error = 'Name is required.';
    } else {
        $data = [
            'name'        => $name,
            'mobile'      => trim($_POST['mobile'] ?? ''),
            'employee_id' => trim($_POST['employee_id'] ?? ''),
            'role'        => $role,
            'manager_id'  => trim($_POST['manager_id'] ?? ''),
            'status'      => $_POST['status'] ?? ($u['status'] ?? 'active'),
        ];
        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 6) {
                $error = 'Password must be at least 6 characters.';
            } else {
                $data['password_hash'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }
        }
        if (!empty($_FILES['photo']['tmp_name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $url = $db->uploadFile($_FILES['photo']['tmp_name'], basename($_FILES['photo']['name']), $_FILES['photo']['type'] ?: 'image/jpeg');
            if ($url) $data['photo_url'] = $url;
        }
        if (!$error) {
            $db->updateDocument(COL_USERS, $id, $data);
            crm_audit('user.updated', 'users', $id,
                ['role' => $u['role'] ?? '', 'status' => $u['status'] ?? ''],
                ['role' => $role, 'status' => $data['status']]);
            header('Location: /crm/users/?updated=1');
            exit;
        }
    }
}

require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/_form.php';
require_once __DIR__ . '/../includes/layout-end.php';
