<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/leads/'); exit; }

$db   = appwrite();
$lead = $db->getDocument(COL_LEADS, $id);
if (empty($lead['$id'])) { header('Location: /crm/leads/'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
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
        'status'       => $_POST['status'] ?? 'new',
        'assigned_to'  => trim($_POST['assigned_to'] ?? ''),
    ];
    if (empty($data['name']) || empty($data['phone'])) {
        $error = 'Name and phone are required.';
    } else {
        $db->updateDocument(COL_LEADS, $id, $data);
        header('Location: /crm/leads/view.php?id=' . $id . '&updated=1');
        exit;
    }
}

$pageTitle = 'Edit Lead';
$activeNav = 'Leads';
require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Lead</h1><p><?= htmlspecialchars($lead['name']??'') ?></p></div>
  <a href="/crm/leads/view.php?id=<?= $id ?>" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<div class="card">
  <div class="card-title">Customer Information</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Full Name *</label>
      <input type="text" name="name" value="<?= htmlspecialchars($_POST['name']??$lead['name']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Phone *</label>
      <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone']??$lead['phone']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($_POST['email']??$lead['email']??'') ?>">
    </div>
    <div class="form-group">
      <label>Lead Source</label>
      <select name="source">
        <?php foreach (['website'=>'Website','whatsapp'=>'WhatsApp','phone'=>'Phone Call','instagram'=>'Instagram','facebook'=>'Facebook','google'=>'Google','walk_in'=>'Walk-in','referral'=>'Referral','existing_customer'=>'Existing Customer','other'=>'Other'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['source']??$lead['source']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <?php foreach (['new','contacted','requirement','quoted','follow_up','negotiation','confirmed','booking','completed','lost'] as $s): ?>
        <option value="<?= $s ?>" <?= ($_POST['status']??$lead['status']??'new')===$s?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Assigned To</label>
      <input type="text" name="assigned_to" value="<?= htmlspecialchars($_POST['assigned_to']??$lead['assigned_to']??'') ?>">
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
        <option value="<?= $v ?>" <?= ($_POST['service_type']??$lead['service_type']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Destination</label>
      <input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination']??$lead['destination']??'') ?>">
    </div>
    <div class="form-group">
      <label>Travel Date</label>
      <input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date']??$lead['travel_date']??'') ?>">
    </div>
    <div class="form-group">
      <label>Budget</label>
      <input type="text" name="budget" value="<?= htmlspecialchars($_POST['budget']??$lead['budget']??'') ?>">
    </div>
    <div class="form-group">
      <label>Adults</label>
      <input type="number" name="adults" value="<?= (int)($_POST['adults']??$lead['adults']??1) ?>" min="1">
    </div>
    <div class="form-group">
      <label>Children</label>
      <input type="number" name="children" value="<?= (int)($_POST['children']??$lead['children']??0) ?>" min="0">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??$lead['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/leads/view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>