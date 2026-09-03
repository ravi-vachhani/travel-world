<?php
$rootPath      = '../';
$pageTitle     = 'All Destinations — Luxury Holiday Packages | Travel World';
$pageDesc      = 'Explore 241+ extraordinary destinations across 5 continents. Maldives, Bali, Paris, Dubai, Japan and more. Filter by continent and find your perfect luxury journey.';
$pageKeywords  = 'holiday destinations, luxury travel destinations, international holiday packages, best places to visit, travel destinations 2025';
$pageCanonical = 'https://www.travelworld.com/destinations/';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'           => 'CollectionPage',
      '@id'             => 'https://www.travelworld.com/destinations/#webpage',
      'url'             => 'https://www.travelworld.com/destinations/',
      'name'            => 'All Destinations — Travel World',
      'description'     => $pageDesc,
      'isPartOf'        => ['@id' => 'https://www.travelworld.com/#website'],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',         'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Destinations', 'item' => 'https://www.travelworld.com/destinations/'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include '../includes/page-header.php';

// All destinations data
$destinations = [
  // Asia
  ['slug'=>'dubai',        'name'=>'Dubai',          'country'=>'UAE',           'continent'=>'asia',    'tag'=>'4N · 5D · Luxury',    'img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80'],
  ['slug'=>'bali',         'name'=>'Bali',            'country'=>'Indonesia',     'continent'=>'asia',    'tag'=>'6N · 7D · Cultural',   'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80'],
  ['slug'=>'tokyo',        'name'=>'Tokyo',           'country'=>'Japan',         'continent'=>'asia',    'tag'=>'7N · 8D · Adventure',  'img'=>'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80'],
  ['slug'=>'thailand',     'name'=>'Thailand',        'country'=>'Thailand',      'continent'=>'asia',    'tag'=>'7N · 8D · Beach',      'img'=>'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=80'],
  ['slug'=>'maldives',     'name'=>'Maldives',        'country'=>'Maldives',      'continent'=>'asia',    'tag'=>'5N · 6D · Overwater',  'img'=>'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80'],
  ['slug'=>'singapore',    'name'=>'Singapore',       'country'=>'Singapore',     'continent'=>'asia',    'tag'=>'4N · 5D · Family',     'img'=>'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=600&q=80'],
  ['slug'=>'istanbul',     'name'=>'Istanbul',        'country'=>'Turkey',        'continent'=>'asia',    'tag'=>'5N · 6D · Heritage',   'img'=>'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=600&q=80'],
  ['slug'=>'vietnam',      'name'=>'Vietnam',         'country'=>'Vietnam',       'continent'=>'asia',    'tag'=>'8N · 9D · Cultural',   'img'=>'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80'],
  ['slug'=>'sri-lanka',    'name'=>'Sri Lanka',       'country'=>'Sri Lanka',     'continent'=>'asia',    'tag'=>'7N · 8D · Explorer',   'img'=>'https://images.unsplash.com/photo-1566296314736-6eaac1ca0cb9?w=600&q=80'],
  ['slug'=>'nepal',        'name'=>'Nepal',           'country'=>'Nepal',         'continent'=>'asia',    'tag'=>'8N · 9D · Adventure',  'img'=>'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=80'],
  ['slug'=>'bhutan',       'name'=>'Bhutan',          'country'=>'Bhutan',        'continent'=>'asia',    'tag'=>'6N · 7D · Spiritual',  'img'=>'https://images.unsplash.com/photo-1553856622-d1b352e9a211?w=600&q=80'],
  ['slug'=>'cambodia',     'name'=>'Cambodia',        'country'=>'Cambodia',      'continent'=>'asia',    'tag'=>'5N · 6D · Heritage',   'img'=>'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=600&q=80'],
  ['slug'=>'malaysia',     'name'=>'Malaysia',        'country'=>'Malaysia',      'continent'=>'asia',    'tag'=>'6N · 7D · Family',     'img'=>'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=600&q=80'],
  ['slug'=>'philippines',  'name'=>'Philippines',     'country'=>'Philippines',   'continent'=>'asia',    'tag'=>'7N · 8D · Beach',      'img'=>'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?w=600&q=80'],
  ['slug'=>'jordan',       'name'=>'Jordan',          'country'=>'Jordan',        'continent'=>'asia',    'tag'=>'5N · 6D · Heritage',   'img'=>'https://images.unsplash.com/photo-1548786811-dd6e453ccca7?w=600&q=80'],
  ['slug'=>'oman',         'name'=>'Oman',            'country'=>'Oman',          'continent'=>'asia',    'tag'=>'6N · 7D · Desert',     'img'=>'https://images.unsplash.com/photo-1578895101408-1a36b834405b?w=600&q=80'],
  ['slug'=>'georgia',      'name'=>'Georgia',         'country'=>'Georgia',       'continent'=>'asia',    'tag'=>'6N · 7D · Scenic',     'img'=>'https://images.unsplash.com/photo-1565008576549-57569a49371d?w=600&q=80'],
  ['slug'=>'uzbekistan',   'name'=>'Uzbekistan',      'country'=>'Uzbekistan',    'continent'=>'asia',    'tag'=>'7N · 8D · Silk Road',  'img'=>'https://images.unsplash.com/photo-1596484552834-6a58f850e0a1?w=600&q=80'],
  ['slug'=>'china',        'name'=>'China',           'country'=>'China',         'continent'=>'asia',    'tag'=>'10N · 11D · Heritage', 'img'=>'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?w=600&q=80'],
  ['slug'=>'hong-kong',    'name'=>'Hong Kong',       'country'=>'Hong Kong',     'continent'=>'asia',    'tag'=>'4N · 5D · City Break', 'img'=>'https://images.unsplash.com/photo-1536599018102-9f803c140fc1?w=600&q=80'],
  ['slug'=>'south-korea',  'name'=>'South Korea',     'country'=>'South Korea',   'continent'=>'asia',    'tag'=>'7N · 8D · Cultural',   'img'=>'https://images.unsplash.com/photo-1517154421773-0529f29ea451?w=600&q=80'],
  ['slug'=>'taiwan',       'name'=>'Taiwan',          'country'=>'Taiwan',        'continent'=>'asia',    'tag'=>'6N · 7D · Explorer',   'img'=>'https://images.unsplash.com/photo-1470004914212-05527e49370b?w=600&q=80'],
  // Europe
  ['slug'=>'paris',        'name'=>'Paris',           'country'=>'France',        'continent'=>'europe',  'tag'=>'5N · 6D · Romantic',   'img'=>'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80'],
  ['slug'=>'switzerland',  'name'=>'Swiss Alps',      'country'=>'Switzerland',   'continent'=>'europe',  'tag'=>'8N · 9D · Scenic',     'img'=>'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80'],
  ['slug'=>'santorini',    'name'=>'Santorini',       'country'=>'Greece',        'continent'=>'europe',  'tag'=>'6N · 7D · Romantic',   'img'=>'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=600&q=80'],
  ['slug'=>'amalfi',       'name'=>'Amalfi Coast',    'country'=>'Italy',         'continent'=>'europe',  'tag'=>'7N · 8D · Coastal',    'img'=>'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=600&q=80'],
  ['slug'=>'amsterdam',    'name'=>'Amsterdam',       'country'=>'Netherlands',   'continent'=>'europe',  'tag'=>'5N · 6D · Leisure',    'img'=>'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=600&q=80'],
  ['slug'=>'zermatt',      'name'=>'Zermatt',         'country'=>'Switzerland',   'continent'=>'europe',  'tag'=>'7N · 8D · Alpine',     'img'=>'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80'],
  ['slug'=>'barcelona',    'name'=>'Barcelona',       'country'=>'Spain',         'continent'=>'europe',  'tag'=>'5N · 6D · City Break', 'img'=>'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=600&q=80'],
  ['slug'=>'prague',       'name'=>'Prague',          'country'=>'Czech Republic','continent'=>'europe',  'tag'=>'4N · 5D · Heritage',   'img'=>'https://images.unsplash.com/photo-1541849546-216549ae216d?w=600&q=80'],
  ['slug'=>'vienna',       'name'=>'Vienna',          'country'=>'Austria',       'continent'=>'europe',  'tag'=>'4N · 5D · Culture',    'img'=>'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=600&q=80'],
  ['slug'=>'dubrovnik',    'name'=>'Dubrovnik',       'country'=>'Croatia',       'continent'=>'europe',  'tag'=>'5N · 6D · Coastal',    'img'=>'https://images.unsplash.com/photo-1555990793-da11153b2473?w=600&q=80'],
  ['slug'=>'lisbon',       'name'=>'Lisbon',          'country'=>'Portugal',      'continent'=>'europe',  'tag'=>'5N · 6D · City Break', 'img'=>'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?w=600&q=80'],
  ['slug'=>'iceland',      'name'=>'Iceland',         'country'=>'Iceland',       'continent'=>'europe',  'tag'=>'7N · 8D · Adventure',  'img'=>'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600&q=80'],
  ['slug'=>'rome',         'name'=>'Rome',            'country'=>'Italy',         'continent'=>'europe',  'tag'=>'5N · 6D · Heritage',   'img'=>'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=600&q=80'],
  ['slug'=>'venice',       'name'=>'Venice',          'country'=>'Italy',         'continent'=>'europe',  'tag'=>'4N · 5D · Romantic',   'img'=>'https://images.unsplash.com/photo-1514890547357-a9ee288728e0?w=600&q=80'],
  ['slug'=>'mykonos',      'name'=>'Mykonos',         'country'=>'Greece',        'continent'=>'europe',  'tag'=>'5N · 6D · Beach',      'img'=>'https://images.unsplash.com/photo-1601581875309-fafbf2d3ed3a?w=600&q=80'],
  // Americas
  ['slug'=>'new-york',     'name'=>'New York',        'country'=>'USA',           'continent'=>'americas','tag'=>'6N · 7D · City Break', 'img'=>'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=600&q=80'],
  ['slug'=>'peru',         'name'=>'Machu Picchu',    'country'=>'Peru',          'continent'=>'americas','tag'=>'8N · 9D · Adventure',  'img'=>'https://images.unsplash.com/photo-1526392060635-9d6019884377?w=600&q=80'],
  ['slug'=>'rio',          'name'=>'Rio de Janeiro',  'country'=>'Brazil',        'continent'=>'americas','tag'=>'6N · 7D · Vibrant',    'img'=>'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=600&q=80'],
  ['slug'=>'cancun',       'name'=>'Cancun',          'country'=>'Mexico',        'continent'=>'americas','tag'=>'6N · 7D · Beach',      'img'=>'https://images.unsplash.com/photo-1552074284-5e88ef1aef18?w=600&q=80'],
  ['slug'=>'vancouver',    'name'=>'Vancouver',       'country'=>'Canada',        'continent'=>'americas','tag'=>'7N · 8D · Scenic',     'img'=>'https://images.unsplash.com/photo-1559511260-66a654ae982a?w=600&q=80'],
  ['slug'=>'costa-rica',   'name'=>'Costa Rica',      'country'=>'Costa Rica',    'continent'=>'americas','tag'=>'7N · 8D · Nature',     'img'=>'https://images.unsplash.com/photo-1518259102261-b40117eabbc9?w=600&q=80'],
  // Africa
  ['slug'=>'marrakech',    'name'=>'Marrakech',       'country'=>'Morocco',       'continent'=>'africa',  'tag'=>'5N · 6D · Cultural',   'img'=>'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=600&q=80'],
  ['slug'=>'tanzania',     'name'=>'Serengeti',       'country'=>'Tanzania',      'continent'=>'africa',  'tag'=>'8N · 9D · Safari',     'img'=>'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80'],
  ['slug'=>'cape-town',    'name'=>'Cape Town',       'country'=>'South Africa',  'continent'=>'africa',  'tag'=>'7N · 8D · Explorer',   'img'=>'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=600&q=80'],
  ['slug'=>'zanzibar',     'name'=>'Zanzibar',        'country'=>'Tanzania',      'continent'=>'africa',  'tag'=>'6N · 7D · Beach',      'img'=>'https://images.unsplash.com/photo-1586861203927-800a5acdcc4d?w=600&q=80'],
  ['slug'=>'cairo',        'name'=>'Cairo',           'country'=>'Egypt',         'continent'=>'africa',  'tag'=>'5N · 6D · Heritage',   'img'=>'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=600&q=80'],
  ['slug'=>'seychelles',   'name'=>'Seychelles',      'country'=>'Seychelles',    'continent'=>'africa',  'tag'=>'6N · 7D · Luxury',     'img'=>'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=600&q=80'],
  ['slug'=>'mauritius',    'name'=>'Mauritius',       'country'=>'Mauritius',     'continent'=>'africa',  'tag'=>'6N · 7D · Romantic',   'img'=>'https://images.unsplash.com/photo-1589979481223-deb893043163?w=600&q=80'],
  // Oceania
  ['slug'=>'sydney',       'name'=>'Sydney',          'country'=>'Australia',     'continent'=>'oceania', 'tag'=>'9N · 10D · Explorer',  'img'=>'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=600&q=80'],
  ['slug'=>'new-zealand',  'name'=>'New Zealand',     'country'=>'New Zealand',   'continent'=>'oceania', 'tag'=>'10N · 11D · Adventure','img'=>'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=600&q=80'],
  ['slug'=>'fiji',         'name'=>'Fiji',            'country'=>'Fiji',          'continent'=>'oceania', 'tag'=>'6N · 7D · Beach',      'img'=>'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=600&q=80'],
  ['slug'=>'bora-bora',    'name'=>'Bora Bora',       'country'=>'French Polynesia','continent'=>'oceania','tag'=>'6N · 7D · Overwater', 'img'=>'https://images.unsplash.com/photo-1589979481223-deb893043163?w=600&q=80'],
];

$total = count($destinations);
$asia_count = count(array_filter($destinations, fn($d) => $d['continent'] === 'asia'));
$europe_count = count(array_filter($destinations, fn($d) => $d['continent'] === 'europe'));
$americas_count = count(array_filter($destinations, fn($d) => $d['continent'] === 'americas'));
$africa_count = count(array_filter($destinations, fn($d) => $d['continent'] === 'africa'));
$oceania_count = count(array_filter($destinations, fn($d) => $d['continent'] === 'oceania'));
?>

<!-- Hero -->
<section class="dest-list-hero">
  <div class="dest-list-hero-content">
    <div class="section-label">Explore the World</div>
    <h1>Every Destination.<br>One Trusted Partner.</h1>
    <p><?php echo $total; ?> Destinations · 5 Continents · Infinite Possibilities</p>
    <div class="dest-list-hero-stats">
      <span>Asia · <?php echo $asia_count; ?></span>
      <span>Europe · <?php echo $europe_count; ?></span>
      <span>Americas · <?php echo $americas_count; ?></span>
      <span>Africa · <?php echo $africa_count; ?></span>
      <span>Oceania · <?php echo $oceania_count; ?></span>
    </div>
  </div>
</section>

<!-- Filter Bar -->
<div class="filter-bar">
  <span class="filter-label">Continent:</span>
  <button class="filter-btn active" data-filter="all">All</button>
  <button class="filter-btn" data-filter="asia">Asia</button>
  <button class="filter-btn" data-filter="europe">Europe</button>
  <button class="filter-btn" data-filter="americas">Americas</button>
  <button class="filter-btn" data-filter="africa">Africa</button>
  <button class="filter-btn" data-filter="oceania">Oceania</button>
  <div class="filter-divider"></div>
  <div class="filter-search">
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Search destinations…">
  </div>
</div>

<!-- Destinations Grid -->
<section class="destinations-list-section">
  <div class="destinations-list-grid">
    <?php foreach ($destinations as $d): ?>
    <a href="/destinations/<?php echo $d['slug']; ?>"
       class="dest-list-card"
       data-continent="<?php echo $d['continent']; ?>"
       data-name="<?php echo strtolower($d['name']); ?>">
      <img src="<?php echo $d['img']; ?>" alt="<?php echo $d['name']; ?>" loading="lazy">
      <div class="dest-list-card-overlay">
        <div class="dest-list-card-continent"><?php echo ucfirst($d['continent']); ?> · <?php echo $d['country']; ?></div>
        <div class="dest-list-card-name"><?php echo $d['name']; ?></div>
        <div class="dest-list-card-tag"><?php echo $d['tag']; ?></div>
        <div class="dest-list-card-explore">Explore →</div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA -->
<section class="enquiry-cta">
  <div class="section-label">Can't Decide?</div>
  <h2 class="section-title">Let Us Choose for You</h2>
  <p class="section-subtitle" style="margin:0 auto 2rem;">Tell us your travel style, budget and dates — our experts will craft the perfect itinerary.</p>
  <a href="/contact" class="btn-submit" style="display:inline-block;text-decoration:none;padding:1rem 3rem;width:auto;">
    Get a Free Consultation <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
  </a>
</section>

<?php include '../includes/page-footer.php'; ?>