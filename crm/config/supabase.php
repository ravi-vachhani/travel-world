<?php
/**
 * Supabase Configuration
 * Travel World CRM
 *
 * Values are read from environment variables when available, with sane
 * fallbacks to the project credentials so the CRM also works on a plain
 * PHP host without env configuration.
 */

// ── Timezone ─────────────────────────────────────────────────────────────────
// The server (Vercel) runs in UTC, which made punch in/out and booking times
// look wrong. Force India Standard Time for every date()/strtotime() call so
// all timestamps the CRM shows and stores are IST-based.
define('CRM_TZ', 'Asia/Kolkata');
date_default_timezone_set(CRM_TZ);

define('SUPABASE_URL', getenv('NEXT_PUBLIC_SUPABASE_URL') ?: (getenv('SUPABASE_URL') ?: 'https://pxrtabaeqnghotaowytx.supabase.co'));

// REST (PostgREST) base endpoint
define('SUPABASE_REST_URL', rtrim(SUPABASE_URL, '/') . '/rest/v1');

// Service role key: full access, used server-side only. Falls back to anon key.
define('SUPABASE_SERVICE_KEY', getenv('SUPABASE_SERVICE_ROLE_KEY')
    ?: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InB4cnRhYmFlcW5naG90YW93eXR4Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc5MDgzMzY5MywiZXhwIjoyMTA2NDA5NjkzfQ.t9fAsnZAbPeR6_B4kFlpO5tfneyPTgC9OimkRcYF0hc');

// Anon key (public)
define('SUPABASE_ANON_KEY', getenv('SUPABASE_ANON_KEY')
    ?: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InB4cnRhYmFlcW5naG90YW93eXR4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3OTA4MzM2OTMsImV4cCI6MjEwNjQwOTY5M30.BjlmHn9-XqpyUOqgWBDkos0QPy2T90I-Bcrl0xmwNsY');

// Storage bucket used for CRM documents (create it in Supabase Storage)
define('SUPABASE_BUCKET', getenv('SUPABASE_BUCKET') ?: 'crm-documents');

// Fixed CRM Login Credentials (stored in env)
define('CRM_ADMIN_EMAIL', getenv('CRM_ADMIN_EMAIL') ?: 'admin@travelworld.com');
define('CRM_ADMIN_PASSWORD', getenv('CRM_ADMIN_PASSWORD') ?: 'TravelWorld@2024');

// Session config
define('CRM_SESSION_NAME', 'tw_crm_session');
define('CRM_SESSION_LIFETIME', 86400); // 24 hours

// Secret used to HMAC-sign the stateless auth cookie. We reuse the Supabase
// JWT secret when available (it is already a strong server-side secret), with a
// fallback so local/dev still works. CHANGE THIS via env in production.
define('CRM_AUTH_SECRET', getenv('SUPABASE_JWT_SECRET')
    ?: 'CzQkafGLsu9dQw9aXNwipb6XTFmF8PE7G+qnJdfdcsNUETYA2CBG+CfKl9E8eRAjRxZys8fHntixXYxQFAqnbQ==');

// Table names (Postgres tables in the `public` schema)
define('COL_CUSTOMERS',  'customers');
define('COL_LEADS',      'leads');
define('COL_ENQUIRIES',  'enquiries');
define('COL_FOLLOWUPS',  'followups');
define('COL_QUOTATIONS', 'quotations');
define('COL_BOOKINGS',   'bookings');
define('COL_PAYMENTS',   'payments');
define('COL_DOCUMENTS',  'documents');
define('COL_FEEDBACK',   'feedback');

// Admin / RBAC / attendance tables
define('COL_USERS',       'crm_users');
define('COL_ROLES',       'crm_roles');
define('COL_ROLE_PERMS',  'crm_role_permissions');
define('COL_AUDIT',       'crm_audit_logs');
define('COL_ATTENDANCE',  'crm_attendance');
