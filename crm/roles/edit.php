<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('roles.edit');

$pageTitle = 'Edit Role';
$activeNav = 'Roles';
$saved = false;

$db = supabase();
$id = $_GET['id'] ?? '';
$role = $db->getDocument(COL_ROLES, $id);
if (empty($role['$id'])) { header('Location: /crm/roles/'); exit; }

// Current permissions for this role
function load_role_perms($db, $roleId): array {
    $rows = $db->listDocuments(COL_ROLE_PERMS, ['equal("role_id","' . addslashes($roleId) . '")', 'limit(500)'])['documents'] ?? [];
    return array_values(array_filter(array_map(fn($r) => $r['permission'] ?? '', $rows)));
}
$current = load_role_perms($db, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scope    = $_POST['scope'] ?? ($role['scope'] ?? 'OWN');
    $selected = array_values(array_intersect($_POST['perms'] ?? [], crm_all_permissions()));

    // Update scope/label
    $db->updateDocument(COL_ROLES, $id, [
        'scope' => in_array($scope, ['OWN','TEAM','ALL'], true) ? $scope : 'OWN',
        'label' => trim($_POST['label'] ?? ($role['label'] ?? $role['name'])),
    ]);

    // Diff permissions: delete removed, add new
    $toAdd    = array_diff($selected, $current);
    $toRemove = array_diff($current, $selected);

    // Remove: find rows and delete
    if ($toRemove) {
        $rows = $db->listDocuments(COL_ROLE_PERMS, ['equal("role_id","' . addslashes($id) . '")', 'limit(500)'])['documents'] ?? [];
        foreach ($rows as $r) {
            if (in_array($r['permission'] ?? '', $toRemove, true)) {
                $db->deleteDocument(COL_ROLE_PERMS, $r['$id']);
            }
        }
    }
    foreach ($toAdd as $p) {
        $db->createDocument(COL_ROLE_PERMS, ['role_id' => $id, 'permission' => $p]);
    }

    crm_audit('role.permissions_changed', 'roles', $id,
        ['permissions' => $current], ['permissions' => $selected]);

    $current = $selected;
    $role['scope'] = $scope;
    $saved = true;
}

$catalogue = crm_permission_catalogue();

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1><?= htmlspecialchars($role['label'] ?? $role['name']) ?></h1><p>Role permissions &amp; scope</p></div>
  <a href="/crm/roles/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($saved): ?><div class="flash flash-success"><?= crm_icon('check') ?> Role saved.</div><?php endif; ?>

<form method="POST">
<div class="card">
  <div class="form-grid">
    <div class="form-group"><label>Role Label</label><input type="text" name="label" value="<?= htmlspecialchars($role['label'] ?? $role['name']) ?>"></div>
    <div class="form-group"><label>Record Scope</label>
      <select name="scope">
        <?php foreach (['OWN'=>'Own records','TEAM'=>'Team records','ALL'=>'All records'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= (($role['scope'] ?? 'OWN') === $v) ? 'selected' : '' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <?php if (!empty($role['is_system'])): ?>
    <div class="flash flash-info mt-2"><?= crm_icon('alert-circle') ?> This is a system role. You can adjust its permissions, but it cannot be deleted.</div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-title">Permissions</div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem">
    <?php foreach ($catalogue as $module => $actions): ?>
    <div style="border:1px solid var(--border);border-radius:10px;padding:0.85rem">
      <div class="fw-700" style="text-transform:capitalize;margin-bottom:0.5rem"><?= htmlspecialchars($module) ?></div>
      <?php foreach ($actions as $a): $perm = "$module.$a"; ?>
      <label style="display:flex;align-items:center;gap:0.5rem;text-transform:none;letter-spacing:0;font-weight:500;color:var(--text);margin-bottom:4px;cursor:pointer">
        <input type="checkbox" name="perms[]" value="<?= $perm ?>" style="width:auto" <?= in_array($perm, $current, true) ? 'checked' : '' ?>>
        <?= htmlspecialchars($a) ?>
      </label>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/roles/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Permissions</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
