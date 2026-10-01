<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$id = $_GET['id'] ?? '';
if (!$id) { header('Location: /crm/quotations/'); exit; }

$db = appwrite();
$q  = $db->getDocument(COL_QUOTATIONS, $id);
if (empty($q['$id'])) { header('Location: /crm/quotations/'); exit; }

$items = json_decode($q['items'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quotation <?= htmlspecialchars($q['quotation_id']??'') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Inter', sans-serif; color: #1a1a2e; font-size: 13px; background: #fff; }
  .page { max-width: 800px; margin: 0 auto; padding: 2rem; }
  .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 2px solid #C9A84C; }
  .logo { font-size: 1.4rem; font-weight: 700; color: #C9A84C; }
  .logo small { display: block; font-size: 0.75rem; color: #666; font-weight: 400; }
  .q-meta { text-align: right; }
  .q-meta h2 { font-size: 1.1rem; color: #C9A84C; }
  .q-meta p { font-size: 0.8rem; color: #666; margin-top: 2px; }
  .section { margin-bottom: 1.5rem; }
  .section-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #C9A84C; margin-bottom: 0.5rem; }
  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.4rem 2rem; }
  .info-row { display: flex; gap: 0.5rem; font-size: 0.8rem; }
  .info-label { color: #888; min-width: 100px; }
  table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
  thead th { background: #f8f4ec; padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: #666; }
  tbody td { padding: 0.6rem 0.75rem; border-bottom: 1px solid #f0ece4; }
  tfoot td { padding: 0.4rem 0.75rem; }
  .total-row td { font-weight: 700; font-size: 1rem; color: #C9A84C; border-top: 2px solid #C9A84C; padding-top: 0.6rem; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: #f8f4ec; color: #C9A84C; }
  .footer { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; font-size: 0.75rem; color: #888; text-align: center; }
  .terms { background: #f9f9f9; border-radius: 6px; padding: 0.75rem; font-size: 0.75rem; color: #666; margin-top: 1rem; }
  @media print {
    body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    .no-print { display: none; }
  }
</style>
</head>
<body>
<div class="page">

  <!-- Print button -->
  <div class="no-print" style="text-align:right;margin-bottom:1rem">
    <button onclick="window.print()" style="background:#C9A84C;color:#fff;border:none;padding:8px 20px;border-radius:6px;font-size:0.875rem;cursor:pointer;font-family:inherit;font-weight:600">🖨️ Print / Save PDF</button>
    <a href="/crm/quotations/view.php?id=<?= $id ?>" style="margin-left:8px;color:#666;font-size:0.875rem">← Back</a>
  </div>

  <div class="header">
    <div>
      <img src="/assets/image/logo-horizontal.png" alt="Travel World"
           style="height:56px;width:auto;max-width:260px;object-fit:contain;margin-bottom:0.35rem"
           onerror="this.onerror=null;this.style.display='none';document.getElementById('qLogoText').style.display='block';">
      <div class="logo" id="qLogoText" style="display:none">Travel World<small>Your Dream, Our Journey</small></div>
      <div style="margin-top:0.5rem;font-size:0.75rem;color:#666">
        📧 info@travelworld.com &nbsp;|&nbsp; 📞 +91 98765 43210
      </div>
    </div>
    <div class="q-meta">
      <h2>QUOTATION</h2>
      <p><?= htmlspecialchars($q['quotation_id']??substr($q['$id'],0,8)) ?></p>
      <p>Date: <?= date('d M Y', strtotime($q['$createdAt'])) ?></p>
      <?php if (!empty($q['valid_until'])): ?>
      <p>Valid Until: <?= date('d M Y', strtotime($q['valid_until'])) ?></p>
      <?php endif; ?>
      <div style="margin-top:4px"><span class="badge"><?= ucfirst($q['status']??'draft') ?></span></div>
    </div>
  </div>

  <!-- Customer & Trip -->
  <div class="section">
    <div class="section-title">Customer & Trip Details</div>
    <div class="info-grid">
      <?php $rows = [
        'Customer'    => $q['customer_name']??'—',
        'Phone'       => $q['customer_phone']??'—',
        'Email'       => $q['customer_email']??'—',
        'Destination' => $q['destination']??'—',
        'Travel Date' => $q['travel_date'] ? date('d M Y', strtotime($q['travel_date'])) : '—',
        'Travellers'  => ($q['adults']??1).' Adults, '.($q['children']??0).' Children',
      ]; foreach ($rows as $k=>$v): ?>
      <div class="info-row"><span class="info-label"><?= $k ?>:</span><strong><?= htmlspecialchars($v) ?></strong></div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Items -->
  <div class="section">
    <div class="section-title">Pricing Breakdown</div>
    <table>
      <thead><tr><th>Item</th><th>Description</th><th>Qty</th><th>Price</th><th style="text-align:right">Total</th></tr></thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td><strong><?= htmlspecialchars($item['name']??'') ?></strong></td>
          <td style="color:#666"><?= htmlspecialchars($item['desc']??'') ?></td>
          <td><?= $item['qty']??1 ?></td>
          <td>₹<?= number_format($item['price']??0) ?></td>
          <td style="text-align:right;font-weight:600">₹<?= number_format($item['total']??0) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr><td colspan="4" style="text-align:right;color:#888">Subtotal</td><td style="text-align:right;font-weight:600">₹<?= number_format($q['subtotal']??0) ?></td></tr>
        <?php if (($q['discount']??0) > 0): ?>
        <tr><td colspan="4" style="text-align:right;color:#888">Discount</td><td style="text-align:right;color:#ef4444">-₹<?= number_format($q['discount']??0) ?></td></tr>
        <?php endif; ?>
        <?php if (($q['tax']??0) > 0): ?>
        <tr><td colspan="4" style="text-align:right;color:#888">Tax (<?= $q['tax'] ?>%)</td><td style="text-align:right">₹<?= number_format(($q['subtotal']??0)*($q['tax']??0)/100) ?></td></tr>
        <?php endif; ?>
        <tr class="total-row"><td colspan="4" style="text-align:right">TOTAL AMOUNT</td><td style="text-align:right">₹<?= number_format($q['total']??0) ?></td></tr>
      </tfoot>
    </table>
  </div>

  <?php if (!empty($q['notes'])): ?>
  <div class="section">
    <div class="section-title">Notes</div>
    <p style="font-size:0.8rem;line-height:1.6"><?= nl2br(htmlspecialchars($q['notes'])) ?></p>
  </div>
  <?php endif; ?>

  <?php if (!empty($q['terms'])): ?>
  <div class="terms">
    <strong style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em">Terms & Conditions</strong><br>
    <?= nl2br(htmlspecialchars($q['terms'])) ?>
  </div>
  <?php endif; ?>

  <div class="footer">
    <p>Thank you for choosing Travel World! &nbsp;|&nbsp; This quotation is valid until <?= $q['valid_until'] ? date('d M Y', strtotime($q['valid_until'])) : 'further notice' ?></p>
    <p style="margin-top:4px">For queries: info@travelworld.com &nbsp;|&nbsp; +91 98765 43210</p>
  </div>
</div>
</body>
</html>