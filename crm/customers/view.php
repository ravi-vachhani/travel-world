<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('customers.view');

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/customers/'); exit; }

$db       = appwrite();
$customer = $db->getDocument(COL_CUSTOMERS, $id);
if (empty($customer['$id'])) { header('Location: /crm/customers/'); exit; }

// Related data
$enquiries = ($db->listDocuments(COL_ENQUIRIES, ['equal("customer_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(10)']))['documents'] ?? [];
$bookings  = ($db->listDocuments(COL_BOOKINGS,  ['equal("customer_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(10)']))['documents'] ?? [];
$payments  = ($db->listDocuments(COL_PAYMENTS,  ['equal("customer_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(5)']))['documents']  ?? [];
$documents = ($db->listDocuments(COL_DOCUMENTS, ['equal("customer_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(10)']))['documents'] ?? [];

$pageTitle = $customer['name'] ?? 'Customer';
$activeNav = 'Customers';

$statusBadge = ['new'=>'badge-new','contacted'=>'badge-contacted','quoted'=>'badge-quoted','confirmed'=>'badge-confirmed','lost'=>'badge-lost','completed'=>'badge-completed','booking'=>'badge-gold'];
$serviceIcons = ['flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨','transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋'];

require_once __DIR__ . '/../includes/layout.php';
?>

<?php if (isset($_GET['created'])): ?>
  <div class="flash flash-success"><?= crm_icon('check') ?> Customer created successfully!</div>
<?php endif; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($customer['name']) ?></h1>
    <p><?= htmlspecialchars($customer['phone']??'') ?> &nbsp;·&nbsp; <?= htmlspecialchars($customer['email']??'') ?></p>
  </div>
  <div style="display:flex;gap:0.75rem;">
    <a href="/crm/customers/edit.php?id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('edit') ?> Edit</a>
    <a href="/crm/enquiries/create.php?customer_id=<?= $id ?>" class="btn btn-primary"><?= crm_icon('plus') ?> New Enquiry</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <div class="card" style="margin-bottom:0">
    <div class="card-title">Personal Details</div>
    <table style="font-size:0.875rem;width:100%">
      <tbody>
        <?php $rows = [
          'Phone'           => $customer['phone']??'—',
          'Alt Phone'       => $customer['alt_phone']??'—',
          'Email'           => $customer['email']??'—',
          'Date of Birth'   => $customer['dob'] ? date('d M Y', strtotime($customer['dob'])) : '—',
          'Anniversary'     => $customer['anniversary'] ? date('d M Y', strtotime($customer['anniversary'])) : '—',
          'City'            => $customer['city']??'—',
          'State'           => $customer['state']??'—',
          'Country'         => $customer['country']??'—',
          'Passport No'     => $customer['passport_no']??'—',
          'Passport Expiry' => $customer['passport_expiry'] ? date('d M Y', strtotime($customer['passport_expiry'])) : '—',
        ]; foreach ($rows as $k=>$v): ?>
        <tr>
          <td class="text-muted text-xs" style="padding:0.35rem 0;width:40%"><?= $k ?></td>
          <td style="padding:0.35rem 0"><?= htmlspecialchars($v) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if (!empty($customer['notes'])): ?>
      <hr class="divider">
      <div class="text-xs text-muted mb-1">Notes</div>
      <p style="font-size:0.875rem"><?= nl2br(htmlspecialchars($customer['notes'])) ?></p>
    <?php endif; ?>
  </div>

  <div style="display:flex;flex-direction:column;gap:1.25rem;">
    <!-- Stats -->
    <div class="stat-grid" style="grid-template-columns:1fr 1fr;margin-bottom:0">
      <div class="stat-card blue" style="margin-bottom:0">
        <div class="stat-icon"><?= crm_icon('message-square') ?></div>
        <div class="stat-label">Enquiries</div>
        <div class="stat-value"><?= count($enquiries) ?></div>
      </div>
      <div class="stat-card green" style="margin-bottom:0">
        <div class="stat-icon"><?= crm_icon('bookmark') ?></div>
        <div class="stat-label">Bookings</div>
        <div class="stat-value"><?= count($bookings) ?></div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Quick Actions</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;">
        <a href="/crm/enquiries/create.php?customer_id=<?= $id ?>"  class="btn btn-secondary btn-sm"><?= crm_icon('message-square') ?> New Enquiry</a>
        <a href="/crm/followups/create.php?customer_id=<?= $id ?>"  class="btn btn-secondary btn-sm"><?= crm_icon('phone') ?> Schedule Follow-up</a>
        <a href="/crm/bookings/create.php?customer_id=<?= $id ?>"   class="btn btn-secondary btn-sm"><?= crm_icon('bookmark') ?> New Booking</a>
        <a href="/crm/documents/upload.php?customer_id=<?= $id ?>"  class="btn btn-secondary btn-sm"><?= crm_icon('upload') ?> Upload Document</a>
      </div>
    </div>
  </div>
</div>

<!-- Enquiries -->
<div class="card">
  <div class="card-title">Enquiries <a href="/crm/enquiries/create.php?customer_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?></a></div>
  <?php if (empty($enquiries)): ?>
    <div class="empty-state"><p>No enquiries</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>ID</th><th>Service</th><th>Destination</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($enquiries as $e): ?>
      <tr>
        <td class="text-xs text-muted"><?= htmlspecialchars($e['enquiry_id']??substr($e['$id'],0,8)) ?></td>
        <td><?= ($serviceIcons[$e['service_type']??'other']??'📋').' '.ucfirst($e['service_type']??'—') ?></td>
        <td><?= htmlspecialchars($e['destination']??'—') ?></td>
        <td><span class="badge <?= $statusBadge[$e['status']??'new']??'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$e['status']??'new')) ?></span></td>
        <td class="text-xs text-muted"><?= date('d M Y', strtotime($e['$createdAt']??'now')) ?></td>
        <td><a href="/crm/enquiries/view.php?id=<?= $e['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<!-- Bookings -->
<div class="card">
  <div class="card-title">Bookings</div>
  <?php if (empty($bookings)): ?>
    <div class="empty-state"><p>No bookings</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Booking ID</th><th>Destination</th><th>Travel Date</th><th>Amount</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($bookings as $b): ?>
      <tr>
        <td class="text-xs text-muted"><?= htmlspecialchars($b['booking_id']??substr($b['$id'],0,8)) ?></td>
        <td><?= htmlspecialchars($b['destination']??'—') ?></td>
        <td class="text-xs"><?= $b['travel_date'] ? date('d M Y', strtotime($b['travel_date'])) : '—' ?></td>
        <td>₹<?= number_format($b['total_amount']??0) ?></td>
        <td><span class="badge <?= $statusBadge[$b['status']??'confirmed']??'badge-confirmed' ?>"><?= ucfirst($b['status']??'confirmed') ?></span></td>
        <td><a href="/crm/bookings/view.php?id=<?= $b['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>