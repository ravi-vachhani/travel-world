<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();
crm_require_permission('enquiries.create');

$pageTitle = 'New Enquiry';
$activeNav = 'Enquiries';
$error     = '';

$db         = appwrite();
$leadId     = $_GET['lead_id']     ?? '';
$customerId = $_GET['customer_id'] ?? '';

// Pre-fill from lead or customer
$prefill = [];
if ($leadId)     $prefill = $db->getDocument(COL_LEADS,     $leadId);
if ($customerId) $prefill = $db->getDocument(COL_CUSTOMERS, $customerId);

// Customer context (shown when creating against an existing customer)
$ctxCounts = ($customerId && !empty($prefill['$id'])) ? crm_customer_counts($customerId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceType = $_POST['service_type'] ?? 'other';
    // Build service-specific details JSON
    $details = [];
    switch ($serviceType) {
        case 'visa':
            $details = ['visa_type'=>$_POST['visa_type']??'','passport_status'=>$_POST['passport_status']??'','travellers'=>(int)($_POST['travellers']??1)];
            break;
        case 'flight':
            $details = ['origin'=>$_POST['origin']??'','flight_class'=>$_POST['flight_class']??'economy','return_date'=>$_POST['return_date']??'','one_way'=>isset($_POST['one_way'])];
            break;
        case 'package':
            $details = ['nights'=>(int)($_POST['nights']??0),'hotel_category'=>$_POST['hotel_category']??'','inclusions'=>$_POST['inclusions']??''];
            break;
        case 'hotel':
            $details = ['check_in'=>$_POST['check_in']??'','check_out'=>$_POST['check_out']??'','rooms'=>(int)($_POST['rooms']??1),'hotel_category'=>$_POST['hotel_category']??''];
            break;
        default:
            $details = ['extra_info'=>$_POST['extra_info']??''];
    }

    $data = [
        'enquiry_id'    => 'TW-E-' . strtoupper(substr(uniqid(), -5)),
        'lead_id'       => $_POST['lead_id'] ?? '',
        'customer_id'   => $_POST['customer_id'] ?? '',
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'customer_phone'=> trim($_POST['customer_phone'] ?? ''),
        'customer_email'=> trim($_POST['customer_email'] ?? ''),
        'service_type'  => $serviceType,
        'destination'   => trim($_POST['destination'] ?? ''),
        'travel_date'   => $_POST['travel_date'] ?? '',
        'adults'        => (int)($_POST['adults'] ?? 1),
        'children'      => (int)($_POST['children'] ?? 0),
        'budget'        => trim($_POST['budget'] ?? ''),
        'details'       => json_encode($details),
        'notes'         => trim($_POST['notes'] ?? ''),
        'status'        => 'new',
        'assigned_to'   => trim($_POST['assigned_to'] ?? ''),
    ];

    if (empty($data['customer_name']) || empty($data['customer_phone'])) {
        $error = 'Customer name and phone are required.';
    } else {
        // Reuse the existing customer for this mobile, or create one — so the
        // enquiry always links to a single, clean customer record (no dupes).
        if (empty($data['customer_id'])) {
            $cust = crm_get_or_create_customer([
                'name'  => $data['customer_name'],
                'phone' => $data['customer_phone'],
                'email' => $data['customer_email'],
            ]);
            if (!empty($cust['id'])) {
                $data['customer_id'] = $cust['id'];
            } elseif (!empty($cust['error'])) {
                $error = $cust['error'];
            }
        }

        if (!$error) {
            $res = $db->createDocument(COL_ENQUIRIES, $data);
            if (!empty($res['$id'])) {
                // Update lead status
                if (!empty($data['lead_id'])) {
                    $db->updateDocument(COL_LEADS, $data['lead_id'], ['status' => 'requirement']);
                }
                // Keep the customer's enquiry count roughly in sync.
                if (!empty($data['customer_id'])) {
                    $c = $db->getDocument(COL_CUSTOMERS, $data['customer_id']);
                    $db->updateDocument(COL_CUSTOMERS, $data['customer_id'],
                        ['enquiry_count' => (int)($c['enquiry_count'] ?? 0) + 1]);
                }
                header('Location: /crm/enquiries/view.php?id=' . $res['$id'] . '&created=1');
                exit;
            }
            $error = 'Failed to create enquiry.';
        }
    }
}

require_once __DIR__ . '/../includes/layout.php';
$serviceType = $_POST['service_type'] ?? 'package';
?>

<div class="page-header">
  <div><h1>New Enquiry</h1><p>Capture detailed travel requirements</p></div>
  <a href="/crm/enquiries/" class="btn btn-secondary">&larr; Back</a>
</div>

<?php if ($error): ?>
  <div class="flash flash-error"><?= crm_icon('alert-circle') ?> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($ctxCounts): ?>
<div class="ctx-panel">
  <h4><?= htmlspecialchars($prefill['name'] ?? 'Customer') ?> <span class="text-muted" style="font-weight:400">· <?= htmlspecialchars(crm_format_mobile($prefill['phone'] ?? '')) ?></span></h4>
  <div class="ctx-row">Existing Records: <?= $ctxCounts['enquiries'] ?> Enquiries · <?= $ctxCounts['quotations'] ?> Quotations · <?= $ctxCounts['bookings'] ?> Bookings · <?= $ctxCounts['followups'] ?> Follow-ups</div>
  <div class="ctx-links">
    <a href="/crm/customers/view.php?id=<?= $customerId ?>"><?= crm_icon('user-check') ?> View Customer</a>
  </div>
</div>
<?php endif; ?>

<form method="POST" id="enquiryForm">
<input type="hidden" name="lead_id"     value="<?= htmlspecialchars($leadId) ?>">
<input type="hidden" name="customer_id" value="<?= htmlspecialchars($customerId) ?>">

<div class="card">
  <div class="card-title">Customer Information</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Customer Name *</label>
      <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name']??$prefill['name']??'') ?>" required
             autocomplete="off" data-autocomplete="customer" data-fill-prefix="customer_">
    </div>
    <div class="form-group">
      <label>Phone *</label>
      <input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone']??$prefill['phone']??'') ?>" required
             data-mobile-lookup autocomplete="off">
      <div data-mobile-result></div>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email']??$prefill['email']??'') ?>">
    </div>
    <div class="form-group">
      <label>Assigned To</label>
      <input type="text" name="assigned_to" value="<?= htmlspecialchars($_POST['assigned_to']??crm_current_user()['id']??'') ?>"
             autocomplete="off" data-autocomplete="user">
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Service & Requirements</div>
  <div class="form-grid">
    <div class="form-group">
      <label>Service Type</label>
      <select name="service_type" id="serviceType" onchange="showServiceFields()">
        <?php foreach (['flight'=>'✈️ Flight','visa'=>'🛂 Visa','package'=>'🏖️ Holiday Package','hotel'=>'🏨 Hotel','transfer'=>'🚕 Transfer / Cab','insurance'=>'🛡️ Travel Insurance','cruise'=>'🚢 Cruise','other'=>'📋 Other'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= $serviceType===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Destination</label>
      <input type="text" name="destination" value="<?= htmlspecialchars($_POST['destination']??$prefill['destination']??'') ?>" placeholder="Dubai, Bali, Europe…"
             autocomplete="off" data-autocomplete="destination" data-fill-prefix="">
    </div>
    <div class="form-group">
      <label>Travel Date</label>
      <input type="date" name="travel_date" value="<?= htmlspecialchars($_POST['travel_date']??$prefill['travel_date']??'') ?>" data-date="future" min="<?= date('Y-m-d') ?>">
    </div>
    <div class="form-group">
      <label>Budget</label>
      <input type="text" name="budget" value="<?= htmlspecialchars($_POST['budget']??$prefill['budget']??'') ?>" placeholder="₹50,000">
    </div>
    <div class="form-group">
      <label>Adults</label>
      <input type="number" name="adults" value="<?= (int)($_POST['adults']??$prefill['adults']??1) ?>" min="1">
    </div>
    <div class="form-group">
      <label>Children</label>
      <input type="number" name="children" value="<?= (int)($_POST['children']??$prefill['children']??0) ?>" min="0">
    </div>
  </div>
</div>

<!-- Service-specific fields -->
<div class="card" id="fields-visa" style="display:none">
  <div class="card-title">🛂 Visa Details</div>
  <div class="form-grid">
    <div class="form-group"><label>Visa Type</label><input type="text" name="visa_type" placeholder="Tourist, Business, Student…" value="<?= htmlspecialchars($_POST['visa_type']??'') ?>"></div>
    <div class="form-group"><label>Travellers</label><input type="number" name="travellers" value="<?= (int)($_POST['travellers']??1) ?>" min="1"></div>
    <div class="form-group"><label>Passport Status</label>
      <select name="passport_status">
        <option value="ready">Ready</option>
        <option value="renewal">Needs Renewal</option>
        <option value="new">New Application</option>
      </select>
    </div>
  </div>
</div>

<div class="card" id="fields-flight" style="display:none">
  <div class="card-title">✈️ Flight Details</div>
  <div class="form-grid">
    <div class="form-group"><label>Origin</label><input type="text" name="origin" placeholder="Mumbai, Delhi…" value="<?= htmlspecialchars($_POST['origin']??'') ?>"></div>
    <div class="form-group"><label>Return Date</label><input type="date" name="return_date" value="<?= htmlspecialchars($_POST['return_date']??'') ?>" data-date="future" min="<?= date('Y-m-d') ?>"></div>
    <div class="form-group"><label>Class</label>
      <select name="flight_class">
        <?php foreach (['economy'=>'Economy','premium_economy'=>'Premium Economy','business'=>'Business','first'=>'First Class'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['flight_class']??'economy')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group flex-center gap-1" style="padding-top:1.5rem">
      <input type="checkbox" name="one_way" id="one_way" <?= isset($_POST['one_way'])?'checked':'' ?>>
      <label for="one_way" style="text-transform:none;font-size:0.875rem">One-way only</label>
    </div>
  </div>
</div>

<div class="card" id="fields-package" style="display:none">
  <div class="card-title">🏖️ Package Details</div>
  <div class="form-grid">
    <div class="form-group"><label>Nights</label><input type="number" name="nights" value="<?= (int)($_POST['nights']??0) ?>" min="1"></div>
    <div class="form-group"><label>Hotel Category</label>
      <select name="hotel_category">
        <?php foreach (['3star'=>'3 Star','4star'=>'4 Star','5star'=>'5 Star','luxury'=>'Luxury','budget'=>'Budget'] as $v=>$l): ?>
        <option value="<?= $v ?>" <?= ($_POST['hotel_category']??'')===$v?'selected':'' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group full"><label>Inclusions / Special Requests</label><textarea name="inclusions"><?= htmlspecialchars($_POST['inclusions']??'') ?></textarea></div>
  </div>
</div>

<div class="card" id="fields-hotel" style="display:none">
  <div class="card-title">🏨 Hotel Details</div>
  <div class="form-grid">
    <div class="form-group"><label>Check-in</label><input type="date" name="check_in" value="<?= htmlspecialchars($_POST['check_in']??'') ?>" data-date="future" min="<?= date('Y-m-d') ?>"></div>
    <div class="form-group"><label>Check-out</label><input type="date" name="check_out" value="<?= htmlspecialchars($_POST['check_out']??'') ?>" data-date="future" data-date-after="check_in" min="<?= date('Y-m-d') ?>"></div>
    <div class="form-group"><label>Rooms</label><input type="number" name="rooms" value="<?= (int)($_POST['rooms']??1) ?>" min="1"></div>
    <div class="form-group"><label>Hotel Category</label>
      <select name="hotel_category">
        <?php foreach (['3star'=>'3 Star','4star'=>'4 Star','5star'=>'5 Star','luxury'=>'Luxury','budget'=>'Budget'] as $v=>$l): ?>
        <option value="<?= $v ?>"><?= $l ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>

<div class="card" id="fields-other" style="display:none">
  <div class="card-title">📋 Additional Info</div>
  <div class="form-grid">
    <div class="form-group full"><label>Details</label><textarea name="extra_info"><?= htmlspecialchars($_POST['extra_info']??'') ?></textarea></div>
  </div>
</div>

<div class="card">
  <div class="form-group">
    <label>Internal Notes</label>
    <textarea name="notes" rows="3"><?= htmlspecialchars($_POST['notes']??'') ?></textarea>
  </div>
</div>

<div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-bottom:1.5rem;">
  <a href="/crm/enquiries/" class="btn btn-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary"><?= crm_icon('check') ?> Save Enquiry</button>
</div>
</form>

<script>
function showServiceFields() {
    const type = document.getElementById('serviceType').value;
    const panels = ['visa','flight','package','hotel','other'];
    panels.forEach(p => {
        const el = document.getElementById('fields-' + p);
        if (el) el.style.display = (p === type || (type === 'transfer' && p === 'other') || (type === 'insurance' && p === 'other') || (type === 'cruise' && p === 'other')) ? 'block' : 'none';
    });
}
showServiceFields();

// When a customer is picked from the name autocomplete, capture its id so the
// enquiry links to the existing customer (no duplicate typing).
document.addEventListener('crm:select', function (e) {
    const input = e.target;
    if (input && input.getAttribute('data-autocomplete') === 'customer') {
        const hidden = document.querySelector('input[name="customer_id"]');
        if (hidden && e.detail && e.detail.id) hidden.value = e.detail.id;
    }
});
</script>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>