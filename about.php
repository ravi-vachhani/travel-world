<?php
$rootPath      = './';
$pageTitle     = 'About Us — Travel World Luxury Travel Agency';
$pageDesc      = 'Travel World is a luxury travel management company with 7+ years of experience, 241+ destinations, and 24,000+ happy travellers. Discover our story and team.';
$pageKeywords  = 'about Travel World, luxury travel agency, travel management company, travel specialists, about us';
$pageCanonical = 'https://www.travelworld.com/about.php';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'           => 'AboutPage',
      '@id'             => 'https://www.travelworld.com/about.php#webpage',
      'url'             => 'https://www.travelworld.com/about.php',
      'name'            => 'About Travel World — Luxury Travel Management',
      'description'     => $pageDesc,
      'isPartOf'        => ['@id' => 'https://www.travelworld.com/#website'],
      'about'           => ['@id' => 'https://www.travelworld.com/#organization'],
    ],
    [
      '@type'           => 'TravelAgency',
      '@id'             => 'https://www.travelworld.com/#organization',
      'name'            => 'Travel World',
      'url'             => 'https://www.travelworld.com/',
      'logo'            => ['@type' => 'ImageObject', 'url' => 'https://www.travelworld.com/assets/image/logo.webp'],
      'description'     => 'Travel World is a luxury travel management company offering bespoke holidays, visa services, flights, hotels, and transfers for individuals and businesses worldwide.',
      'foundingDate'    => '2017',
      'areaServed'      => 'Worldwide',
      'serviceType'     => ['Holiday Packages', 'Visa Services', 'Corporate Travel', 'Honeymoon Packages'],
      'contactPoint'    => [
        '@type'         => 'ContactPoint',
        'telephone'     => '+91-9904040001',
        'contactType'   => 'customer service',
        'availableLanguage' => ['English', 'Hindi'],
      ],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => 'https://www.travelworld.com/about.php'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/includes/page-header.php';
?>

<!-- Hero -->
<section class="page-hero" style="height:55vh;">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="./">Home</a><span>›</span><span>About Us</span>
    </div>
    <h1 class="page-hero-title">Our Story</h1>
    <p class="page-hero-tagline">Fifteen years of crafting journeys that change lives</p>
  </div>
</section>

<!-- Who We Are -->
<section class="inner-section">
  <div class="overview-grid">
    <div class="overview-text reveal">
      <div class="section-label">Who We Are</div>
      <h2 class="section-title">Born from a Passion for the Extraordinary</h2>
      <p>TravelWorld was founded in 2010 by a group of passionate travellers who believed that a journey should be more than a holiday — it should be a transformative experience that stays with you forever.</p>
      <p>From our first office in Mumbai, we have grown into one of India's most trusted luxury travel specialists, crafting bespoke itineraries for discerning travellers across 62 destinations on 5 continents.</p>
      <p>We don't sell packages. We listen to your dreams, understand your desires, and create journeys that are as unique as you are — from a private villa in Santorini to a Bedouin camp in the Sahara, from a ryokan in Kyoto to an overwater bungalow in the Maldives.</p>
    </div>
    <div class="overview-highlights reveal">
      <div class="highlight-item"><i class="fas fa-globe"></i><h6>Destinations</h6><p>62 Countries</p></div>
      <div class="highlight-item"><i class="fas fa-users"></i><h6>Happy Travellers</h6><p>15,000+</p></div>
      <div class="highlight-item"><i class="fas fa-calendar"></i><h6>Years of Excellence</h6><p>Since 2010</p></div>
      <div class="highlight-item"><i class="fas fa-award"></i><h6>Awards Won</h6><p>12 Industry Awards</p></div>
      <div class="highlight-item"><i class="fas fa-star"></i><h6>Average Rating</h6><p>4.9 / 5.0</p></div>
      <div class="highlight-item"><i class="fas fa-headset"></i><h6>Support</h6><p>24/7 Travel Assistance</p></div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="inner-section alt">
  <div class="section-label reveal">Our Purpose</div>
  <h2 class="section-title reveal">Mission & Vision</h2>
  <div class="stay-tiers reveal" style="grid-template-columns:1fr 1fr;gap:2rem;">
    <div class="stay-tier">
      <div class="stay-tier-header"><h4>🎯 Our Mission</h4></div>
      <div class="stay-tier-body">
        <p style="font-family:'Inter',sans-serif;font-size:0.9rem;color:var(--gray);line-height:1.8;">
          To craft extraordinary travel experiences that go beyond the ordinary — connecting our clients with the world's most remarkable places, people and cultures in a way that is seamless, personal and unforgettable.
        </p>
      </div>
    </div>
    <div class="stay-tier">
      <div class="stay-tier-header"><h4>🌟 Our Vision</h4></div>
      <div class="stay-tier-body">
        <p style="font-family:'Inter',sans-serif;font-size:0.9rem;color:var(--gray);line-height:1.8;">
          To be India's most trusted luxury travel partner — known not for the volume of journeys we create, but for the depth of experience, the quality of curation, and the lasting memories we leave with every traveller.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Values -->
<section class="inner-section">
  <div class="section-label reveal">What Drives Us</div>
  <h2 class="section-title reveal">Our Values</h2>
  <div class="tips-grid" style="margin-top:2rem;">
    <div class="tip-card reveal">
      <i class="fas fa-gem"></i>
      <h5>Uncompromising Quality</h5>
      <p>We partner only with the finest hotels, guides and operators — every element of your journey is vetted to our exacting standards.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-fingerprint"></i>
      <h5>True Personalisation</h5>
      <p>No two journeys are the same. We take the time to understand who you are and what you dream of — then we make it happen.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-handshake"></i>
      <h5>Honest Expertise</h5>
      <p>Our team has personally visited every destination we recommend. We give you honest, first-hand advice — not brochure copy.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-leaf"></i>
      <h5>Responsible Travel</h5>
      <p>We believe in travel that gives back — supporting local communities, protecting natural environments and promoting sustainable tourism.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-headset"></i>
      <h5>Always There for You</h5>
      <p>From the moment you enquire to the moment you return home, our team is available 24/7 to ensure everything goes perfectly.</p>
    </div>
    <div class="tip-card reveal">
      <i class="fas fa-heart"></i>
      <h5>Passion for Travel</h5>
      <p>We are travellers first. Our passion for discovering the world is what drives us to create journeys that truly inspire.</p>
    </div>
  </div>
</section>

<!-- Team -->
<!-- <section class="inner-section alt">
  <div class="section-label reveal">The People Behind the Journeys</div>
  <h2 class="section-title reveal">Meet Our Team</h2>
  <p class="section-subtitle reveal">A team of passionate travellers, each with deep expertise in their specialist regions.</p>
  <div class="team-grid" style="margin-top:3rem;">
    <?php
    $team = [
      ['name'=>'Arjun Mehta',    'role'=>'Founder & CEO',              'img'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&q=80','region'=>'Asia & Middle East'],
      ['name'=>'Priya Sharma',   'role'=>'Head of Luxury Travel',      'img'=>'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&q=80','region'=>'Europe & Americas'],
      ['name'=>'Rahul Kapoor',   'role'=>'Adventure Travel Specialist','img'=>'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&q=80','region'=>'Africa & Oceania'],
      ['name'=>'Sneha Patel',    'role'=>'Honeymoon Expert',           'img'=>'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&q=80','region'=>'Maldives & Bali'],
      ['name'=>'Vikram Singh',   'role'=>'Corporate Travel Manager',   'img'=>'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&q=80','region'=>'Business Travel'],
      ['name'=>'Ananya Nair',    'role'=>'Family Travel Specialist',   'img'=>'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&q=80','region'=>'Family & Group Tours'],
    ];
    foreach ($team as $member): ?>
    <div class="team-card reveal">
      <img class="team-card-img" src="<?php echo $member['img']; ?>" alt="<?php echo $member['name']; ?>" loading="lazy">
      <h5><?php echo $member['name']; ?></h5>
      <p><?php echo $member['role']; ?></p>
      <p style="font-size:0.7rem;color:var(--gray);margin-top:0.3rem;font-family:'Inter',sans-serif;"><?php echo $member['region']; ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section> -->

<!-- Awards -->
<section class="inner-section">
  <div class="section-label reveal">Recognition</div>
  <h2 class="section-title reveal">Awards & Accolades</h2>
  <div class="food-grid" style="margin-top:2rem;">
    <div class="food-card reveal"><span class="food-card-emoji">🏆</span><h6>Best Luxury Travel Agency</h6><p>Travel + Leisure India, 2024</p></div>
    <div class="food-card reveal"><span class="food-card-emoji">⭐</span><h6>Top 10 Travel Companies</h6><p>Condé Nast Traveller India, 2023</p></div>
    <div class="food-card reveal"><span class="food-card-emoji">🌟</span><h6>Excellence in Service</h6><p>TAAI National Awards, 2023</p></div>
    <div class="food-card reveal"><span class="food-card-emoji">🎖️</span><h6>Best Honeymoon Specialist</h6><p>WeddingWire India, 2022 & 2023</p></div>
    <div class="food-card reveal"><span class="food-card-emoji">🌿</span><h6>Sustainable Tourism Award</h6><p>PATA India Chapter, 2022</p></div>
    <div class="food-card reveal"><span class="food-card-emoji">💎</span><h6>Preferred Partner</h6><p>Virtuoso Luxury Travel Network</p></div>
  </div>
</section>

<!-- CTA -->
<section class="enquiry-cta">
  <div class="section-label">Ready to Travel?</div>
  <h2 class="section-title">Start Your Journey Today</h2>
  <p class="section-subtitle">Let our experts craft the trip of a lifetime — tailored entirely to you.</p>
  <a href="./contact.php" class="btn-submit" style="display:inline-block;text-decoration:none;padding:1rem 3rem;margin-top:1rem;">
    Plan My Journey <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
  </a>
</section>

<?php include __DIR__ . '/includes/page-footer.php'; ?>