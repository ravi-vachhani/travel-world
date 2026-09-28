<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle = 'Enquiries';
$activeNav = 'Enquiries';

$db            = appwrite();
$filterStatus  = $_GET['status']  ?? '';
$filterService = $_GET['service'] ?? '';
$search        = trim($_GET['q']  ?? '');

$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($filterStatus)  $queries[] = 'equal("status","'.$filterStatus.'")';
if ($filterService) $queries[] = 'equal("service_type","'.$filterService.'")';

$result    = $db->listDocuments(COL_ENQUIRIES, $queries);
$enquiries = $result['documents'] ?? [];
$total     = $result['total'] ?? count($enquiries);

$statusBadge  = ['new'=>'badge-new','contacted'=>'badge-contacted','requirement'=>'badge-quoted','quoted'=>'badge-quoted','follow_up'=>'badge-quoted','negotiation'=>'badge-contacted','confirmed'=>'badge-confirmed','booking'=>'badge-gold','completed'=>'badge-completed','lost'=>'badge-lost'];
$serviceIcons = ['flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨','transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋'];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Enquiries</h1><p><?= $total ?> total enquiries</p></div>
  <a href="/crm/enquiries/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New Enquiry</a>
</div>

<div class="filters-row">
  <form method="GET" style="display:contents">
    <div class="search-bar" style="flex:1;min-width:200px;max-width:320px">
      <?= crm_icon('search') ?>
      <input type="text" name="q" placeholder="Search…" value="<?= htmlspecialchars($search) ?>">
    </div>
    <select name="status" onchange="this.form.submit()">
      <option value="">All Statuses</option>
      <?php foreach (['new','contacted','requirement','quoted','follow_up','negotiation','confirmed','booking','completed','lost'] as $s): ?>
      <option value="<?= $s ?>" <?= $filterStatus===$s?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="service" onchange="this.form.submit()">
      <option value="">All Services</option>
      <?php foreach (['flight','visa','package','hotel','transfer','insurance','cruise','other'] as $sv): ?>
      <option value="<?= $sv ?>" <?= $filterService===$sv?'selected':'' ?>><?= ucfirst($sv) ?></option>
      <?php endforeach; ?>
    </select>
  </form>
</div>

<div class="card">
  <?php if (empty($enquiries)): ?>
    <div class="empty-state"><?= crm_icon('message-square') ?><p>No enquiries found</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Enquiry ID</th><th>Customer</th><th>Service</th><th>Destination</th><th>Travel Date</th><th>Status</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($enquiries as $e): ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($e['enquiry_id']??substr($e['$id'],0,8)) ?></td>
          <td>
            <a href="/crm/enquiries/view.php?id=<?= $e['$id'] ?>" class="fw-600"><?= htmlspecialchars($e['customer_name']??'—') ?></a>
            <div class="text-xs text-muted"><?= htmlspecialchars($e['customer_phone']??'') ?></div>
          </td>
          <td><?= ($serviceIcons[$e['service_type']??'other']??'📋').' '.ucfirst($e['service_type']??'—') ?></td>
          <td><?= htmlspecialchars($e['destination']??'—') ?></td>
          <td class="text-xs"><?= $e['travel_date'] ? date('d M Y', strtotime($e['travel_date'])) : '—' ?></td>
          <td><span class="badge <?= $statusBadge[$e['status']??'new']??'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$e['status']??'new')) ?></span></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($e['$createdAt']??'now')) ?></td>
          <td>
            <div class="actions">
              <a href="/crm/enquiries/view.php?id=<?= $e['$id'] ?>"      class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
              <a href="/crm/enquiries/edit.php?id=<?= $e['$id'] ?>"      class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('edit') ?></a>
              <a href="/crm/quotations/create.php?enquiry_id=<?= $e['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Create Quotation"><?= crm_icon('file-text') ?></a>
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