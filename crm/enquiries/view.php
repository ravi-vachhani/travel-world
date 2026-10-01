<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/enquiries/'); exit; }

$db  = appwrite();
$enq = $db->getDocument(COL_ENQUIRIES, $id);
if (empty($enq['$id'])) { header('Location: /crm/enquiries/'); exit; }

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $db->updateDocument(COL_ENQUIRIES, $id, ['status' => $_POST['status']]);
    header('Location: /crm/enquiries/view.php?id=' . $id . '&updated=1');
    exit;
}

$details   = json_decode($enq['details'] ?? '{}', true) ?: [];
$followups = ($db->listDocuments(COL_FOLLOWUPS,  ['equal("enquiry_id","'.$id.'")', 'orderDesc("scheduled_at")', 'limit(10)']))['documents'] ?? [];
$quotations= ($db->listDocuments(COL_QUOTATIONS, ['equal("enquiry_id","'.$id.'")', 'orderDesc("$createdAt")', 'limit(5)']))['documents']  ?? [];

$pageTitle = 'Enquiry: ' . ($enq['customer_name'] ?? '');
$activeNav = 'Enquiries';

$statusBadge  = ['new'=>'badge-new','contacted'=>'badge-contacted','requirement'=>'badge-quoted','quoted'=>'badge-quoted','follow_up'=>'badge-quoted','negotiation'=>'badge-contacted','confirmed'=>'badge-confirmed','booking'=>'badge-gold','completed'=>'badge-completed','lost'=>'badge-lost'];
$serviceIcons = ['flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨','transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋'];

require_once __DIR__ . '/../includes/layout.php';
?>

<?php if (isset($_GET['created'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Enquiry created!</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Updated.</div><?php endif; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($enq['customer_name']??'Enquiry') ?></h1>
    <p>Enquiry ID: <?= htmlspecialchars($enq['enquiry_id']??substr($enq['$id'],0,8)) ?> &nbsp;·&nbsp; <?= date('d M Y', strtotime($enq['$createdAt'])) ?></p>
  </div>
  <div style="display:flex;gap:0.75rem;">
    <a href="/crm/enquiries/edit.php?id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('edit') ?> Edit</a>
    <a href="/crm/quotations/create.php?enquiry_id=<?= $id ?>" class="btn btn-primary"><?= crm_icon('file-text') ?> Create Quotation</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <div class="card" style="margin-bottom:0">
    <div class="card-title">Enquiry Details</div>
    <table style="font-size:0.875rem;width:100%"><tbody>
      <?php $rows = [
        'Service'      => ($serviceIcons[$enq['service_type']??'other']??'📋').' '.ucfirst($enq['service_type']??'—'),
        'Destination'  => htmlspecialchars($enq['destination']??'—'),
        'Travel Date'  => $enq['travel_date'] ? date('d M Y', strtotime($enq['travel_date'])) : '—',
        'Adults'       => ($enq['adults']??1).' Adults, '.($enq['children']??0).' Children',
        'Budget'       => htmlspecialchars($enq['budget']??'—'),
        'Assigned To'  => htmlspecialchars($enq['assigned_to']??'Unassigned'),
        'Status'       => '<span class="badge '.($statusBadge[$enq['status']??'new']??'badge-new').'">'.ucfirst(str_replace('_',' ',$enq['status']??'new')).'</span>',
      ]; foreach ($rows as $k=>$v): ?>
      <tr>
        <td class="text-muted text-xs" style="padding:0.35rem 0;width:38%"><?= $k ?></td>
        <td style="padding:0.35rem 0"><?= $v ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody></table>

    <?php if (!empty($details)): ?>
    <hr class="divider">
    <div class="text-xs text-muted mb-1">Service Details</div>
    <table style="font-size:0.8rem;width:100%"><tbody>
      <?php foreach ($details as $k=>$v): if ($v === '' || $v === null || $v === false) continue; ?>
      <tr>
        <td class="text-muted" style="padding:0.25rem 0;width:38%"><?= ucfirst(str_replace('_',' ',$k)) ?></td>
        <td style="padding:0.25rem 0"><?= is_bool($v) ? ($v?'Yes':'No') : htmlspecialchars((string)$v) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>

    <?php if (!empty($enq['notes'])): ?>
    <hr class="divider">
    <div class="text-xs text-muted mb-1">Notes</div>
    <p style="font-size:0.875rem"><?= nl2br(htmlspecialchars($enq['notes'])) ?></p>
    <?php endif; ?>
  </div>

  <div style="display:flex;flex-direction:column;gap:1.25rem;">
    <!-- Contact -->
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Customer Contact</div>
      <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:0.5rem;">
        <div><?= crm_icon('phone') ?> &nbsp;<a href="tel:<?= htmlspecialchars($enq['customer_phone']??'') ?>"><?= htmlspecialchars($enq['customer_phone']??'—') ?></a></div>
        <?php if (!empty($enq['customer_email'])): ?>
        <div><?= crm_icon('send') ?> &nbsp;<a href="mailto:<?= htmlspecialchars($enq['customer_email']) ?>"><?= htmlspecialchars($enq['customer_email']) ?></a></div>
        <?php endif; ?>
        <?php if (!empty($enq['customer_id'])): ?>
        <div><a href="/crm/customers/view.php?id=<?= htmlspecialchars($enq['customer_id']) ?>" class="btn btn-secondary btn-sm"><?= crm_icon('user-check') ?> View Customer Profile</a></div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Status Update -->
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Update Status</div>
      <form method="POST">
        <input type="hidden" name="update_status" value="1">
        <div style="display:flex;gap:0.75rem;align-items:center;">
          <select name="status" style="flex:1">
            <?php foreach (['new','contacted','requirement','quoted','follow_up','negotiation','confirmed','booking','completed','lost'] as $s): ?>
            <option value="<?= $s ?>" <?= ($enq['status']??'new')===$s?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary btn-sm"><?= crm_icon('check') ?></button>
        </div>
      </form>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Actions</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;">
        <a href="/crm/followups/create.php?enquiry_id=<?= $id ?>"  class="btn btn-secondary btn-sm"><?= crm_icon('phone') ?> Schedule Follow-up</a>
        <a href="/crm/quotations/create.php?enquiry_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('file-text') ?> Create Quotation</a>
        <a href="/crm/bookings/create.php?enquiry_id=<?= $id ?>"   class="btn btn-secondary btn-sm"><?= crm_icon('bookmark') ?> Convert to Booking</a>
      </div>
    </div>
  </div>
</div>

<!-- Quotations -->
<div class="card">
  <div class="card-title">Quotations (<?= count($quotations) ?>) <a href="/crm/quotations/create.php?enquiry_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?></a></div>
  <?php if (empty($quotations)): ?>
    <div class="empty-state"><p>No quotations yet</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Quotation ID</th><th>Version</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($quotations as $q): ?>
      <tr>
        <td class="text-xs text-muted"><?= htmlspecialchars($q['quotation_id']??substr($q['$id'],0,8)) ?></td>
        <td>v<?= (int)($q['version']??1) ?></td>
        <td class="fw-600">₹<?= number_format($q['total']??0) ?></td>
        <td><span class="badge <?= $statusBadge[$q['status']??'new']??'badge-new' ?>"><?= ucfirst($q['status']??'draft') ?></span></td>
        <td class="text-xs text-muted"><?= date('d M Y', strtotime($q['$createdAt']??'now')) ?></td>
        <td><a href="/crm/quotations/view.php?id=<?= $q['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<!-- Follow-ups -->
<div class="card">
  <div class="card-title">Follow-ups (<?= count($followups) ?>) <a href="/crm/followups/create.php?enquiry_id=<?= $id ?>" class="btn btn-secondary btn-sm"><?= crm_icon('plus') ?></a></div>
  <?php if (empty($followups)): ?>
    <div class="empty-state"><p>No follow-ups</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
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
  </table></div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>