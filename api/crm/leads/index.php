<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle = 'Leads';
$activeNav = 'Leads';

$db = appwrite();

// Filters
$filterStatus  = $_GET['status']  ?? '';
$filterService = $_GET['service'] ?? '';
$search        = trim($_GET['q']  ?? '');

$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($filterStatus)  $queries[] = 'equal("status","' . $filterStatus . '")';
if ($filterService) $queries[] = 'equal("service_type","' . $filterService . '")';
if ($search)        $queries[] = 'search("name","' . addslashes($search) . '")';

$result = $db->listDocuments(COL_LEADS, $queries);
$leads  = $result['documents'] ?? [];
$total  = $result['total'] ?? count($leads);

$statusBadge = [
    'new'         => 'badge-new',
    'contacted'   => 'badge-contacted',
    'requirement' => 'badge-quoted',
    'quoted'      => 'badge-quoted',
    'follow_up'   => 'badge-quoted',
    'negotiation' => 'badge-contacted',
    'confirmed'   => 'badge-confirmed',
    'booking'     => 'badge-gold',
    'completed'   => 'badge-completed',
    'lost'        => 'badge-lost',
];
$serviceIcons = [
    'flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨',
    'transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋',
];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div>
    <h1>Leads</h1>
    <p><?= $total ?> total leads</p>
  </div>
  <a href="/crm/leads/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New Lead</a>
</div>

<!-- Filters -->
<div class="filters-row">
  <form method="GET" style="display:contents">
    <div class="search-bar" style="flex:1;min-width:200px;max-width:320px">
      <?= crm_icon('search') ?>
      <input type="text" name="q" placeholder="Search by name…" value="<?= htmlspecialchars($search) ?>">
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
    <?php if ($search): ?><a href="/crm/leads/" class="btn btn-secondary btn-sm">Clear</a><?php endif; ?>
  </form>
</div>

<div class="card">
  <?php if (empty($leads)): ?>
    <div class="empty-state">
      <?= crm_icon('users') ?>
      <p>No leads found. <a href="/crm/leads/create.php">Add your first lead</a></p>
    </div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Lead ID</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Service</th>
          <th>Source</th>
          <th>Status</th>
          <th>Assigned To</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($leads as $lead): ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($lead['lead_id'] ?? substr($lead['$id'],0,8)) ?></td>
          <td>
            <a href="/crm/leads/view.php?id=<?= $lead['$id'] ?>" class="fw-600">
              <?= htmlspecialchars($lead['name'] ?? '—') ?>
            </a>
          </td>
          <td>
            <div><?= htmlspecialchars($lead['phone'] ?? '—') ?></div>
            <div class="text-xs text-muted"><?= htmlspecialchars($lead['email'] ?? '') ?></div>
          </td>
          <td><?= ($serviceIcons[$lead['service_type']??'other']??'📋') . ' ' . ucfirst($lead['service_type']??'—') ?></td>
          <td class="text-xs"><?= ucfirst(str_replace('_',' ',$lead['source']??'—')) ?></td>
          <td><span class="badge <?= $statusBadge[$lead['status']??'new']??'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$lead['status']??'new')) ?></span></td>
          <td class="text-xs"><?= htmlspecialchars($lead['assigned_to']??'Unassigned') ?></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($lead['$createdAt']??'now')) ?></td>
          <td>
            <div class="actions">
              <a href="/crm/leads/view.php?id=<?= $lead['$id'] ?>"   class="btn btn-secondary btn-sm btn-icon" title="View"><?= crm_icon('eye') ?></a>
              <a href="/crm/leads/edit.php?id=<?= $lead['$id'] ?>"   class="btn btn-secondary btn-sm btn-icon" title="Edit"><?= crm_icon('edit') ?></a>
              <a href="/crm/enquiries/create.php?lead_id=<?= $lead['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="New Enquiry"><?= crm_icon('message-square') ?></a>
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