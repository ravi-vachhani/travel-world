<?php
require_once __DIR__ . '/../config/appwrite.php';
require_once __DIR__ . '/../config/auth.php';

crm_require_auth();

$pageTitle = 'Settings';
$activeNav = 'Settings';
$success   = '';

// Handle password change (updates env — not possible on Vercel, so just show info)
// In production, update via Vercel env vars dashboard

require_once __DIR__ . '/../includes/layout.php';
?>

<div class="page-header">
  <div><h1>Settings</h1><p>CRM configuration and account settings</p></div>
</div>

<!-- Appwrite Setup Guide -->
<div class="card">
  <div class="card-title"><?= crm_icon('settings') ?> Appwrite Configuration</div>
  <p style="font-size:0.875rem;color:var(--muted);margin-bottom:1rem">
    Configure these environment variables in your Vercel project dashboard under <strong>Settings → Environment Variables</strong>.
  </p>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Variable</th><th>Description</th><th>Current Status</th></tr></thead>
      <tbody>
        <?php
        $vars = [
          'APPWRITE_ENDPOINT'    => ['Appwrite API endpoint', APPWRITE_ENDPOINT],
          'APPWRITE_PROJECT_ID'  => ['Your Appwrite project ID', APPWRITE_PROJECT_ID ? '✅ Set' : '❌ Not set'],
          'APPWRITE_API_KEY'     => ['Server API key (with DB + Storage access)', APPWRITE_API_KEY ? '✅ Set' : '❌ Not set'],
          'APPWRITE_DATABASE_ID' => ['Database ID in Appwrite', APPWRITE_DATABASE_ID],
          'APPWRITE_BUCKET_ID'   => ['Storage bucket ID for documents', APPWRITE_BUCKET_ID],
          'CRM_ADMIN_EMAIL'      => ['Login email', CRM_ADMIN_EMAIL],
          'CRM_ADMIN_PASSWORD'   => ['Login password', '••••••••'],
        ];
        foreach ($vars as $key => [$desc, $val]): ?>
        <tr>
          <td><code style="background:var(--bg);padding:2px 6px;border-radius:4px;font-size:0.8rem"><?= $key ?></code></td>
          <td class="text-xs text-muted"><?= $desc ?></td>
          <td class="text-xs"><?= htmlspecialchars($val) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Appwrite Collections Setup -->
<div class="card">
  <div class="card-title"><?= crm_icon('folder') ?> Required Appwrite Collections</div>
  <p style="font-size:0.875rem;color:var(--muted);margin-bottom:1rem">
    Create these collections in your Appwrite database. Each needs the attributes listed below.
  </p>
  <?php
  $collections = [
    'customers'  => 'name, email, phone, alt_phone, dob, anniversary, address, city, state, country, passport_no, passport_expiry, notes, enquiry_count, booking_count, lead_id',
    'leads'      => 'lead_id, name, email, phone, source, service_type, destination, travel_date, adults, children, budget, notes, status, assigned_to, customer_id',
    'enquiries'  => 'enquiry_id, lead_id, customer_id, customer_name, customer_phone, customer_email, service_type, destination, travel_date, adults, children, budget, details, notes, status, assigned_to',
    'followups'  => 'enquiry_id, lead_id, customer_id, customer_name, type, scheduled_at, notes, done',
    'quotations' => 'quotation_id, enquiry_id, customer_name, customer_phone, customer_email, destination, travel_date, adults, children, items, subtotal, discount, tax, total, notes, terms, status, version, valid_until',
    'bookings'   => 'booking_id, enquiry_id, quotation_id, customer_id, customer_name, customer_phone, customer_email, destination, service_type, travel_date, return_date, adults, children, supplier, booking_ref, total_amount, paid_amount, notes, status',
    'payments'   => 'booking_id, customer_name, amount, payment_type, method, reference, paid_at, notes',
    'documents'  => 'booking_id, enquiry_id, customer_id, customer_name, doc_type, filename, file_url, notes, status',
    'feedback'   => 'booking_id, customer_name, rating, comments, created_at',
  ];
  foreach ($collections as $col => $attrs): ?>
  <div style="margin-bottom:1rem;padding:0.75rem;background:var(--bg);border-radius:8px;border:1px solid var(--border)">
    <div class="fw-600 text-gold" style="font-size:0.875rem;margin-bottom:4px"><?= $col ?></div>
    <div class="text-xs text-muted"><?= $attrs ?></div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Login Info -->
<div class="card">
  <div class="card-title"><?= crm_icon('user-check') ?> Login Credentials</div>
  <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:0.5rem;">
    <div><span class="text-muted">Email:</span> <strong><?= htmlspecialchars(CRM_ADMIN_EMAIL) ?></strong></div>
    <div><span class="text-muted">Password:</span> <strong>Set via <code>CRM_ADMIN_PASSWORD</code> env variable</strong></div>
    <div class="flash flash-info" style="margin-top:0.5rem">
      <?= crm_icon('alert-circle') ?> To change credentials, update the environment variables in your Vercel dashboard and redeploy.
    </div>
  </div>
</div>

<!-- CRM Info -->
<div class="card">
  <div class="card-title"><?= crm_icon('bar-chart-2') ?> CRM Information</div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem 2rem;font-size:0.875rem;">
    <?php $info = [
      'CRM Version'   => '1.0.0',
      'Built With'    => 'PHP + Appwrite',
      'Deployed On'   => 'Vercel',
      'PHP Runtime'   => 'vercel-php@0.7.2',
      'Logged In As'  => crm_current_user()['email'] ?? '—',
      'Session'       => 'Active',
    ]; foreach ($info as $k=>$v): ?>
    <div><span class="text-muted"><?= $k ?>:</span> <strong><?= htmlspecialchars($v) ?></strong></div>
    <?php endforeach; ?>
  </div>
</div>

<div style="margin-bottom:1.5rem">
  <a href="/crm/logout.php" class="btn btn-danger"><?= crm_icon('log-out') ?> Logout</a>
</div>

<?php require_once __DIR__ . '/../includes/layout-end.php'; ?>

