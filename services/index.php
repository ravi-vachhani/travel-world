<?php
$rootPath      = '../';
$pageTitle     = 'Our Services — Luxury Travel Management | Travel World';
$pageDesc      = 'Travel World luxury travel services — honeymoon packages, adventure travel, corporate travel management, family holidays, group tours and more. Tailored for every traveller.';
$pageKeywords  = 'luxury travel services, honeymoon packages, corporate travel, adventure travel, family holidays, group tours, travel management';
$pageCanonical = 'https://www.travelworld.com/services/';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'CollectionPage',
      '@id'         => 'https://www.travelworld.com/services/#webpage',
      'url'         => 'https://www.travelworld.com/services/',
      'name'        => 'Our Services — Travel World',
      'description' => $pageDesc,
      'isPartOf'    => ['@id' => 'https://www.travelworld.com/#website'],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://www.travelworld.com/services/'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include '../includes/page-header.php';

$services = [
  [
    'slug'    => 'honeymoon',
    'icon'    => 'fas fa-heart',
    'title'   => 'Honeymoon Packages',
    'tagline' => 'Begin Forever in Paradise',
    'desc'    => 'Bespoke honeymoon itineraries crafted for couples — private villas, candlelit dinners, overwater bungalows and moments you\'ll treasure forever.',
    'img'     => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80',
    'popular' => ['Maldives', 'Bali', 'Santorini', 'Paris'],
  ],
  [
    'slug'    => 'adventure',
    'icon'    => 'fas fa-mountain',
    'title'   => 'Adventure Travel',
    'tagline' => 'Push Your Limits',
    'desc'    => 'From Himalayan treks to Sahara camel rides, from Patagonian hikes to Maldivian dives — adventure travel designed for the bold.',
    'img'     => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=80',
    'popular' => ['Nepal', 'Patagonia', 'Iceland', 'New Zealand'],
  ],
  [
    'slug'    => 'luxury',
    'icon'    => 'fas fa-gem',
    'title'   => 'Luxury Escapes',
    'tagline' => 'The Finest in Every Detail',
    'desc'    => 'Private jets, Michelin-starred dining, butler service and the world\'s most exclusive hotels — luxury travel without compromise.',
    'img'     => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
    'popular' => ['Dubai', 'Maldives', 'Swiss Alps', 'Amalfi'],
  ],
  [
    'slug'    => 'family',
    'icon'    => 'fas fa-users',
    'title'   => 'Family Holidays',
    'tagline' => 'Memories for a Lifetime',
    'desc'    => 'Family-friendly itineraries that keep everyone happy — from theme parks to wildlife safaris, beach resorts to cultural adventures.',
    'img'     => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=600&q=80',
    'popular' => ['Singapore', 'Bali', 'Sydney', 'Thailand'],
  ],
  [
    'slug'    => 'corporate',
    'icon'    => 'fas fa-briefcase',
    'title'   => 'Corporate Travel',
    'tagline' => 'Business Class, Every Time',
    'desc'    => 'End-to-end corporate travel management — flights, hotels, transfers, MICE events and incentive trips handled with precision.',
    'img'     => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=600&q=80',
    'popular' => ['Dubai', 'Singapore', 'London', 'New York'],
  ],
  [
    'slug'    => 'cruise',
    'icon'    => 'fas fa-ship',
    'title'   => 'Cruise Packages',
    'tagline' => 'Sail the World in Style',
    'desc'    => 'Mediterranean, Caribbean, Norwegian Fjords and beyond — luxury cruise packages with the world\'s finest cruise lines.',
    'img'     => 'https://images.unsplash.com/photo-1548574505-5e239809ee19?w=600&q=80',
    'popular' => ['Mediterranean', 'Caribbean', 'Norway', 'Alaska'],
  ],
  [
    'slug'    => 'group',
    'icon'    => 'fas fa-people-group',
    'title'   => 'Group Tours',
    'tagline' => 'Better Together',
    'desc'    => 'Curated group tours for friends, families and colleagues — shared experiences that create lifelong bonds.',
    'img'     => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=600&q=80',
    'popular' => ['Europe', 'Southeast Asia', 'Morocco', 'Japan'],
  ],
  [
    'slug'    => 'solo',
    'icon'    => 'fas fa-person-walking',
    'title'   => 'Solo Travel',
    'tagline' => 'Your Journey, Your Rules',
    'desc'    => 'Safe, well-planned solo itineraries for the independent traveller — with the security of expert support whenever you need it.',
    'img'     => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600&q=80',
    'popular' => ['Japan', 'Iceland', 'New Zealand', 'Portugal'],
  ],
];
?>

<!-- Hero -->
<section class="page-hero" style="height:50vh;">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>›</span><span>Services</span>
    </div>
    <h1 class="page-hero-title">Our Services</h1>
    <p class="page-hero-tagline">Every journey crafted to perfection — whatever your travel style</p>
  </div>
</section>

<!-- Services Grid -->
<section class="inner-section">
  <div class="section-label reveal">What We Offer</div>
  <h2 class="section-title reveal">Travel Experiences for Every Dream</h2>
  <p class="section-subtitle reveal">From intimate honeymoons to grand family adventures — we specialise in every kind of extraordinary journey.</p>

  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2rem;margin-top:3rem;">
    <?php foreach ($services as $s): ?>
    <a href="/services/<?php echo $s['slug']; ?>" style="text-decoration:none;display:block;" class="reveal">
      <div style="background:var(--dark3);border:1px solid rgba(255,255,255,0.06);border-radius:12px;overflow:hidden;transition:border-color 0.3s,transform 0.3s;" onmouseover="this.style.borderColor='rgba(201,168,76,0.35)';this.style.transform='translateY(-6px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)';this.style.transform='translateY(0)'">
        <div style="position:relative;height:200px;overflow:hidden;">
          <img src="<?php echo $s['img']; ?>" alt="<?php echo $s['title']; ?>" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s;" loading="lazy">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.7) 0%,transparent 60%);"></div>
          <div style="position:absolute;bottom:1rem;left:1.2rem;">
            <i class="<?php echo $s['icon']; ?>" style="color:var(--gold);font-size:1.2rem;"></i>
          </div>
        </div>
        <div style="padding:1.5rem;">
          <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:400;color:var(--white);margin-bottom:0.3rem;"><?php echo $s['title']; ?></h4>
          <p style="font-family:'Inter',sans-serif;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:0.8rem;"><?php echo $s['tagline']; ?></p>
          <p style="font-family:'Inter',sans-serif;font-size:0.8rem;color:var(--gray);line-height:1.7;margin-bottom:1rem;"><?php echo $s['desc']; ?></p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
            <?php foreach ($s['popular'] as $dest): ?>
            <span style="font-family:'Inter',sans-serif;font-size:0.65rem;color:var(--gray);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:3px;padding:0.2rem 0.6rem;"><?php echo $dest; ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Why Us -->
<section class="inner-section alt">
  <div class="section-label reveal">Why TravelWorld</div>
  <h2 class="section-title reveal">The TravelWorld Difference</h2>
  <div class="tips-grid" style="margin-top:2rem;">
    <div class="tip-card reveal"><i class="fas fa-fingerprint"></i><h5>100% Bespoke</h5><p>Every itinerary is crafted from scratch — no templates, no off-the-shelf packages.</p></div>
    <div class="tip-card reveal"><i class="fas fa-user-tie"></i><h5>Expert Specialists</h5><p>Each destination has a dedicated specialist who has personally visited and vetted every experience.</p></div>
    <div class="tip-card reveal"><i class="fas fa-headset"></i><h5>24/7 Support</h5><p>Our emergency line is available around the clock — wherever you are in the world.</p></div>
    <div class="tip-card reveal"><i class="fas fa-shield-alt"></i><h5>Fully Protected</h5><p>All bookings are financially protected and covered by our travel insurance partnerships.</p></div>
    <div class="tip-card reveal"><i class="fas fa-leaf"></i><h5>Responsible Travel</h5><p>We partner with sustainable operators and support local communities in every destination.</p></div>
    <div class="tip-card reveal"><i class="fas fa-star"></i><h5>4.9/5 Rating</h5><p>Over 15,000 happy travellers and a 4.9/5 average rating across all platforms.</p></div>
  </div>
</section>

<!-- CTA -->
<section class="enquiry-cta">
  <div class="section-label">Start Planning</div>
  <h2 class="section-title">Tell Us Your Dream</h2>
  <p class="section-subtitle" style="margin:0 auto 2rem;">Our experts are ready to craft your perfect journey — free consultation, no obligation.</p>
  <a href="/contact" class="btn-submit" style="display:inline-block;text-decoration:none;padding:1rem 3rem;width:auto;">
    Get a Free Consultation <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
  </a>
</section>

<?php include '../includes/page-footer.php'; ?>