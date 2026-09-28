<?php
require_once __DIR__ . '/config/appwrite.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/appwrite-client.php';

crm_require_auth();

$pageTitle = 'Dashboard';
$activeNav = 'Dashboard';

$db = appwrite();

// Fetch counts from Appwrite
function safeCount(array $res): int {
    return $res['total'] ?? count($res['documents'] ?? []);
}

$totalLeads      = safeCount($db->listDocuments(COL_LEADS,      ['limit(1)']));
$totalCustomers  = safeCount($db->listDocuments(COL_CUSTOMERS,  ['limit(1)']));
$totalEnquiries  = safeCount($db->listDocuments(COL_ENQUIRIES,  ['limit(1)']));
$totalBookings   = safeCount($db->listDocuments(COL_BOOKINGS,   ['limit(1)']));
$totalQuotations = safeCount($db->listDocuments(COL_QUOTATIONS, ['limit(1)']));

// Today's follow-ups
$today = date('Y-m-d');
$followupsToday = safeCount($db->listDocuments(COL_FOLLOWUPS, [
    'greaterThanEqual("scheduled_at","' . $today . 'T00:00:00")',
    'lessThan("scheduled_at","' . $today . 'T23:59:59")',
    'equal("done",false)',
    'limit(1)',
]));

// Recent leads (last 8)
$recentLeads = $db->listDocuments(COL_LEADS, ['orderDesc("$createdAt")', 'limit(8)']);
$recentLeads = $recentLeads['documents'] ?? [];

// Recent enquiries (last 5)
$recentEnquiries = $db->listDocuments(COL_ENQUIRIES, ['orderDesc("$createdAt")', 'limit(5)']);
$recentEnquiries = $recentEnquiries['documents'] ?? [];

// Upcoming travel (next 7 days)
$nextWeek = date('Y-m-d', strtotime('+7 days'));
$upcomingTravel = $db->listDocuments(COL_BOOKINGS, [
    'greaterThanEqual("travel_date","' . $today . '")',
    'lessThanEqual("travel_date","' . $nextWeek . '")',
    'limit(5)',
]);
$upcomingTravel = $upcomingTravel['documents'] ?? [];

$serviceIcons = [
    'flight'    => '✈️', 'visa'      => '🛂', 'package'   => '🏖️',
    'hotel'     => '🏨', 'transfer'  => '🚕', 'insurance' => '🛡️',
    'cruise'    => '🚢', 'other'     => '📋',
];

$statusBadge = [
    'new'          => 'badge-new',
    'contacted'    => 'badge-contacted',
    'quoted'       => 'badge-quoted',
    'confirmed'    => 'badge-confirmed',
    'lost'         => 'badge-lost',
    'completed'    => 'badge-completed',
    'booking'      => 'badge-gold',
    'negotiation'  => 'badge-contacted',
    'follow_up'    => 'badge-quoted',
];

require_once __DIR__ . '/includes/layout.php';
?>

<div class="page-header">
  <div>
    <h1>Dashboard</h1>
    <p>Welcome back, <?= htmlspecialchars(crm_current_user()['name'] ?? 'Admin') ?>! Here's what's happening today.</p>
  </div>
  <a href="/crm/leads/create.php" class="btn btn-primary">
    <?= crm_icon('plus') ?> New Lead
  </a>
</div>

<!-- Stat Cards -->
<div class="stat-grid">
  <div class="stat-card blue">
    <div class="stat-icon"><?= crm_icon('users') ?></div>
    <div class="stat-label">Total Leads</div>
    <div class="stat-value"><?= $totalLeads ?></div>
  </div>
  <div class="stat-card gold">
    <div class="stat-icon"><?= crm_icon('user-check') ?></div>
    <div class="stat-label">Customers</div>
    <div class="stat-value"><?= $totalCustomers ?></div>
  </div>
  <div class="stat-card purple">
    <div class="stat-icon"><?= crm_icon('message-square') ?></div>
    <div class="stat-label">Enquiries</div>
    <div class="stat-value"><?= $totalEnquiries ?></div>
  </div>
  <div class="stat-card cyan">
    <div class="stat-icon"><?= crm_icon('phone') ?></div>
    <div class="stat-label">Follow-ups Today</div>
    <div class="stat-value"><?= $followupsToday ?></div>
  </div>
  <div class="stat-card gold">
    <div class="stat-icon"><?= crm_icon('file-text') ?></div>
    <div class="stat-label">Quotations</div>
    <div class="stat-value"><?= $totalQuotations ?></div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><?= crm_icon('bookmark') ?></div>
    <div class="stat-label">Bookings</div>
    <div class="stat-value"><?= $totalBookings ?></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <!-- Recent Leads -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">
      Recent Leads
      <a href="/crm/leads/" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <?php if (empty($recentLeads)): ?>
      <div class="empty-state">
        <?= crm_icon('users') ?>
        <p>No leads yet. <a href="/crm/leads/create.php">Add your first lead</a></p>
      </div>
    <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Service</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentLeads as $lead): ?>
          <tr>
            <td>
              <a href="/crm/leads/view.php?id=<?= htmlspecialchars($lead['$id']) ?>" class="fw-600">
                <?= htmlspecialchars($lead['name'] ?? '—') ?>
              </a>
              <div class="text-xs text-muted"><?= htmlspecialchars($lead['phone'] ?? '') ?></div>
            </td>
            <td><?= $serviceIcons[$lead['service_type'] ?? 'other'] ?? '📋' ?> <?= ucfirst($lead['service_type'] ?? '—') ?></td>
            <td><span class="badge <?= $statusBadge[$lead['status'] ?? 'new'] ?? 'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$lead['status'] ?? 'new')) ?></span></td>
            <td class="text-muted text-xs"><?= date('d M', strtotime($lead['$createdAt'] ?? 'now')) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <!-- Upcoming Travel -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">
      Upcoming Travel (7 days)
      <a href="/crm/travel/" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <?php if (empty($upcomingTravel)): ?>
      <div class="empty-state">
        <?= crm_icon('map') ?>
        <p>No upcoming departures</p>
      </div>
    <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Customer</th><th>Destination</th><th>Date</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($upcomingTravel as $bk): ?>
          <tr>
            <td class="fw-600"><?= htmlspecialchars($bk['customer_name'] ?? '—') ?></td>
            <td><?= htmlspecialchars($bk['destination'] ?? '—') ?></td>
            <td class="text-xs text-muted"><?= date('d M Y', strtotime($bk['travel_date'] ?? 'now')) ?></td>
            <td><span class="badge <?= $statusBadge[$bk['status'] ?? 'confirmed'] ?? 'badge-confirmed' ?>"><?= ucfirst($bk['status'] ?? 'confirmed') ?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

</div>

<!-- Recent Enquiries -->
<div class="card">
  <div class="card-title">
    Recent Enquiries
    <a href="/crm/enquiries/" class="btn btn-secondary btn-sm">View All</a>
  </div>
  <?php if (empty($recentEnquiries)): ?>
    <div class="empty-state">
      <?= crm_icon('message-square') ?>
      <p>No enquiries yet</p>
    </div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Customer</th><th>Service</th><th>Destination</th><th>Status</th><th>Date</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($recentEnquiries as $enq): ?>
        <tr>
          <td class="text-xs text-muted"><?= htmlspecialchars($enq['enquiry_id'] ?? substr($enq['$id'],0,8)) ?></td>
          <td class="fw-600"><?= htmlspecialchars($enq['customer_name'] ?? '—') ?></td>
          <td><?= $serviceIcons[$enq['service_type'] ?? 'other'] ?? '📋' ?> <?= ucfirst($enq['service_type'] ?? '—') ?></td>
          <td><?= htmlspecialchars($enq['destination'] ?? '—') ?></td>
          <td><span class="badge <?= $statusBadge[$enq['status'] ?? 'new'] ?? 'badge-new' ?>"><?= ucfirst(str_replace('_',' ',$enq['status'] ?? 'new')) ?></span></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($enq['$createdAt'] ?? 'now')) ?></td>
          <td>
            <a href="/crm/enquiries/view.php?id=<?= htmlspecialchars($enq['$id']) ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- Quick Actions -->
<div class="card">
  <div class="card-title">Quick Actions</div>
  <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
    <a href="/crm/leads/create.php"      class="btn btn-secondary"><?= crm_icon('users') ?> New Lead</a>
    <a href="/crm/customers/create.php"  class="btn btn-secondary"><?= crm_icon('user-check') ?> New Customer</a>
    <a href="/crm/enquiries/create.php"  class="btn btn-secondary"><?= crm_icon('message-square') ?> New Enquiry</a>
    <a href="/crm/followups/create.php"  class="btn btn-secondary"><?= crm_icon('phone') ?> Schedule Follow-up</a>
    <a href="/crm/quotations/create.php" class="btn btn-secondary"><?= crm_icon('file-text') ?> New Quotation</a>
    <a href="/crm/bookings/create.php"   class="btn btn-secondary"><?= crm_icon('bookmark') ?> New Booking</a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/layout-end.php'; ?>