<?php
/**
 * CRM Authentication — stateless signed-cookie sessions.
 *
 * WHY NOT PHP SESSIONS: on Vercel (serverless) PHP's default session files are
 * written to an ephemeral /tmp that is not shared between function instances,
 * so a user appears "logged out" on the next request. Instead we store the
 * login state in a cookie that is HMAC-signed with CRM_AUTH_SECRET. Nothing is
 * stored server-side, so it works across any instance.
 *
 * The public function names (crm_login / crm_is_logged_in / crm_require_auth /
 * crm_current_user / crm_logout / crm_session_start) are kept identical to the
 * previous implementation so no page needs to change.
 */

require_once __DIR__ . '/supabase.php';
require_once __DIR__ . '/supabase-client.php';

// ── Internal: base64url helpers ──────────────────────────────────────────────

function _crm_b64url_encode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function _crm_b64url_decode(string $data): string {
    return base64_decode(strtr($data, '-_', '+/'));
}

/** Build a signed token "<payloadB64>.<sigB64>" from a user array. */
function _crm_sign_token(array $payload): string {
    $payload['iat'] = time();
    $payload['exp'] = time() + CRM_SESSION_LIFETIME;
    $json = json_encode($payload);
    $b64  = _crm_b64url_encode($json);
    $sig  = hash_hmac('sha256', $b64, CRM_AUTH_SECRET, true);
    return $b64 . '.' . _crm_b64url_encode($sig);
}

/** Verify a signed token; returns the payload array or null if invalid/expired. */
function _crm_verify_token(?string $token): ?array {
    if (!$token || strpos($token, '.') === false) return null;
    [$b64, $sigB64] = explode('.', $token, 2);
    $expected = hash_hmac('sha256', $b64, CRM_AUTH_SECRET, true);
    $given    = _crm_b64url_decode($sigB64);
    if (!hash_equals($expected, $given)) return null;      // tampered / wrong secret
    $payload = json_decode(_crm_b64url_decode($b64), true);
    if (!is_array($payload)) return null;
    if (($payload['exp'] ?? 0) < time()) return null;      // expired
    return $payload;
}

/** True when the request is served over HTTPS (handles Vercel's proxy header). */
function _crm_is_https(): bool {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') return true;
    if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')   return true;
    if (($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '')   === 'on')      return true;
    return false;
}

/**
 * Work out the cookie Domain so the session survives www <-> non-www.
 * Returns the registrable domain with a leading dot (e.g. ".travelworld.co.in")
 * so both www.travelworld.co.in and travelworld.co.in share one cookie. For
 * Vercel preview hosts / localhost / IPs we return '' (host-only cookie).
 */
function _crm_cookie_domain(): string {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $host = preg_replace('/:\d+$/', '', $host);     // strip port
    if ($host === '' || filter_var($host, FILTER_VALIDATE_IP)) return '';
    if (substr($host, -strlen('travelworld.co.in')) === 'travelworld.co.in') {
        return '.travelworld.co.in';
    }
    // Any other custom domain: share across its own www/non-www by using the
    // last two labels (best-effort; falls back to host-only on short hosts).
    $parts = explode('.', $host);
    if (count($parts) >= 2 && !str_contains($host, 'vercel.app') && $host !== 'localhost') {
        // keep it host-only to be safe on unknown multi-label TLDs
        return '';
    }
    return '';
}

function _crm_set_cookie(string $value, int $expires): void {
    $params = [
        'expires'  => $expires,
        'path'     => '/',                 // whole site, so /api/crm.php sees it too
        'secure'   => _crm_is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ];
    $domain = _crm_cookie_domain();
    if ($domain !== '') $params['domain'] = $domain;
    setcookie(CRM_SESSION_NAME, $value, $params);
    // Make it available within the same request too.
    $_COOKIE[CRM_SESSION_NAME] = $value;
}

// ── Public API ───────────────────────────────────────────────────────────────

/** Kept for backwards compatibility; stateless auth needs no session start. */
function crm_session_start(): void {
    // no-op (previously called session_start)
}

/** Cache of the resolved current user for the duration of the request. */
function &_crm_user_cache(): array {
    static $cache = ['loaded' => false, 'user' => []];
    return $cache;
}

function crm_current_user(): array {
    $cache = &_crm_user_cache();
    if ($cache['loaded']) return $cache['user'];

    $cache['loaded'] = true;
    $cache['user']   = [];

    $payload = _crm_verify_token($_COOKIE[CRM_SESSION_NAME] ?? null);
    if (!$payload) return $cache['user'];

    // The signed cookie carries the identity; permissions/role/status are
    // refreshed from the DB so deactivation/role changes take effect immediately.
    $user = [
        'id'     => $payload['id']    ?? '',
        'email'  => $payload['email'] ?? '',
        'name'   => $payload['name']  ?? 'User',
        'role'   => $payload['role']  ?? 'admin',
        'status' => 'active',
    ];

    if (!empty($user['id']) && $user['id'] !== 'root') {
        $fresh = supabase()->getDocument(COL_USERS, $user['id']);
        if (!empty($fresh['$id'])) {
            $user['name']      = $fresh['name']   ?? $user['name'];
            $user['email']     = $fresh['email']  ?? $user['email'];
            $user['role']      = $fresh['role']   ?? $user['role'];
            $user['status']    = $fresh['status'] ?? 'active';
            $user['employee_id'] = $fresh['employee_id'] ?? '';
            $user['photo_url'] = $fresh['photo_url'] ?? '';
        }
    }

    $cache['user'] = $user;
    return $cache['user'];
}

function crm_is_logged_in(): bool {
    $u = crm_current_user();
    if (empty($u['email'])) return false;
    // Inactive / suspended users may not use the CRM.
    if (($u['status'] ?? 'active') !== 'active') return false;
    return true;
}

function crm_require_auth(): void {
    if (!crm_is_logged_in()) {
        header('Location: /crm/login.php');
        exit;
    }
}

/**
 * Attempt login. Checks the crm_users table first (bcrypt password), then falls
 * back to the fixed env super-admin credentials so the system is usable before
 * any user rows exist.
 */
function crm_login(string $email, string $password): bool {
    $email = strtolower(trim($email));

    // 1) Real user from the database
    $rows = supabase()->listDocuments(COL_USERS, [
        'equal("email","' . addslashes($email) . '")',
        'limit(1)',
    ]);
    $user = $rows['documents'][0] ?? null;

    if ($user) {
        $hash   = $user['password_hash'] ?? '';
        $status = $user['status'] ?? 'active';
        if ($hash && password_verify($password, $hash)) {
            if ($status !== 'active') {
                return false; // inactive / suspended cannot log in
            }
            _crm_issue_session([
                'id'    => $user['$id'],
                'email' => $user['email'] ?? $email,
                'name'  => $user['name'] ?? 'User',
                'role'  => $user['role'] ?? 'viewer',
            ]);
            // Stamp last_login (best effort)
            supabase()->updateDocument(COL_USERS, $user['$id'], [
                'last_login' => date('c'),
            ]);
            return true;
        }
        return false;
    }

    // 2) Fallback fixed super-admin (env credentials)
    if ($email === strtolower(CRM_ADMIN_EMAIL) && $password === CRM_ADMIN_PASSWORD) {
        _crm_issue_session([
            'id'    => 'root',
            'email' => CRM_ADMIN_EMAIL,
            'name'  => 'Super Admin',
            'role'  => 'super_admin',
        ]);
        return true;
    }

    return false;
}

/** Issue the signed cookie for an authenticated identity. */
function _crm_issue_session(array $identity): void {
    $token = _crm_sign_token($identity);
    _crm_set_cookie($token, time() + CRM_SESSION_LIFETIME);
    // Prime the request-level cache.
    $cache = &_crm_user_cache();
    $cache['loaded'] = true;
    $cache['user']   = array_merge(['status' => 'active'], $identity);
}

function crm_logout(): void {
    _crm_set_cookie('', time() - 3600);
    $cache = &_crm_user_cache();
    $cache['loaded'] = true;
    $cache['user']   = [];
    header('Location: /crm/login.php');
    exit;
}
