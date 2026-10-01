<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('bookings.view');

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/bookings/'); exit; }

$db      = appwrite();
$booking = $db->getDocument(COL_BOOKINGS, $id);
if (empty($booking['$id'])) { header('Location: /crm/bookings/'); exit; }

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $db->updateDocument(COL_BOOKINGS, $id, ['status' => $_POST['status']]);
    header('Location: /crm/bookings/view.php?id=' . $id . '&updated=1');
    exit;
}

$payments  = ($db->listDocuments(COL_PAYMENTS,  ['equal("booking_id","'.$id.'")', 'orderDesc("paid_at")', 'limit(20)']))['documents'] ?? [];
$documents = ($db->listDocuments(COL_DOCUMENTS, ['equal("booking_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(20)']))['documents'] ?? [];

$totalPaid = array_sum(array_column($payments, 'amount'));
$balance   = (float)($booking['total_amount']??0) - $totalPaid;

$pageTitle = 'Booking: ' . ($booking['customer_name'] ?? '');
$activeNav = 'Bookings';

$statusBadge = ['confirmed'=>'badge-confirmed','pending'=>'badge-quoted','cancelled'=>'badge-lost','completed'=>'badge-completed','on_hold'=>'badge-contacted'];
$docStatusBadge = ['pending'=>'badge-quoted','uploaded'=>'badge-new','verified'=>'badge-confirmed','rejected'=>'badge-lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<?php if (isset($_GET['created'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Booking confirmed!</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Updated.</div><?php endif; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($booking['customer_name']??'Booking') ?></h1>
    <p>Booking ID: <?= htmlspecialchars($booking['booking_id']??substr($booking['$id'],0,8)) ?> &nbsp;·&nbsp; <?= date('d M Y', strtotime($booking['$createdAt'])) ?></p>
  </div>
  <div style="display:flex;gap:0.75rem;">
    <a href="/crm/payments/create.php?booking_id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('credit-card') ?> Add Payment</a>
    <a href="/crm/documents/upload.php?booking_id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('upload') ?> Upload Doc</a>
  </div>
</div>

<!-- Summary Stats -->
<div class="stat-grid" style="margin-bottom:1.25rem">
  <div class="stat-card gold">
    <div class="stat-icon"><?= crm_icon('dollar-sign') ?></div>
    <div class="stat-label">Total Amount</div>
    <div class="stat-value" style="font-size:1.4rem">₹<?= number_format($booking['total_amount']??0) ?></div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><?= crm_icon('check') ?></div>
    <div class="stat-label">Paid</div>
    <div class="stat-value" style="font-size:1.4rem">₹<?= number_format($totalPaid) ?></div>
  </div>
  <div class="stat-card <?= $balance > 0 ? 'red' : 'green' ?>">
    <div class="stat-icon"><?= crm_icon('alert-circle') ?></div>
    <div class="stat-label">Balance</div>
    <div class="stat-value" style="font-size:1.4rem">₹<?= number_format(abs($balance)) ?></div>
  </div>
  <div class="stat-card blue">
    <div class="stat-icon"><?= crm_icon('calendar') ?></div>
    <div class="stat-label">Travel Date</div>
    <div class="stat-value" style="font-size:1rem;margin-top:4px"><?= $booking['travel_date'] ? date('d M Y', strtotime($booking['travel_date'])) : '—' ?></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <div class="card" style="margin-bottom:0">
    <div class="card-title">Booking Details</div>
    <table style="font-size:0.875rem;width:100%"><tbody>
      <?php $rows = [
        'Status'       => '<span class="badge '.($statusBadge[$booking['status']??'confirmed']??'badge-confirmed').'">'.ucfirst(str_replace('_',' ',$booking['status']??'confirmed')).'</span>',
        'Service'      => ucfirst($booking['service_type']??'—'),
        'Destination'  => htmlspecialchars($booking['destination']??'—'),
        'Travel Date'  => $booking['travel_date'] ? date('d M Y', strtotime($booking['travel_date'])) : '—',
        'Return Date'  => $booking['return_date']  ? date('d M Y', strtotime($booking['return_date']))  : '—',
        'Travellers'   => ($booking['adults']??1).' Adults, '.($booking['children']??0).' Children',
        'Supplier'     => htmlspecialchars($booking['supplier']??'—'),
        'Booking Ref'  => htmlspecialchars($booking['booking_ref']??'—'),
      ]; foreach ($rows as $k=>$v): ?>
      <tr>
        <td class="text-muted text-xs" style="padding:0.35rem 0;width:38%"><?= $k ?></td>
        <td style="padding:0.35rem 0"><?= $v ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php if (!empty($booking['notes'])): ?>
    <hr class="divider">
    <div class="text-xs text-muted mb-1">Notes</div>
    <p style="font-size:0.875rem"><?= nl2br(htmlspecialchars($booking['notes'])) ?></p>
    <?php endif; ?>
  </div>

  <div style="display:flex;flex-direction:column;gap:1.25rem;">
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Customer</div>
      <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:0.4rem;">
        <div class="fw-600"><?= htmlspecialchars($booking['customer_name']??'—') ?></div>
        <div><?= crm_icon('phone') ?> <a href="tel:<?= htmlspecialchars($booking['customer_phone']??'') ?>"><?= htmlspecialchars($booking['customer_phone']??'—') ?></a></div>
        <?php if (!empty($booking['customer_email'])): ?>
        <div><?= crm_icon('send') ?> <a href="mailto:<?= htmlspecialchars($booking['customer_email']) ?>"><?= htmlspecialchars($booking['customer_email']) ?></a></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Update Status</div>
      <form method="POST">
        <input type="hidden" name="update_status" value="1">
        <div style="display:flex;gap:0.5rem;">
          <select name="status" style="flex:1">
            <?php foreach (['confirmed','pending','on_hold','completed','cancelled'] as $s): ?>
            <option value="<?= $s ?>" <?= ($booking['status']??'confirmed')===$s?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary btn-sm"><?= crm_icon('check') ?></button>
        </div>
      </form>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Quick Actions</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;">
        <a href="/crm/payments/create.php?booking_id=<?= $id ?>"  class="btn btn-secondary btn-sm"><?= crm_icon('credit-card') ?> Add Payment</a>
        <a href="/crm/documents/upload.php?booking_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('upload') ?> Upload Document</a>
        <a href="/crm/followups/create.php?booking_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('phone') ?> Schedule Follow-up</a>
      </div>
    </div>
  </div>
</div>

<!-- Payments -->
<div class="card">
  <div class="card-title">
    Payments
    <a href="/crm/payments/create.php?booking_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?> Add</a>
  </div>
  <?php if (empty($payments)): ?>
    <div class="empty-state"><p>No payments recorded</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Type</th><th>Amount</th><th>Method</th><th>Reference</th><th>Date</th></tr></thead>
    <tbody>
      <?php foreach ($payments as $p): ?>
      <tr>
        <td><?= ucfirst($p['payment_type']??'payment') ?></td>
        <td class="fw-600 text-green">₹<?= number_format($p['amount']??0) ?></td>
        <td><?= ucfirst(str_replace('_',' ',$p['method']??'—')) ?></td>
        <td class="text-xs text-muted"><?= htmlspecialchars($p['reference']??'—') ?></td>
        <td class="text-xs text-muted"><?= date('d M Y', strtotime($p['paid_at']??'now')) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td class="fw-700">Total Paid</td>
        <td class="fw-700 text-green">₹<?= number_format($totalPaid) ?></td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td class="fw-700">Balance</td>
        <td class="fw-700 <?= $balance > 0 ? 'text-red' : 'text-green' ?>">₹<?= number_format(abs($balance)) ?></td>
        <td colspan="3"></td>
      </tr>
    </tfoot>
  </table></div>
  <?php endif; ?>
</div>

<!-- Documents -->
<div class="card">
  <div class="card-title">
    Documents
    <a href="/crm/documents/upload.php?booking_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('upload') ?> Upload</a>
  </div>
  <?php if (empty($documents)): ?>
    <div class="empty-state"><p>No documents uploaded</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Type</th><th>Filename</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($documents as $doc): ?>
      <tr>
        <td><?= ucfirst(str_replace('_',' ',$doc['doc_type']??'document')) ?></td>
        <td class="text-xs"><?= htmlspecialchars($doc['filename']??'—') ?></td>
        <td><span class="badge <?= $docStatusBadge[$doc['status']??'uploaded']??'badge-new' ?>"><?= ucfirst($doc['status']??'uploaded') ?></span></td>
        <td class="text-xs text-muted"><?= date('d M Y', strtotime($doc['$createdAt']??'now')) ?></td>
        <td>
          <?php if (!empty($doc['file_url'])): ?>
          <a href="<?= htmlspecialchars($doc['file_url']) ?>" target="_blank" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>