<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('leads.create');

$pageTitle = 'New Lead';
$activeNav = 'Leads';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = appwrite();
    $data = [
        'lead_id'      => 'TW-L-' . strtoupper(substr(uniqid(), -5)),
        'name'         => trim($_POST['name'] ?? ''),
        'email'        => trim($_POST['email'] ?? ''),
        'phone'        => trim($_POST['phone'] ?? ''),
        'source'       => $_POST['source'] ?? 'other',
        'service_type' => $_POST['service_type'] ?? 'other',
        'destination'  => trim($_POST['destination'] ?? ''),
        'travel_date'  => $_POST['travel_date'] ?? '',
        'adults'       => (int)($_POST['adults'] ?? 1),
        'children'     => (int)($_POST['children'] ?? 0),
        'budget'       => trim($_POST['budget'] ?? ''),
        'notes'        => trim($_POST['notes'] ?? ''),
        'status'       => 'new',
        'assigned_to'  => trim($_POST['assigned_to'] ?? ''),
    ];

    if (empty($data['name']) || empty($data['phone'])) {
        $error = 'Name and phone are required.';
    } else {
        $res = $db->createDocument(COL_LEADS, $data);
        if (!empty($res['$id'])) {
            header('Location: /crm/leads/view.php?id=' . $res['$id'] . '&created=1');
            exit;
        } else {
            $error = 'Failed to create lead. Please try again.';
        }
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div>
    <h1>New Lead</h1>
    <p>Capture a new travel enquiry lead</p>
  </div>
  <a href="/crm/leads/" class="btn btn-secondary">&larr; Back to Leads</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="/crm/leads/create.php">
<div class="card">
  <div class="card-title">Customer Information</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Full Name *</label>
      <input type="text" name="name" value="<?= htmlspecialchars($_POST['name']??'') ?>" placeholder="John Doe" required>
    </div>
    <div class="form-group">
      <label>Phone *</label>
      <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone']??'') ?>" placeholder="+91 98765 43210" required>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($_POST['email']??'') ?>" placeholder="john@example.com">
    </div>
    <div class="form-group">
      <label>Lead Source</label>
      <select name="source">
        <?php foreach (['website'=>'Website','whatsapp'=>'WhatsApp','phone'=>'Phone Call','instagram'=>'Instagram','facebook'=>'Facebook','google'=>'Google','walk_in'=>'Walk-in','referral'=>'Referral','existing_customer'=>'Existing Customer','other'=>'Other'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['source']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Travel Requirements</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Service Type</label>
      <select name="service_type">
        <?php foreach (['flight'=>'✈️ Flight','visa'=>'🛂 Visa','package'=>'🏖️ Holiday Package','hotel'=>'🏨 Hotel','transfer'=>'🚕 Transfer / Cab','insurance'=>'🛡️ Travel Insurance','cruise'=>'🚢 Cruise','other'=>'📋 Other'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['service_type']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Destination</label>
      <input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination']??'') ?>" placeholder="Dubai, Bali, Europe…">
    </div>
    <div class="form-group">
      <label>Travel Date</label>
      <input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date']??'') ?>">
    </div>
    <div class="form-group">
      <label>Budget</label>
      <input type="text" name="budget" value="<?= htmlspecialchars($_POST['budget']??'') ?>" placeholder="₹50,000 – ₹1,00,000">
    </div>
    <div class="form-group">
      <label>Adults</label>
      <input type="number" name="adults" value="<?= (int)($_POST['adults']??1) ?>" min="1" max="50">
    </div>
    <div class="form-group">
      <label>Children</label>
      <input type="number" name="children" value="<?= (int)($_POST['children']??0) ?>" min="0" max="20">
    </div>
    <div class="form-group">
      <label>Assigned To</label>
      <input type="text" name="assigned_to" value="<?= htmlspecialchars($_POST['assigned_to']??'') ?>" placeholder="Sales executive name">
    </div>
    <div class="form-group full">
      <label>Notes / Requirements</label>
      <textarea name="notes" rows="3" placeholder="Any special requirements, preferences…"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/leads/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Lead</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>