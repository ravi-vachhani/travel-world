<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

crm_require_auth();

$pageTitle = 'Reports';
$activeNav = 'Reports';

$db = appwrite();

// Aggregate counts
function safeCount(array $res): int { return $res['total'] ?? count($res['documents'] ?? []); }

$totalLeads      = safeCount($db->listDocuments(COL_LEADS,      ['limit(1)']));
$totalCustomers  = safeCount($db->listDocuments(COL_CUSTOMERS,  ['limit(1)']));
$totalEnquiries  = safeCount($db->listDocuments(COL_ENQUIRIES,  ['limit(1)']));
$totalBookings   = safeCount($db->listDocuments(COL_BOOKINGS,   ['limit(1)']));
$totalQuotations = safeCount($db->listDocuments(COL_QUOTATIONS, ['limit(1)']));

// Confirmed bookings
$confirmedBookings = safeCount($db->listDocuments(COL_BOOKINGS, ['equal("status","confirmed")', 'limit(1)']));
$completedBookings = safeCount($db->listDocuments(COL_BOOKINGS, ['equal("status","completed")', 'limit(1)']));
$lostLeads         = safeCount($db->listDocuments(COL_LEADS,    ['equal("status","lost")', 'limit(1)']));

// Revenue
$allPayments = ($db->listDocuments(COL_PAYMENTS, ['limit(100)']))['documents'] ?? [];
$totalRevenue = array_sum(array_column($allPayments, 'amount'));

// Conversion rate
$conversionRate = $totalLeads > 0 ? round(($confirmedBookings / $totalLeads) * 100, 1) : 0;

// Service-wise enquiries
$services = ['flight','visa','package','hotel','transfer','insurance','cruise','other'];
$serviceStats = [];
foreach ($services as $svc) {
    $serviceStats[$svc] = safeCount($db->listDocuments(COL_ENQUIRIES, ['equal("service_type","'.$svc.'")', 'limit(1)']));
}
arsort($serviceStats);

// Lead sources
$sources = ['website','whatsapp','phone','instagram','facebook','google','walk_in','referral','existing_customer','other'];
$sourceStats = [];
foreach ($sources as $src) {
    $cnt = safeCount($db->listDocuments(COL_LEADS, ['equal("source","'.$src.'")', 'limit(1)']));
    if ($cnt > 0) $sourceStats[$src] = $cnt;
}
arsort($sourceStats);

// Pipeline status
$statuses = ['new','contacted','requirement','quoted','follow_up','negotiation','confirmed','booking','completed','lost'];
$pipelineStats = [];
foreach ($statuses as $s) {
    $pipelineStats[$s] = safeCount($db->listDocuments(COL_LEADS, ['equal("status","'.$s.'")', 'limit(1)']));
}

// Recent payments (last 10)
$recentPayments = ($db->listDocuments(COL_PAYMENTS, ['orderDesc("paid_at")', 'limit(10)']))['documents'] ?? [];

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Reports</h1><p>Business overview and analytics</p></div>
</div>

<!-- KPI Cards -->
<div class="stat-grid" style="margin-bottom:1.5rem">
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
  <div class="stat-card green">
    <div class="stat-icon"><?= crm_icon('bookmark') ?></div>
    <div class="stat-label">Bookings</div>
    <div class="stat-value"><?= $totalBookings ?></div>
  </div>
  <div class="stat-card gold">
    <div class="stat-icon"><?= crm_icon('dollar-sign') ?></div>
    <div class="stat-label">Revenue Collected</div>
    <div class="stat-value" style="font-size:1.3rem">₹<?= number_format($totalRevenue) ?></div>
  </div>
  <div class="stat-card cyan">
    <div class="stat-icon"><?= crm_icon('trending-up') ?></div>
    <div class="stat-label">Conversion Rate</div>
    <div class="stat-value"><?= $conversionRate ?>%</div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><?= crm_icon('check') ?></div>
    <div class="stat-label">Completed</div>
    <div class="stat-value"><?= $completedBookings ?></div>
  </div>
  <div class="stat-card red">
    <div class="stat-icon"><?= crm_icon('x') ?></div>
    <div class="stat-label">Lost Leads</div>
    <div class="stat-value"><?= $lostLeads ?></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">

  <!-- Service-wise Enquiries -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">Enquiries by Service</div>
    <?php
    $serviceIcons = ['flight'=>'✈️','visa'=>'🛂','package'=>'🏖️','hotel'=>'🏨','transfer'=>'🚕','insurance'=>'🛡️','cruise'=>'🚢','other'=>'📋'];
    $maxSvc = max(array_values($serviceStats) ?: [1]);
    foreach ($serviceStats as $svc => $cnt):
      $pct = $maxSvc > 0 ? round(($cnt / $maxSvc) * 100) : 0;
    ?>
    <div style="margin-bottom:0.75rem">
      <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:3px">
        <span><?= ($serviceIcons[$svc]??'📋') . ' ' . ucfirst($svc) ?></span>
        <span class="fw-600"><?= $cnt ?></span>
      </div>
      <div style="background:var(--border);border-radius:4px;height:6px">
        <div style="background:var(--gold);width:<?= $pct ?>%;height:6px;border-radius:4px;transition:width 0.3s"></div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($serviceStats)): ?><div class="empty-state"><p>No data yet</p></div><?php endif; ?>
  </div>

  <!-- Lead Sources -->
  <div class="card" style="margin-bottom:0">
    <div class="card-title">Leads by Source</div>
    <?php
    $maxSrc = max(array_values($sourceStats) ?: [1]);
    foreach ($sourceStats as $src => $cnt):
      $pct = $maxSrc > 0 ? round(($cnt / $maxSrc) * 100) : 0;
    ?>
    <div style="margin-bottom:0.75rem">
      <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:3px">
        <span><?= ucfirst(str_replace('_',' ',$src)) ?></span>
        <span class="fw-600"><?= $cnt ?></span>
      </div>
      <div style="background:var(--border);border-radius:4px;height:6px">
        <div style="background:var(--c-new);width:<?= $pct ?>%;height:6px;border-radius:4px"></div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($sourceStats)): ?><div class="empty-state"><p>No data yet</p></div><?php endif; ?>
  </div>
</div>

<!-- Sales Pipeline -->
<div class="card">
  <div class="card-title">Sales Pipeline</div>
  <div class="pipeline-grid">
    <?php
    $pipelineColors = ['new'=>'var(--c-new)','contacted'=>'var(--c-contacted)','requirement'=>'var(--c-quoted)','quoted'=>'var(--c-quoted)','follow_up'=>'var(--c-quoted)','negotiation'=>'var(--c-contacted)','confirmed'=>'var(--c-confirmed)','booking'=>'var(--gold)','completed'=>'var(--c-completed)','lost'=>'var(--c-lost)'];
    foreach ($pipelineStats as $s => $cnt):
    ?>
    <div class="pipeline-col">
      <div class="pipeline-col-header" style="color:<?= $pipelineColors[$s]??'var(--text)' ?>">
        <?= ucfirst(str_replace('_',' ',$s)) ?>
        <span class="pipeline-count"><?= $cnt ?></span>
      </div>
      <div style="font-size:1.5rem;font-weight:700;text-align:center;padding:0.5rem 0"><?= $cnt ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Recent Payments -->
<div class="card">
  <div class="card-title">Recent Payments <a href="/crm/payments/" class="btn btn-secondary btn-sm">View All</a></div>
  <?php if (empty($recentPayments)): ?>
    <div class="empty-state"><p>No payments yet</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Customer</th><th>Type</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead>
    <tbody>
      <?php foreach ($recentPayments as $p): ?>
      <tr>
        <td class="fw-600"><?= htmlspecialchars($p['customer_name']??'—') ?></td>
        <td class="text-xs"><?= ucfirst($p['payment_type']??'payment') ?></td>
        <td class="fw-600 text-green">₹<?= number_format($p['amount']??0) ?></td>
        <td class="text-xs"><?= ucfirst(str_replace('_',' ',$p['method']??'—')) ?></td>
        <td class="text-xs text-muted"><?= date('d M Y', strtotime($p['paid_at']??'now')) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>