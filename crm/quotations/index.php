<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('quotations.view');

$pageTitle = 'Quotations';
$activeNav = 'Quotations';

$db      = appwrite();
$filter  = $_GET['status'] ?? '';
$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($filter) $queries[] = 'equal("status","'.$filter.'")';

$result     = $db->listDocuments(COL_QUOTATIONS, $queries);
$quotations = $result['documents'] ?? [];
$total      = $result['total'] ?? count($quotations);

$statusBadge = ['draft'=>'badge-new','sent'=>'badge-contacted','accepted'=>'badge-confirmed','rejected'=>'badge-lost','expired'=>'badge-lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Quotations</h1><p><?= $total ?> quotations</p></div>
  <a href="/crm/quotations/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New Quotation</a>
</div>

<div class="filters-row">
  <?php foreach ([''=>'All','draft'=>'Draft','sent'=>'Sent','accepted'=>'Accepted','rejected'=>'Rejected','expired'=>'Expired'] as $v=>$l): ?>
  <a href="?status=<?= $v ?>" class="btn <?= $filter===$v?'btn-primary':'btn-secondary' ?> btn-sm"><?= $l ?></a>
  <?php endforeach; ?>
</div>

<div class="card">
  <?php if (empty($quotations)): ?>
    <div class="empty-state"><?= crm_icon('file-text') ?><p>No quotations found</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Quotation ID</th><th>Customer</th><th>Destination</th><th>Total</th><th>Version</th><th>Status</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($quotations as $q): ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($q['quotation_id']??substr($q['$id'],0,8)) ?></td>
          <td class="fw-600"><?= htmlspecialchars($q['customer_name']??'—') ?></td>
          <td><?= htmlspecialchars($q['destination']??'—') ?></td>
          <td class="fw-600 text-gold">₹<?= number_format($q['total']??0) ?></td>
          <td class="text-xs">v<?= (int)($q['version']??1) ?></td>
          <td><span class="badge <?= $statusBadge[$q['status']??'draft']??'badge-new' ?>"><?= ucfirst($q['status']??'draft') ?></span></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($q['$createdAt']??'now')) ?></td>
          <td>
            <div class="actions">
              <a href="/crm/quotations/view.php?id=<?= $q['$id'] ?>"   class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
              <a href="/crm/quotations/edit.php?id=<?= $q['$id'] ?>"   class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('edit') ?></a>
              <a href="/crm/bookings/create.php?quotation_id=<?= $q['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Convert to Booking"><?= crm_icon('bookmark') ?></a>
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