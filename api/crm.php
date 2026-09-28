<?php
/**
 * Single CRM dispatcher — counts as 1 Vercel serverless function.
 * Routes all /crm/* requests to the correct handler file in api/crm/.
 */

// Parse the requested path
$requestUri  = $_SERVER['REQUEST_URI'] ?? '/crm/';
$path        = parse_url($requestUri, PHP_URL_PATH);

// Strip /crm prefix and normalize
$route = preg_replace('#^/crm#', '', $path);
$route = rtrim($route, '/') ?: '/';

// Map route → file inside api/crm/
$map = [
    '/'                    => '/index.php',
    '/login'               => '/login.php',
    '/login.php'           => '/login.php',
    '/logout'              => '/logout.php',
    '/logout.php'          => '/logout.php',

    '/leads'               => '/leads/index.php',
    '/leads/create'        => '/leads/create.php',
    '/leads/create.php'    => '/leads/create.php',
    '/leads/view'          => '/leads/view.php',
    '/leads/view.php'      => '/leads/view.php',
    '/leads/edit'          => '/leads/edit.php',
    '/leads/edit.php'      => '/leads/edit.php',

    '/customers'           => '/customers/index.php',
    '/customers/create'    => '/customers/create.php',
    '/customers/create.php'=> '/customers/create.php',
    '/customers/view'      => '/customers/view.php',
    '/customers/view.php'  => '/customers/view.php',
    '/customers/edit'      => '/customers/edit.php',
    '/customers/edit.php'  => '/customers/edit.php',

    '/enquiries'           => '/enquiries/index.php',
    '/enquiries/create'    => '/enquiries/create.php',
    '/enquiries/create.php'=> '/enquiries/create.php',
    '/enquiries/view'      => '/enquiries/view.php',
    '/enquiries/view.php'  => '/enquiries/view.php',
    '/enquiries/edit'      => '/enquiries/edit.php',
    '/enquiries/edit.php'  => '/enquiries/edit.php',

    '/followups'           => '/followups/index.php',
    '/followups/create'    => '/followups/create.php',
    '/followups/create.php'=> '/followups/create.php',
    '/followups/done'      => '/followups/done.php',
    '/followups/done.php'  => '/followups/done.php',
    '/followups/edit'      => '/followups/edit.php',
    '/followups/edit.php'  => '/followups/edit.php',

    '/quotations'          => '/quotations/index.php',
    '/quotations/create'   => '/quotations/create.php',
    '/quotations/create.php'=> '/quotations/create.php',
    '/quotations/view'     => '/quotations/view.php',
    '/quotations/view.php' => '/quotations/view.php',
    '/quotations/edit'     => '/quotations/edit.php',
    '/quotations/edit.php' => '/quotations/edit.php',
    '/quotations/print'    => '/quotations/print.php',
    '/quotations/print.php'=> '/quotations/print.php',

    '/bookings'            => '/bookings/index.php',
    '/bookings/create'     => '/bookings/create.php',
    '/bookings/create.php' => '/bookings/create.php',
    '/bookings/view'       => '/bookings/view.php',
    '/bookings/view.php'   => '/bookings/view.php',
    '/bookings/edit'       => '/bookings/edit.php',
    '/bookings/edit.php'   => '/bookings/edit.php',

    '/payments'            => '/payments/index.php',
    '/payments/create'     => '/payments/create.php',
    '/payments/create.php' => '/payments/create.php',

    '/documents'           => '/documents/index.php',
    '/documents/upload'    => '/documents/upload.php',
    '/documents/upload.php'=> '/documents/upload.php',
    '/documents/verify'    => '/documents/verify.php',
    '/documents/verify.php'=> '/documents/verify.php',

    '/travel'              => '/travel/index.php',
    '/reports'             => '/reports/index.php',
    '/settings'            => '/settings/index.php',
];

$file = $map[$route] ?? null;

if ($file === null) {
    http_response_code(404);
    echo '<h1>404 — CRM page not found</h1><p><a href="/crm/">Back to Dashboard</a></p>';
    exit;
}

$fullPath = __DIR__ . '/crm' . $file;

if (!file_exists($fullPath)) {
    http_response_code(404);
    echo '<h1>404 — File not found: ' . htmlspecialchars($file) . '</h1>';
    exit;
}

// Include the target file in this scope so require_once paths resolve correctly
// We need to chdir so relative paths inside included files work
chdir(dirname($fullPath));
require $fullPath;