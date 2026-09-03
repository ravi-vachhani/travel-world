<?php
$rootPath      = '../';
$pageTitle     = 'Visa Services — Apply for USA, UK, Schengen & More | Travel World';
$pageDesc      = 'Expert visa assistance for 50+ countries. USA, UK, Schengen, Canada, Australia, Dubai and more. 90% success rate. Complete documentation support and appointment booking.';
$pageKeywords  = 'visa services, visa assistance, USA visa, UK visa, Schengen visa, Canada visa, Australia visa, Dubai visa, visa application help';
$pageCanonical = 'https://www.travelworld.com/visa/';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'CollectionPage',
      '@id'         => 'https://www.travelworld.com/visa/#webpage',
      'url'         => 'https://www.travelworld.com/visa/',
      'name'        => 'Visa Services — Travel World',
      'description' => $pageDesc,
      'isPartOf'    => ['@id' => 'https://www.travelworld.com/#website'],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',          'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Visa Services', 'item' => 'https://www.travelworld.com/visa/'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/../includes/page-header.php';
?>

<!-- HERO -->
<section class="page-hero" style="min-height:420px;">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1600&q=80');"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>/</span><span>Visa Services</span>
    </div>
    <h1 class="page-hero-title">VISA SERVICES</h1>
    <p class="page-hero-tagline">Expert guidance for 50+ countries · 90% USA visa success rate</p>
  </div>
</section>

<!-- USA FEATURED -->
<section class="inner-section" style="padding-bottom:2rem;">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="section-label">FEATURED</div>
    <h2 class="section-title reveal">USA Visa — Our Speciality</h2>
    <div class="visa-featured-card reveal" style="background:#fff;border:1px solid rgba(0,0,0,0.08);border-left:5px solid var(--gold);border-radius:12px;padding:2.5rem;margin-top:2rem;display:flex;gap:3rem;align-items:center;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
      <div style="font-size:5rem;flex-shrink:0;">🇺🇸</div>
      <div style="flex:1;">
        <div style="display:inline-block;background:var(--gold);color:#fff;font-size:0.72rem;font-weight:600;letter-spacing:0.1em;padding:0.3rem 1rem;border-radius:20px;margin-bottom:1rem;">⭐ 90% Approval Rate</div>
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:300;color:#1A1410;margin-bottom:0.8rem;">USA B1/B2 Tourist & Business Visa</h3>
        <p style="font-family:'Inter',sans-serif;font-size:0.85rem;color:#6B6560;line-height:1.7;margin-bottom:1.5rem;">We have helped 5,000+ applicants secure their US visa with a 90% success rate. Our specialists handle DS-160 form, document checklist, appointment booking, and mock interview preparation.</p>
        <div style="display:flex;gap:3rem;margin-bottom:1.5rem;flex-wrap:wrap;">
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--gold);">90%</div><div style="font-size:0.72rem;color:#6B6560;font-family:'Inter',sans-serif;">Approval Rate</div></div>
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--gold);">5,000+</div><div style="font-size:0.72rem;color:#6B6560;font-family:'Inter',sans-serif;">Visas Processed</div></div>
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--gold);">7 Days</div><div style="font-size:0.72rem;color:#6B6560;font-family:'Inter',sans-serif;">Avg Processing</div></div>
        </div>
        <a href="usa" style="display:inline-block;background:var(--gold);color:#fff;font-family:'Inter',sans-serif;font-size:0.8rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;padding:0.9rem 2rem;border-radius:6px;text-decoration:none;">Apply for USA Visa →</a>
      </div>
    </div>
  </div>
</section>

<!-- ALL VISA COUNTRIES -->
<section class="inner-section alt">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="section-label">ALL COUNTRIES</div>
    <h2 class="section-title reveal">Visa Services We Offer</h2>
    <p style="font-family:'Inter',sans-serif;font-size:0.88rem;color:#6B6560;margin-bottom:3rem;" class="reveal">From tourist visas to business visas — we handle documentation, appointments, and follow-ups for all major countries.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">

      <?php
      $visas = [
        ['slug'=>'usa',         'fc'=>'us', 'name'=>'USA',              'type'=>'B1/B2 Tourist & Business', 'time'=>'3–5 weeks',  'note'=>'90% success rate'],
        ['slug'=>'uk',          'fc'=>'gb', 'name'=>'United Kingdom',   'type'=>'Standard Visitor Visa',    'time'=>'3 weeks',    'note'=>'Online application'],
        ['slug'=>'schengen',    'fc'=>'eu', 'name'=>'Schengen (Europe)','type'=>'26 Countries Covered',     'time'=>'2–3 weeks',  'note'=>'Single application'],
        ['slug'=>'canada',      'fc'=>'ca', 'name'=>'Canada',           'type'=>'Tourist / Student / PR',   'time'=>'4–8 weeks',  'note'=>'Biometrics required'],
        ['slug'=>'australia',   'fc'=>'au', 'name'=>'Australia',        'type'=>'Tourist / ETA / eVisitor', 'time'=>'1–4 weeks',  'note'=>'Online ETA available'],
        ['slug'=>'dubai',       'fc'=>'ae', 'name'=>'Dubai / UAE',      'type'=>'Tourist / E-Visa',         'time'=>'3–5 days',   'note'=>'Visa on arrival for Indians'],
        ['slug'=>'singapore',   'fc'=>'sg', 'name'=>'Singapore',        'type'=>'Tourist / Transit',        'time'=>'3–5 days',   'note'=>'E-visa available'],
        ['slug'=>'thailand',    'fc'=>'th', 'name'=>'Thailand',         'type'=>'Tourist / E-Visa',         'time'=>'1–3 days',   'note'=>'Visa on arrival'],
        ['slug'=>'japan',       'fc'=>'jp', 'name'=>'Japan',            'type'=>'Tourist / Business',       'time'=>'5–7 days',   'note'=>'Sticker visa'],
        ['slug'=>'new-zealand', 'fc'=>'nz', 'name'=>'New Zealand',      'type'=>'Tourist / NZeTA',          'time'=>'1–3 days',   'note'=>'Online NZeTA'],
        ['slug'=>'malaysia',    'fc'=>'my', 'name'=>'Malaysia',         'type'=>'Tourist / eNTRI',          'time'=>'1–2 days',   'note'=>'Visa free for Indians'],
        ['slug'=>'indonesia',   'fc'=>'id', 'name'=>'Indonesia / Bali', 'type'=>'Visa on Arrival',          'time'=>'On arrival', 'note'=>'Easy process'],
        ['slug'=>'france',      'fc'=>'fr', 'name'=>'France',           'type'=>'Schengen Visa',            'time'=>'2–3 weeks',  'note'=>'Part of Schengen'],
        ['slug'=>'germany',     'fc'=>'de', 'name'=>'Germany',          'type'=>'Schengen Visa',            'time'=>'2–3 weeks',  'note'=>'Part of Schengen'],
        ['slug'=>'italy',       'fc'=>'it', 'name'=>'Italy',            'type'=>'Schengen Visa',            'time'=>'2–3 weeks',  'note'=>'Part of Schengen'],
        ['slug'=>'greece',      'fc'=>'gr', 'name'=>'Greece',           'type'=>'Schengen Visa',            'time'=>'2–3 weeks',  'note'=>'Part of Schengen'],
        ['slug'=>'turkey',      'fc'=>'tr', 'name'=>'Turkey',           'type'=>'E-Visa',                   'time'=>'1–3 days',   'note'=>'Online e-visa'],
        ['slug'=>'egypt',       'fc'=>'eg', 'name'=>'Egypt',            'type'=>'Tourist / E-Visa',         'time'=>'3–5 days',   'note'=>'Visa on arrival'],
        ['slug'=>'south-africa','fc'=>'za', 'name'=>'South Africa',     'type'=>'Tourist Visa',             'time'=>'2–3 weeks',  'note'=>'Biometrics required'],
        ['slug'=>'kenya',       'fc'=>'ke', 'name'=>'Kenya',            'type'=>'E-Visa',                   'time'=>'3–5 days',   'note'=>'Online e-visa'],
      ];
      foreach ($visas as $v): ?>
      <a href="<?php echo $v['slug']; ?>" class="visa-list-card reveal" style="background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:10px;padding:1.5rem;text-decoration:none;display:block;transition:border-color 0.3s,transform 0.3s,box-shadow 0.3s;">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
          <img src="https://flagcdn.com/w80/<?php echo $v['fc']; ?>.png" alt="<?php echo $v['name']; ?>" style="width:48px;height:48px;object-fit:cover;border-radius:50%;border:1px solid rgba(0,0,0,0.1);flex-shrink:0;">
          <div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:400;color:#1A1410;"><?php echo $v['name']; ?></div>
            <div style="font-family:'Inter',sans-serif;font-size:0.7rem;color:#6B6560;"><?php echo $v['type']; ?></div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <div>
            <div style="font-family:'Inter',sans-serif;font-size:0.68rem;color:#6B6560;text-transform:uppercase;letter-spacing:0.1em;">Processing Time</div>
            <div style="font-family:'Inter',sans-serif;font-size:0.8rem;color:#1A1410;font-weight:500;"><?php echo $v['time']; ?></div>
          </div>
          <div style="font-family:'Inter',sans-serif;font-size:0.68rem;color:var(--gold);background:rgba(184,134,11,0.08);padding:0.3rem 0.7rem;border-radius:20px;"><?php echo $v['note']; ?></div>
        </div>
        <div style="margin-top:1rem;font-family:'Inter',sans-serif;font-size:0.72rem;color:var(--gold);letter-spacing:0.1em;">View Details →</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US FOR VISA -->
<section class="inner-section">
  <div style="max-width:1100px;margin:0 auto;text-align:center;">
    <div class="section-label">WHY US</div>
    <h2 class="section-title reveal">Why Choose TravelWorld for Visa?</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:2rem;margin-top:3rem;">
      <?php
      $whys = [
        ['icon'=>'fa-check-circle','title'=>'90% Success Rate','desc'=>'Especially for USA visas — highest approval rate in the industry.'],
        ['icon'=>'fa-file-alt','title'=>'Complete Documentation','desc'=>'We prepare every document, checklist, and form on your behalf.'],
        ['icon'=>'fa-calendar-check','title'=>'Appointment Booking','desc'=>'We book your visa appointment at the earliest available slot.'],
        ['icon'=>'fa-user-tie','title'=>'Interview Preparation','desc'=>'Mock interviews and coaching for USA & UK visa interviews.'],
        ['icon'=>'fa-headset','title'=>'24/7 Support','desc'=>'Our visa team is available round the clock for any queries.'],
        ['icon'=>'fa-shield-alt','title'=>'Refusal Assistance','desc'=>'Previous refusal? We analyze and reapply with stronger documentation.'],
      ];
      foreach ($whys as $w): ?>
      <div class="reveal" style="background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:10px;padding:2rem;text-align:left;box-shadow:0 2px 12px rgba(0,0,0,0.05);">
        <i class="fas <?php echo $w['icon']; ?>" style="color:var(--gold);font-size:1.4rem;margin-bottom:1rem;display:block;"></i>
        <h5 style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:400;color:#1A1410;margin-bottom:0.5rem;"><?php echo $w['title']; ?></h5>
        <p style="font-family:'Inter',sans-serif;font-size:0.78rem;color:#6B6560;line-height:1.7;"><?php echo $w['desc']; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ENQUIRY CTA -->
<section class="enquiry-cta">
  <div class="section-label">GET STARTED</div>
  <h2 class="section-title reveal">Start Your Visa Application</h2>
  <p style="font-family:'Inter',sans-serif;font-size:0.88rem;color:#6B6560;margin-bottom:2rem;" class="reveal">Fill in your details and our visa expert will contact you within 2 hours.</p>
  <form class="enquiry-form" onsubmit="return false;">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="tel" name="phone" placeholder="Phone / WhatsApp Number" required>
    <select name="dest">
      <option value="">Select Country</option>
      <option>USA</option><option>UK</option><option>Schengen / Europe</option>
      <option>Canada</option><option>Australia</option><option>Dubai / UAE</option>
      <option>Singapore</option><option>Thailand</option><option>Japan</option>
      <option>New Zealand</option><option>Other</option>
    </select>
    <input type="text" name="dates" placeholder="Planned Travel Dates">
    <textarea name="message" placeholder="Any previous refusals or special requirements?"></textarea>
    <button type="submit" class="btn-submit">
      <i class="fab fa-whatsapp"></i> Send Enquiry on WhatsApp
    </button>
  </form>
</section>

<?php include __DIR__ . '/../includes/page-footer.php'; ?>