<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$pageTitle = 'Record Payment';
$activeNav = 'Payments';
$error     = '';
$bookingId = $_GET['booking_id'] ?? '';

$db      = appwrite();
$booking = [];
if ($bookingId) {
    $booking = $db->getDocument(COL_BOOKINGS, $bookingId);
    // Calculate existing paid
    $existingPayments = ($db->listDocuments(COL_PAYMENTS, ['equal("booking_id","'.$bookingId.'")', 'limit(50)']))['documents'] ?? [];
    $alreadyPaid = array_sum(array_column($existingPayments, 'amount'));
    $balance     = (float)($booking['total_amount']??0) - $alreadyPaid;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'booking_id'    => trim($_POST['booking_id']    ?? ''),
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'amount'        => (float)($_POST['amount']     ?? 0),
        'payment_type'  => $_POST['payment_type']  ?? 'partial',
        'method'        => $_POST['method']         ?? 'cash',
        'reference'     => trim($_POST['reference'] ?? ''),
        'paid_at'       => $_POST['paid_at']        ?? date('Y-m-d'),
        'notes'         => trim($_POST['notes']     ?? ''),
    ];

    if (empty($data['customer_name']) || $data['amount'] <= 0) {
        $error = 'Customer name and a valid amount are required.';
    } else {
        $res = $db->createDocument(COL_PAYMENTS, $data);
        if (!empty($res['$id'])) {
            // Update booking paid_amount
            if (!empty($data['booking_id'])) {
                $bk = $db->getDocument(COL_BOOKINGS, $data['booking_id']);
                $newPaid = (float)($bk['paid_amount']??0) + $data['amount'];
                $db->updateDocument(COL_BOOKINGS, $data['booking_id'], ['paid_amount' => $newPaid]);
            }
            $back = $bookingId ? '/crm/bookings/view.php?id='.$bookingId.'&updated=1' : '/crm/payments/';
            header('Location: ' . $back);
            exit;
        }
        $error = 'Failed to record payment.';
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Record Payment</h1></div>
  <a href="<?= $bookingId ? '/crm/bookings/view.php?id='.$bookingId : '/crm/payments/' ?>" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($booking)): ?>
<div class="card" style="background:var(--surface2)">
  <div style="display:flex;gap:2rem;font-size:0.875rem;flex-wrap:wrap;">
    <div><span class="text-muted">Booking:</span> <strong><?= htmlspecialchars($booking['booking_id']??'') ?></strong></div>
    <div><span class="text-muted">Customer:</span> <strong><?= htmlspecialchars($booking['customer_name']??'') ?></strong></div>
    <div><span class="text-muted">Total:</span> <strong class="text-gold">₹<?= number_format($booking['total_amount']??0) ?></strong></div>
    <div><span class="text-muted">Balance:</span> <strong class="<?= ($balance??0) > 0 ? 'text-red' : 'text-green' ?>">₹<?= number_format($balance??0) ?></strong></div>
  </div>
</div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="booking_id" value="<?= htmlspecialchars($bookingId) ?>">

<div class="card">
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name']??$booking['customer_name']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Amount (₹) *</label>
      <input type="number" name="amount" value="<?= (float)($_POST['amount']??$balance??0) ?>" min="1" step="0.01" required>
    </div>
    <div class="form-group">
      <label>Payment Type</label>
      <select name="payment_type">
        <?php foreach (['advance'=>'Advance','partial'=>'Partial','final'=>'Final Payment','refund'=>'Refund'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['payment_type']??'partial')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Payment Method</label>
      <select name="method">
        <?php foreach (['cash'=>'Cash','bank_transfer'=>'Bank Transfer','upi'=>'UPI','card'=>'Card','cheque'=>'Cheque','online'=>'Online'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['method']??'cash')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Reference / Transaction ID</label>
      <input type="text" name="reference" value="<?= htmlspecialchars($_POST['reference']??'') ?>" placeholder="UTR, transaction no…">
    </div>
    <div class="form-group">
      <label>Payment Date</label>
      <input type="date" name="paid_at" value="<?= htmlspecialchars($_POST['paid_at']??date('Y-m-d')) ?>">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="<?= $bookingId ? '/crm/bookings/view.php?id='.$bookingId : '/crm/payments/' ?>" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Record Payment</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>