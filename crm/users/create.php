<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('users.create');

$pageTitle = 'New User';
$activeNav = 'Users';
$error = '';

$db    = supabase();
$roles = $db->listDocuments(COL_ROLES, ['orderAsc("label")', 'limit(100)'])['documents'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'viewer';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Name, email and password are required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Prevent duplicate email
        $dupe = $db->listDocuments(COL_USERS, ['equal("email","' . addslashes($email) . '")', 'limit(1)']);
        if (!empty($dupe['documents'][0])) {
            $error = 'A user with this email already exists.';
        } else {
            // Optional profile photo upload
            $photoUrl = '';
            if (!empty($_FILES['photo']['tmp_name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoUrl = $db->uploadFile($_FILES['photo']['tmp_name'], basename($_FILES['photo']['name']), $_FILES['photo']['type'] ?: 'image/jpeg');
            }
            $data = [
                'name'          => $name,
                'email'         => $email,
                'mobile'        => trim($_POST['mobile'] ?? ''),
                'employee_id'   => trim($_POST['employee_id'] ?? ''),
                'role'          => $role,
                'manager_id'    => trim($_POST['manager_id'] ?? ''),
                'status'        => $_POST['status'] ?? 'active',
                'photo_url'     => $photoUrl,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            ];
            $res = $db->createDocument(COL_USERS, $data);
            if (!empty($res['$id'])) {
                crm_audit('user.created', 'users', $res['$id'], null,
                    ['name' => $name, 'email' => $email, 'role' => $role]);
                header('Location: /crm/users/?created=1');
                exit;
            }
            $error = 'Failed to create user.' . ($db->lastError() ? ' (' . $db->lastError() . ')' : '');
        }
    }
}

require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/_form.php';
require_once __DIR__ . '/../includes/layout-end.php';
