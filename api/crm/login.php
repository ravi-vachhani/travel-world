<?php
require_once __DIR__ . '/config/appwrite.php';
require_once __DIR__ . '/config/auth.php';

crm_session_start();

// Already logged in → redirect to dashboard
if (crm_is_logged_in()) {
    header('Location: /crm/');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (crm_login($email, $password)) {
        header('Location: /crm/');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRM Login — Travel World</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --gold: #C9A84C;
    --gold-dark: #a8872e;
    --bg: #0f1117;
    --surface: #1a1d27;
    --border: #2a2d3a;
    --text: #e8eaf0;
    --muted: #8b8fa8;
    --error: #ff5c5c;
  }
  body {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }
  .login-wrap {
    width: 100%;
    max-width: 420px;
  }
  .login-logo {
    text-align: center;
    margin-bottom: 2rem;
  }
  .login-logo img {
    height: 48px;
    margin-bottom: 0.75rem;
  }
  .login-logo h1 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--muted);
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }
  .login-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2.5rem 2rem;
  }
  .login-card h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
  }
  .login-card p {
    color: var(--muted);
    font-size: 0.875rem;
    margin-bottom: 2rem;
  }
  .form-group {
    margin-bottom: 1.25rem;
  }
  label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
  }
  input[type="email"],
  input[type="password"] {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: var(--text);
    font-size: 0.95rem;
    font-family: inherit;
    transition: border-color 0.2s;
    outline: none;
  }
  input:focus {
    border-color: var(--gold);
  }
  .error-msg {
    background: rgba(255,92,92,0.1);
    border: 1px solid rgba(255,92,92,0.3);
    color: var(--error);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    margin-bottom: 1.25rem;
  }
  .btn-login {
    width: 100%;
    background: var(--gold);
    color: #0f1117;
    border: none;
    border-radius: 8px;
    padding: 0.85rem;
    font-size: 1rem;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 0.5rem;
  }
  .btn-login:hover { background: var(--gold-dark); }
  .back-link {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.85rem;
    color: var(--muted);
  }
  .back-link a { color: var(--gold); text-decoration: none; }
  .back-link a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="login-wrap">
  <div class="login-logo">
    <img src="/assets/image/logo.webp" alt="Travel World">
    <h1>CRM Portal</h1>
  </div>
  <div class="login-card">
    <h2>Welcome back</h2>
    <p>Sign in to access the Travel World CRM</p>

    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/crm/login.php">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="admin@travelworld.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-login">Sign In</button>
    </form>
  </div>
  <div class="back-link">
    <a href="/">&larr; Back to Travel World</a>
  </div>
</div>
</body>
</html>