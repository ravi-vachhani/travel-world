<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';

require_once __DIR__ . '/../config/rbac.php';

crm_require_auth();
crm_require_permission('customers.view');

$pageTitle = 'Customers';
$activeNav = 'Customers';

$db     = appwrite();
$search = trim($_GET['q'] ?? '');
$queries = ['orderDesc("$createdAt")', 'limit(50)'];
if ($search) $queries[] = 'search("name","' . addslashes($search) . '")';

$result    = $db->listDocuments(COL_CUSTOMERS, $queries);
$customers = $result['documents'] ?? [];
$total     = $result['total'] ?? count($customers);

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Customers</h1><p><?= $total ?> total customers</p></div>
  <a href="/crm/customers/create.php" class="btn btn-primary"><?= crm_icon('plus') ?> New Customer</a>
</div>

<div class="filters-row">
  <form method="GET" style="display:contents">
    <div class="search-bar" style="flex:1;min-width:200px;max-width:360px">
      <?= crm_icon('search') ?>
      <input type="text" name="q" placeholder="Search customers…" value="<?= htmlspecialchars($search) ?>">
    </div>
    <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    <?php if ($search): ?><a href="/crm/customers/" class="btn btn-secondary btn-sm">Clear</a><?php endif; ?>
  </form>
</div>

<div class="card">
  <?php if (empty($customers)): ?>
    <div class="empty-state">
      <?= crm_icon('user-check') ?>
      <p>No customers yet. <a href="/crm/customers/create.php">Add your first customer</a></p>
    </div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Name</th><th>Phone</th><th>Email</th><th>City</th><th>Enquiries</th><th>Bookings</th><th>Joined</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
          <td>
            <a href="/crm/customers/view.php?id=<?= $c['$id'] ?>" class="fw-600"><?= htmlspecialchars($c['name']??'—') ?></a>
          </td>
          <td><?= htmlspecialchars($c['phone']??'—') ?></td>
          <td class="text-xs text-muted"><?= htmlspecialchars($c['email']??'—') ?></td>
          <td class="text-xs"><?= htmlspecialchars($c['city']??'—') ?></td>
          <td class="text-xs"><?= (int)($c['enquiry_count']??0) ?></td>
          <td class="text-xs"><?= (int)($c['booking_count']??0) ?></td>
          <td class="text-xs text-muted"><?= date('d M Y', strtotime($c['$createdAt']??'now')) ?></td>
          <td>
            <div class="actions">
              <a href="/crm/customers/view.php?id=<?= $c['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('eye') ?></a>
              <a href="/crm/customers/edit.php?id=<?= $c['$id'] ?>" class="btn btn-secondary btn-sm btn-icon"><?= crm_icon('edit') ?></a>
              <a href="/crm/enquiries/create.php?customer_id=<?= $c['$id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="New Enquiry"><?= crm_icon('message-square') ?></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>