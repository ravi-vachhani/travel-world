<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/quotations/'); exit; }

$db  = appwrite();
$q   = $db->getDocument(COL_QUOTATIONS, $id);
if (empty($q['$id'])) { header('Location: /crm/quotations/'); exit; }

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $db->updateDocument(COL_QUOTATIONS, $id, ['status' => $_POST['status']]);
    header('Location: /crm/quotations/view.php?id=' . $id . '&updated=1');
    exit;
}

$items = json_decode($q['items'] ?? '[]', true) ?: [];
$pageTitle = 'Quotation: ' . ($q['customer_name'] ?? '');
$activeNav = 'Quotations';

$statusBadge = ['draft'=>'badge-new','sent'=>'badge-contacted','accepted'=>'badge-confirmed','rejected'=>'badge-lost','expired'=>'badge-lost'];

require_once __DIR__ . '/../includes/layout.php';
?>

<?php if (isset($_GET['created'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Quotation created!</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="flash flash-success"><?= crm_icon('check') ?> Updated.</div><?php endif; ?>

<div class="page-header">
  <div>
    <h1><?= htmlspecialchars($q['quotation_id']??substr($q['$id'],0,8)) ?></h1>
    <p><?= htmlspecialchars($q['customer_name']??'') ?> &nbsp;·&nbsp; <?= date('d M Y', strtotime($q['$createdAt'])) ?></p>
  </div>
  <div style="display:flex;gap:0.75rem;">
    <a href="/crm/quotations/print.php?id=<?= $id ?>" class="btn btn-secondary" target="_blank"><?= crm_icon('download') ?> Print / PDF</a>
    <a href="/crm/quotations/edit.php?id=<?= $id ?>" class="btn btn-secondary"><?= crm_icon('edit') ?> Edit</a>
    <a href="/crm/bookings/create.php?quotation_id=<?= $id ?>" class="btn btn-primary"><?= crm_icon('bookmark') ?> Convert to Booking</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <!-- Quotation Details -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">Quotation Details</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem 1.5rem;font-size:0.875rem;margin-bottom:1rem;">
      <?php $rows = [
        'Customer'    => htmlspecialchars($q['customer_name']??'—'),
        'Phone'       => htmlspecialchars($q['customer_phone']??'—'),
        'Email'       => htmlspecialchars($q['customer_email']??'—'),
        'Destination' => htmlspecialchars($q['destination']??'—'),
        'Travel Date' => $q['travel_date'] ? date('d M Y', strtotime($q['travel_date'])) : '—',
        'Travellers'  => ($q['adults']??1).' Adults, '.($q['children']??0).' Children',
        'Valid Until' => $q['valid_until'] ? date('d M Y', strtotime($q['valid_until'])) : '—',
        'Version'     => 'v'.(int)($q['version']??1),
      ]; foreach ($rows as $k=>$v): ?>
      <div><span class="text-muted text-xs"><?= $k ?></span><br><?= $v ?></div>
      <?php endforeach; ?>
    </div>

    <!-- Items Table -->
    <div class="table-wrap">
      <table>
        <thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr>
            <td class="fw-600"><?= htmlspecialchars($item['name']??'') ?></td>
            <td class="text-xs text-muted"><?= htmlspecialchars($item['desc']??'') ?></td>
            <td><?= $item['qty']??1 ?></td>
            <td>₹<?= number_format($item['price']??0) ?></td>
            <td class="fw-600">₹<?= number_format($item['total']??0) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr><td colspan="4" style="text-align:right;padding:0.5rem 0.75rem" class="text-muted">Subtotal</td><td class="fw-600">₹<?= number_format($q['subtotal']??0) ?></td></tr>
          <?php if (($q['discount']??0) > 0): ?>
          <tr><td colspan="4" style="text-align:right;padding:0.3rem 0.75rem" class="text-muted">Discount</td><td class="text-red">-₹<?= number_format($q['discount']??0) ?></td></tr>
          <?php endif; ?>
          <?php if (($q['tax']??0) > 0): ?>
          <tr><td colspan="4" style="text-align:right;padding:0.3rem 0.75rem" class="text-muted">Tax (<?= $q['tax'] ?>%)</td><td>₹<?= number_format(($q['subtotal']??0)*($q['tax']??0)/100) ?></td></tr>
          <?php endif; ?>
          <tr style="border-top:2px solid var(--border)"><td colspan="4" style="text-align:right;padding:0.6rem 0.75rem" class="fw-700">Total</td><td class="fw-700 text-gold" style="font-size:1.1rem">₹<?= number_format($q['total']??0) ?></td></tr>
        </tfoot>
      </table>
    </div>

    <?php if (!empty($q['notes'])): ?>
    <hr class="divider">
    <div class="text-xs text-muted mb-1">Notes</div>
    <p style="font-size:0.875rem"><?= nl2br(htmlspecialchars($q['notes'])) ?></p>
    <?php endif; ?>
    <?php if (!empty($q['terms'])): ?>
    <hr class="divider">
    <div class="text-xs text-muted mb-1">Terms & Conditions</div>
    <p style="font-size:0.8rem;color:var(--muted)"><?= nl2br(htmlspecialchars($q['terms'])) ?></p>
    <?php endif; ?>
  </div>

  <!-- Status & Actions -->
  <div style="display:flex;flex-direction:column;gap:1.25rem;">
    <div class="card" style="margin-bottom:0">
      <div class="card-title">Status</div>
      <div style="margin-bottom:1rem"><span class="badge <?= $statusBadge[$q['status']??'draft']??'badge-new' ?>" style="font-size:0.9rem;padding:6px 14px"><?= ucfirst($q['status']??'draft') ?></span></div>
      <form method="POST">
        <input type="hidden" name="update_status" value="1">
        <div style="display:flex;gap:0.5rem;">
          <select name="status" style="flex:1">
            <?php foreach (['draft','sent','accepted','rejected','expired'] as $s): ?>
            <option value="<?= $s ?>" <?= ($q['status']??'draft')===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary btn-sm"><?= crm_icon('check') ?></button>
        </div>
      </form>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Summary</div>
      <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:0.4rem;">
        <div class="flex-center gap-1"><?= crm_icon('dollar-sign') ?> <span class="text-muted">Total:</span> <strong class="text-gold">₹<?= number_format($q['total']??0) ?></strong></div>
        <div class="flex-center gap-1"><?= crm_icon('calendar') ?> <span class="text-muted">Valid:</span> <?= $q['valid_until'] ? date('d M Y', strtotime($q['valid_until'])) : '—' ?></div>
      </div>
    </div>

    <div class="card" style="margin-bottom:0">
      <div class="card-title">Actions</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;">
        <a href="/crm/quotations/print.php?id=<?= $id ?>" class="btn btn-secondary btn-sm" target="_blank"><?= crm_icon('download') ?> Print / PDF</a>
        <a href="/crm/bookings/create.php?quotation_id=<?= $id ?>" class="btn btn-primary btn-sm"><?= crm_icon('bookmark') ?> Convert to Booking</a>
        <?php if (!empty($q['enquiry_id'])): ?>
        <a href="/crm/enquiries/view.php?id=<?= $q['enquiry_id'] ?>" class="btn btn-secondary btn-sm"><?= crm_icon('message-square') ?> View Enquiry</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>