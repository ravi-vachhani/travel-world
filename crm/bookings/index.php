<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('bookings.view');

$pageTitle = 'Bookings';
$activeNav = 'Bookings';

$db     = appwrite();
$filter = $_GET['status'] ?? '';
$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($filter) $queries[] = 'equal("status","'.$filter.'")';

$result   = $db->listDocuments(COL_BOOKINGS, $queries);
$bookings = $result['documents'] ?? [];
$total    = $result['total'] ?? count($bookings);

$statusBadge = ['confirmed'=>'badge-confirmed','pending'=>'badge-quoted','cancelled'=>'badge-lost','completed'=>'badge-completed','on_hold'=>'badge-contacted'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Bookings</h1><p><?= $total ?> bookings</p></div>
  <a href="/crm/bookings/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New Booking</a>
</div>

<div class="filters-row">
  <?php foreach ([''=>'All','confirmed'=>'Confirmed','pending'=>'Pending','completed'=>'Completed','cancelled'=>'Cancelled','on_hold'=>'On Hold'] as $v=>$l): ?>
  <a href="?status=<?= $v ?>" class="btn <?= $filter===$v?'btn-primary':'btn-secondary' ?> btn-sm"><?= $l ?></a>
  <?php endforeach; ?>
</div>

<div class="card">
  <?php if (empty($bookings)): ?>
    <div class="empty-state"><?= crm_icon('bookmark') ?><p>No bookings found</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Booking ID</th><th>Customer</th><th>Destination</th><th>Travel Date</th><th>Total</th><th>Paid</th><th>Balance</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($bookings as $b): ?>
        <?php
          $total_amt = (float)($b['total_amount']??0);
          $paid_amt  = (float)($b['paid_amount']??0);
          $balance   = $total_amt - $paid_amt;
        ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($b['booking_id']??substr($b['$id'],0,8)) ?></td>
          <td>
            <a href="/crm/bookings/view.php?id=<?= $b['$id'] ?>" class="fw-600"><?= htmlspecialchars($b['customer_name']??'—') ?></a>
            <div class="text-xs text-muted"><?= htmlspecialchars($b['customer_phone']??'') ?></div>
          </td>
          <td><?= htmlspecialchars($b['destination']??'—') ?></td>
          <td class="text-xs"><?= $b['travel_date'] ? date('d M Y', strtotime($b['travel_date'])) : '—' ?></td>
          <td class="fw-600">₹<?= number_format($total_amt) ?></td>
          <td class="text-green">₹<?= number_format($paid_amt) ?></td>
          <td class="<?= $balance > 0 ? 'text-red' : 'text-green' ?> fw-600">₹<?= number_format($balance) ?></td>
          <td><span class="badge <?= $statusBadge[$b['status']??'confirmed']??'badge-confirmed' ?>"><?= ucfirst(str_replace('_',' ',$b['status']??'confirmed')) ?></span></td>
          <td>
            <div class="actions">
              <a href="/crm/bookings/view.php?id=<?= $b['$id'] ?>"    class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
              <a href="/crm/payments/create.php?booking_id=<?= $b['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Add Payment"><?= crm_icon('credit-card') ?></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>