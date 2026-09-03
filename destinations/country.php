<?php
// ── LOAD DATA ────────────────────────────────────────────────────
$slug = preg_replace('/[^a-z0-9-]/', '', $_GET['slug'] ?? 'dubai');
$dataFile = __DIR__ . '/data/' . $slug . '.php';

if (!file_exists($dataFile)) {
  header('Location: /destinations');
  exit;
}

$d = include $dataFile;

// ── FORMAT DETECTION ─────────────────────────────────────────────
// New format: has 'overview' (string) + 'must_visit' with 'img' key
// Old format: has 'overview_title' + 'must_visit' with 'image' key
$isNewFormat = isset($d['overview']) && !isset($d['overview_title']);

// ── NORMALISE budget field ────────────────────────────────────────
$budget = $d['budget'] ?? '₹1,00,000+';

$rootPath  = '../';
$pageTitle = ($d['name'] ?? 'Destination') . ', ' . ($d['country'] ?? '');
$pageDesc  = $isNewFormat
  ? substr($d['overview'] ?? '', 0, 160)
  : ($d['overview_short'] ?? '');

// ── SEO META ─────────────────────────────────────────────────────
$destName    = $d['name'] ?? 'Destination';
$destCountry = $d['country'] ?? '';
$destImage   = $d['hero_image'] ?? $d['image'] ?? '';
$destUrl     = 'https://www.travelworld.com/destinations/' . $slug;

$pageKeywords  = $destName . ' travel, ' . $destName . ' holiday packages, ' . $destName . ' tour, visit ' . $destName . ', ' . $destCountry . ' travel';
$pageCanonical = $destUrl;
$ogType        = 'article';
$ogImage       = $destImage ?: 'https://www.travelworld.com/assets/image/logo.webp';

// ── JSON-LD: TouristDestination + BreadcrumbList ──────────────────
$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'TouristDestination',
      '@id'         => $destUrl . '#destination',
      'name'        => $destName . ', ' . $destCountry,
      'description' => $pageDesc,
      'url'         => $destUrl,
      'image'       => $ogImage,
      'touristType' => ['Leisure', 'Honeymoon', 'Adventure', 'Cultural'],
      'includesAttraction' => array_map(function($place) {
        return ['@type' => 'TouristAttraction', 'name' => $place['name'] ?? $place];
      }, array_slice($d['must_visit'] ?? [], 0, 5)),
    ],
    [
      '@type'           => 'TravelAction',
      'agent'           => ['@id' => 'https://www.travelworld.com/#organization'],
      'object'          => ['@id' => $destUrl . '#destination'],
      'actionStatus'    => 'PotentialActionStatus',
      'target'          => 'https://wa.me/919904040001?text=I+want+to+travel+to+' . urlencode($destName),
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',         'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Destinations', 'item' => 'https://www.travelworld.com/destinations/'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $destName,      'item' => $destUrl],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/../includes/page-header.php';
?>

<!-- ── HERO ──────────────────────────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-bg" style="background-image:url('<?php echo $d['hero_image']; ?>')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>›</span>
      <a href="/destinations">Destinations</a><span>›</span>
      <span><?php echo $d['name']; ?></span>
    </div>
    <h1 class="page-hero-title"><?php echo $d['name']; ?></h1>
    <p class="page-hero-tagline"><?php echo $d['tagline']; ?></p>
    <div class="page-hero-stats">
      <span class="page-hero-stat"><i class="fas fa-calendar-check"></i> Best Time: <?php echo $d['best_time']; ?></span>
      <span class="page-hero-stat"><i class="fas fa-clock"></i> <?php echo $d['duration']; ?></span>
      <span class="page-hero-stat"><i class="fas fa-coins"></i> <?php echo $d['currency']; ?></span>
      <span class="page-hero-stat"><i class="fas fa-passport"></i> <?php echo $d['visa']; ?></span>
    </div>
  </div>
</section>

<!-- ── OVERVIEW ───────────────────────────────────────────────── -->
<section class="inner-section">
  <div class="overview-grid">
    <div class="overview-text reveal">
      <div class="section-label">Overview</div>
      <?php if ($isNewFormat): ?>
        <h2 class="section-title">Why Visit <?php echo $d['name']; ?>?</h2>
        <p><?php echo $d['overview']; ?></p>
      <?php else: ?>
        <h2 class="section-title"><?php echo $d['overview_title']; ?></h2>
        <?php foreach ($d['overview_paras'] as $para): ?>
          <p><?php echo $para; ?></p>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="overview-highlights reveal">
      <?php if ($isNewFormat): ?>
        <?php
        $quickFacts = [
          ['icon'=>'fas fa-plane',        'label'=>'Flight Time',  'value'=> $d['flight_time'] ?? ''],
          ['icon'=>'fas fa-passport',     'label'=>'Visa',         'value'=> $d['visa'] ?? ''],
          ['icon'=>'fas fa-language',     'label'=>'Language',     'value'=> $d['language'] ?? ''],
          ['icon'=>'fas fa-coins',        'label'=>'Currency',     'value'=> $d['currency'] ?? ''],
          ['icon'=>'fas fa-rupee-sign',   'label'=>'Budget',       'value'=> $budget],
          ['icon'=>'fas fa-calendar-alt', 'label'=>'Best Time',    'value'=> $d['best_time'] ?? ''],
        ];
        foreach ($quickFacts as $h): ?>
        <div class="highlight-item">
          <i class="<?php echo $h['icon']; ?>"></i>
          <h6><?php echo $h['label']; ?></h6>
          <p><?php echo $h['value']; ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <?php foreach ($d['highlights'] as $h): ?>
        <div class="highlight-item">
          <i class="<?php echo $h['icon']; ?>"></i>
          <h6><?php echo $h['label']; ?></h6>
          <p><?php echo $h['value']; ?></p>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ── MUST VISIT PLACES ──────────────────────────────────────── -->
<section class="inner-section alt">
  <div class="section-label reveal">Must Visit</div>
  <h2 class="section-title reveal">Top Places to See in <?php echo $d['name']; ?></h2>
  <p class="section-subtitle reveal">Hand-picked by our travel experts — the experiences that define this destination.</p>
  <div class="places-grid">
    <?php foreach ($d['must_visit'] as $place): ?>
    <div class="place-card reveal">
      <?php $imgSrc = $place['img'] ?? $place['image'] ?? ''; ?>
      <img class="place-card-img" src="<?php echo $imgSrc; ?>" alt="<?php echo $place['name']; ?>" loading="lazy">
      <div class="place-card-overlay">
        <div class="place-card-tag"><?php echo $place['category']; ?></div>
        <div class="place-card-name"><?php echo $place['name']; ?></div>
        <div class="place-card-desc"><?php echo $place['desc']; ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── EXPERIENCES / THINGS TO DO ────────────────────────────── -->
<section class="inner-section">
  <div class="section-label reveal">Experiences</div>
  <h2 class="section-title reveal">Things to Do in <?php echo $d['name']; ?></h2>

  <?php if ($isNewFormat): ?>
  <?php
  $expTabMeta = [
    'adventure' => ['icon'=>'fas fa-hiking',       'label'=>'Adventure'],
    'culture'   => ['icon'=>'fas fa-landmark',     'label'=>'Culture'],
    'food'      => ['icon'=>'fas fa-utensils',     'label'=>'Food & Drink'],
    'shopping'  => ['icon'=>'fas fa-shopping-bag', 'label'=>'Shopping'],
  ];
  ?>
  <div class="tabs-nav reveal">
    <?php foreach ($d['experiences'] as $key => $items): ?>
    <button class="tab-btn" data-tab="<?php echo $key; ?>">
      <i class="<?php echo $expTabMeta[$key]['icon'] ?? 'fas fa-star'; ?>"></i>
      <?php echo $expTabMeta[$key]['label'] ?? ucfirst($key); ?>
    </button>
    <?php endforeach; ?>
  </div>
  <?php foreach ($d['experiences'] as $key => $items): ?>
  <div class="tab-panel" id="tab-<?php echo $key; ?>">
    <div class="exp-list">
      <?php foreach ($items as $item): ?>
      <div class="exp-item reveal">
        <i class="<?php echo $expTabMeta[$key]['icon'] ?? 'fas fa-star'; ?>"></i>
        <div class="exp-item-text">
          <?php if (is_array($item)): ?>
            <h6><?php echo $item['title'] ?? $item['name'] ?? ''; ?></h6>
            <p><?php echo $item['desc'] ?? $item['note'] ?? ''; ?></p>
          <?php else: ?>
            <p><?php echo $item; ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>

  <?php else: ?>
  <div class="tabs-nav reveal">
    <?php foreach ($d['experiences'] as $key => $exp): ?>
    <button class="tab-btn" data-tab="<?php echo $key; ?>">
      <i class="<?php echo $exp['icon']; ?>"></i> <?php echo $exp['label']; ?>
    </button>
    <?php endforeach; ?>
  </div>
  <?php foreach ($d['experiences'] as $key => $exp): ?>
  <div class="tab-panel" id="tab-<?php echo $key; ?>">
    <div class="exp-list">
      <?php foreach ($exp['items'] as $item): ?>
      <div class="exp-item reveal">
        <i class="<?php echo $item['icon']; ?>"></i>
        <div class="exp-item-text">
          <h6><?php echo $item['name']; ?></h6>
          <p><?php echo $item['note']; ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</section>

<!-- ── WHERE TO STAY (old format only) ───────────────────────── -->
<?php if (!$isNewFormat && !empty($d['stay'])): ?>
<section class="inner-section alt">
  <div class="section-label reveal">Accommodation</div>
  <h2 class="section-title reveal">Where to Stay in <?php echo $d['name']; ?></h2>
  <div class="stay-tiers">
    <?php foreach ($d['stay'] as $tier): ?>
    <div class="stay-tier reveal">
      <div class="stay-tier-header"><h4><?php echo $tier['tier']; ?></h4></div>
      <div class="stay-tier-body">
        <?php foreach ($tier['hotels'] as $hotel): ?>
        <div class="hotel-item">
          <div class="hotel-name"><?php echo $hotel['name']; ?></div>
          <div class="hotel-stars"><?php echo str_repeat('★', $hotel['stars']); ?></div>
          <div class="hotel-note"><?php echo $hotel['note']; ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- ── FOOD & CUISINE (old format only) ──────────────────────── -->
<?php if (!$isNewFormat && !empty($d['food'])): ?>
<section class="inner-section">
  <div class="section-label reveal">Food & Cuisine</div>
  <h2 class="section-title reveal">What to Eat in <?php echo $d['name']; ?></h2>
  <p class="section-subtitle reveal">The dishes and drinks that define this destination — don't leave without trying them.</p>
  <div class="food-grid">
    <?php foreach ($d['food'] as $item): ?>
    <div class="food-card reveal">
      <span class="food-card-emoji"><?php echo $item['emoji']; ?></span>
      <h6><?php echo $item['name']; ?></h6>
      <p><?php echo $item['note']; ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- ── TRAVEL TIPS (old format only) ─────────────────────────── -->
<?php if (!$isNewFormat && !empty($d['tips'])): ?>
<section class="inner-section alt">
  <div class="section-label reveal">Travel Tips</div>
  <h2 class="section-title reveal">Essential Tips for <?php echo $d['name']; ?></h2>
  <div class="tips-grid">
    <?php foreach ($d['tips'] as $tip): ?>
    <div class="tip-card reveal">
      <i class="<?php echo $tip['icon']; ?>"></i>
      <h5><?php echo $tip['title']; ?></h5>
      <p><?php echo $tip['content']; ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- ── SAMPLE ITINERARIES ─────────────────────────────────────── -->
<section class="inner-section<?php echo $isNewFormat ? '' : ' alt'; ?>">
  <div class="section-label reveal">Itineraries</div>
  <h2 class="section-title reveal">Sample Itineraries for <?php echo $d['name']; ?></h2>
  <p class="section-subtitle reveal">Day-by-day plans crafted by our experts — fully customisable to your preferences.</p>

  <div class="itinerary-tabs reveal">
    <?php foreach ($d['itineraries'] as $key => $plan): ?>
    <?php $label = preg_replace('/[^0-9]/', '', $key); ?>
    <button class="itin-btn" data-itin="<?php echo $key; ?>"><?php echo $label; ?> Days</button>
    <?php endforeach; ?>
  </div>

  <?php foreach ($d['itineraries'] as $key => $plan): ?>
  <div class="itin-panel" id="itin-<?php echo $key; ?>">
    <div class="itin-days">
      <?php foreach ($plan as $i => $day): ?>
      <div class="itin-day reveal">
        <div class="itin-day-num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
        <div class="itin-day-content">
          <?php if (is_array($day)): ?>
            <h5><?php echo ($day['day'] ?? '') . (isset($day['day']) ? ': ' : '') . ($day['title'] ?? ''); ?></h5>
            <?php if (!empty($day['activities'])): ?>
            <p><?php echo implode(' · ', $day['activities']); ?></p>
            <?php elseif (!empty($day['desc'])): ?>
            <p><?php echo $day['desc']; ?></p>
            <?php endif; ?>
          <?php else: ?>
            <p><?php echo $day; ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
</section>

<!-- ── ENQUIRY CTA ────────────────────────────────────────────── -->
<section class="enquiry-cta">
  <div class="section-label">Ready to Go?</div>
  <h2 class="section-title">Plan Your <?php echo $d['name']; ?> Journey</h2>
  <p class="section-subtitle" style="margin:0 auto 2.5rem;">
    Our <?php echo $d['name']; ?> specialists will craft a bespoke itinerary tailored entirely to you.
    Starting from <?php echo $budget; ?>.
  </p>
  <div style="max-width:700px;margin:0 auto;">
    <form class="enquiry-form" id="enquiryForm">
      <input type="text"  name="name"  placeholder="Your Name"          required>
      <input type="email" name="email" placeholder="Email Address"       required>
      <input type="tel"   name="phone" placeholder="Phone / WhatsApp"    required>
      <input type="text"  name="dates" placeholder="Preferred Dates"     >
      <select name="travellers">
        <option value="" disabled selected>Travellers</option>
        <option>Solo (1)</option>
        <option>Couple (2)</option>
        <option>Small Group (3–5)</option>
        <option>Family with Kids</option>
        <option>Large Group (6+)</option>
      </select>
      <select name="duration">
        <option value="" disabled selected>Duration</option>
        <?php foreach (array_keys($d['itineraries']) as $key): ?>
        <?php $label = preg_replace('/[^0-9]/', '', $key); ?>
        <option><?php echo $label; ?> Days</option>
        <?php endforeach; ?>
        <option>Custom</option>
      </select>
      <textarea name="message" placeholder="Any special requests, occasions or preferences…" style="grid-column:1/-1;"></textarea>
      <button type="submit" class="btn-submit" style="grid-column:1/-1;">
        Enquire About <?php echo $d['name']; ?> <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
      </button>
    </form>
  </div>
</section>

<!-- ── RELATED DESTINATIONS ───────────────────────────────────── -->
<?php if (!empty($d['related'])): ?>
<section class="inner-section alt">
  <div class="section-label reveal">You Might Also Love</div>
  <h2 class="section-title reveal">Similar Destinations</h2>
  <div class="related-grid">
    <?php
    $relatedImages = [
      'dubai'        => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80',
      'bali'         => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80',
      'tokyo'        => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80',
      'paris'        => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80',
      'maldives'     => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80',
      'santorini'    => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=600&q=80',
      'amalfi'       => 'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=600&q=80',
      'amsterdam'    => 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=600&q=80',
      'marrakech'    => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=600&q=80',
      'new-york'     => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=600&q=80',
      'singapore'    => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=600&q=80',
      'istanbul'     => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=600&q=80',
      'switzerland'  => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80',
      'swiss-alps'   => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80',
      'zermatt'      => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?w=600&q=80',
      'sydney'       => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=600&q=80',
      'thailand'     => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=80',
      'seychelles'   => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=600&q=80',
      'bora-bora'    => 'https://images.unsplash.com/photo-1589197331516-4d84b72ebde3?w=600&q=80',
      'vietnam'      => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80',
      'mykonos'      => 'https://images.unsplash.com/photo-1601581875309-fafbf2d3ed3a?w=600&q=80',
      'rome'         => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=600&q=80',
      'barcelona'    => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=600&q=80',
      'prague'       => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=600&q=80',
      'vienna'       => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=600&q=80',
      'dubrovnik'    => 'https://images.unsplash.com/photo-1555990793-da11153b2473?w=600&q=80',
      'lisbon'       => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?w=600&q=80',
      'iceland'      => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600&q=80',
      'venice'       => 'https://images.unsplash.com/photo-1514890547357-a9ee288728e0?w=600&q=80',
      'bhutan'       => 'https://images.unsplash.com/photo-1553856622-d1b352e9a211?w=600&q=80',
      'nepal'        => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=80',
      'sri-lanka'    => 'https://images.unsplash.com/photo-1586861203927-800a5acdcc4d?w=600&q=80',
      'cambodia'     => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=600&q=80',
      'malaysia'     => 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=600&q=80',
      'philippines'  => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?w=600&q=80',
      'jordan'       => 'https://images.unsplash.com/photo-1548786811-dd6e453ccca7?w=600&q=80',
      'oman'         => 'https://images.unsplash.com/photo-1578895101408-1a36b834405b?w=600&q=80',
      'georgia'      => 'https://images.unsplash.com/photo-1565008576549-57569a49371d?w=600&q=80',
      'uzbekistan'   => 'https://images.unsplash.com/photo-1596484552834-6a58f850e0a1?w=600&q=80',
      'china'        => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?w=600&q=80',
      'hong-kong'    => 'https://images.unsplash.com/photo-1536599018102-9f803c140fc1?w=600&q=80',
      'south-korea'  => 'https://images.unsplash.com/photo-1517154421773-0529f29ea451?w=600&q=80',
      'taiwan'       => 'https://images.unsplash.com/photo-1470004914212-05527e49370b?w=600&q=80',
      'japan'        => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80',
      'peru'         => 'https://images.unsplash.com/photo-1526392060635-9d6019884377?w=600&q=80',
      'rio'          => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=600&q=80',
      'cancun'       => 'https://images.unsplash.com/photo-1552074284-5e88ef1aef18?w=600&q=80',
      'costa-rica'   => 'https://images.unsplash.com/photo-1518259102261-b40117eabbc9?w=600&q=80',
      'patagonia'    => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80',
      'tanzania'     => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=600&q=80',
      'cape-town'    => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=600&q=80',
      'zanzibar'     => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=600&q=80',
      'kenya'        => 'https://images.unsplash.com/photo-1549366021-9f761d450615?w=600&q=80',
      'cairo'        => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=600&q=80',
      'mauritius'    => 'https://images.unsplash.com/photo-1589197331516-4d84b72ebde3?w=600&q=80',
      'new-zealand'  => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=600&q=80',
      'fiji'         => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=600&q=80',
      'australia'    => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80',
      'abu-dhabi'    => 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=600&q=80',
      'india'        => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=600&q=80',
      'tibet'        => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
      'vancouver'    => 'https://images.unsplash.com/photo-1559511260-66a654ae982a?w=600&q=80',
    ];
    foreach ($d['related'] as $rel):
      $rel = is_array($rel) ? ($rel['slug'] ?? reset($rel)) : $rel;
      $relImg = $relatedImages[$rel] ?? 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=600&q=80';
      $relName = ucwords(str_replace('-', ' ', $rel));
    ?>
    <a href="/destinations/<?php echo $rel; ?>" class="related-card reveal">
      <img src="<?php echo $relImg; ?>" alt="<?php echo $relName; ?>" loading="lazy">
      <div class="related-card-overlay">
        <span><?php echo $relName; ?></span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/../includes/page-footer.php'; ?>