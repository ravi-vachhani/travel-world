<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle = 'New Customer';
$activeNav = 'Customers';
$error = '';


// Pre-fill from lead if converting
$leadId = $_GET['lead_id'] ?? '';
$lead   = [];
if ($leadId) {
    $db   = appwrite();
    $lead = $db->getDocument(COL_LEADS, $leadId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db   = appwrite();
    $data = [
        'name'          => trim($_POST['name'] ?? ''),
        'email'         => trim($_POST['email'] ?? ''),
        'phone'         => trim($_POST['phone'] ?? ''),
        'alt_phone'     => trim($_POST['alt_phone'] ?? ''),
        'dob'           => $_POST['dob'] ?? '',
        'anniversary'   => $_POST['anniversary'] ?? '',
        'address'       => trim($_POST['address'] ?? ''),
        'city'          => trim($_POST['city'] ?? ''),
        'state'         => trim($_POST['state'] ?? ''),
        'country'       => trim($_POST['country'] ?? 'India'),
        'passport_no'   => trim($_POST['passport_no'] ?? ''),
        'passport_expiry'=> $_POST['passport_expiry'] ?? '',
        'notes'         => trim($_POST['notes'] ?? ''),
        'enquiry_count' => 0,
        'booking_count' => 0,
        'lead_id'       => $_POST['lead_id'] ?? '',
    ];
    if (empty($data['name']) || empty($data['phone'])) {
        $error = 'Name and phone are required.';
    } else {
        $res = $db->createDocument(COL_CUSTOMERS, $data);
        if (!empty($res['$id'])) {
            // Update lead status if converting
            if (!empty($data['lead_id'])) {
                $db->updateDocument(COL_LEADS, $data['lead_id'], ['status' => 'contacted', 'customer_id' => $res['$id']]);
            }
            header('Location: /crm/customers/view.php?id=' . $res['$id'] . '&created=1');
            exit;
        }
        $error = 'Failed to create customer.';
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>New Customer</h1><p>Add a customer profile</p></div>
  <a href="/crm/customers/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="lead_id" value="<?= htmlspecialchars($leadId) ?>">

<div class="card">
  <div class="card-title">Personal Information</div>
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
      <label>Alternate Phone</label>
      <input type="tel" name="alt_phone" value="<?= htmlspecialchars($_POST['alt_phone']??'') ?>">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($_POST['email']??$lead['email']??'') ?>">
    </div>
    <div class="form-group">
      <label>Date of Birth</label>
      <input type="date" name="dob" value="<?= htmlspecialchars($_POST['dob']??'') ?>">
    </div>
    <div class="form-group">
      <label>Anniversary</label>
      <input type="date" name="anniversary" value="<?= htmlspecialchars($_POST['anniversary']??'') ?>">
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Address</div>
  <div class="form-grid">
    <div class="form-group full">
      <label>Address</label>
      <input type="text" name="address" value="<?= htmlspecialchars($_POST['address']??'') ?>">
    </div>
    <div class="form-group">
      <label>City</label>
      <input type="text" name="city" value="<?= htmlspecialchars($_POST['city']??'') ?>">
    </div>
    <div class="form-group">
      <label>State</label>
      <input type="text" name="state" value="<?= htmlspecialchars($_POST['state']??'') ?>">
    </div>
    <div class="form-group">
      <label>Country</label>
      <input type="text" name="country" value="<?= htmlspecialchars($_POST['country']??'India') ?>">
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Travel Documents</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Passport Number</label>
      <input type="text" name="passport_no" value="<?= htmlspecialchars($_POST['passport_no']??'') ?>" placeholder="A1234567">
    </div>
    <div class="form-group">
      <label>Passport Expiry</label>
      <input type="date" name="passport_expiry" value="<?= htmlspecialchars($_POST['passport_expiry']??'') ?>">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/customers/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Customer</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>