<?php
/**
 * Role-Based Access Control helpers.
 *
 * Permissions are strings like "customers.view". A user's effective permission
 * set is derived from their role (crm_roles) via crm_role_permissions. Record
 * scope (OWN / TEAM / ALL) comes from the role and governs which rows a user may
 * see or act on.
 *
 * These checks are SERVER-SIDE. Pages call crm_require_permission() at the top
 * so that even a direct URL / API hit is blocked, not just a hidden button.
 */

require_once __DIR__ . '/supabase.php';
require_once __DIR__ . '/supabase-client.php';
require_once __DIR__ . '/auth.php';

/** Full catalogue of permissions, grouped by module (for the roles editor). */
function crm_permission_catalogue(): array {
    return [
        'customers'  => ['view', 'create', 'edit', 'delete'],
        'leads'      => ['view', 'create', 'edit', 'delete'],
        'enquiries'  => ['view', 'create', 'edit', 'delete'],
        'followups'  => ['view', 'create', 'edit', 'delete'],
        'quotations' => ['view', 'create', 'edit', 'delete'],
        'bookings'   => ['view', 'create', 'edit', 'delete'],
        'payments'   => ['view', 'create', 'edit', 'delete'],
        'documents'  => ['view', 'upload', 'delete'],
        'reports'    => ['view'],
        'attendance' => ['view', 'manage'],
        'users'      => ['view', 'create', 'edit', 'delete'],
        'roles'      => ['view', 'create', 'edit', 'delete'],
    ];
}

/** Flat list of all permission strings. */
function crm_all_permissions(): array {
    $out = [];
    foreach (crm_permission_catalogue() as $m => $acts) {
        foreach ($acts as $a) $out[] = "$m.$a";
    }
    return $out;
}

/** Load (and cache) the role row + permission list for a role name. */
function crm_role_bundle(string $roleName): array {
    static $cache = [];
    if (isset($cache[$roleName])) return $cache[$roleName];

    $bundle = ['role' => null, 'scope' => 'OWN', 'permissions' => []];

    // The built-in super_admin always has everything, even before DB seeding.
    if ($roleName === 'super_admin') {
        $bundle['scope']       = 'ALL';
        $bundle['permissions'] = ['*'];
        return $cache[$roleName] = $bundle;
    }

    $roles = supabase()->listDocuments(COL_ROLES, [
        'equal("name","' . addslashes($roleName) . '")',
        'limit(1)',
    ]);
    $role = $roles['documents'][0] ?? null;
    if ($role) {
        $bundle['role']  = $role;
        $bundle['scope'] = $role['scope'] ?? 'OWN';
        $perms = supabase()->listDocuments(COL_ROLE_PERMS, [
            'equal("role_id","' . addslashes($role['$id']) . '")',
            'limit(500)',
        ]);
        foreach (($perms['documents'] ?? []) as $p) {
            if (!empty($p['permission'])) $bundle['permissions'][] = $p['permission'];
        }
    }
    return $cache[$roleName] = $bundle;
}

/** All permission strings the current user holds. */
function crm_user_permissions(): array {
    $u = crm_current_user();
    $role = $u['role'] ?? '';
    if ($role === 'super_admin') return ['*'];
    return crm_role_bundle($role)['permissions'];
}

/** The current user's record scope: OWN | TEAM | ALL. */
function crm_user_scope(): string {
    $u = crm_current_user();
    $role = $u['role'] ?? '';
    if ($role === 'super_admin') return 'ALL';
    return crm_role_bundle($role)['scope'] ?? 'OWN';
}

/** True if the current user holds a given permission (e.g. "customers.edit"). */
function crm_can(string $permission): bool {
    $perms = crm_user_permissions();
    if (in_array('*', $perms, true)) return true;
    if (in_array($permission, $perms, true)) return true;
    // module wildcard: "customers.*"
    $module = explode('.', $permission)[0] ?? '';
    if ($module && in_array($module . '.*', $perms, true)) return true;
    return false;
}

/** True if the user holds ANY of the given permissions. */
function crm_can_any(array $permissions): bool {
    foreach ($permissions as $p) if (crm_can($p)) return true;
    return false;
}

/**
 * Enforce a permission; render a 403 and stop if the user lacks it.
 * Call this at the TOP of a page/handler, after crm_require_auth().
 */
function crm_require_permission(string $permission): void {
    if (crm_can($permission)) return;
    http_response_code(403);
    $title = 'Access denied';
    // Minimal, theme-consistent 403 page.
    echo '<!DOCTYPE html><html><head><meta charset="utf-8">'
       . '<title>403 — ' . htmlspecialchars($title) . '</title>'
       . '<link rel="stylesheet" href="/crm/assets/crm.css"></head><body>'
       . '<div style="max-width:480px;margin:12vh auto;text-align:center;'
       . 'background:#fff;border:1px solid #e2e6ee;border-radius:16px;padding:2.5rem;'
       . 'box-shadow:0 4px 24px rgba(16,24,40,0.08)">'
       . '<h1 style="font-size:1.4rem;margin-bottom:.5rem">Access denied</h1>'
       . '<p style="color:#6b7280;margin-bottom:1.5rem">You do not have permission '
       . 'to access <strong>' . htmlspecialchars($permission) . '</strong>.</p>'
       . '<a href="/crm/" class="btn btn-primary" style="display:inline-flex">Back to Dashboard</a>'
       . '</div></body></html>';
    exit;
}

/**
 * Scope filter helper for list queries. Returns an Appwrite-style query clause
 * (or null) that restricts rows to the current user when scope is OWN/TEAM.
 *
 * $ownerField   column that stores the owning user id (e.g. "assigned_to")
 * Returns array of query strings to merge into listDocuments().
 */
function crm_scope_queries(string $ownerField = 'assigned_to'): array {
    $scope = crm_user_scope();
    $u     = crm_current_user();
    $uid   = $u['id'] ?? '';

    if ($scope === 'ALL' || $uid === '' || $uid === 'root') {
        return []; // no restriction
    }
    if ($scope === 'OWN') {
        return ['equal("' . $ownerField . '","' . addslashes($uid) . '")'];
    }
    if ($scope === 'TEAM') {
        // Team = users who report to the same manager, or to this user.
        $teamIds = crm_team_user_ids($uid);
        if (!$teamIds) return ['equal("' . $ownerField . '","' . addslashes($uid) . '")'];
        // PostgREST "in" via our client isn't wired; fall back to own + manager
        // handled at query build time by callers. Return own as safe default.
        return ['equal("' . $ownerField . '","' . addslashes($uid) . '")'];
    }
    return [];
}

/** Return the set of user ids that belong to the current user's team. */
function crm_team_user_ids(string $uid): array {
    $ids = [$uid];
    // direct reports (users whose manager_id = uid)
    $reports = supabase()->listDocuments(COL_USERS, [
        'equal("manager_id","' . addslashes($uid) . '")',
        'limit(200)',
    ]);
    foreach (($reports['documents'] ?? []) as $r) {
        if (!empty($r['$id'])) $ids[] = $r['$id'];
    }
    return array_values(array_unique($ids));
}

/** Convenience: is the current user an administrator (admin or super_admin)? */
function crm_is_admin(): bool {
    $role = crm_current_user()['role'] ?? '';
    return in_array($role, ['admin', 'super_admin'], true);
}

// ── Audit logging ─────────────────────────────────────────────────────────────

/**
 * Write an audit record. $old / $new may be arrays (stored as JSON).
 */
function crm_audit(string $action, string $module, string $recordId = '', $old = null, $new = null): void {
    $u = crm_current_user();
    supabase()->createDocument(COL_AUDIT, [
        'actor_id'   => $u['id']   ?? '',
        'actor_name' => $u['name'] ?? '',
        'action'     => $action,
        'module'     => $module,
        'record_id'  => $recordId,
        'old_value'  => $old !== null ? json_encode($old) : '',
        'new_value'  => $new !== null ? json_encode($new) : '',
    ]);
}
