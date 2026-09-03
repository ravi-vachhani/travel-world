<?php
$rootPath = '../';
$slug = preg_replace('/[^a-z0-9-]/', '', $_GET['slug'] ?? 'usa');
$dataFile = __DIR__ . '/data/' . $slug . '.php';

if (!file_exists($dataFile)) {
    header('Location: ../visa/');
    exit;
}
$d = include $dataFile;

$visaName = $d['name'] ?? 'Visa';
$pageTitle = $visaName . ' Visa Services — Travel World';
$pageDesc  = $d['meta_desc'] ?? 'Expert visa assistance for ' . $visaName . '. Complete documentation support, appointment booking, and fast processing.';
$pageKeywords  = $visaName . ' visa, ' . $visaName . ' visa application, ' . $visaName . ' visa requirements, ' . $visaName . ' visa documents, apply ' . $visaName . ' visa';
$pageCanonical = 'https://www.travelworld.com/visa/' . $slug;
$ogType        = 'article';
$ogImage       = $d['hero_image'] ?? 'https://www.travelworld.com/assets/image/logo.webp';

// ── JSON-LD: Service + BreadcrumbList ─────────────────────────────
$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'          => 'Service',
      '@id'            => 'https://www.travelworld.com/visa/' . $slug . '#service',
      'name'           => $visaName . ' Visa Assistance',
      'description'    => $pageDesc,
      'url'            => 'https://www.travelworld.com/visa/' . $slug,
      'provider'       => ['@id' => 'https://www.travelworld.com/#organization'],
      'serviceType'    => 'Visa Application Assistance',
      'areaServed'     => 'Worldwide',
      'offers'         => [
        '@type'        => 'Offer',
        'name'         => $visaName . ' Visa Service',
        'description'  => 'End-to-end ' . $visaName . ' visa assistance including document preparation and submission',
        'url'          => 'https://www.travelworld.com/visa/' . $slug,
        'seller'       => ['@id' => 'https://www.travelworld.com/#organization'],
      ],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',          'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Visa Services', 'item' => 'https://www.travelworld.com/visa/'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $visaName . ' Visa', 'item' => 'https://www.travelworld.com/visa/' . $slug],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include '../includes/page-header.php';
?>

<!-- HERO -->
<section class="page-hero">
  <div class="page-hero-bg" style="background-image:url('<?php echo $d['hero_image']; ?>');"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>/</span>
      <a href="/visa">Visa Services</a><span>/</span>
      <span><?php echo $d['name']; ?></span>
    </div>
    <h1 class="page-hero-title"><?php echo strtoupper($d['name']); ?> VISA</h1>
    <p class="page-hero-tagline"><?php echo $d['tagline']; ?></p>
    <div class="page-hero-stats">
      <div class="page-hero-stat"><i class="fas fa-clock"></i> <?php echo $d['processing_time']; ?></div>
      <div class="page-hero-stat"><i class="fas fa-check-circle"></i> <?php echo $d['success_rate']; ?> Success Rate</div>
      <div class="page-hero-stat"><i class="fas fa-file-alt"></i> <?php echo $d['visa_type']; ?></div>
      <div class="page-hero-stat"><i class="fas fa-rupee-sign"></i> <?php echo $d['fee_range']; ?></div>
    </div>
  </div>
</section>

<!-- OVERVIEW -->
<section class="inner-section">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="overview-grid" style="display:grid;grid-template-columns:1.4fr 1fr;gap:5rem;align-items:start;">
      <div>
        <div class="section-label">OVERVIEW</div>
        <h2 class="section-title reveal"><?php echo $d['name']; ?> Visa — Everything You Need to Know</h2>
        <p style="font-family:'Inter',sans-serif;font-size:0.88rem;color:#6B6560;line-height:1.8;margin-bottom:1.5rem;" class="reveal"><?php echo $d['overview']; ?></p>
        <?php if (!empty($d['success_highlight'])): ?>
        <div style="background:rgba(184,134,11,0.08);border-left:3px solid var(--gold);padding:1.2rem 1.5rem;border-radius:0 8px 8px 0;margin-bottom:1.5rem;" class="reveal">
          <p style="font-family:'Inter',sans-serif;font-size:0.85rem;color:#1A1410;font-weight:500;"><?php echo $d['success_highlight']; ?></p>
        </div>
        <?php endif; ?>
      </div>
      <div>
        <!-- Quick Info Card -->
        <div style="background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:12px;padding:2rem;box-shadow:0 4px 20px rgba(0,0,0,0.06);" class="reveal">
          <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:400;color:#1A1410;margin-bottom:1.5rem;border-bottom:1px solid rgba(0,0,0,0.08);padding-bottom:1rem;">Quick Info</h4>
          <?php
          $info = [
            ['icon'=>'fa-passport',       'label'=>'Visa Type',        'val'=>$d['visa_type']],
            ['icon'=>'fa-clock',          'label'=>'Processing Time',  'val'=>$d['processing_time']],
            ['icon'=>'fa-calendar-alt',   'label'=>'Validity',         'val'=>$d['validity']],
            ['icon'=>'fa-check-circle',   'label'=>'Success Rate',     'val'=>$d['success_rate']],
            ['icon'=>'fa-rupee-sign',     'label'=>'Fee Range',        'val'=>$d['fee_range']],
            ['icon'=>'fa-fingerprint',    'label'=>'Biometrics',       'val'=>$d['biometrics']],
            ['icon'=>'fa-map-marker-alt', 'label'=>'Embassy / VFS',    'val'=>$d['embassy']],
          ];
          foreach ($info as $i): ?>
          <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1rem;">
            <i class="fas <?php echo $i['icon']; ?>" style="color:var(--gold);width:16px;margin-top:2px;flex-shrink:0;"></i>
            <div>
              <div style="font-family:'Inter',sans-serif;font-size:0.65rem;text-transform:uppercase;letter-spacing:0.12em;color:#6B6560;"><?php echo $i['label']; ?></div>
              <div style="font-family:'Inter',sans-serif;font-size:0.82rem;color:#1A1410;font-weight:500;"><?php echo $i['val']; ?></div>
            </div>
          </div>
          <?php endforeach; ?>
          <a href="https://wa.me/919876543210?text=Hello%2C+I+need+<?php echo urlencode($d['name']); ?>+visa+assistance!" target="_blank" style="display:block;background:#25D366;color:#fff;text-align:center;font-family:'Inter',sans-serif;font-size:0.8rem;font-weight:600;padding:0.9rem;border-radius:6px;text-decoration:none;margin-top:1.5rem;">
            <i class="fab fa-whatsapp"></i> Apply Now on WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DOCUMENTS REQUIRED -->
<section class="inner-section alt">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="section-label">DOCUMENTS</div>
    <h2 class="section-title reveal">Documents Required</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;margin-top:2.5rem;">
      <?php foreach ($d['documents'] as $i => $doc): ?>
      <div class="reveal" style="background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:8px;padding:1.2rem 1.5rem;display:flex;align-items:flex-start;gap:1rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
        <span style="background:var(--gold);color:#fff;font-family:'Inter',sans-serif;font-size:0.7rem;font-weight:600;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><?php echo $i+1; ?></span>
        <span style="font-family:'Inter',sans-serif;font-size:0.82rem;color:#1A1410;line-height:1.5;"><?php echo $doc; ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PROCESS STEPS -->
<section class="inner-section">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="section-label">HOW IT WORKS</div>
    <h2 class="section-title reveal">Our Visa Process</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.5rem;margin-top:3rem;">
      <?php foreach ($d['process'] as $i => $step): ?>
      <div class="reveal" style="text-align:center;padding:2rem 1.5rem;">
        <div style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:300;color:var(--gold);opacity:0.4;margin-bottom:0.5rem;"><?php echo str_pad($i+1,2,'0',STR_PAD_LEFT); ?></div>
        <h5 style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:400;color:#1A1410;margin-bottom:0.5rem;"><?php echo $step['title']; ?></h5>
        <p style="font-family:'Inter',sans-serif;font-size:0.75rem;color:#6B6560;line-height:1.6;"><?php echo $step['desc']; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- TIPS & FAQ -->
<section class="inner-section alt">
  <div style="max-width:1100px;margin:0 auto;">
    <div class="section-label">TIPS & FAQ</div>
    <h2 class="section-title reveal">Important Tips & FAQs</h2>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;margin-top:3rem;">
      <!-- Tips -->
      <div>
        <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:400;color:#1A1410;margin-bottom:1.5rem;">Pro Tips</h4>
        <?php foreach ($d['tips'] as $tip): ?>
        <div class="reveal" style="display:flex;gap:1rem;margin-bottom:1rem;align-items:flex-start;">
          <i class="fas fa-lightbulb" style="color:var(--gold);margin-top:2px;flex-shrink:0;"></i>
          <p style="font-family:'Inter',sans-serif;font-size:0.82rem;color:#1A1410;line-height:1.6;"><?php echo $tip; ?></p>
        </div>
        <?php endforeach; ?>
      </div>
      <!-- FAQ -->
      <div>
        <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:400;color:#1A1410;margin-bottom:1.5rem;">Frequently Asked</h4>
        <?php foreach ($d['faq'] as $faq): ?>
        <div class="reveal" style="margin-bottom:1.5rem;border-bottom:1px solid rgba(0,0,0,0.06);padding-bottom:1.5rem;">
          <h6 style="font-family:'Inter',sans-serif;font-size:0.82rem;font-weight:600;color:#1A1410;margin-bottom:0.5rem;"><?php echo $faq['q']; ?></h6>
          <p style="font-family:'Inter',sans-serif;font-size:0.78rem;color:#6B6560;line-height:1.6;"><?php echo $faq['a']; ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ENQUIRY FORM -->
<section class="enquiry-cta">
  <div class="section-label">APPLY NOW</div>
  <h2 class="section-title reveal">Apply for <?php echo $d['name']; ?> Visa</h2>
  <p style="font-family:'Inter',sans-serif;font-size:0.88rem;color:#6B6560;margin-bottom:2rem;" class="reveal">Our visa expert will contact you within 2 hours with a complete checklist and next steps.</p>
  <form class="enquiry-form" onsubmit="return false;">
    <input type="hidden" name="dest" value="<?php echo $d['name']; ?> Visa">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="tel" name="phone" placeholder="Phone / WhatsApp Number" required>
    <input type="email" name="email" placeholder="Email Address">
    <input type="text" name="dates" placeholder="Planned Travel Dates">
    <select name="travellers">
      <option value="">Number of Applicants</option>
      <option>1 Person</option><option>2 People</option><option>3–4 People</option><option>5+ People</option>
    </select>
    <select name="budget">
      <option value="">Previous Refusal?</option>
      <option>No, first time applying</option>
      <option>Yes, once refused</option>
      <option>Yes, refused multiple times</option>
    </select>
    <textarea name="message" placeholder="Any additional details or questions?"></textarea>
    <button type="submit" class="btn-submit">
      <i class="fab fa-whatsapp"></i> Send Visa Enquiry on WhatsApp
    </button>
  </form>
</section>

<?php include '../includes/page-footer.php'; ?>