<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$pageTitle = 'Upcoming Travel';
$activeNav = 'Upcoming Travel';

$db     = appwrite();
$today  = date('Y-m-d');
$filter = $_GET['filter'] ?? 'upcoming';

switch ($filter) {
    case 'this_week':
        $from = $today;
        $to   = date('Y-m-d', strtotime('+7 days'));
        break;
    case 'this_month':
        $from = $today;
        $to   = date('Y-m-d', strtotime('+30 days'));
        break;
    case 'completed':
        $queries = ['equal("status","completed")', 'orderDesc("travel_date")', 'limit(50)'];
        break;
    default: // upcoming
        $from = $today;
        $to   = date('Y-m-d', strtotime('+90 days'));
}

if ($filter !== 'completed') {
    $queries = [
        'greaterThanEqual("travel_date","'.$from.'")',
        'lessThanEqual("travel_date","'.$to.'")',
        'orderAsc("travel_date")',
        'limit(50)',
    ];
}

$result   = $db->listDocuments(COL_BOOKINGS, $queries);
$bookings = $result['documents'] ?? [];
$total    = $result['total'] ?? count($bookings);

$statusBadge = ['confirmed'=>'badge-confirmed','pending'=>'badge-quoted','cancelled'=>'badge-lost','completed'=>'badge-completed','on_hold'=>'badge-contacted'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Upcoming Travel</h1><p><?= $total ?> departures</p></div>
</div>

<div class="filters-row">
  <?php foreach (['upcoming'=>'All Upcoming','this_week'=>'This Week','this_month'=>'Next 30 Days','completed'=>'Completed'] as $v=>$l): ?>
  <a href="?filter=<?= $v ?>" class="btn <?= $filter===$v?'btn-primary':'btn-secondary' ?> btn-sm"><?= $l ?></a>
  <?php endforeach; ?>
</div>

<div class="card">
  <?php if (empty($bookings)): ?>
    <div class="empty-state"><?= crm_icon('map') ?><p>No upcoming travel in this period</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Customer</th><th>Destination</th><th>Service</th><th>Travel Date</th><th>Return</th><th>Travellers</th><th>Balance</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($bookings as $b): ?>
        <?php
          $daysLeft = (int)((strtotime($b['travel_date']??'now') - time()) / 86400);
          $balance  = (float)($b['total_amount']??0) - (float)($b['paid_amount']??0);
        ?>
        <tr>
          <td>
            <div class="fw-600"><?= htmlspecialchars($b['customer_name']??'—') ?></div>
            <div class="text-xs text-muted"><?= htmlspecialchars($b['customer_phone']??'') ?></div>
          </td>
          <td><?= htmlspecialchars($b['destination']??'—') ?></td>
          <td class="text-xs"><?= ucfirst($b['service_type']??'—') ?></td>
          <td>
            <div><?= $b['travel_date'] ? date('d M Y', strtotime($b['travel_date'])) : '—' ?></div>
            <?php if ($daysLeft >= 0 && $filter !== 'completed'): ?>
            <div class="text-xs <?= $daysLeft <= 3 ? 'text-red' : 'text-muted' ?>">
              <?= $daysLeft === 0 ? 'Today!' : ($daysLeft === 1 ? 'Tomorrow' : 'in '.$daysLeft.' days') ?>
            </div>
            <?php endif; ?>
          </td>
          <td class="text-xs"><?= $b['return_date'] ? date('d M Y', strtotime($b['return_date'])) : '—' ?></td>
          <td class="text-xs"><?= ($b['adults']??1).'A '.($b['children']??0).'C' ?></td>
          <td class="<?= $balance > 0 ? 'text-red fw-600' : 'text-green' ?>">
            <?= $balance > 0 ? '₹'.number_format($balance).' due' : '✓ Paid' ?>
          </td>
          <td><span class="badge <?= $statusBadge[$b['status']??'confirmed']??'badge-confirmed' ?>"><?= ucfirst(str_replace('_',' ',$b['status']??'confirmed')) ?></span></td>
          <td>
            <div class="actions">
              <a href="/crm/bookings/view.php?id=<?= $b['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
              <?php if ($balance > 0): ?>
              <a href="/crm/payments/create.php?booking_id=<?= $b['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Add Payment"><?= crm_icon('credit-card') ?></a>
              <?php endif; ?>
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