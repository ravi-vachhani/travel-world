<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('quotations.edit');

$pageTitle = 'Edit Quotation';
$activeNav = 'Quotations';
$error     = '';

$db = appwrite();
$id = $_GET['id'] ?? '';
$q  = $db->getDocument(COL_QUOTATIONS, $id);
if (empty($q['$id'])) { header('Location: /crm/quotations/'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rebuild line items from the dynamic rows
    $items = [];
    $itemNames  = $_POST['item_name']  ?? [];
    $itemDescs  = $_POST['item_desc']  ?? [];
    $itemQtys   = $_POST['item_qty']   ?? [];
    $itemPrices = $_POST['item_price'] ?? [];
    foreach ($itemNames as $i => $name) {
        if (empty(trim($name))) continue;
        $qty   = (float)($itemQtys[$i]   ?? 1);
        $price = (float)($itemPrices[$i] ?? 0);
        $items[] = ['name'=>trim($name),'desc'=>trim($itemDescs[$i]??''),'qty'=>$qty,'price'=>$price,'total'=>$qty*$price];
    }
    $subtotal = array_sum(array_column($items, 'total'));
    $discount = (float)($_POST['discount'] ?? 0);
    $tax      = (float)($_POST['tax']      ?? 0);
    $total    = $subtotal - $discount + ($subtotal * $tax / 100);

    $data = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'customer_phone'=> trim($_POST['customer_phone'] ?? ''),
        'customer_email'=> trim($_POST['customer_email'] ?? ''),
        'destination'   => trim($_POST['destination'] ?? ''),
        'travel_date'   => $_POST['travel_date'] ?? '',
        'adults'        => (int)($_POST['adults'] ?? 1),
        'children'      => (int)($_POST['children'] ?? 0),
        'items'         => json_encode($items),
        'subtotal'      => $subtotal,
        'discount'      => $discount,
        'tax'           => $tax,
        'total'         => $total,
        'notes'         => trim($_POST['notes'] ?? ''),
        'terms'         => trim($_POST['terms'] ?? ''),
        'valid_until'   => $_POST['valid_until'] ?? '',
        // Bump the version on each edit so revisions are traceable.
        'version'       => (int)($q['version'] ?? 1) + 1,
    ];

    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } else {
        $db->updateDocument(COL_QUOTATIONS, $id, $data);
        header('Location: /crm/quotations/view.php?id=' . $id . '&updated=1');
        exit;
    }
}

// Values to render: posted (on validation error) else the stored quotation.
$cur = function (string $k, $default = '') use ($q) { return $q[$k] ?? $default; };
$items = json_decode($q['items'] ?? '[]', true) ?: [];
if (!$items) $items = [['name'=>'','desc'=>'','qty'=>1,'price'=>0]];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Edit Quotation</h1><p><?= htmlspecialchars($q['quotation_id'] ?? '') ?> · v<?= (int)($q['version'] ?? 1) ?></p></div>
  <a href="/crm/quotations/view.php?id=<?= $id ?>" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" id="quotationForm">

<div class="card">
  <div class="card-title">Customer &amp; Trip Details</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name'] ?? $cur('customer_name')) ?>" required>
    </div>
    <div class="form-group">
      <label>Phone</label>
      <input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone'] ?? $cur('customer_phone')) ?>">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email'] ?? $cur('customer_email')) ?>">
    </div>
    <div class="form-group">
      <label>Destination</label>
      <input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination'] ?? $cur('destination')) ?>">
    </div>
    <div class="form-group">
      <label>Travel Date</label>
      <input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date'] ?? $cur('travel_date')) ?>">
    </div>
    <div class="form-group">
      <label>Adults</label>
      <input type="number" name="adults" value="<?= (int)($_POST['adults'] ?? $cur('adults', 1)) ?>" min="1">
    </div>
    <div class="form-group">
      <label>Children</label>
      <input type="number" name="children" value="<?= (int)($_POST['children'] ?? $cur('children', 0)) ?>" min="0">
    </div>
    <div class="form-group">
      <label>Valid Until</label>
      <input type="date" name="valid_until" value="<?= htmlspecialchars($_POST['valid_until'] ?? $cur('valid_until')) ?>">
    </div>
  </div>
</div>

<!-- Line Items -->
<div class="card">
  <div class="card-title">
    Pricing Breakdown
    <button type="button" class="btn btn-secondary btn-sm" onclick="addItem()"><?= crm_icon('plus') ?> Add Item</button>
  </div>
  <div class="table-wrap">
    <table id="itemsTable">
      <thead>
        <tr><th style="width:30%">Item</th><th style="width:30%">Description</th><th style="width:10%">Qty</th><th style="width:15%">Price (₹)</th><th style="width:10%">Total</th><th style="width:5%"></th></tr>
      </thead>
      <tbody id="itemsBody">
        <?php foreach ($items as $it): ?>
        <tr>
          <td><input type="text" name="item_name[]" class="item-name" value="<?= htmlspecialchars($it['name'] ?? '') ?>" placeholder="Item name"></td>
          <td><input type="text" name="item_desc[]" value="<?= htmlspecialchars($it['desc'] ?? '') ?>" placeholder="Description"></td>
          <td><input type="number" name="item_qty[]" value="<?= (float)($it['qty'] ?? 1) ?>" min="1" class="item-qty" onchange="calcTotal(this)"></td>
          <td><input type="number" name="item_price[]" value="<?= (float)($it['price'] ?? 0) ?>" min="0" class="item-price" onchange="calcTotal(this)"></td>
          <td class="item-total fw-600">₹<?= number_format((float)($it['total'] ?? 0)) ?></td>
          <td><button type="button" class="btn btn-danger btn-sm btn-icon" onclick="removeRow(this)"><?= crm_icon('x') ?></button></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
    <table style="width:280px;font-size:0.875rem;">
      <tr><td class="text-muted" style="padding:0.3rem 0">Subtotal</td><td class="fw-600" id="subtotalDisplay" style="text-align:right">₹0</td></tr>
      <tr>
        <td class="text-muted" style="padding:0.3rem 0">Discount (₹)</td>
        <td style="text-align:right"><input type="number" name="discount" id="discount" value="<?= (float)($_POST['discount'] ?? $cur('discount', 0)) ?>" min="0" style="width:100px;text-align:right" onchange="updateSummary()"></td>
      </tr>
      <tr>
        <td class="text-muted" style="padding:0.3rem 0">Tax (%)</td>
        <td style="text-align:right"><input type="number" name="tax" id="tax" value="<?= (float)($_POST['tax'] ?? $cur('tax', 0)) ?>" min="0" max="100" style="width:100px;text-align:right" onchange="updateSummary()"></td>
      </tr>
      <tr style="border-top:1px solid var(--border)">
        <td class="fw-700" style="padding:0.5rem 0">Total</td>
        <td class="fw-700 text-gold" id="totalDisplay" style="text-align:right;font-size:1.1rem">₹0</td>
      </tr>
    </table>
  </div>
</div>

<div class="card">
  <div class="form-grid">
    <div class="form-group full">
      <label>Notes for Customer</label>
      <textarea name="notes" rows="3"><?= htmlspecialchars($_POST['notes'] ?? $cur('notes')) ?></textarea>
    </div>
    <div class="form-group full">
      <label>Terms &amp; Conditions</label>
      <textarea name="terms" rows="3"><?= htmlspecialchars($_POST['terms'] ?? $cur('terms')) ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/quotations/view.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Changes</button>
</div>
</form>

<script>
function calcTotal(el) {
    const row   = el.closest('tr');
    const qty   = parseFloat(row.querySelector('.item-qty').value)   || 0;
    const price = parseFloat(row.querySelector('.item-price').value) || 0;
    row.querySelector('.item-total').textContent = '₹' + (qty * price).toLocaleString('en-IN');
    updateSummary();
}
function updateSummary() {
    let subtotal = 0;
    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const qty   = parseFloat(row.querySelector('.item-qty')?.value)   || 0;
        const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
        subtotal += qty * price;
    });
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax      = parseFloat(document.getElementById('tax').value)      || 0;
    const total    = subtotal - discount + (subtotal * tax / 100);
    document.getElementById('subtotalDisplay').textContent = '₹' + subtotal.toLocaleString('en-IN');
    document.getElementById('totalDisplay').textContent    = '₹' + Math.round(total).toLocaleString('en-IN');
}
function addItem() {
    const tbody = document.getElementById('itemsBody');
    const row   = document.createElement('tr');
    row.innerHTML = `
      <td><input type="text" name="item_name[]" class="item-name" placeholder="Item name"></td>
      <td><input type="text" name="item_desc[]" placeholder="Description"></td>
      <td><input type="number" name="item_qty[]" value="1" min="1" class="item-qty" onchange="calcTotal(this)"></td>
      <td><input type="number" name="item_price[]" value="0" min="0" class="item-price" onchange="calcTotal(this)"></td>
      <td class="item-total fw-600">₹0</td>
      <td><button type="button" class="btn btn-danger btn-sm btn-icon" onclick="removeRow(this)"><?= crm_icon('x') ?></button></td>`;
    tbody.appendChild(row);
}
function removeRow(btn) { btn.closest('tr').remove(); updateSummary(); }
// Initialise the totals on load.
updateSummary();
</script>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
