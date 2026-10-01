<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/india.php';

crm_require_auth();
crm_require_permission('customers.create');

$pageTitle = 'New Customer';
$activeNav = 'Customers';
$error = '';
$dupeError = '';


// Pre-fill from lead if converting
$leadId = $_GET['lead_id'] ?? '';
$lead   = [];
if ($leadId) {
    $db   = appwrite();
    $lead = $db->getDocument(COL_LEADS, $leadId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db    = appwrite();
    $phone = trim($_POST['phone'] ?? '');
    $norm  = crm_normalize_mobile($phone);

    // ── Duplicate prevention: a customer with this mobile already exists → show
    //    a clear error (with a link to the existing record) and do NOT create a
    //    duplicate. This keeps the customer database clean.
    $existing = $norm !== '' ? crm_find_customer_by_mobile($phone) : null;
    if ($existing) {
        $dupeError = 'This mobile number already exists for customer "'
            . htmlspecialchars($existing['name'] ?? '')
            . '". <a href="/crm/customers/view.php?id=' . $existing['$id'] . '">Open existing customer</a>.';
    }

    $data = [
        'name'          => trim($_POST['name'] ?? ''),
        'email'         => trim($_POST['email'] ?? ''),
        'phone'         => $phone,
        'mobile_normalized' => $norm,
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
    } elseif (!empty($dupeError)) {
        $error = $dupeError;        // mobile already exists — block creation
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
        $error = 'Failed to create customer.' . ($db->lastError() ? ' (' . $db->lastError() . ')' : '');
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>New Customer</h1><p>Add a customer profile</p></div>
  <a href="/crm/customers/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?>
    <span><?= !empty($dupeError) && $error === $dupeError ? $error : htmlspecialchars($error) ?></span>
  </div>
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
      <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone']??$lead['phone']??'') ?>" required data-mobile-lookup autocomplete="off">
      <div data-mobile-result></div>
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
      <input type="date" name="dob" value="<?= htmlspecialchars($_POST['dob']??'') ?>" data-date="past" max="<?= date('Y-m-d') ?>">
      <span class="date-hint">Cannot be a future date</span>
    </div>
    <div class="form-group">
      <label>Anniversary</label>
      <input type="date" name="anniversary" value="<?= htmlspecialchars($_POST['anniversary']??'') ?>" data-date="past" max="<?= date('Y-m-d') ?>">
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
      <label>State</label>
      <?= crm_state_select('state', $_POST['state'] ?? '') ?>
    </div>
    <div class="form-group">
      <label>City</label>
      <?= crm_city_input('city', $_POST['city'] ?? '') ?>
    </div>
    <div class="form-group">
      <label>Country</label>
      <?= crm_country_select('country', $_POST['country'] ?? 'India') ?>
    </div>
  </div>
</div>
<script>window.CRM_CITIES = <?= crm_cities_json() ?>;</script>

<div class="card">
  <div class="card-title">Travel Documents</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Passport Number</label>
      <input type="text" name="passport_no" value="<?= htmlspecialchars($_POST['passport_no']??'') ?>" placeholder="A1234567">
    </div>
    <div class="form-group">
      <label>Passport Expiry</label>
      <input type="date" name="passport_expiry" value="<?= htmlspecialchars($_POST['passport_expiry']??'') ?>" data-date="future" min="<?= date('Y-m-d') ?>">
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