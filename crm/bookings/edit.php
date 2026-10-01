<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('bookings.edit');

$pageTitle = 'Edit Booking';
$activeNav = 'Bookings';
$error     = '';

$db = appwrite();
$id = $_GET['id'] ?? '';
$bk = $db->getDocument(COL_BOOKINGS, $id);
if (empty($bk['$id'])) { header('Location: /crm/bookings/'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'customer_name'  => trim($_POST['customer_name']  ?? ''),
        'customer_phone' => trim($_POST['customer_phone'] ?? ''),
        'customer_email' => trim($_POST['customer_email'] ?? ''),
        'destination'    => trim($_POST['destination']    ?? ''),
        'service_type'   => $_POST['service_type'] ?? ($bk['service_type'] ?? 'package'),
        'travel_date'    => $_POST['travel_date']  ?? '',
        'return_date'    => $_POST['return_date']  ?? '',
        'adults'         => (int)($_POST['adults']  ?? 1),
        'children'       => (int)($_POST['children']?? 0),
        'supplier'       => trim($_POST['supplier'] ?? ''),
        'booking_ref'    => trim($_POST['booking_ref'] ?? ''),
        'total_amount'   => (float)($_POST['total_amount'] ?? 0),
        'status'         => $_POST['status'] ?? ($bk['status'] ?? 'confirmed'),
        'notes'          => trim($_POST['notes'] ?? ''),
    ];
    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } else {
        $db->updateDocument(COL_BOOKINGS, $id, $data);
        header('Location: /crm/bookings/view.php?id=' . $id . '&updated=1');
        exit;
    }
}

$cur = function (string $k, $d = '') use ($bk) { return $bk[$k] ?? $d; };
$services = ['flight'=>'Flight','visa'=>'Visa','package'=>'Package','hotel'=>'Hotel','transfer'=>'Transfer','insurance'=>'Insurance','cruise'=>'Cruise','other'=>'Other'];
$statuses = ['confirmed','in_progress','completed','cancelled'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Booking</h1><p><?= htmlspecialchars($bk['booking_id'] ?? '') ?></p></div>
  <a href="/crm/bookings/view.php?id=<?= $id ?>" class="btn btn-secondary">&larr; Back</a>
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
    <div class="form-group"><label>Phone</label><input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone'] ?? $cur('customer_phone')) ?>" data-mobile-lookup autocomplete="off"><div data-mobile-result></div></div>
    <div class="form-group"><label>Email</label><input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email'] ?? $cur('customer_email')) ?>"></div>
  </div>
</div>

<div class="card">
  <div class="card-title">Trip &amp; Status</div>
  <div class="form-grid">
    <div class="form-group"><label>Destination</label><input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination'] ?? $cur('destination')) ?>" data-autocomplete="destination" data-fill-prefix="" autocomplete="off"></div>
    <div class="form-group">
      <label>Service Type</label>
      <select name="service_type">
        <?php foreach ($services as $v=>$l): ?>
        <option value="<?= $v ?>" <?= (($_POST['service_type'] ?? $cur('service_type','package'))===$v)?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label>Travel Date</label><input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date'] ?? $cur('travel_date')) ?>"></div>
    <div class="form-group"><label>Return Date</label><input type="date" name="return_date" value="<?= htmlspecialchars($_POST['return_date'] ?? $cur('return_date')) ?>"></div>
    <div class="form-group"><label>Adults</label><input type="number" name="adults" value="<?= (int)($_POST['adults'] ?? $cur('adults',1)) ?>" min="1"></div>
    <div class="form-group"><label>Children</label><input type="number" name="children" value="<?= (int)($_POST['children'] ?? $cur('children',0)) ?>" min="0"></div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <?php foreach ($statuses as $s): ?>
        <option value="<?= $s ?>" <?= (($_POST['status'] ?? $cur('status','confirmed'))===$s)?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Supplier &amp; Billing</div>
  <div class="form-grid">
    <div class="form-group"><label>Supplier</label><input type="text" name="supplier" value="<?= htmlspecialchars($_POST['supplier'] ?? $cur('supplier')) ?>"></div>
    <div class="form-group"><label>Booking Reference</label><input type="text" name="booking_ref" value="<?= htmlspecialchars($_POST['booking_ref'] ?? $cur('booking_ref')) ?>"></div>
    <div class="form-group"><label>Total Amount (₹)</label><input type="number" name="total_amount" value="<?= (float)($_POST['total_amount'] ?? $cur('total_amount',0)) ?>" min="0"></div>
    <div class="form-group full"><label>Notes</label><textarea name="notes" rows="3"><?= htmlspecialchars($_POST['notes'] ?? $cur('notes')) ?></textarea></div>
  </div>
  <div class="text-xs text-muted mt-1">Paid amount is managed via Payments and is not edited here.</div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/bookings/view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
