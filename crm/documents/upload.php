<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/appwrite-client.php';

crm_require_auth();

$pageTitle  = 'Upload Document';
$activeNav  = 'Documents';
$error      = '';
$bookingId  = $_GET['booking_id']  ?? '';
$enquiryId  = $_GET['enquiry_id']  ?? '';
$customerId = $_GET['customer_id'] ?? '';

$db      = appwrite();
$prefill = [];
if ($bookingId)  $prefill = $db->getDocument(COL_BOOKINGS,  $bookingId);
if ($enquiryId)  $prefill = $db->getDocument(COL_ENQUIRIES, $enquiryId);
if ($customerId) $prefill = $db->getDocument(COL_CUSTOMERS, $customerId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Upload file to Appwrite Storage via multipart
    $file     = $_FILES['document'] ?? null;
    $fileUrl  = '';
    $filename = '';

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $filename = basename($file['name']);
        // Upload to Appwrite Storage
        $endpoint  = APPWRITE_ENDPOINT . '/storage/buckets/' . APPWRITE_BUCKET_ID . '/files';
        $projectId = APPWRITE_PROJECT_ID;
        $apiKey    = APPWRITE_API_KEY;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Appwrite-Project: ' . $projectId,
            'X-Appwrite-Key: ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'fileId'   => 'unique()',
            'file'     => new CURLFile($file['tmp_name'], $file['type'], $filename),
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $uploaded = json_decode($response, true);
        if (!empty($uploaded['$id'])) {
            $fileUrl = APPWRITE_ENDPOINT . '/storage/buckets/' . APPWRITE_BUCKET_ID . '/files/' . $uploaded['$id'] . '/view?project=' . $projectId;
        }
    }

    $data = [
        'booking_id'    => $_POST['booking_id']    ?? '',
        'enquiry_id'    => $_POST['enquiry_id']    ?? '',
        'customer_id'   => $_POST['customer_id']   ?? '',
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'doc_type'      => $_POST['doc_type']      ?? 'other',
        'filename'      => $filename ?: trim($_POST['doc_url'] ?? ''),
        'file_url'      => $fileUrl  ?: trim($_POST['doc_url'] ?? ''),
        'notes'         => trim($_POST['notes']    ?? ''),
        'status'        => 'uploaded',
    ];

    if (empty($data['customer_name'])) {
        $error = 'Customer name is required.';
    } else {
        $res = $db->createDocument(COL_DOCUMENTS, $data);
        if (!empty($res['$id'])) {
            $back = $bookingId  ? '/crm/bookings/view.php?id='.$bookingId.'&updated=1'
                  : ($enquiryId ? '/crm/enquiries/view.php?id='.$enquiryId.'&updated=1'
                  : '/crm/documents/');
            header('Location: ' . $back);
            exit;
        }
        $error = 'Failed to save document record.';
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Upload Document</h1></div>
  <a href="/crm/documents/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="booking_id"  value="<?= htmlspecialchars($bookingId) ?>">
<input type="hidden" name="enquiry_id"  value="<?= htmlspecialchars($enquiryId) ?>">
<input type="hidden" name="customer_id" value="<?= htmlspecialchars($customerId) ?>">

<div class="card">
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name']??$prefill['customer_name']??$prefill['name']??'') ?>" required>
    </div>
    <div class="form-group">
      <label>Document Type</label>
      <select name="doc_type">
        <?php foreach ([
          'passport'        => '🛂 Passport',
          'photo'           => '📷 Photo',
          'bank_statement'  => '🏦 Bank Statement',
          'visa'            => '📋 Visa',
          'flight_ticket'   => '✈️ Flight Ticket',
          'hotel_voucher'   => '🏨 Hotel Voucher',
          'insurance'       => '🛡️ Insurance',
          'id_proof'        => '🪪 ID Proof',
          'other'           => '📄 Other',
        ] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['doc_type']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group full">
      <label>Upload File</label>
      <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
      <div class="text-xs text-muted mt-1">Supported: PDF, JPG, PNG, DOC (max 10MB)</div>
    </div>
    <div class="form-group full">
      <label>Or paste URL / Drive link</label>
      <input type="text" name="doc_url" value="<?= htmlspecialchars($_POST['doc_url']??'') ?>" placeholder="https://drive.google.com/…">
    </div>
    <div class="form-group full">
      <label>Notes</label>
      <textarea name="notes"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
    </div>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/documents/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('upload') ?> Upload</button>
</div>
</form>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>