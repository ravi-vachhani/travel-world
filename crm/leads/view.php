<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/leads/'); exit; }

$db   = appwrite();
$lead = $db->getDocument(COL_LEADS, $id);
if (empty($lead['$id'])) { header('Location: /crm/leads/'); exit; }

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $db->updateDocument(COL_LEADS, $id, ['status' => $_POST['status']]);
    header('Location: /crm/leads/view.php?id=' . $id . '&updated=1');
    exit;
}

// Fetch related enquiries
$enquiries = $db->listDocuments(COL_ENQUIRIES, ['equal("lead_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(10)']);
$enquiries = $enquiries['documents'] ?? [];

// Fetch follow-ups
$followups = $db->listDocuments(COL_FOLLOWUPS, ['equal("lead_id","'.$id.'")', 'orderDesc("scheduled_at")', 'limit(10)']);
$followups = $followups['documents'] ?? [];

$pageTitle = 'Lead: ' . ($lead['name'] ?? '');
$activeNav = 'Leads';

$statusBadge = [
    'new'=>'badge-new','contacted'=>'badge-contacted','requirement'=>'badge-quoted',
    'quoted'=>'badge-quoted','follow_up'=>'badge-quoted','negotiation'=>'badge-contacted',
    'confirmed'=>'badge-confirmed','booking'=>'badge-gold','completed'=>'badge-completed','lost'=>'badge-lost',
];
$serviceIcons = ['flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨','transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋'];

require_once __DIR__ . '/../includes/layout.php';
?>

<?php if (isset($_GET['created'])): ?>
  <div class="flash flash-success"><?= crm_icon('check') ?> Lead created successfully!</div>
<?php elseif (isset($_GET['updated'])): ?>
  <div class="flash flash-success"><?= crm_icon('check') ?> Lead updated.</div>
<?php endif; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($lead['name']) ?></h1>
    <p>Lead ID: <?= htmlspecialchars($lead['lead_id'] ?? substr($lead['$id'],0,8)) ?> &nbsp;·&nbsp;
       Created: <?= date('d M Y', strtotime($lead['$createdAt'])) ?></p>
  </div>
  <div style="display:flex;gap:0.75rem;">
    <a href="/crm/leads/edit.php?id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('edit') ?> Edit</a>
    <a href="/crm/enquiries/create.php?lead_id=<?= $id ?>" class="btn btn-primary"><?= crm_icon('plus') ?> New Enquiry</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <!-- Lead Details -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">Lead Details</div>
    <table style="font-size:0.875rem;">
      <tbody>
        <tr><td class="text-muted" style="width:40%;padding:0.4rem 0">Status</td>
            <td><span class="badge <?= $statusBadge[$lead['status']??'new']??'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$lead['status']??'new')) ?></span></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Service</td>
            <td><?= ($serviceIcons[$lead['service_type']??'other']??'📋') . ' ' . ucfirst($lead['service_type']??'—') ?></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Destination</td>
            <td><?= htmlspecialchars($lead['destination']??'—') ?></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Travel Date</td>
            <td><?= $lead['travel_date'] ? date('d M Y', strtotime($lead['travel_date'])) : '—' ?></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Travellers</td>
            <td><?= ($lead['adults']??1) ?> Adults, <?= ($lead['children']??0) ?> Children</td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Budget</td>
            <td><?= htmlspecialchars($lead['budget']??'—') ?></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Source</td>
            <td><?= ucfirst(str_replace('_',' ',$lead['source']??'—')) ?></td></tr>
        <tr><td class="text-muted" style="padding:0.4rem 0">Assigned To</td>
            <td><?= htmlspecialchars($lead['assigned_to']??'Unassigned') ?></td></tr>
      </tbody>
    </table>
    <?php if (!empty($lead['notes'])): ?>
      <hr class="divider">
      <div class="text-xs text-muted mb-1">Notes</div>
      <p style="font-size:0.875rem"><?= nl2br(htmlspecialchars($lead['notes'])) ?></p>
    <?php endif; ?>
  </div>

  <!-- Contact + Status Update -->
  <div style="display:flex;flex-direction:column;gap:1.25rem;">
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Contact</div>
      <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.875rem;">
        <div><?= crm_icon('phone') ?> &nbsp;<a href="tel:<?= htmlspecialchars($lead['phone']??'') ?>"><?= htmlspecialchars($lead['phone']??'—') ?></a></div>
        <?php if (!empty($lead['email'])): ?>
        <div><?= crm_icon('send') ?> &nbsp;<a href="mailto:<?= htmlspecialchars($lead['email']) ?>"><?= htmlspecialchars($lead['email']) ?></a></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Update Status</div>
      <form method="POST">
        <input type="hidden" name="update_status" value="1">
        <div style="display:flex;gap:0.75rem;align-items:center;">
          <select name="status" style="flex:1">
            <?php foreach (['new','contacted','requirement','quoted','follow_up','negotiation','confirmed','booking','completed','lost'] as $s): ?>
            <option value="<?= $s ?>" <?= ($lead['status']??'new')===$s?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary btn-sm"><?= crm_icon('check') ?> Update</button>
        </div>
      </form>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Quick Actions</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;">
        <a href="/crm/followups/create.php?lead_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('phone') ?> Schedule Follow-up</a>
        <a href="/crm/enquiries/create.php?lead_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('message-square') ?> Create Enquiry</a>
        <a href="/crm/customers/create.php?lead_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('user-check') ?> Convert to Customer</a>
      </div>
    </div>
  </div>
</div>

<!-- Enquiries -->
<div class="card">
  <div class="card-title">
    Enquiries (<?= count($enquiries) ?>)
    <a href="/crm/enquiries/create.php?lead_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?> Add</a>
  </div>
  <?php if (empty($enquiries)): ?>
    <div class="empty-state"><p>No enquiries yet</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Service</th><th>Destination</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($enquiries as $enq): ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($enq['enquiry_id']??substr($enq['$id'],0,8)) ?></td>
          <td><?= ($serviceIcons[$enq['service_type']??'other']??'📋') . ' ' . ucfirst($enq['service_type']??'—') ?></td>
          <td><?= htmlspecialchars($enq['destination']??'—') ?></td>
          <td><span class="badge <?= $statusBadge[$enq['status']??'new']??'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$enq['status']??'new')) ?></span></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($enq['$createdAt']??'now')) ?></td>
          <td><a href="/crm/enquiries/view.php?id=<?= $enq['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- Follow-ups -->
<div class="card">
  <div class="card-title">
    Follow-ups (<?= count($followups) ?>)
    <a href="/crm/followups/create.php?lead_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?> Add</a>
  </div>
  <?php if (empty($followups)): ?>
    <div class="empty-state"><p>No follow-ups scheduled</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Type</th><th>Scheduled</th><th>Notes</th><th>Done</th></tr></thead>
      <tbody>
        <?php foreach ($followups as $fu): ?>
        <tr>
          <td><?= ucfirst($fu['type']??'call') ?></td>
          <td class="text-xs"><?= date('d M Y H:i', strtotime($fu['scheduled_at']??'now')) ?></td>
          <td class="text-xs text-muted"><?= htmlspecialchars(substr($fu['notes']??'',0,60)) ?></td>
          <td><?= $fu['done'] ? '<span class="badge badge-confirmed">Done</span>' : '<span class="badge badge-new">Pending</span>' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>