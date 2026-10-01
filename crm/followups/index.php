<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('followups.view');

$pageTitle = 'Follow-ups';
$activeNav = 'Follow-ups';

$db     = appwrite();
$filter = $_GET['filter'] ?? 'today'; // today | overdue | upcoming | all
$today  = date('Y-m-d');

$queries = ['equal("done",false)', 'orderAsc("scheduled_at")', 'limit(50)'];
switch ($filter) {
    case 'overdue':
        $queries[] = 'lessThan("scheduled_at","' . $today . 'T00:00:00")';
        break;
    case 'today':
        $queries[] = 'greaterThanEqual("scheduled_at","' . $today . 'T00:00:00")';
        $queries[] = 'lessThan("scheduled_at","' . $today . 'T23:59:59")';
        break;
    case 'upcoming':
        $queries[] = 'greaterThan("scheduled_at","' . $today . 'T23:59:59")';
        break;
    case 'all':
        $queries = ['orderDesc("scheduled_at")', 'limit(50)'];
        break;
}

$result    = $db->listDocuments(COL_FOLLOWUPS, $queries);
$followups = $result['documents'] ?? [];
$total     = $result['total'] ?? count($followups);

// Counts for tabs
$overdueCount  = ($db->listDocuments(COL_FOLLOWUPS, ['equal("done",false)','lessThan("scheduled_at","'.$today.'T00:00:00")','limit(1)']))['total'] ?? 0;
$todayCount    = ($db->listDocuments(COL_FOLLOWUPS, ['equal("done",false)','greaterThanEqual("scheduled_at","'.$today.'T00:00:00")','lessThan("scheduled_at","'.$today.'T23:59:59")','limit(1)']))['total'] ?? 0;
$upcomingCount = ($db->listDocuments(COL_FOLLOWUPS, ['equal("done",false)','greaterThan("scheduled_at","'.$today.'T23:59:59")','limit(1)']))['total'] ?? 0;

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Follow-ups</h1><p><?= $total ?> <?= $filter ?> follow-ups</p></div>
  <a href="/crm/followups/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> Schedule Follow-up</a>
</div>

<!-- Tabs -->
<div style="display:flex;gap:0.5rem;margin-bottom:1.25rem;flex-wrap:wrap;">
  <?php $tabs = ['overdue'=>['Overdue',$overdueCount,'badge-lost'],'today'=>['Today',$todayCount,'badge-quoted'],'upcoming'=>['Upcoming',$upcomingCount,'badge-new'],'all'=>['All',null,null]]; ?>
  <?php foreach ($tabs as $key=>[$label,$count,$cls]): ?>
  <a href="?filter=<?= $key ?>" class="btn <?= $filter===$key?'btn-primary':'btn-secondary' ?>">
    <?= $label ?>
    <?php if ($count !== null): ?><span class="badge <?= $cls ?>" style="margin-left:4px"><?= $count ?></span><?php endif; ?>
  </a>
  <?php endforeach; ?>
</div>

<div class="card">
  <?php if (empty($followups)): ?>
    <div class="empty-state"><?= crm_icon('phone') ?><p>No follow-ups in this category</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Customer</th><th>Type</th><th>Scheduled</th><th>Notes</th><th>Linked To</th><th>Done</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($followups as $fu): ?>
        <?php $isPast = strtotime($fu['scheduled_at']??'now') < time(); ?>
        <tr <?= ($isPast && !$fu['done']) ? 'style="background:rgba(239,68,68,0.04)"' : '' ?>>
          <td class="fw-600"><?= htmlspecialchars($fu['customer_name']??'—') ?></td>
          <td>
            <?php $typeIcons=['call'=>'📞','whatsapp'=>'💬','email'=>'📧','meeting'=>'🤝','custom'=>'📝']; ?>
            <?= ($typeIcons[$fu['type']??'call']??'📞') . ' ' . ucfirst($fu['type']??'call') ?>
          </td>
          <td class="text-xs <?= ($isPast && !$fu['done']) ? 'text-red' : '' ?>">
            <?= date('d M Y H:i', strtotime($fu['scheduled_at']??'now')) ?>
          </td>
          <td class="text-xs text-muted"><?= htmlspecialchars(substr($fu['notes']??'',0,60)) ?></td>
          <td class="text-xs">
            <?php if (!empty($fu['enquiry_id'])): ?>
              <a href="/crm/enquiries/view.php?id=<?= $fu['enquiry_id'] ?>">Enquiry</a>
            <?php elseif (!empty($fu['lead_id'])): ?>
              <a href="/crm/leads/view.php?id=<?= $fu['lead_id'] ?>">Lead</a>
            <?php else: echo '—'; endif; ?>
          </td>
          <td><?= $fu['done'] ? '<span class="badge badge-confirmed">Done</span>' : '<span class="badge badge-new">Pending</span>' ?></td>
          <td>
            <div class="actions">
              <?php if (!$fu['done']): ?>
              <a href="/crm/followups/done.php?id=<?= $fu['$id'] ?>" class="btn btn-success btn-sm btn-icon" title="Mark Done"><?= crm_icon('check') ?></a>
              <?php endif; ?>
              <a href="/crm/followups/edit.php?id=<?= $fu['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('edit') ?></a>
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