<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('followups.create');

$pageTitle  = 'Schedule Follow-up';
$activeNav  = 'Follow-ups';
$error      = '';
$enquiryId  = $_GET['enquiry_id']  ?? '';
$leadId     = $_GET['lead_id']     ?? '';
$customerId = $_GET['customer_id'] ?? '';

$db      = appwrite();
$prefill = [];
if ($enquiryId)  $prefill = $db->getDocument(COL_ENQUIRIES, $enquiryId);
if ($leadId)     $prefill = $db->getDocument(COL_LEADS,     $leadId);
if ($customerId) $prefill = $db->getDocument(COL_CUSTOMERS, $customerId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'enquiry_id'    => $_POST['enquiry_id']    ?? '',
        'lead_id'       => $_POST['lead_id']       ?? '',
        'customer_id'   => $_POST['customer_id']   ?? '',
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'type'          => $_POST['type'] ?? 'call',
        'scheduled_at'  => ($_POST['scheduled_date'] ?? '') . 'T' . ($_POST['scheduled_time'] ?? '09:00') . ':00',
        'notes'         => trim($_POST['notes'] ?? ''),
        'done'          => false,
    ];
    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } else {
        $res = $db->createDocument(COL_FOLLOWUPS, $data);
        if (!empty($res['$id'])) {
            $back = $enquiryId ? '/crm/enquiries/view.php?id='.$enquiryId.'&updated=1'
                  : ($leadId   ? '/crm/leads/view.php?id='.$leadId.'&updated=1'
                  : '/crm/followups/');
            header('Location: ' . $back);
            exit;
        }
        $error = 'Failed to schedule follow-up.';
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Schedule Follow-up</h1></div>
  <a href="/crm/followups/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="enquiry_id"  value="<?= htmlspecialchars($enquiryId) ?>">
<input type="hidden" name="lead_id"     value="<?= htmlspecialchars($leadId) ?>">
<input type="hidden" name="customer_id" value="<?= htmlspecialchars($customerId) ?>">

<div class="card">
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name']??$prefill['name']??$prefill['customer_name']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Follow-up Type</label>
      <select name="type">
        <?php foreach (['call'=>'📞 Call','whatsapp'=>'💬 WhatsApp','email'=>'📧 Email','meeting'=>'🤝 Meeting','custom'=>'📝 Custom'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['type']??'call')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Date *</label>
      <input type="date" name="scheduled_date" value="<?= htmlspecialchars($_POST['scheduled_date']??date('Y-m-d')) ?>" required>
    </div>
    <div class="form-group">
      <label>Time</label>
      <input type="time" name="scheduled_time" value="<?= htmlspecialchars($_POST['scheduled_time']??'10:00') ?>">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes" rows="3" placeholder="What to discuss, customer requirements…"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/followups/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Schedule</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>