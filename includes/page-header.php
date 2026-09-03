<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo $rootPath ?? './'; ?>assets/image/favicon.ico">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $rootPath ?? './'; ?>assets/image/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo $rootPath ?? './'; ?>assets/image/logo.png">

  <title><?php echo htmlspecialchars($pageTitle ?? 'TravelWorld'); ?> — TravelWorld Luxury Travel</title>
  <meta name="description" content="<?php echo htmlspecialchars($pageDesc ?? 'Luxury travel experiences crafted for the discerning traveller.'); ?>">
  <?php if (!empty($pageKeywords)): ?>
  <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
  <?php endif; ?>

  <!-- Canonical URL -->
  <?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'www.travelworld.com';
    $uri  = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $canonicalUrl = $pageCanonical ?? ($protocol . '://' . $host . $uri);
  ?>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">

  <!-- Open Graph -->
  <meta property="og:type"        content="<?php echo htmlspecialchars($ogType ?? 'website'); ?>">
  <meta property="og:title"       content="<?php echo htmlspecialchars($pageTitle ?? 'TravelWorld'); ?> — TravelWorld Luxury Travel">
  <meta property="og:description" content="<?php echo htmlspecialchars($pageDesc ?? 'Luxury travel experiences crafted for the discerning traveller.'); ?>">
  <meta property="og:url"         content="<?php echo htmlspecialchars($canonicalUrl); ?>">
  <meta property="og:image"       content="<?php echo htmlspecialchars($ogImage ?? ($protocol . '://' . $host . '/assets/image/logo.webp')); ?>">
  <meta property="og:site_name"   content="TravelWorld">
  <meta property="og:locale"      content="en_US">

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="<?php echo htmlspecialchars($pageTitle ?? 'TravelWorld'); ?> — TravelWorld Luxury Travel">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDesc ?? 'Luxury travel experiences crafted for the discerning traveller.'); ?>">
  <meta name="twitter:image"       content="<?php echo htmlspecialchars($ogImage ?? ($protocol . '://' . $host . '/assets/image/logo.webp')); ?>">

  <!-- Robots -->
  <meta name="robots" content="<?php echo htmlspecialchars($metaRobots ?? 'index, follow'); ?>">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo $rootPath ?? './'; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo $rootPath ?? './'; ?>assets/css/inner.css">

  <!-- JSON-LD Schema (page-specific) -->
  <?php if (!empty($jsonLd)): ?>
  <script type="application/ld+json"><?php echo $jsonLd; ?></script>
  <?php endif; ?>

  <style>
    /* Reveal animation — uses CSS animation so content is always visible */
    .reveal { animation: revealUp 0.7s ease both; }
    @keyframes revealUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    /* Stagger children slightly */
    .reveal:nth-child(2) { animation-delay: 0.1s; }
    .reveal:nth-child(3) { animation-delay: 0.2s; }
    .reveal:nth-child(4) { animation-delay: 0.3s; }
    .reveal:nth-child(5) { animation-delay: 0.4s; }
  </style>
</head>
<body>

<!-- ── HEADER / NAV ──────────────────────────────────────────── -->
<header id="header" class="site-header">
  <nav class="nav-container">
    <a href="<?php echo $rootPath ?? './'; ?>" class="nav-logo">
      <img  src="<?php echo $rootPath ?? './'; ?>assets/image/logo.webp" alt="Travel World" class="inner_lage_logo nav-logo-img">
    </a>

    <ul class="nav-links">
      <li><a href="<?php echo $rootPath ?? './'; ?>">Home</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>destinations/">Destinations</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>services/">Services</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>visa/">Visa</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>about.php">About</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>contact.php" class="nav-cta">Enquire</a></li>
    </ul>

    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <div class="mobile-menu" id="mobileMenu">
    <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu"></button>
    <ul>
      <li><a href="<?php echo $rootPath ?? './'; ?>">Home</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>destinations/">Destinations</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>services/">Services</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>visa/">Visa Services</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>about.php">About</a></li>
      <li><a href="<?php echo $rootPath ?? './'; ?>contact.php">Enquire</a></li>
    </ul>
  </div>
</header>