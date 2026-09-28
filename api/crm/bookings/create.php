<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle    = 'New Booking';
$activeNav    = 'Bookings';
$error        = '';
$enquiryId    = $_GET['enquiry_id']    ?? '';
$quotationId  = $_GET['quotation_id']  ?? '';
$customerId   = $_GET['customer_id']   ?? '';

$db      = appwrite();
$prefill = [];
if ($enquiryId)   $prefill = $db->getDocument(COL_ENQUIRIES,  $enquiryId);
if ($quotationId) $prefill = $db->getDocument(COL_QUOTATIONS, $quotationId);
if ($customerId)  $prefill = $db->getDocument(COL_CUSTOMERS,  $customerId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalAmount = (float)($_POST['total_amount'] ?? 0);
    $paidAmount  = (float)($_POST['advance_amount'] ?? 0);

    $data = [
        'booking_id'     => 'TW-B-' . strtoupper(substr(uniqid(), -5)),
        'enquiry_id'     => $_POST['enquiry_id']    ?? '',
        'quotation_id'   => $_POST['quotation_id']  ?? '',
        'customer_id'    => $_POST['customer_id']   ?? '',
        'customer_name'  => trim($_POST['customer_name']  ?? ''),
        'customer_phone' => trim($_POST['customer_phone'] ?? ''),
        'customer_email' => trim($_POST['customer_email'] ?? ''),
        'destination'    => trim($_POST['destination']    ?? ''),
        'service_type'   => $_POST['service_type']  ?? 'package',
        'travel_date'    => $_POST['travel_date']   ?? '',
        'return_date'    => $_POST['return_date']   ?? '',
        'adults'         => (int)($_POST['adults']  ?? 1),
        'children'       => (int)($_POST['children']?? 0),
        'supplier'       => trim($_POST['supplier'] ?? ''),
        'booking_ref'    => trim($_POST['booking_ref'] ?? ''),
        'total_amount'   => $totalAmount,
        'paid_amount'    => $paidAmount,
        'notes'          => trim($_POST['notes'] ?? ''),
        'status'         => 'confirmed',
    ];

    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } else {
        $res = $db->createDocument(COL_BOOKINGS, $data);
        if (!empty($res['$id'])) {
            // Update enquiry status
            if (!empty($data['enquiry_id'])) {
                $db->updateDocument(COL_ENQUIRIES, $data['enquiry_id'], ['status' => 'booking']);
            }
            // Record advance payment if any
            if ($paidAmount > 0) {
                $db->createDocument(COL_PAYMENTS, [
                    'booking_id'    => $res['$id'],
                    'customer_name' => $data['customer_name'],
                    'amount'        => $paidAmount,
                    'payment_type'  => 'advance',
                    'method'        => $_POST['payment_method'] ?? 'cash',
                    'reference'     => trim($_POST['payment_ref'] ?? ''),
                    'paid_at'       => date('Y-m-d'),
                    'notes'         => 'Advance payment at booking',
                ]);
            }
            header('Location: /crm/bookings/view.php?id=' . $res['$id'] . '&created=1');
            exit;
        }
        $error = 'Failed to create booking.';
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>New Booking</h1></div>
  <a href="/crm/bookings/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="enquiry_id"   value="<?= htmlspecialchars($enquiryId) ?>">
<input type="hidden" name="quotation_id" value="<?= htmlspecialchars($quotationId) ?>">
<input type="hidden" name="customer_id"  value="<?= htmlspecialchars($customerId) ?>">

<div class="card">
  <div class="card-title">Customer Details</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name']??$prefill['customer_name']??$prefill['name']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Phone</label>
      <input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone']??$prefill['customer_phone']??$prefill['phone']??'') ?>">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email']??$prefill['customer_email']??$prefill['email']??'') ?>">
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Trip Details</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Service Type</label>
      <select name="service_type">
        <?php foreach (['flight'=>'✈️ Flight','visa'=>'🛂 Visa','package'=>'🏖️ Package','hotel'=>'🏨 Hotel','transfer'=>'🚕 Transfer','insurance'=>'🛡️ Insurance','cruise'=>'🚢 Cruise','other'=>'📋 Other'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['service_type']??$prefill['service_type']??'package')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Destination</label>
      <input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination']??$prefill['destination']??'') ?>">
    </div>
    <div class="form-group">
      <label>Travel Date</label>
      <input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date']??$prefill['travel_date']??'') ?>">
    </div>
    <div class="form-group">
      <label>Return Date</label>
      <input type="date" name="return_date" value="<?= htmlspecialchars($_POST['return_date']??'') ?>">
    </div>
    <div class="form-group">
      <label>Adults</label>
      <input type="number" name="adults" value="<?= (int)($_POST['adults']??$prefill['adults']??1) ?>" min="1">
    </div>
    <div class="form-group">
      <label>Children</label>
      <input type="number" name="children" value="<?= (int)($_POST['children']??$prefill['children']??0) ?>" min="0">
    </div>
    <div class="form-group">
      <label>Supplier / Vendor</label>
      <input type="text" name="supplier" value="<?= htmlspecialchars($_POST['supplier']??'') ?>" placeholder="Airline, hotel name…">
    </div>
    <div class="form-group">
      <label>Booking Reference</label>
      <input type="text" name="booking_ref" value="<?= htmlspecialchars($_POST['booking_ref']??'') ?>" placeholder="PNR, confirmation no…">
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Payment</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Total Amount (₹)</label>
      <input type="number" name="total_amount" value="<?= (float)($_POST['total_amount']??$prefill['total']??0) ?>" min="0" step="0.01">
    </div>
    <div class="form-group">
      <label>Advance Paid (₹)</label>
      <input type="number" name="advance_amount" value="<?= (float)($_POST['advance_amount']??0) ?>" min="0" step="0.01">
    </div>
    <div class="form-group">
      <label>Payment Method</label>
      <select name="payment_method">
        <?php foreach (['cash'=>'Cash','bank_transfer'=>'Bank Transfer','upi'=>'UPI','card'=>'Card','cheque'=>'Cheque','online'=>'Online'] as $v=>$l): ?>
        <option value="<?= $v ?>"><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Payment Reference</label>
      <input type="text" name="payment_ref" value="<?= htmlspecialchars($_POST['payment_ref']??'') ?>" placeholder="Transaction ID, UTR…">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/bookings/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Confirm Booking</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>