<?php
/**
 * CRM Authentication Helper
 * Simple session-based auth with fixed credentials
 */

require_once __DIR__ . '/appwrite.php';

function crm_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_name(CRM_SESSION_NAME);
        session_set_cookie_params([
            'lifetime' => CRM_SESSION_LIFETIME,
            'path'     => '/crm',
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function crm_is_logged_in(): bool {
    crm_session_start();
    return !empty($_SESSION['crm_user']) && !empty($_SESSION['crm_logged_in']);
}

function crm_require_auth(): void {
    if (!crm_is_logged_in()) {
        header('Location: /crm/login.php');
        exit;
    }
}

function crm_login(string $email, string $password): bool {
    crm_session_start();
    if ($email === CRM_ADMIN_EMAIL && $password === CRM_ADMIN_PASSWORD) {
        $_SESSION['crm_logged_in'] = true;
        $_SESSION['crm_user'] = [
            'email' => $email,
            'name'  => 'Admin',
            'role'  => 'admin',
        ];
        session_regenerate_id(true);
        return true;
    }
    return false;
}

function crm_logout(): void {
    crm_session_start();
    $_SESSION = [];
    session_destroy();
    header('Location: /crm/login.php');
    exit;
}

function crm_current_user(): array {
    crm_session_start();
    return $_SESSION['crm_user'] ?? [];
}