<?php
/**
 * Appwrite Configuration
 * Travel World CRM
 */

define('APPWRITE_ENDPOINT', getenv('APPWRITE_ENDPOINT') ?: 'https://cloud.appwrite.io/v1');
define('APPWRITE_PROJECT_ID', getenv('APPWRITE_PROJECT_ID') ?: '');
define('APPWRITE_API_KEY', getenv('APPWRITE_API_KEY') ?: '');
define('APPWRITE_DATABASE_ID', getenv('APPWRITE_DATABASE_ID') ?: 'travelworld-crm');
define('APPWRITE_BUCKET_ID', getenv('APPWRITE_BUCKET_ID') ?: 'crm-documents');

// Fixed CRM Login Credentials (stored in env)
define('CRM_ADMIN_EMAIL', getenv('CRM_ADMIN_EMAIL') ?: 'admin@travelworld.com');
define('CRM_ADMIN_PASSWORD', getenv('CRM_ADMIN_PASSWORD') ?: 'TravelWorld@2024');

// Session config
define('CRM_SESSION_NAME', 'tw_crm_session');
define('CRM_SESSION_LIFETIME', 86400); // 24 hours

// Appwrite Collection IDs
define('COL_CUSTOMERS',  'customers');
define('COL_LEADS',      'leads');
define('COL_ENQUIRIES',  'enquiries');
define('COL_FOLLOWUPS',  'followups');
define('COL_QUOTATIONS', 'quotations');
define('COL_BOOKINGS',   'bookings');
define('COL_PAYMENTS',   'payments');
define('COL_DOCUMENTS',  'documents');
define('COL_FEEDBACK',   'feedback');