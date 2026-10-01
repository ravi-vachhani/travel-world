<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/customers/'); exit; }

$db       = appwrite();
$customer = $db->getDocument(COL_CUSTOMERS, $id);
if (empty($customer['$id'])) { header('Location: /crm/customers/'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'           => trim($_POST['name'] ?? ''),
        'email'          => trim($_POST['email'] ?? ''),
        'phone'          => trim($_POST['phone'] ?? ''),
        'alt_phone'      => trim($_POST['alt_phone'] ?? ''),
        'dob'            => $_POST['dob'] ?? '',
        'anniversary'    => $_POST['anniversary'] ?? '',
        'address'        => trim($_POST['address'] ?? ''),
        'city'           => trim($_POST['city'] ?? ''),
        'state'          => trim($_POST['state'] ?? ''),
        'country'        => trim($_POST['country'] ?? 'India'),
        'passport_no'    => trim($_POST['passport_no'] ?? ''),
        'passport_expiry'=> $_POST['passport_expiry'] ?? '',
        'notes'          => trim($_POST['notes'] ?? ''),
    ];
    if (empty($data['name']) || empty($data['phone'])) {
        $error = 'Name and phone are required.';
    } else {
        $db->updateDocument(COL_CUSTOMERS, $id, $data);
        header('Location: /crm/customers/view.php?id=' . $id . '&updated=1');
        exit;
    }
}

$pageTitle = 'Edit Customer';
$activeNav = 'Customers';
$c = $customer; // shorthand

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Customer</h1><p><?= htmlspecialchars($c['name']??'') ?></p></div>
  <a href="/crm/customers/view.php?id=<?= $id ?>" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<div class="card">
  <div class="card-title">Personal Information</div>
  <div class="form-grid">
    <?php
    $f = function($name, $label, $type='text', $req=false) use ($c) {
        $val = htmlspecialchars($_POST[$name] ?? $c[$name] ?? '');
        $r   = $req ? 'required' : '';
        echo "<div class='form-group'><label>{$label}" . ($req?' *':'') . "</label><input type='{$type}' name='{$name}' value='{$val}' {$r}></div>";
    };
    $f('name',     'Full Name', 'text', true);
    $f('phone',    'Phone', 'tel', true);
    $f('alt_phone','Alternate Phone', 'tel');
    $f('email',    'Email', 'email');
    $f('dob',      'Date of Birth', 'date');
    $f('anniversary','Anniversary', 'date');
    ?>
  </div>
</div>

<div class="card">
  <div class="card-title">Address</div>
  <div class="form-grid">
    <div class="form-group full">
      <label>Address</label>
      <input type="text" name="address" value="<?= htmlspecialchars($_POST['address']??$c['address']??'') ?>">
    </div>
    <?php $f('city','City'); $f('state','State'); $f('country','Country'); ?>
  </div>
</div>

<div class="card">
  <div class="card-title">Travel Documents</div>
  <div class="form-grid">
    <?php $f('passport_no','Passport Number'); $f('passport_expiry','Passport Expiry','date'); ?>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??$c['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/customers/view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>