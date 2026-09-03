<?php
$rootPath      = '../';
$pageTitle     = 'Travel Blog — Destination Guides & Travel Tips | Travel World';
$pageDesc      = 'Travel inspiration, destination guides, packing tips and insider advice from the Travel World team. Explore Dubai, Maldives, Bali, Europe and more.';
$pageKeywords  = 'travel blog, destination guides, travel tips, holiday inspiration, travel advice, best places to visit';
$pageCanonical = 'https://www.travelworld.com/blog/';
$ogType        = 'website';

$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'Blog',
      '@id'         => 'https://www.travelworld.com/blog/#webpage',
      'url'         => 'https://www.travelworld.com/blog/',
      'name'        => 'Travel World Blog',
      'description' => $pageDesc,
      'publisher'   => ['@id' => 'https://www.travelworld.com/#organization'],
      'isPartOf'    => ['@id' => 'https://www.travelworld.com/#website'],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => 'https://www.travelworld.com/blog/'],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/../includes/page-header.php';

$posts = [
  ['slug'=>'top-10-things-dubai',      'title'=>'Top 10 Things to Do in Dubai',                'category'=>'Destination Guide', 'date'=>'August 2025', 'read'=>'8 min read', 'img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80', 'excerpt'=>'From the world\'s tallest building to a desert safari under the stars — our definitive guide to Dubai\'s must-do experiences.'],
  ['slug'=>'maldives-honeymoon-guide', 'title'=>'The Ultimate Maldives Honeymoon Guide',       'category'=>'Honeymoon',         'date'=>'July 2025',   'read'=>'10 min read','img'=>'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80', 'excerpt'=>'Everything you need to know about planning the perfect Maldives honeymoon — best atolls, resorts, and when to go.'],
  ['slug'=>'bali-hidden-gems',         'title'=>'Bali\'s Hidden Gems: Beyond the Tourist Trail','category'=>'Travel Tips',       'date'=>'June 2025',   'read'=>'7 min read', 'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80', 'excerpt'=>'Discover the Bali that most tourists never see — secret temples, hidden waterfalls and authentic village experiences.'],
  ['slug'=>'europe-in-14-days',        'title'=>'Europe in 14 Days: The Perfect Itinerary',    'category'=>'Itinerary',         'date'=>'May 2025',    'read'=>'12 min read','img'=>'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80', 'excerpt'=>'Paris, Swiss Alps, Venice, Amalfi, Santorini — how to see the best of Europe in two weeks without feeling rushed.'],
  ['slug'=>'japan-first-timer',        'title'=>'Japan for First-Timers: Everything You Need', 'category'=>'Destination Guide', 'date'=>'April 2025',  'read'=>'11 min read','img'=>'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80', 'excerpt'=>'From Tokyo\'s neon streets to Kyoto\'s ancient temples — the complete first-timer\'s guide to Japan.'],
  ['slug'=>'packing-luxury-travel',    'title'=>'How to Pack for a Luxury Holiday',            'category'=>'Travel Tips',       'date'=>'March 2025',  'read'=>'6 min read', 'img'=>'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=600&q=80', 'excerpt'=>'The art of packing light without sacrificing style — our luxury travel packing guide for every destination.'],
];
?>

<!-- Hero -->
<section class="page-hero" style="height:45vh;">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>›</span><span>Blog</span>
    </div>
    <h1 class="page-hero-title">Travel Stories</h1>
    <p class="page-hero-tagline">Inspiration, guides and insider advice from our travel experts</p>
  </div>
</section>

<!-- Blog Grid -->
<section class="inner-section">
  <div class="section-label reveal">Latest Articles</div>
  <h2 class="section-title reveal">From Our Travel Desk</h2>

  <!-- Featured Post -->
  <div class="reveal" style="margin-top:3rem;margin-bottom:3rem;">
    <a href="/blog/<?php echo $posts[0]['slug']; ?>" style="text-decoration:none;display:grid;grid-template-columns:1.2fr 1fr;gap:0;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.06);">
      <div style="position:relative;height:400px;overflow:hidden;">
        <img src="<?php echo $posts[0]['img']; ?>" alt="<?php echo $posts[0]['title']; ?>" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s;" loading="lazy">
      </div>
      <div style="background:var(--dark3);padding:3rem;display:flex;flex-direction:column;justify-content:center;">
        <span style="font-family:'Inter',sans-serif;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:0.8rem;"><?php echo $posts[0]['category']; ?> · <?php echo $posts[0]['date']; ?></span>
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:300;color:var(--white);line-height:1.2;margin-bottom:1rem;"><?php echo $posts[0]['title']; ?></h3>
        <p style="font-family:'Inter',sans-serif;font-size:0.82rem;color:var(--gray);line-height:1.8;margin-bottom:1.5rem;"><?php echo $posts[0]['excerpt']; ?></p>
        <span style="font-family:'Inter',sans-serif;font-size:0.75rem;color:var(--gold);letter-spacing:0.1em;">Read Article → · <?php echo $posts[0]['read']; ?></span>
      </div>
    </a>
  </div>

  <!-- Post Grid -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
    <?php foreach (array_slice($posts, 1) as $post): ?>
    <a href="/blog/<?php echo $post['slug']; ?>" style="text-decoration:none;display:block;" class="reveal">
      <div style="background:var(--dark3);border:1px solid rgba(255,255,255,0.06);border-radius:12px;overflow:hidden;transition:border-color 0.3s,transform 0.3s;" onmouseover="this.style.borderColor='rgba(201,168,76,0.35)';this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)';this.style.transform='translateY(0)'">
        <div style="height:200px;overflow:hidden;">
          <img src="<?php echo $post['img']; ?>" alt="<?php echo $post['title']; ?>" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s;" loading="lazy">
        </div>
        <div style="padding:1.5rem;">
          <span style="font-family:'Inter',sans-serif;font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--gold);"><?php echo $post['category']; ?> · <?php echo $post['date']; ?></span>
          <h4 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:400;color:var(--white);line-height:1.25;margin:0.6rem 0 0.8rem;"><?php echo $post['title']; ?></h4>
          <p style="font-family:'Inter',sans-serif;font-size:0.78rem;color:var(--gray);line-height:1.7;margin-bottom:1rem;"><?php echo $post['excerpt']; ?></p>
          <span style="font-family:'Inter',sans-serif;font-size:0.7rem;color:var(--gold);">Read → · <?php echo $post['read']; ?></span>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Newsletter -->
<section class="enquiry-cta">
  <div class="section-label">Stay Inspired</div>
  <h2 class="section-title">Get Travel Inspiration in Your Inbox</h2>
  <p class="section-subtitle" style="margin:0 auto 2rem;">Monthly destination guides, exclusive deals and insider tips from our travel experts.</p>
  <form style="display:flex;gap:1rem;max-width:500px;margin:0 auto;" onsubmit="event.preventDefault();this.innerHTML='<p style=\'color:var(--gold);font-family:Inter,sans-serif;\'>✓ You\'re subscribed! Welcome to the TravelWorld community.</p>'">
    <input type="email" placeholder="Your email address" required style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:6px;padding:0.9rem 1.2rem;font-family:'Inter',sans-serif;font-size:0.82rem;color:var(--white);outline:none;">
    <button type="submit" class="btn-submit" style="width:auto;padding:0.9rem 2rem;white-space:nowrap;">Subscribe</button>
  </form>
</section>

<?php include __DIR__ . '/../includes/page-footer.php'; ?>