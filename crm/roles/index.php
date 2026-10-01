<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('roles.view');

$pageTitle = 'Roles';
$activeNav = 'Roles';
$error = '';

$db = supabase();

// Create a new custom role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_role'])) {
    crm_require_permission('roles.create');
    $label = trim($_POST['label'] ?? '');
    $scope = $_POST['scope'] ?? 'OWN';
    if ($label !== '') {
        $name = preg_replace('/[^a-z0-9_]/', '', strtolower(str_replace(' ', '_', $label)));
        $res = $db->createDocument(COL_ROLES, [
            'name'      => $name,
            'label'     => $label,
            'scope'     => in_array($scope, ['OWN','TEAM','ALL'], true) ? $scope : 'OWN',
            'is_system' => false,
            'description' => trim($_POST['description'] ?? ''),
        ]);
        if (!empty($res['$id'])) {
            crm_audit('role.created', 'roles', $res['$id'], null, ['label' => $label, 'scope' => $scope]);
            header('Location: /crm/roles/edit.php?id=' . $res['$id']);
            exit;
        }
        $error = 'Failed to create role.' . ($db->lastError() ? ' (' . $db->lastError() . ')' : '');
    }
}

$roles = $db->listDocuments(COL_ROLES, ['orderAsc("label")', 'limit(100)'])['documents'] ?? [];

// permission counts per role
$permCounts = [];
foreach ($roles as $r) {
    $c = $db->listDocuments(COL_ROLE_PERMS, ['equal("role_id","' . addslashes($r['$id']) . '")', 'limit(1)']);
    $permCounts[$r['$id']] = $c['total'] ?? count($c['documents'] ?? []);
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Roles &amp; Permissions</h1><p><?= count($roles) ?> roles</p></div>
</div>

<?php if ($error): ?><div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Role</th><th>Scope</th><th>Type</th><th>Permissions</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($roles as $r): ?>
        <tr>
          <td class="fw-600"><?= htmlspecialchars($r['label'] ?? $r['name']) ?><div class="text-xs text-muted"><?= htmlspecialchars($r['name']) ?></div></td>
          <td><span class="badge badge-gold"><?= htmlspecialchars($r['scope'] ?? 'OWN') ?></span></td>
          <td class="text-xs"><?= !empty($r['is_system']) ? 'System' : 'Custom' ?></td>
          <td><?= $permCounts[$r['$id']] ?? 0 ?></td>
          <td>
            <div class="actions">
              <?php if (crm_can('roles.edit')): ?>
                <a href="/crm/roles/edit.php?id=<?= $r['$id'] ?>" class="btn btn-secondary btn-sm"><?= crm_icon('edit') ?> Permissions</a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (crm_can('roles.create')): ?>
<div class="card">
  <div class="card-title">Create Custom Role</div>
  <form method="POST">
    <div class="form-grid">
      <div class="form-group"><label>Role Name *</label><input type="text" name="label" placeholder="e.g. Senior Sales" required></div>
      <div class="form-group"><label>Record Scope</label>
        <select name="scope"><option value="OWN">Own records</option><option value="TEAM">Team records</option><option value="ALL">All records</option></select>
      </div>
      <div class="form-group full"><label>Description</label><input type="text" name="description" placeholder="Optional"></div>
    </div>
    <div style="display:flex;justify-content:flex-end;margin-top:1rem">
      <button class="btn btn-primary" name="create_role" value="1"><?= crm_icon('plus') ?> Create Role</button>
    </div>
  </form>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
