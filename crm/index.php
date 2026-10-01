<?php
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/supabase-client.php';

crm_require_auth();

$pageTitle = 'Dashboard';
$activeNav = 'Dashboard';

$db = appwrite();

// Fetch counts from Supabase
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

// ── Chart data ───────────────────────────────────────────────────────────────

// 1) Lead pipeline: count per status
$leadStatuses = ['new','contacted','quoted','negotiation','booking','completed','lost'];
$pipeline = [];
foreach ($leadStatuses as $s) {
    $pipeline[$s] = safeCount($db->listDocuments(COL_LEADS, ['equal("status","'.$s.'")', 'limit(1)']));
}

// 2) Enquiries by service type
$serviceTypes = ['flight','visa','package','hotel','transfer','insurance','cruise','other'];
$byService = [];
foreach ($serviceTypes as $svc) {
    $c = safeCount($db->listDocuments(COL_ENQUIRIES, ['equal("service_type","'.$svc.'")', 'limit(1)']));
    if ($c > 0) $byService[$svc] = $c;
}
arsort($byService);

// 3) Revenue (sum of all payments) + bookings trend over the last 6 months
$allPayments = ($db->listDocuments(COL_PAYMENTS, ['orderDesc("paid_at")', 'limit(500)']))['documents'] ?? [];
$totalRevenue = array_sum(array_column($allPayments, 'amount'));

// Last 6 months labels (IST)
$months = [];
for ($i = 5; $i >= 0; $i--) {
    $t = strtotime("first day of -$i month");
    $months[date('Y-m', $t)] = ['label' => date('M', $t), 'bookings' => 0, 'revenue' => 0];
}
// Bookings per month
$allBookings = ($db->listDocuments(COL_BOOKINGS, ['orderDesc("$createdAt")', 'limit(500)']))['documents'] ?? [];
foreach ($allBookings as $b) {
    $key = date('Y-m', strtotime($b['$createdAt'] ?? 'now'));
    if (isset($months[$key])) $months[$key]['bookings']++;
}
// Revenue per month (by payment date)
foreach ($allPayments as $p) {
    $key = date('Y-m', strtotime($p['paid_at'] ?? $p['$createdAt'] ?? 'now'));
    if (isset($months[$key])) $months[$key]['revenue'] += (float)($p['amount'] ?? 0);
}

// Conversion funnel counts
$funnel = [
    'Leads'      => $totalLeads,
    'Enquiries'  => $totalEnquiries,
    'Quotations' => $totalQuotations,
    'Bookings'   => $totalBookings,
];

$serviceLabels = [
    'flight'=>'Flight','visa'=>'Visa','package'=>'Package','hotel'=>'Hotel',
    'transfer'=>'Transfer','insurance'=>'Insurance','cruise'=>'Cruise','other'=>'Other',
];
$serviceColors = [
    'flight'=>'#3b6ef0','visa'=>'#8b5cf6','package'=>'#B8902F','hotel'=>'#0891b2',
    'transfer'=>'#059669','insurance'=>'#d97706','cruise'=>'#db2777','other'=>'#64748b',
];

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
  <div class="stat-card gold">
    <div class="stat-icon"><?= crm_icon('dollar-sign') ?></div>
    <div class="stat-label">Total Revenue</div>
    <div class="stat-value" style="font-size:1.5rem">₹<?= number_format($totalRevenue) ?></div>
  </div>
</div>

<!-- ── Charts row ──────────────────────────────────────────── -->
<div class="dash-charts">

  <!-- Bookings & Revenue trend (6 months) -->
  <div class="card chart-card" style="margin-bottom:0">
    <div class="card-title">
      Bookings &amp; Revenue — Last 6 Months
      <span class="chart-legend">
        <span class="lg-dot" style="background:var(--gold)"></span> Bookings
        <span class="lg-dot" style="background:#3b6ef0;margin-left:0.75rem"></span> Revenue
      </span>
    </div>
    <?php
      $maxBk = max(1, max(array_column($months, 'bookings')));
      $maxRv = max(1, max(array_column($months, 'revenue')));
    ?>
    <div class="bar-chart">
      <?php foreach ($months as $m): ?>
      <div class="bar-col" title="<?= $m['label'] ?>: <?= $m['bookings'] ?> bookings, ₹<?= number_format($m['revenue']) ?>">
        <div class="bar-stack">
          <div class="bar bar-rev" style="height:<?= round(($m['revenue']/$maxRv)*100) ?>%"></div>
          <div class="bar bar-bk"  style="height:<?= round(($m['bookings']/$maxBk)*100) ?>%"></div>
        </div>
        <div class="bar-val"><?= $m['bookings'] ?></div>
        <div class="bar-label"><?= $m['label'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Enquiries by service type (donut) -->
  <div class="card chart-card" style="margin-bottom:0">
    <div class="card-title">Enquiries by Service</div>
    <?php
      $svcTotal = array_sum($byService);
      // build conic-gradient stops
      $stops = []; $acc = 0;
      foreach ($byService as $svc => $cnt) {
          $start = $svcTotal ? ($acc / $svcTotal) * 360 : 0;
          $acc += $cnt;
          $end = $svcTotal ? ($acc / $svcTotal) * 360 : 0;
          $stops[] = ($serviceColors[$svc] ?? '#999') . ' ' . round($start,1) . 'deg ' . round($end,1) . 'deg';
      }
      $conic = $svcTotal ? 'conic-gradient(' . implode(',', $stops) . ')' : 'var(--surface2)';
    ?>
    <?php if (!$svcTotal): ?>
      <div class="empty-state"><?= crm_icon('message-square') ?><p>No enquiries yet</p></div>
    <?php else: ?>
    <div class="donut-wrap">
      <div class="donut" style="background:<?= $conic ?>">
        <div class="donut-hole">
          <div class="donut-total"><?= $svcTotal ?></div>
          <div class="donut-sub">Enquiries</div>
        </div>
      </div>
      <div class="donut-legend">
        <?php foreach ($byService as $svc => $cnt): ?>
        <div class="dl-row">
          <span class="dl-dot" style="background:<?= $serviceColors[$svc] ?? '#999' ?>"></span>
          <span class="dl-name"><?= $serviceLabels[$svc] ?? ucfirst($svc) ?></span>
          <span class="dl-count"><?= $cnt ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- ── Pipeline + Funnel row ───────────────────────────────── -->
<div class="dash-charts">

  <!-- Lead pipeline (horizontal bars) -->
  <div class="card chart-card" style="margin-bottom:0">
    <div class="card-title">Lead Pipeline</div>
    <?php $maxPipe = max(1, max($pipeline)); ?>
    <div class="hbar-chart">
      <?php foreach ($pipeline as $st => $cnt): ?>
      <div class="hbar-row">
        <span class="hbar-label"><?= ucfirst(str_replace('_',' ',$st)) ?></span>
        <div class="hbar-track">
          <div class="hbar-fill <?= $statusBadge[$st] ?? 'badge-new' ?>" style="width:<?= round(($cnt/$maxPipe)*100) ?>%"></div>
        </div>
        <span class="hbar-count"><?= $cnt ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Conversion funnel -->
  <div class="card chart-card" style="margin-bottom:0">
    <div class="card-title">Conversion Funnel</div>
    <?php $maxFn = max(1, max($funnel)); $fnColors = ['#3b6ef0','#8b5cf6','#d97706','#059669']; $fi = 0; ?>
    <div class="funnel">
      <?php foreach ($funnel as $label => $cnt): $w = round(($cnt/$maxFn)*100); ?>
      <div class="funnel-row">
        <div class="funnel-bar" style="width:<?= max($w,12) ?>%;background:<?= $fnColors[$fi++ % 4] ?>">
          <span class="funnel-name"><?= $label ?></span>
          <span class="funnel-count"><?= $cnt ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
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