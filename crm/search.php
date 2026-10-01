<?php
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/supabase-client.php';
require_once __DIR__ . '/config/rbac.php';
require_once __DIR__ . '/config/helpers.php';

crm_require_auth();

$pageTitle = 'Search';
$activeNav = '';

$db  = supabase();
$q   = trim($_GET['q'] ?? '');
$esc = addslashes($q);
$digits = crm_normalize_mobile($q);
$isMobile = preg_match('/^\+?\d[\d\s\-]+$/', $q) && strlen($digits) >= 6;

$results = ['customers'=>[], 'leads'=>[], 'enquiries'=>[], 'quotations'=>[], 'bookings'=>[]];

if ($q !== '') {
    // Customers — prioritised when a mobile number is entered.
    if ($isMobile) {
        $c = $db->listDocuments(COL_CUSTOMERS, ['search("phone","' . $digits . '")', 'limit(10)'])['documents'] ?? [];
        if (!$c && strlen($digits) === 10) {
            $c = $db->listDocuments(COL_CUSTOMERS, ['equal("mobile_normalized","' . $digits . '")', 'limit(10)'])['documents'] ?? [];
        }
    } else {
        $c = $db->listDocuments(COL_CUSTOMERS, ['search("name","' . $esc . '")', 'limit(10)'])['documents'] ?? [];
    }
    $results['customers'] = $c;

    if (crm_can('leads.view'))
        $results['leads'] = $db->listDocuments(COL_LEADS, ['search("name","' . $esc . '")', 'limit(8)'])['documents'] ?? [];
    if (crm_can('enquiries.view'))
        $results['enquiries'] = $db->listDocuments(COL_ENQUIRIES, ['search("destination","' . $esc . '")', 'limit(8)'])['documents'] ?? [];
    if (crm_can('quotations.view'))
        $results['quotations'] = $db->listDocuments(COL_QUOTATIONS, ['search("customer_name","' . $esc . '")', 'limit(8)'])['documents'] ?? [];
    if (crm_can('bookings.view'))
        $results['bookings'] = $db->listDocuments(COL_BOOKINGS, ['search("customer_name","' . $esc . '")', 'limit(8)'])['documents'] ?? [];
}

require_once __DIR__ . '/includes/layout.php';
?>
<div class="page-header"><div><h1>Search</h1><p>Results for "<?= htmlspecialchars($q) ?>"</p></div></div>

<div class="filters-row">
  <form method="GET" style="display:contents">
    <div class="search-bar" style="flex:1;max-width:480px">
      <?= crm_icon('search') ?>
      <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Name, mobile, email, ID, destination…" autofocus>
    </div>
    <button class="btn btn-primary btn-sm" type="submit">Search</button>
  </form>
</div>

<?php
// Customers first (and emphasised for mobile searches)
$cust = $results['customers'];
?>
<div class="card">
  <div class="card-title">Customers (<?= count($cust) ?>)</div>
  <?php if (!$cust): ?><div class="empty-state"><?= crm_icon('user-check') ?><p>No matching customers.</p></div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Name</th><th>Mobile</th><th>Enquiries</th><th>Bookings</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($cust as $c): $k = crm_customer_counts($c['$id']); ?>
      <tr>
        <td class="fw-600"><?= htmlspecialchars($c['name'] ?? '—') ?><div class="text-xs text-muted"><?= htmlspecialchars($c['email'] ?? '') ?></div></td>
        <td><?= htmlspecialchars(crm_format_mobile($c['phone'] ?? '')) ?></td>
        <td><?= $k['enquiries'] ?></td>
        <td><?= $k['bookings'] ?></td>
        <td><a href="/crm/customers/view.php?id=<?= $c['$id'] ?>" class="btn btn-secondary btn-sm">Open</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>

<?php
$sections = [
  'leads'      => ['Leads', '/crm/leads/view.php?id=', 'name', 'lead_id'],
  'enquiries'  => ['Enquiries', '/crm/enquiries/view.php?id=', 'customer_name', 'enquiry_id'],
  'quotations' => ['Quotations', '/crm/quotations/view.php?id=', 'customer_name', 'quotation_id'],
  'bookings'   => ['Bookings', '/crm/bookings/view.php?id=', 'customer_name', 'booking_id'],
];
foreach ($sections as $key => [$title, $link, $nameField, $idField]):
  $rows = $results[$key];
?>
<div class="card">
  <div class="card-title"><?= $title ?> (<?= count($rows) ?>)</div>
  <?php if (!$rows): ?><div class="text-muted text-sm" style="padding:0.5rem">No matches.</div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>ID</th><th>Name / Destination</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td class="text-xs text-muted"><?= htmlspecialchars($r[$idField] ?? substr($r['$id'],0,8)) ?></td>
        <td class="fw-600"><?= htmlspecialchars($r[$nameField] ?? '—') ?> <span class="text-muted text-xs"><?= htmlspecialchars($r['destination'] ?? '') ?></span></td>
        <td><a href="<?= $link . $r['$id'] ?>" class="btn btn-secondary btn-sm">Open</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/layout-end.php'; ?>
