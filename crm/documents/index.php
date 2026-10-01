<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$pageTitle = 'Documents';
$activeNav = 'Documents';

$db      = appwrite();
$filter  = $_GET['status'] ?? '';
$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($filter) $queries[] = 'equal("status","'.$filter.'")';

$result    = $db->listDocuments(COL_DOCUMENTS, $queries);
$documents = $result['documents'] ?? [];
$total     = $result['total'] ?? count($documents);

$statusBadge = ['pending'=>'badge-quoted','uploaded'=>'badge-new','verified'=>'badge-confirmed','rejected'=>'badge-lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Documents</h1><p><?= $total ?> documents</p></div>
  <a href="/crm/documents/upload.php" class="btn btn-primary"><?= crm_icon('upload') ?> Upload Document</a>
</div>

<div class="filters-row">
  <?php foreach ([''=>'All','pending'=>'Pending','uploaded'=>'Uploaded','verified'=>'Verified','rejected'=>'Rejected'] as $v=>$l): ?>
  <a href="?status=<?= $v ?>" class="btn <?= $filter===$v?'btn-primary':'btn-secondary' ?> btn-sm"><?= $l ?></a>
  <?php endforeach; ?>
</div>

<div class="card">
  <?php if (empty($documents)): ?>
    <div class="empty-state"><?= crm_icon('folder') ?><p>No documents found</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Customer</th><th>Document Type</th><th>Filename</th><th>Linked To</th><th>Status</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($documents as $doc): ?>
        <tr>
          <td class="fw-600"><?= htmlspecialchars($doc['customer_name']??'—') ?></td>
          <td><?= ucfirst(str_replace('_',' ',$doc['doc_type']??'document')) ?></td>
          <td class="text-xs text-muted"><?= htmlspecialchars($doc['filename']??'—') ?></td>
          <td class="text-xs">
            <?php if (!empty($doc['booking_id'])): ?>
              <a href="/crm/bookings/view.php?id=<?= $doc['booking_id'] ?>">Booking</a>
            <?php elseif (!empty($doc['enquiry_id'])): ?>
              <a href="/crm/enquiries/view.php?id=<?= $doc['enquiry_id'] ?>">Enquiry</a>
            <?php else: echo '—'; endif; ?>
          </td>
          <td>
            <span class="badge <?= $statusBadge[$doc['status']??'uploaded']??'badge-new' ?>"><?= ucfirst($doc['status']??'uploaded') ?></span>
          </td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($doc['$createdAt']??'now')) ?></td>
          <td>
            <div class="actions">
              <?php if (!empty($doc['file_url'])): ?>
              <a href="<?= htmlspecialchars($doc['file_url']) ?>" target="_blank" class="btn btn-secondary btn-sm btn-icon" title="View"><?= crm_icon('eye') ?></a>
              <?php endif; ?>
              <a href="/crm/documents/verify.php?id=<?= $doc['$id'] ?>&status=verified" class="btn btn-success btn-sm btn-icon" title="Verify"><?= crm_icon('check') ?></a>
              <a href="/crm/documents/verify.php?id=<?= $doc['$id'] ?>&status=rejected" class="btn btn-danger btn-sm btn-icon" title="Reject"><?= crm_icon('x') ?></a>
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