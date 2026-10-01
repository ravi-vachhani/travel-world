<?php
/** Shared user form. Expects $roles, optionally $u (edit) and $error. */
$u = $u ?? [];
$isEdit = !empty($u['$id']);
?>
<div class="page-header">
  <div><h1><?= $isEdit ? 'Edit User' : 'New User' ?></h1><p>Staff account &amp; role</p></div>
  <a href="/crm/users/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if (!empty($error)): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
<div class="card">
  <div class="card-title">Profile</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Full Name *</label>
      <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $u['name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
      <label>Email *</label>
      <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? $u['email'] ?? '') ?>" <?= $isEdit ? 'readonly' : 'required' ?>>
    </div>
    <div class="form-group">
      <label>Mobile</label>
      <input type="tel" name="mobile" value="<?= htmlspecialchars($_POST['mobile'] ?? $u['mobile'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Employee ID</label>
      <input type="text" name="employee_id" value="<?= htmlspecialchars($_POST['employee_id'] ?? $u['employee_id'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label><?= $isEdit ? 'New Password (leave blank to keep)' : 'Password *' ?></label>
      <input type="password" name="password" <?= $isEdit ? '' : 'required' ?> placeholder="••••••••">
    </div>
    <div class="form-group">
      <label>Profile Photo</label>
      <input type="file" name="photo" accept="image/*">
      <?php if (!empty($u['photo_url'])): ?><div class="text-xs text-muted mt-1">Current photo will be kept if none chosen.</div><?php endif; ?>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Access</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Role *</label>
      <select name="role" required>
        <?php foreach ($roles as $r): $rn = $r['name'] ?? ''; ?>
        <option value="<?= htmlspecialchars($rn) ?>" <?= (($_POST['role'] ?? $u['role'] ?? 'viewer') === $rn) ? 'selected' : '' ?>>
          <?= htmlspecialchars($r['label'] ?? $rn) ?> — <?= htmlspecialchars($r['scope'] ?? 'OWN') ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <?php foreach (['active','inactive','suspended'] as $s): ?>
        <option value="<?= $s ?>" <?= (($_POST['status'] ?? $u['status'] ?? 'active') === $s) ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Reports To (Manager User ID)</label>
      <input type="text" name="manager_id" value="<?= htmlspecialchars($_POST['manager_id'] ?? $u['manager_id'] ?? '') ?>" placeholder="For TEAM scope">
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/users/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> <?= $isEdit ? 'Save Changes' : 'Create User' ?></button>
</div>
</form>
