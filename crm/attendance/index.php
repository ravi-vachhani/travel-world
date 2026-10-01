<?php
require_once __DIR__ . '/../config/supabase.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/supabase-client.php';
require_once __DIR__ . '/../config/rbac.php';
require_once __DIR__ . '/../config/helpers.php';

crm_require_auth();

$pageTitle = 'Attendance';
$activeNav = 'Attendance';

$db   = supabase();
$me   = crm_current_user();
$canSeeAll = crm_can('attendance.view') || crm_can('attendance.manage') || crm_is_admin();

// Date range filter (defaults to current month)
$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to']   ?? date('Y-m-d');

$queries = [
    'greaterThanEqual("work_date","' . addslashes($from) . '")',
    'lessThanEqual("work_date","' . addslashes($to) . '")',
    'orderDesc("punch_in")',
    'limit(500)',
];
if (!$canSeeAll) {
    // Non-privileged users only see their own attendance.
    $queries[] = 'equal("user_id","' . addslashes($me['id'] ?? '') . '")';
}

$rows = $db->listDocuments(COL_ATTENDANCE, $queries)['documents'] ?? [];

// Aggregate worked minutes per user.
$byUser = [];
foreach ($rows as $r) {
    $uid = $r['user_id'] ?? '';
    if (!isset($byUser[$uid])) {
        $byUser[$uid] = ['name' => $r['user_name'] ?: $uid, 'minutes' => 0, 'days' => []];
    }
    $byUser[$uid]['minutes'] += (int)($r['worked_minutes'] ?? 0);
    $byUser[$uid]['days'][$r['work_date'] ?? ''] = true;
}

function hm(int $mins): string {
    return intdiv($mins, 60) . 'h ' . ($mins % 60) . 'm';
}

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div>
    <h1>Attendance</h1>
    <p><?= $canSeeAll ? 'Staff working hours' : 'Your working hours' ?></p>
  </div>
</div>

<div class="filters-row">
  <form method="GET" style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap">
    <label style="margin:0">From <input type="date" name="from" value="<?= htmlspecialchars($from) ?>"></label>
    <label style="margin:0">To <input type="date" name="to" value="<?= htmlspecialchars($to) ?>"></label>
    <button class="btn btn-secondary btn-sm" type="submit"><?= crm_icon('search') ?> Apply</button>
  </form>
</div>

<?php if ($canSeeAll): ?>
<!-- Summary per staff -->
<div class="card">
  <div class="card-title">Summary (<?= htmlspecialchars($from) ?> → <?= htmlspecialchars($to) ?>)</div>
  <?php if (empty($byUser)): ?>
    <div class="empty-state"><?= crm_icon('clock') ?><p>No attendance records in this range.</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Staff</th><th>Days Worked</th><th>Total Hours</th></tr></thead>
      <tbody>
        <?php foreach ($byUser as $uid => $info): ?>
        <tr>
          <td class="fw-600"><?= htmlspecialchars($info['name']) ?></td>
          <td><?= count($info['days']) ?></td>
          <td class="fw-600 text-gold"><?= hm($info['minutes']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- Detailed sessions -->
<div class="card">
  <div class="card-title">Punch Log</div>
  <?php if (empty($rows)): ?>
    <div class="empty-state"><?= crm_icon('clock') ?><p>No punch records.</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Date</th><?php if ($canSeeAll): ?><th>Staff</th><?php endif; ?><th>Punch In</th><th>Punch Out</th><th>Worked</th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r):
          $in  = !empty($r['punch_in'])  ? strtotime($r['punch_in'])  : null;
          $out = !empty($r['punch_out']) ? strtotime($r['punch_out']) : null;
          $mins = (int)($r['worked_minutes'] ?? 0);
        ?>
        <tr>
          <td class="text-xs"><?= htmlspecialchars($r['work_date'] ?? ($in ? date('Y-m-d',$in) : '—')) ?></td>
          <?php if ($canSeeAll): ?><td><?= htmlspecialchars($r['user_name'] ?? '—') ?></td><?php endif; ?>
          <td class="text-xs"><?= $in ? date('d M, h:i A', $in) : '—' ?></td>
          <td class="text-xs"><?= $out ? date('d M, h:i A', $out) : '<span class="badge badge-confirmed">Active</span>' ?></td>
          <td class="fw-600"><?= $out ? hm($mins) : '—' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>
