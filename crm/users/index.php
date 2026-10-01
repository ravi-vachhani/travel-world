<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('users.view');

$pageTitle = 'Users';
$activeNav = 'Users';

$db = supabase();

// Handle status actions (activate / deactivate / suspend) — server-side guarded.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_status'])) {
    crm_require_permission('users.edit');
    $id     = $_POST['id'] ?? '';
    $status = $_POST['set_status'];
    if ($id && in_array($status, ['active', 'inactive', 'suspended'], true)) {
        $before = $db->getDocument(COL_USERS, $id);
        $db->updateDocument(COL_USERS, $id, ['status' => $status]);
        crm_audit('user.status_changed', 'users', $id,
            ['status' => $before['status'] ?? ''], ['status' => $status]);
    }
    header('Location: /crm/users/?updated=1');
    exit;
}

$users = $db->listDocuments(COL_USERS, ['orderDesc("$createdAt")', 'limit(200)'])['documents'] ?? [];

$statusBadge = ['active' => 'badge-confirmed', 'inactive' => 'badge-pending', 'suspended' => 'badge-lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Users</h1><p><?= count($users) ?> staff accounts</p></div>
  <?php if (crm_can('users.create')): ?>
  <a href="/crm/users/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New User</a>
  <?php endif; ?>
</div>

<?php if (isset($_GET['updated'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> User updated.</div><?php endif; ?>
<?php if (isset($_GET['created'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> User created.</div><?php endif; ?>

<div class="card">
  <?php if (empty($users)): ?>
    <div class="empty-state"><?= crm_icon('shield') ?><p>No users yet. <a href="/crm/users/create.php">Add the first user</a></p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>User</th><th>Employee ID</th><th>Mobile</th><th>Role</th><th>Status</th><th>Last Login</th><th>Created</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:0.6rem">
              <?php if (!empty($u['photo_url'])): ?>
                <img src="<?= htmlspecialchars($u['photo_url']) ?>" alt="" style="width:34px;height:34px;border-radius:50%;object-fit:cover">
              <?php else: ?>
                <div class="user-avatar" style="width:34px;height:34px"><?= strtoupper(substr($u['name'] ?? 'U',0,1)) ?></div>
              <?php endif; ?>
              <div>
                <div class="fw-600"><?= htmlspecialchars($u['name'] ?? '—') ?></div>
                <div class="text-xs text-muted"><?= htmlspecialchars($u['email'] ?? '') ?></div>
              </div>
            </div>
          </td>
          <td class="text-xs"><?= htmlspecialchars($u['employee_id'] ?? '—') ?></td>
          <td class="text-xs"><?= htmlspecialchars($u['mobile'] ?? '—') ?></td>
          <td><span class="badge badge-gold"><?= htmlspecialchars(ucwords(str_replace('_',' ', $u['role'] ?? '—'))) ?></span></td>
          <td><span class="badge <?= $statusBadge[$u['status'] ?? 'active'] ?? 'badge-new' ?>"><?= ucfirst($u['status'] ?? 'active') ?></span></td>
          <td class="text-xs text-muted"><?= !empty($u['last_login']) ? date('d M Y, h:i A', strtotime($u['last_login'])) : 'Never' ?></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($u['$createdAt'] ?? 'now')) ?></td>
          <td>
            <div class="actions">
              <?php if (crm_can('users.edit')): ?>
                <a href="/crm/users/edit.php?id=<?= $u['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Edit"><?= crm_icon('edit') ?></a>
                <?php $cur = $u['status'] ?? 'active'; ?>
                <?php if ($cur !== 'active'): ?>
                  <form method="POST" style="display:inline"><input type="hidden" name="id" value="<?= $u['$id'] ?>"><button name="set_status" value="active" class="btn btn-success btn-sm btn-icon" title="Activate"><?= crm_icon('check') ?></button></form>
                <?php endif; ?>
                <?php if ($cur !== 'inactive'): ?>
                  <form method="POST" style="display:inline"><input type="hidden" name="id" value="<?= $u['$id'] ?>"><button name="set_status" value="inactive" class="btn btn-secondary btn-sm btn-icon" title="Deactivate"><?= crm_icon('x') ?></button></form>
                <?php endif; ?>
                <?php if ($cur !== 'suspended'): ?>
                  <form method="POST" style="display:inline"><input type="hidden" name="id" value="<?= $u['$id'] ?>"><button name="set_status" value="suspended" class="btn btn-danger btn-sm btn-icon" title="Suspend"><?= crm_icon('alert-circle') ?></button></form>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
