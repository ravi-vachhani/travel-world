<?php
$rootPath = '../';
$slug = preg_replace('/[^a-z0-9-]/', '', $_GET['slug'] ?? 'top-10-things-dubai');

$posts = [
  'top-10-things-dubai' => [
    'title'    => 'Top 10 Things to Do in Dubai',
    'category' => 'Destination Guide',
    'date'     => 'August 15, 2025',
    'author'   => 'Arjun Mehta',
    'read'     => '8 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'Dubai is a city that defies superlatives. In just five decades, it has transformed from a small fishing village into one of the world\'s most extraordinary destinations — a place where the future is already here, where the desert meets the sea, and where every experience is designed to astonish. Here are the ten experiences that define Dubai.'],
      ['type'=>'h2',   'text'=>'1. Ascend the Burj Khalifa'],
      ['type'=>'p',    'text'=>'At 828 metres, the Burj Khalifa is the world\'s tallest building — and the view from the 124th floor observation deck is simply breathtaking. Book the "At the Top SKY" experience on the 148th floor for the ultimate perspective. Go at sunset for the most dramatic light, and book weeks in advance.'],
      ['type'=>'h2',   'text'=>'2. Desert Safari at Sunset'],
      ['type'=>'p',    'text'=>'No visit to Dubai is complete without a desert safari. The red dunes of the Dubai Desert Conservation Reserve are just 45 minutes from the city. A premium safari includes dune bashing in a 4x4, camel riding, sandboarding, a Bedouin camp dinner under the stars, and traditional entertainment. Book a private safari for the most exclusive experience.'],
      ['type'=>'h2',   'text'=>'3. Walk the Dubai Marina'],
      ['type'=>'p',    'text'=>'The Dubai Marina is one of the world\'s largest man-made marinas — a 3km waterfront promenade lined with restaurants, cafés and luxury yachts. Walk the Marina Walk at night when the skyscrapers are lit up, take a traditional abra (water taxi) across the water, or dine at one of the waterfront restaurants.'],
      ['type'=>'h2',   'text'=>'4. Shop at the Dubai Mall'],
      ['type'=>'p',    'text'=>'The Dubai Mall is not just a shopping centre — it\'s a destination in itself. With over 1,200 stores, an indoor ice rink, the Dubai Aquarium (home to the world\'s largest acrylic panel), a dinosaur skeleton, and the spectacular Dubai Fountain show outside, you could spend an entire day here without shopping at all.'],
      ['type'=>'h2',   'text'=>'5. Explore the Gold and Spice Souks'],
      ['type'=>'p',    'text'=>'Cross the Dubai Creek by abra (traditional wooden boat) to reach the old city — Deira. The Gold Souk is one of the world\'s largest, with over 300 shops selling gold, diamonds and precious stones. Nearby, the Spice Souk fills the air with the fragrance of saffron, frankincense, cardamom and rose water. Bargaining is expected and part of the experience.'],
      ['type'=>'h2',   'text'=>'6. Visit the Palm Jumeirah'],
      ['type'=>'p',    'text'=>'The Palm Jumeirah is one of the world\'s most ambitious engineering projects — an artificial island in the shape of a palm tree, home to luxury hotels, residences and the Atlantis resort. Take the Palm Monorail for views of the island, visit the Atlantis Aquaventure waterpark, or simply walk the boardwalk for views of the Dubai skyline.'],
      ['type'=>'h2',   'text'=>'7. Dine at a World-Class Restaurant'],
      ['type'=>'p',    'text'=>'Dubai has one of the world\'s most exciting restaurant scenes — from the Burj Al Arab\'s underwater restaurant to rooftop dining with Burj Khalifa views. Don\'t miss Nobu at Atlantis, Zuma in DIFC, or a traditional Emirati meal at Al Hadheerah in the desert. Book well in advance for the most popular venues.'],
      ['type'=>'h2',   'text'=>'8. Experience the Dubai Frame'],
      ['type'=>'p',    'text'=>'The Dubai Frame is a 150-metre picture frame that bridges old and new Dubai — with the historic city on one side and the modern skyline on the other. The glass-floored sky bridge between the two towers offers a vertiginous view straight down. It\'s one of Dubai\'s most photogenic and thought-provoking attractions.'],
      ['type'=>'h2',   'text'=>'9. Miracle Garden'],
      ['type'=>'p',    'text'=>'The Dubai Miracle Garden is the world\'s largest natural flower garden — 150 million flowers arranged in extraordinary sculptures and displays, including a life-size Emirates A380 covered in flowers. Open from October to April only, it\'s a surreal and spectacular experience that contrasts beautifully with the surrounding desert.'],
      ['type'=>'h2',   'text'=>'10. Watch the Dubai Fountain Show'],
      ['type'=>'p',    'text'=>'The Dubai Fountain is the world\'s largest choreographed fountain system — 275 metres of dancing water jets that shoot up to 150 metres in the air, choreographed to Arabic and international music. The show runs every 30 minutes after sunset and is free to watch from the Dubai Mall waterfront. For the best view, book a table at a waterfront restaurant.'],
      ['type'=>'tip',  'text'=>'Pro Tip: Visit Dubai between November and March for the best weather (25–30°C). Avoid July–August when temperatures exceed 45°C. The Dubai Shopping Festival in January offers incredible deals across the city.'],
    ],
    'related_dest' => 'dubai',
  ],
  'maldives-honeymoon-guide' => [
    'title'    => 'The Ultimate Maldives Honeymoon Guide',
    'category' => 'Honeymoon',
    'date'     => 'July 20, 2025',
    'author'   => 'Priya Sharma',
    'read'     => '10 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'The Maldives is the world\'s most romantic destination — 1,200 coral islands scattered across the Indian Ocean, each one a jewel of white sand and turquoise water. For honeymooners, it offers something truly unique: complete privacy, extraordinary natural beauty, and a level of luxury that is unmatched anywhere on earth.'],
      ['type'=>'h2',   'text'=>'Choosing the Right Atoll'],
      ['type'=>'p',    'text'=>'The Maldives is divided into 26 atolls, each with its own character. North Malé Atoll is closest to the airport and home to some of the most famous resorts. South Malé Atoll offers excellent diving. Baa Atoll is a UNESCO Biosphere Reserve with the famous Hanifaru Bay manta ray aggregation. Lhaviyani Atoll is known for its pristine reefs and fewer crowds.'],
      ['type'=>'h2',   'text'=>'Overwater Bungalows: What to Know'],
      ['type'=>'p',    'text'=>'The overwater bungalow is the defining Maldives experience — a private villa built on stilts above the lagoon, with a glass floor panel, direct lagoon access, and a private deck with steps into the water. The best overwater villas face west for sunset views. Look for villas with private pools for the ultimate luxury.'],
      ['type'=>'h2',   'text'=>'Best Time to Visit'],
      ['type'=>'p',    'text'=>'The Maldives has two seasons: the dry season (November to April) and the wet season (May to October). The dry season is ideal for honeymooners — calm seas, clear skies, and excellent visibility for snorkelling and diving. December and January are peak season; book 6–12 months in advance for the best resorts.'],
      ['type'=>'h2',   'text'=>'Top Honeymoon Resorts'],
      ['type'=>'p',    'text'=>'Soneva Jani offers the most spectacular overwater villas with retractable roofs for stargazing. Gili Lankanfushi is the world\'s largest overwater villa resort. Four Seasons Landaa Giraavaru is set in a UNESCO Biosphere Reserve. Velaa Private Island offers unmatched exclusivity with a private golf course and chocolate room.'],
      ['type'=>'h2',   'text'=>'Experiences Not to Miss'],
      ['type'=>'p',    'text'=>'Snorkelling with manta rays at Hanifaru Bay (June–November) is a once-in-a-lifetime experience. A private sandbank picnic — your own deserted island for the day — is the ultimate romantic gesture. Sunset dolphin cruises, underwater dining at Ithaa at Conrad Maldives, and bioluminescent beach walks complete the perfect honeymoon.'],
      ['type'=>'tip',  'text'=>'Honeymoon Tip: Always mention you\'re on honeymoon when booking. Most resorts offer complimentary upgrades, flower arrangements, champagne and special touches for honeymooners. TravelWorld can arrange all of this on your behalf.'],
    ],
    'related_dest' => 'maldives',
  ],

  'bali-hidden-gems' => [
    'title'    => 'Bali\'s Hidden Gems: Beyond the Tourist Trail',
    'category' => 'Travel Tips',
    'date'     => 'June 10, 2025',
    'author'   => 'Sneha Nair',
    'read'     => '7 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'Bali is one of the world\'s most visited islands — but beyond the crowded rice terraces of Tegallalang and the busy streets of Seminyak lies a Bali that most tourists never discover. These are the secret temples, hidden waterfalls, and authentic village experiences that make Bali truly magical.'],
      ['type'=>'h2',   'text'=>'Sidemen Valley: Bali\'s Best-Kept Secret'],
      ['type'=>'p',    'text'=>'While tourists flock to Ubud, the Sidemen Valley in East Bali remains blissfully quiet. Terraced rice fields cascade down volcanic hillsides, traditional weaving villages produce the finest ikat textiles, and Mount Agung looms dramatically in the background. Stay at one of the small family-run guesthouses for an authentic Balinese experience.'],
      ['type'=>'h2',   'text'=>'Sekumpul Waterfall: Bali\'s Most Beautiful'],
      ['type'=>'p',    'text'=>'Sekumpul in North Bali is arguably the island\'s most spectacular waterfall — a cluster of seven falls plunging into a lush jungle gorge. The 45-minute trek through rice fields and jungle is part of the experience. Arrive early (before 8am) to have it almost to yourself. Hire a local guide from the village for the best route.'],
      ['type'=>'h2',   'text'=>'Pura Lempuyang: The Real Gate of Heaven'],
      ['type'=>'p',    'text'=>'The famous "Gates of Heaven" photo at Pura Lempuyang has been seen by millions — but few know that the temple complex has seven levels, each requiring a steep climb through jungle. The highest temple, Pura Lempuyang Luhur, sits at 1,175 metres with views across to Mount Agung. Visit at sunrise for the most dramatic light and fewest crowds.'],
      ['type'=>'h2',   'text'=>'Amed: Bali\'s Diving Paradise'],
      ['type'=>'p',    'text'=>'The fishing village of Amed on Bali\'s northeast coast is a world away from the tourist south. Black sand beaches, traditional jukung fishing boats, and some of Bali\'s best diving — including the famous USAT Liberty shipwreck at nearby Tulamben — make this the perfect escape for those who want authentic Bali.'],
      ['type'=>'h2',   'text'=>'Munduk: Coffee, Cloves and Waterfalls'],
      ['type'=>'p',    'text'=>'The highland village of Munduk in North Bali sits at 1,000 metres amid coffee, clove and vanilla plantations. Trek through the plantations to hidden waterfalls, visit a traditional coffee farm, and stay in a colonial Dutch-era villa. The cool mountain air is a welcome relief from the coastal heat.'],
      ['type'=>'tip',  'text'=>'Insider Tip: Hire a private driver for your Bali explorations rather than joining group tours. A good driver costs around ₹2,500–3,500 per day and will take you to places no tour bus can reach. Ask your TravelWorld consultant for recommended drivers.'],
    ],
    'related_dest' => 'bali',
  ],

  'europe-in-14-days' => [
    'title'    => 'Europe in 14 Days: The Perfect Itinerary',
    'category' => 'Itinerary',
    'date'     => 'May 5, 2025',
    'author'   => 'Arjun Mehta',
    'read'     => '12 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'Europe in two weeks — it sounds ambitious, but with the right itinerary, you can experience the very best of the continent without feeling rushed. This route takes you from the romance of Paris to the drama of the Swiss Alps, the art of Venice, the beauty of the Amalfi Coast, and the magic of Santorini.'],
      ['type'=>'h2',   'text'=>'Days 1–3: Paris, France'],
      ['type'=>'p',    'text'=>'Begin in Paris — the City of Light. Day 1: Eiffel Tower at sunset, Seine River cruise, dinner in Saint-Germain. Day 2: Louvre Museum (book in advance), Notre-Dame, Marais district, Sainte-Chapelle. Day 3: Versailles day trip, Champs-Élysées, Arc de Triomphe, farewell dinner at a classic brasserie. Stay in the 7th arrondissement for the best location.'],
      ['type'=>'h2',   'text'=>'Days 4–5: Swiss Alps, Switzerland'],
      ['type'=>'p',    'text'=>'Take the TGV from Paris to Geneva (3.5 hours), then transfer to Interlaken or Zermatt. Day 4: Arrive, cable car to Schilthorn or Gornergrat for Matterhorn views. Day 5: Jungfraujoch — the "Top of Europe" at 3,454 metres, with views across the Aletsch Glacier. The Swiss rail system is impeccable — buy a Swiss Travel Pass for unlimited travel.'],
      ['type'=>'h2',   'text'=>'Days 6–8: Venice & Florence, Italy'],
      ['type'=>'p',    'text'=>'Train from Zurich to Venice (4 hours). Day 6: Arrive Venice, St. Mark\'s Basilica, Doge\'s Palace, gondola ride at sunset. Day 7: Rialto Market, Murano glass island, Burano lace island. Day 8: Train to Florence — Uffizi Gallery (Botticelli\'s Birth of Venus), Ponte Vecchio, Piazzale Michelangelo sunset. Stay in the Oltrarno neighbourhood.'],
      ['type'=>'h2',   'text'=>'Days 9–10: Amalfi Coast, Italy'],
      ['type'=>'p',    'text'=>'Train from Florence to Naples (3 hours), then ferry or private transfer to the Amalfi Coast. Day 9: Positano — the most photogenic village on the coast, with its cascade of pastel houses. Day 10: Ravello for gardens and views, Amalfi town, boat trip to the Emerald Grotto. Hire a private boat for the most spectacular coastal experience.'],
      ['type'=>'h2',   'text'=>'Days 11–14: Santorini, Greece'],
      ['type'=>'p',    'text'=>'Fly from Naples to Santorini (2 hours). Day 11: Arrive, check into a caldera-view hotel in Oia or Imerovigli. Day 12: Oia village, sunset at the castle — arrive 2 hours early for a spot. Day 13: Catamaran cruise around the caldera, hot springs, Red Beach, wine tasting at Santo Wines. Day 14: Akrotiri archaeological site, final sunset, departure.'],
      ['type'=>'tip',  'text'=>'Planning Tip: Book Paris and Santorini hotels 6 months in advance — the best properties sell out quickly. TravelWorld can handle all bookings, transfers and visa arrangements for this itinerary. Schengen visa covers all five countries.'],
    ],
    'related_dest' => 'paris',
  ],

  'japan-first-timer' => [
    'title'    => 'Japan for First-Timers: Everything You Need to Know',
    'category' => 'Destination Guide',
    'date'     => 'April 12, 2025',
    'author'   => 'Vikram Singh',
    'read'     => '11 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'Japan is unlike anywhere else on earth — a country where ancient tradition and cutting-edge modernity coexist in perfect harmony, where the streets are immaculate, the food is extraordinary, and the people are among the most courteous in the world. For first-time visitors, it can feel overwhelming. This guide will help you navigate Japan with confidence.'],
      ['type'=>'h2',   'text'=>'When to Visit Japan'],
      ['type'=>'p',    'text'=>'Spring (late March to early May) is Japan\'s most celebrated season — cherry blossom (sakura) season transforms the country into a pink wonderland. Book 6–12 months in advance as this is peak season. Autumn (October–November) offers spectacular foliage (koyo) with fewer crowds. Avoid Golden Week (late April to early May) when domestic travel peaks and prices surge.'],
      ['type'=>'h2',   'text'=>'Getting Around: The JR Pass'],
      ['type'=>'p',    'text'=>'The Japan Rail Pass is essential for first-timers visiting multiple cities. A 14-day pass (approximately ₹55,000) covers unlimited travel on all JR trains including the Shinkansen bullet trains. Buy it before you leave India — it cannot be purchased in Japan. The Shinkansen from Tokyo to Kyoto takes just 2 hours 15 minutes and is an experience in itself.'],
      ['type'=>'h2',   'text'=>'Tokyo: Where to Begin'],
      ['type'=>'p',    'text'=>'Spend your first 3–4 days in Tokyo. Must-see: Senso-ji Temple in Asakusa (visit at dawn before the crowds), Shibuya Crossing (the world\'s busiest pedestrian crossing), teamLab Borderless digital art museum (book weeks in advance), Tsukiji Outer Market for the world\'s best sushi breakfast, and Shinjuku\'s Golden Gai for an evening of tiny bars.'],
      ['type'=>'h2',   'text'=>'Kyoto: The Soul of Japan'],
      ['type'=>'p',    'text'=>'Kyoto is Japan\'s cultural heart — 17 UNESCO World Heritage Sites in one city. Don\'t miss: Fushimi Inari Shrine (10,000 torii gates — hike to the top for solitude), Arashiyama Bamboo Grove (visit at 6am before the crowds), Kinkaku-ji (the Golden Pavilion), and the Gion district at dusk when geisha emerge for evening appointments.'],
      ['type'=>'h2',   'text'=>'Food: Japan\'s Greatest Gift'],
      ['type'=>'p',    'text'=>'Japan has more Michelin stars than any other country. But the best food is often the simplest: a bowl of ramen at a counter restaurant, fresh sushi at Tsukiji, takoyaki (octopus balls) from a street stall in Osaka, or a convenience store onigiri (rice ball) at 2am. Osaka is Japan\'s food capital — spend at least two days eating your way through Dotonbori.'],
      ['type'=>'h2',   'text'=>'Practical Tips for Indian Travellers'],
      ['type'=>'p',    'text'=>'Japan is largely cash-based — carry yen at all times (7-Eleven ATMs accept international cards). Tipping is considered rude. Remove shoes when entering homes and some restaurants. Bow when greeting. Carry a pocket WiFi (rent at the airport) or buy a data SIM. Vegetarian options are limited — inform restaurants in advance. Most signs are in English in tourist areas.'],
      ['type'=>'tip',  'text'=>'Visa Tip: Indians require a Japan visa. Apply through the Japan e-Visa system online — processing takes 5–7 working days and costs approximately ₹1,500. TravelWorld handles all Japan visa applications with a 95% success rate.'],
    ],
    'related_dest' => 'tokyo',
  ],

  'packing-luxury-travel' => [
    'title'    => 'How to Pack for a Luxury Holiday',
    'category' => 'Travel Tips',
    'date'     => 'March 8, 2025',
    'author'   => 'Deepika Joshi',
    'read'     => '6 min read',
    'hero_img' => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85',
    'content'  => [
      ['type'=>'intro', 'text'=>'The art of packing for a luxury holiday is about travelling light without sacrificing style. Whether you\'re heading to the Maldives for a week or embarking on a 14-day European grand tour, the principles are the same: quality over quantity, versatility over variety, and always, always leave room for what you\'ll buy along the way.'],
      ['type'=>'h2',   'text'=>'The Golden Rule: One Bag Per Week'],
      ['type'=>'p',    'text'=>'For trips up to 7 days, a single carry-on is sufficient if you pack strategically. For longer trips, a medium checked bag (around 23kg) plus a quality carry-on is ideal. Avoid checking multiple bags — it slows you down, increases the risk of loss, and signals inexperience. The world\'s most seasoned travellers pack light.'],
      ['type'=>'h2',   'text'=>'Building a Capsule Wardrobe'],
      ['type'=>'p',    'text'=>'Choose a neutral colour palette — navy, white, beige, black — where every piece works with every other piece. For a 10-day trip: 3 trousers/skirts, 5 tops, 2 dresses/shirts, 1 smart jacket, 1 casual layer, 2 pairs of shoes (one smart, one comfortable). Merino wool is the luxury traveller\'s best friend — it\'s lightweight, wrinkle-resistant, odour-resistant and temperature-regulating.'],
      ['type'=>'h2',   'text'=>'The Luxury Toiletry Kit'],
      ['type'=>'p',    'text'=>'Invest in a quality leather toiletry bag and decant your favourite products into travel-size containers. Most luxury hotels provide premium toiletries — call ahead to confirm and pack accordingly. Essentials: SPF 50 sunscreen, a good moisturiser (air travel is dehydrating), your preferred fragrance in a travel atomiser, and a silk eye mask for long-haul flights.'],
      ['type'=>'h2',   'text'=>'Tech Essentials for the Modern Traveller'],
      ['type'=>'p',    'text'=>'A universal travel adapter (the Kikkerland UL03-A covers 150+ countries), a portable power bank (20,000mAh for multiple device charges), noise-cancelling headphones (Sony WH-1000XM5 or Bose QuietComfort 45), and a lightweight laptop or iPad for work and entertainment. Download offline maps, your airline app, and a translation app before departure.'],
      ['type'=>'h2',   'text'=>'What to Leave Behind'],
      ['type'=>'p',    'text'=>'Leave behind: more than 2 books (use a Kindle), full-size toiletries (buy locally or use hotel supplies), "just in case" items you\'ve never used on previous trips, and anything that requires ironing. If you haven\'t worn it in the last month, you won\'t wear it on holiday. Be ruthless — every kilogram you don\'t carry is a luxury in itself.'],
      ['type'=>'tip',  'text'=>'Pro Tip: Pack your carry-on the night before and leave it for 24 hours. You\'ll almost always find things to remove. For checked luggage, use packing cubes to compress clothing and keep everything organised. TravelWorld clients receive a complimentary packing guide with every booking.'],
    ],
    'related_dest' => 'paris',
  ],
];

if (!isset($posts[$slug])) {
  header('Location: /blog/');
  exit;
}

$post = $posts[$slug];
$pageTitle = $post['title'];
$pageDesc  = substr($post['content'][0]['text'] ?? '', 0, 160);
$postUrl   = 'https://www.travelworld.com/blog/' . $slug;

// ── SEO META ─────────────────────────────────────────────────────
$pageKeywords  = $post['title'] . ', ' . ($post['category'] ?? 'travel') . ', travel tips, Travel World blog';
$pageCanonical = $postUrl;
$ogType        = 'article';
$ogImage       = $post['hero_img'] ?? 'https://www.travelworld.com/assets/image/logo.webp';

// ── JSON-LD: BlogPosting + BreadcrumbList ─────────────────────────
$datePublished = date('Y-m-d', strtotime($post['date'] ?? 'now'));
$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'            => 'BlogPosting',
      '@id'              => $postUrl . '#article',
      'headline'         => $post['title'],
      'description'      => $pageDesc,
      'url'              => $postUrl,
      'image'            => $ogImage,
      'datePublished'    => $datePublished,
      'dateModified'     => $datePublished,
      'author'           => [
        '@type' => 'Person',
        'name'  => $post['author'] ?? 'Travel World',
      ],
      'publisher'        => ['@id' => 'https://www.travelworld.com/#organization'],
      'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $postUrl],
      'articleSection'   => $post['category'] ?? 'Travel',
      'keywords'         => $pageKeywords,
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => 'https://www.travelworld.com/blog/'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => $postUrl],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/../includes/page-header.php';
?>

<!-- Hero -->
<section class="page-hero" style="height:60vh;">
  <div class="page-hero-bg" style="background-image:url('<?php echo $post['hero_img']; ?>')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>›</span>
      <a href="/blog">Blog</a><span>›</span>
      <span><?php echo $post['category']; ?></span>
    </div>
    <h1 class="page-hero-title" style="font-size:clamp(1.8rem,4vw,3.5rem);"><?php echo $post['title']; ?></h1>
    <div class="page-hero-stats">
      <span class="page-hero-stat"><i class="fas fa-user"></i> <?php echo $post['author']; ?></span>
      <span class="page-hero-stat"><i class="fas fa-calendar"></i> <?php echo $post['date']; ?></span>
      <span class="page-hero-stat"><i class="fas fa-clock"></i> <?php echo $post['read']; ?></span>
    </div>
  </div>
</section>

<!-- Article Content -->
<section class="inner-section">
  <div style="max-width:780px;margin:0 auto;">
    <?php foreach ($post['content'] as $block): ?>
      <?php if ($block['type'] === 'intro'): ?>
        <p class="reveal" style="font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:300;color:rgba(255,255,255,0.85);line-height:1.8;margin-bottom:2.5rem;border-left:3px solid var(--gold);padding-left:1.5rem;"><?php echo $block['text']; ?></p>
      <?php elseif ($block['type'] === 'h2'): ?>
        <h2 class="reveal" style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:400;color:var(--white);margin:2.5rem 0 1rem;"><?php echo $block['text']; ?></h2>
      <?php elseif ($block['type'] === 'p'): ?>
        <p class="reveal" style="font-family:'Inter',sans-serif;font-size:0.9rem;color:var(--gray);line-height:1.9;margin-bottom:1.5rem;"><?php echo $block['text']; ?></p>
      <?php elseif ($block['type'] === 'tip'): ?>
        <div class="reveal" style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.25);border-radius:8px;padding:1.5rem;margin:2rem 0;">
          <p style="font-family:'Inter',sans-serif;font-size:0.85rem;color:var(--light);line-height:1.8;"><strong style="color:var(--gold);">✦ <?php echo $block['text']; ?></strong></p>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <!-- Author Box -->
    <div class="reveal" style="margin-top:4rem;padding:2rem;background:var(--dark3);border:1px solid rgba(255,255,255,0.06);border-radius:10px;display:flex;align-items:center;gap:1.5rem;">
      <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80" alt="<?php echo $post['author']; ?>" style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid rgba(201,168,76,0.3);">
      <div>
        <h6 style="font-family:'Inter',sans-serif;font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:0.3rem;">Written by</h6>
        <p style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;color:var(--white);margin-bottom:0.3rem;"><?php echo $post['author']; ?></p>
        <p style="font-family:'Inter',sans-serif;font-size:0.75rem;color:var(--gray);">Luxury Travel Specialist, TravelWorld</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="enquiry-cta">
  <div class="section-label">Ready to Go?</div>
  <h2 class="section-title">Plan Your Trip</h2>
  <p class="section-subtitle" style="margin:0 auto 2rem;">Let our experts craft a bespoke itinerary based on this guide.</p>
  <a href="/contact" class="btn-submit" style="display:inline-block;text-decoration:none;padding:1rem 3rem;width:auto;">
    Get a Free Consultation <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
  </a>
</section>

<?php include __DIR__ . '/../includes/page-footer.php'; ?>