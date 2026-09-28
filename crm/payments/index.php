<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle = 'Payments';
$activeNav = 'Payments';

$db      = appwrite();
$queries = ['orderDesc("paid_at")', 'limit(50)'];

$result   = $db->listDocuments(COL_PAYMENTS, $queries);
$payments = $result['documents'] ?? [];
$total    = $result['total'] ?? count($payments);
$totalAmt = array_sum(array_column($payments, 'amount'));

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Payments</h1><p><?= $total ?> payment records</p></div>
  <a href="/crm/payments/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> Record Payment</a>
</div>

<div class="stat-grid" style="margin-bottom:1.25rem">
  <div class="stat-card green">
    <div class="stat-icon"><?= crm_icon('dollar-sign') ?></div>
    <div class="stat-label">Total Collected</div>
    <div class="stat-value" style="font-size:1.4rem">₹<?= number_format($totalAmt) ?></div>
  </div>
  <div class="stat-card blue">
    <div class="stat-icon"><?= crm_icon('credit-card') ?></div>
    <div class="stat-label">Transactions</div>
    <div class="stat-value"><?= $total ?></div>
  </div>
</div>

<div class="card">
  <?php if (empty($payments)): ?>
    <div class="empty-state"><?= crm_icon('credit-card') ?><p>No payments recorded</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Customer</th><th>Booking ID</th><th>Type</th><th>Amount</th><th>Method</th><th>Reference</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($payments as $p): ?>
        <tr>
          <td class="fw-600"><?= htmlspecialchars($p['customer_name']??'—') ?></td>
          <td class="text-xs text-muted">
            <?php if (!empty($p['booking_id'])): ?>
            <a href="/crm/bookings/view.php?id=<?= $p['booking_id'] ?>"><?= htmlspecialchars(substr($p['booking_id'],0,12)) ?></a>
            <?php else: echo '—'; endif; ?>
          </td>
          <td>
            <?php $typeColors=['advance'=>'badge-quoted','partial'=>'badge-contacted','final'=>'badge-confirmed','refund'=>'badge-lost']; ?>
            <span class="badge <?= $typeColors[$p['payment_type']??'advance']??'badge-new' ?>"><?= ucfirst($p['payment_type']??'payment') ?></span>
          </td>
          <td class="fw-600 text-green">₹<?= number_format($p['amount']??0) ?></td>
          <td class="text-xs"><?= ucfirst(str_replace('_',' ',$p['method']??'—')) ?></td>
          <td class="text-xs text-muted"><?= htmlspecialchars($p['reference']??'—') ?></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($p['paid_at']??'now')) ?></td>
          <td>
            <?php if (!empty($p['booking_id'])): ?>
            <a href="/crm/bookings/view.php?id=<?= $p['booking_id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="fw-700" style="padding:0.75rem">Total</td>
          <td class="fw-700 text-green" style="padding:0.75rem">₹<?= number_format($totalAmt) ?></td>
          <td colspan="4"></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>