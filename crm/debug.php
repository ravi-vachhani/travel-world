<?php
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/supabase-client.php';

crm_require_auth();

$db = supabase();

// Test 1: Connectivity check
$collections = $db->testConnection();

// Test 2: Try creating a test document in leads
$testCreate = null;
if (isset($_GET['test_create'])) {
    $testCreate = $db->createDocument(COL_LEADS, [
        'lead_id'      => 'TEST-' . time(),
        'name'         => 'Test Lead',
        'email'        => 'test@test.com',
        'phone'        => '9999999999',
        'source'       => 'other',
        'service_type' => 'other',
        'destination'  => 'Test',
        'travel_date'  => '',
        'adults'       => 1,
        'children'     => 0,
        'budget'       => '',
        'notes'        => 'Debug test',
        'status'       => 'new',
        'assigned_to'  => '',
    ]);
}

// Test 3: List leads
$leads = $db->listDocuments(COL_LEADS, ['limit(3)']);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head><title>CRM Debug</title>
<style>body{font-family:monospace;padding:2rem;background:#111;color:#eee} pre{background:#1a1a1a;padding:1rem;border-radius:6px;overflow:auto;font-size:0.8rem} h2{color:#C9A84C} .ok{color:#4ade80} .err{color:#f87171} a{color:#C9A84C}</style>
</head>
<body>
<h1>CRM Debug Panel</h1>

<h2>Environment Variables</h2>
<pre><?php
echo "SUPABASE_URL:         " . SUPABASE_URL . "\n";
echo "SUPABASE_REST_URL:    " . SUPABASE_REST_URL . "\n";
echo "SUPABASE_SERVICE_KEY: " . (SUPABASE_SERVICE_KEY ? '✅ Set (' . strlen(SUPABASE_SERVICE_KEY) . ' chars)' : '❌ NOT SET') . "\n";
echo "SUPABASE_ANON_KEY:    " . (SUPABASE_ANON_KEY ? '✅ Set (' . strlen(SUPABASE_ANON_KEY) . ' chars)' : '❌ NOT SET') . "\n";
echo "SUPABASE_BUCKET:      " . (SUPABASE_BUCKET ? '✅ ' . SUPABASE_BUCKET : '❌ NOT SET') . "\n";
echo "\nTable Names:\n";
echo "COL_LEADS:      " . COL_LEADS . "\n";
echo "COL_CUSTOMERS:  " . COL_CUSTOMERS . "\n";
echo "COL_ENQUIRIES:  " . COL_ENQUIRIES . "\n";
echo "COL_FOLLOWUPS:  " . COL_FOLLOWUPS . "\n";
echo "COL_QUOTATIONS: " . COL_QUOTATIONS . "\n";
echo "COL_BOOKINGS:   " . COL_BOOKINGS . "\n";
echo "COL_PAYMENTS:   " . COL_PAYMENTS . "\n";
echo "COL_DOCUMENTS:  " . COL_DOCUMENTS . "\n";
?>
</pre>

<h2>Supabase Connection Test</h2>
<pre><?= json_encode($collections, JSON_PRETTY_PRINT) ?></pre>

<h2>List Leads (first 3)</h2>
<pre><?= json_encode($leads, JSON_PRETTY_PRINT) ?></pre>

<h2>Test Create Lead</h2>
<?php if ($testCreate !== null): ?>
<pre><?= json_encode($testCreate, JSON_PRETTY_PRINT) ?></pre>
<?php else: ?>
<p><a href="?test_create=1">▶ Click to test creating a document</a></p>
<?php endif; ?>

<hr>
<p><a href="/crm/">← Back to CRM</a></p>
</body>
</html>