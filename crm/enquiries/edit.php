<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('enquiries.edit');

$pageTitle = 'Edit Enquiry';
$activeNav = 'Enquiries';
$error     = '';

$db  = appwrite();
$id  = $_GET['id'] ?? '';
$enq = $db->getDocument(COL_ENQUIRIES, $id);
if (empty($enq['$id'])) { header('Location: /crm/enquiries/'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'customer_phone'=> trim($_POST['customer_phone'] ?? ''),
        'customer_email'=> trim($_POST['customer_email'] ?? ''),
        'service_type'  => $_POST['service_type'] ?? ($enq['service_type'] ?? 'other'),
        'destination'   => trim($_POST['destination'] ?? ''),
        'travel_date'   => $_POST['travel_date'] ?? '',
        'adults'        => (int)($_POST['adults'] ?? 1),
        'children'      => (int)($_POST['children'] ?? 0),
        'budget'        => trim($_POST['budget'] ?? ''),
        'status'        => $_POST['status'] ?? ($enq['status'] ?? 'new'),
        'notes'         => trim($_POST['notes'] ?? ''),
        'assigned_to'   => trim($_POST['assigned_to'] ?? ''),
    ];
    if (empty($data['customer_name']) || empty($data['customer_phone'])) {
        $error = 'Customer name and phone are required.';
    } else {
        $db->updateDocument(COL_ENQUIRIES, $id, $data);
        header('Location: /crm/enquiries/view.php?id=' . $id . '&updated=1');
        exit;
    }
}

$cur = function (string $k, $d = '') use ($enq) { return $enq[$k] ?? $d; };
$services = ['flight'=>'✈️ Flight','visa'=>'🛂 Visa','package'=>'🏖️ Holiday Package','hotel'=>'🏨 Hotel','transfer'=>'🚕 Transfer / Cab','insurance'=>'🛡️ Travel Insurance','cruise'=>'🚢 Cruise','other'=>'📋 Other'];
$statuses = ['new','contacted','quoted','negotiation','booking','completed','lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Enquiry</h1><p><?= htmlspecialchars($enq['enquiry_id'] ?? '') ?></p></div>
  <a href="/crm/enquiries/view.php?id=<?= $id ?>" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="customer_id" value="<?= htmlspecialchars($cur('customer_id')) ?>">
<div class="card">
  <div class="card-title">Customer</div>
  <div class="form-grid">
    <div class="form-group"><label>Customer Name *</label><input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name'] ?? $cur('customer_name')) ?>" required autocomplete="off" data-autocomplete="customer" data-fill-prefix="customer_"></div>
    <div class="form-group"><label>Phone *</label><input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone'] ?? $cur('customer_phone')) ?>" required data-mobile-lookup autocomplete="off"><div data-mobile-result></div></div>
    <div class="form-group"><label>Email</label><input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email'] ?? $cur('customer_email')) ?>"></div>
    <div class="form-group"><label>Assigned To</label><input type="text" name="assigned_to" value="<?= htmlspecialchars($_POST['assigned_to'] ?? $cur('assigned_to')) ?>" data-autocomplete="user" autocomplete="off"></div>
  </div>
</div>

<div class="card">
  <div class="card-title">Requirement</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Service Type</label>
      <select name="service_type">
        <?php foreach ($services as $v=>$l): ?>
        <option value="<?= $v ?>" <?= (($_POST['service_type'] ?? $cur('service_type','other'))===$v)?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label>Destination</label><input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination'] ?? $cur('destination')) ?>" data-autocomplete="destination" data-fill-prefix="" autocomplete="off"></div>
    <div class="form-group"><label>Travel Date</label><input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date'] ?? $cur('travel_date')) ?>"></div>
    <div class="form-group"><label>Budget</label><input type="text" name="budget" value="<?= htmlspecialchars($_POST['budget'] ?? $cur('budget')) ?>"></div>
    <div class="form-group"><label>Adults</label><input type="number" name="adults" value="<?= (int)($_POST['adults'] ?? $cur('adults',1)) ?>" min="1"></div>
    <div class="form-group"><label>Children</label><input type="number" name="children" value="<?= (int)($_POST['children'] ?? $cur('children',0)) ?>" min="0"></div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <?php foreach ($statuses as $s): ?>
        <option value="<?= $s ?>" <?= (($_POST['status'] ?? $cur('status','new'))===$s)?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>

<div class="card">
  <div class="form-group full"><label>Internal Notes</label><textarea name="notes" rows="3"><?= htmlspecialchars($_POST['notes'] ?? $cur('notes')) ?></textarea></div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/enquiries/view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
