<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('followups.edit');

$pageTitle = 'Edit Follow-up';
$activeNav = 'Follow-ups';
$error     = '';

$db = appwrite();
$id = $_GET['id'] ?? '';
$fu = $db->getDocument(COL_FOLLOWUPS, $id);
if (empty($fu['$id'])) { header('Location: /crm/followups/'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['scheduled_date'] ?? '';
    $time = $_POST['scheduled_time'] ?? '09:00';
    $data = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'type'          => $_POST['type'] ?? ($fu['type'] ?? 'call'),
        'scheduled_at'  => $date ? ($date . 'T' . $time . ':00') : ($fu['scheduled_at'] ?? ''),
        'notes'         => trim($_POST['notes'] ?? ''),
        'done'          => isset($_POST['done']),
    ];
    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } elseif ($date !== '' && $date < date('Y-m-d')) {
        $error = 'Follow-up date cannot be in the past.';
    } else {
        $db->updateDocument(COL_FOLLOWUPS, $id, $data);
        $back = !empty($fu['enquiry_id']) ? '/crm/enquiries/view.php?id=' . $fu['enquiry_id'] . '&updated=1'
              : (!empty($fu['lead_id'])   ? '/crm/leads/view.php?id=' . $fu['lead_id'] . '&updated=1'
              : '/crm/followups/?updated=1');
        header('Location: ' . $back);
        exit;
    }
}

$cur       = function (string $k, $d = '') use ($fu) { return $fu[$k] ?? $d; };
$schedAt   = $fu['scheduled_at'] ?? '';
$schedDate = $schedAt ? date('Y-m-d', strtotime($schedAt)) : date('Y-m-d');
$schedTime = $schedAt ? date('H:i',   strtotime($schedAt)) : '09:00';
$types = ['call'=>'📞 Call','whatsapp'=>'💬 WhatsApp','email'=>'📧 Email','meeting'=>'🤝 Meeting','visit'=>'🏢 Visit'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Follow-up</h1></div>
  <a href="/crm/followups/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<div class="card">
  <div class="form-grid">
    <div class="form-group"><label>Customer Name *</label><input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name'] ?? $cur('customer_name')) ?>" required autocomplete="off" data-autocomplete="customer" data-fill-prefix="customer_"></div>
    <div class="form-group">
      <label>Type</label>
      <select name="type">
        <?php foreach ($types as $v=>$l): ?>
        <option value="<?= $v ?>" <?= (($_POST['type'] ?? $cur('type','call'))===$v)?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label>Date</label><input type="date" name="scheduled_date" value="<?= htmlspecialchars($schedDate) ?>" data-date="future" min="<?= date('Y-m-d') ?>"></div>
    <div class="form-group"><label>Time</label><input type="time" name="scheduled_time" value="<?= htmlspecialchars($schedTime) ?>"></div>
    <div class="form-group full"><label>Notes</label><textarea name="notes" rows="3"><?= htmlspecialchars($_POST['notes'] ?? $cur('notes')) ?></textarea></div>
    <div class="form-group">
      <label style="text-transform:none;letter-spacing:0;display:flex;align-items:center;gap:0.5rem;cursor:pointer">
        <input type="checkbox" name="done" style="width:auto" <?= !empty($fu['done']) ? 'checked' : '' ?>> Mark as done
      </label>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/followups/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
