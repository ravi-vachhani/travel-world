<?php
// ── LOAD SERVICE DATA ─────────────────────────────────────────
$slug = preg_replace('/[^a-z0-9-]/', '', $_GET['slug'] ?? 'honeymoon');

$services = [
  'honeymoon' => [
    'title'    => 'Honeymoon Packages',
    'tagline'  => 'Begin Forever in Paradise',
    'icon'     => 'fas fa-heart',
    'hero_img' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=1600&q=85',
    'intro'    => 'Your honeymoon is the most important journey of your life — and we treat it that way. Every detail is crafted with love: the private villa with the ocean view, the candlelit dinner on the beach, the sunrise boat trip, the couples\' spa treatment. We handle everything so you can focus entirely on each other.',
    'includes' => [
      ['icon'=>'fas fa-plane',       'title'=>'Flights',              'desc'=>'Business or first class flights with preferred seating'],
      ['icon'=>'fas fa-hotel',       'title'=>'Luxury Accommodation', 'desc'=>'Handpicked hotels and villas — honeymoon upgrades included'],
      ['icon'=>'fas fa-car',         'title'=>'Private Transfers',    'desc'=>'Airport to hotel in air-conditioned private vehicles'],
      ['icon'=>'fas fa-utensils',    'title'=>'Romantic Dining',      'desc'=>'Candlelit dinners, private beach setups, breakfast in bed'],
      ['icon'=>'fas fa-spa',         'title'=>'Couples\' Spa',        'desc'=>'Curated spa treatments for two at the finest spas'],
      ['icon'=>'fas fa-camera',      'title'=>'Photography',          'desc'=>'Professional honeymoon photoshoot at iconic locations'],
      ['icon'=>'fas fa-gift',        'title'=>'Honeymoon Surprises',  'desc'=>'Flower arrangements, champagne, personalised touches'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Dedicated honeymoon concierge available around the clock'],
    ],
    'packages' => [
      ['name'=>'Maldives Overwater Dream',  'duration'=>'6N · 7D', 'price'=>'From ₹1,80,000/couple', 'desc'=>'Overwater bungalow, sunset cruise, couples\' spa, private beach dinner.'],
      ['name'=>'Bali Romance',              'duration'=>'7N · 8D', 'price'=>'From ₹1,20,000/couple', 'desc'=>'Private villa with pool, temple tour, rice terrace trek, spa day.'],
      ['name'=>'Santorini Sunset',          'duration'=>'7N · 8D', 'price'=>'From ₹2,20,000/couple', 'desc'=>'Caldera-view suite, private catamaran, wine tasting, Oia sunset.'],
      ['name'=>'Paris & Amalfi',            'duration'=>'10N · 11D','price'=>'From ₹2,80,000/couple', 'desc'=>'Eiffel Tower dinner, Versailles, Positano villa, Capri day trip.'],
    ],
    'destinations' => ['maldives','bali','santorini','paris','dubai','amalfi'],
    'testimonial' => ['quote'=>'Our Maldives honeymoon was absolutely perfect — every detail was taken care of. We didn\'t have to think about anything except enjoying each other.','author'=>'Priya & Rahul, Mumbai'],
  ],
  'adventure' => [
    'title'    => 'Adventure Travel',
    'tagline'  => 'Push Your Limits',
    'icon'     => 'fas fa-mountain',
    'hero_img' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1600&q=85',
    'intro'    => 'Adventure travel is not just about adrenaline — it\'s about pushing your boundaries, discovering your limits, and returning home transformed. From Himalayan base camps to Saharan dunes, from Patagonian glaciers to Maldivian dive sites, we craft adventures that challenge and inspire.',
    'includes' => [
      ['icon'=>'fas fa-person-hiking','title'=>'Expert Guides',       'desc'=>'Certified local guides with deep knowledge of the terrain'],
      ['icon'=>'fas fa-shield-alt',  'title'=>'Safety Equipment',     'desc'=>'All technical equipment provided and safety-checked'],
      ['icon'=>'fas fa-tent',        'title'=>'Accommodation',        'desc'=>'From mountain lodges to luxury tented camps'],
      ['icon'=>'fas fa-utensils',    'title'=>'Meals',                'desc'=>'Nutritious meals planned for high-energy activities'],
      ['icon'=>'fas fa-first-aid',   'title'=>'Medical Support',      'desc'=>'First aid trained guides and emergency protocols'],
      ['icon'=>'fas fa-plane',       'title'=>'Flights & Transfers',  'desc'=>'All logistics handled — you just show up and adventure'],
      ['icon'=>'fas fa-file-alt',    'title'=>'Permits & Visas',      'desc'=>'All trekking permits and entry requirements arranged'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Emergency support line active throughout your trip'],
    ],
    'packages' => [
      ['name'=>'Everest Base Camp Trek',    'duration'=>'14N · 15D','price'=>'From ₹1,50,000/person','desc'=>'Lukla flight, Namche Bazaar, Tengboche, EBC at 5,364m.'],
      ['name'=>'Sahara Desert Expedition',  'duration'=>'5N · 6D', 'price'=>'From ₹80,000/person', 'desc'=>'Marrakech, Atlas Mountains, Merzouga dunes, Berber camp.'],
      ['name'=>'Patagonia Explorer',        'duration'=>'12N · 13D','price'=>'From ₹2,50,000/person','desc'=>'Torres del Paine, W Trek, Grey Glacier, Perito Moreno.'],
      ['name'=>'Iceland Ring Road',         'duration'=>'10N · 11D','price'=>'From ₹2,00,000/person','desc'=>'Northern Lights, geysers, waterfalls, glacier hike, whale watching.'],
    ],
    'destinations' => ['nepal','iceland','new-zealand','marrakech','switzerland','zermatt'],
    'testimonial' => ['quote'=>'The Everest Base Camp trek was the hardest and most rewarding thing I\'ve ever done. The TravelWorld team made it safe and unforgettable.','author'=>'Vikram Singh, Delhi'],
  ],
  'luxury' => [
    'title'    => 'Luxury Escapes',
    'tagline'  => 'The Finest in Every Detail',
    'icon'     => 'fas fa-gem',
    'hero_img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=85',
    'intro'    => 'True luxury is not about price — it\'s about perfection. The right room at the right hotel, the table with the best view, the guide who knows the back door to the museum. We have spent years building relationships with the world\'s finest hotels, restaurants and experience providers so that our clients receive access that money alone cannot buy.',
    'includes' => [
      ['icon'=>'fas fa-plane',       'title'=>'Business/First Class', 'desc'=>'Premium cabin flights with lounge access and priority boarding'],
      ['icon'=>'fas fa-hotel',       'title'=>'5-Star Hotels',        'desc'=>'The world\'s finest hotels — suite upgrades and VIP amenities'],
      ['icon'=>'fas fa-car',         'title'=>'Chauffeur Service',    'desc'=>'Private chauffeur-driven vehicles throughout your journey'],
      ['icon'=>'fas fa-star',        'title'=>'Michelin Dining',      'desc'=>'Reservations at the world\'s best restaurants — secured in advance'],
      ['icon'=>'fas fa-user-tie',    'title'=>'Personal Concierge',   'desc'=>'Dedicated concierge available 24/7 for any request'],
      ['icon'=>'fas fa-spa',         'title'=>'Spa & Wellness',       'desc'=>'Access to the finest spas and wellness retreats worldwide'],
      ['icon'=>'fas fa-ticket-alt',  'title'=>'VIP Access',           'desc'=>'Skip-the-line access to museums, events and experiences'],
      ['icon'=>'fas fa-gem',         'title'=>'Exclusive Experiences','desc'=>'Private tours, after-hours museum visits, helicopter transfers'],
    ],
    'packages' => [
      ['name'=>'Dubai Ultra Luxury',        'duration'=>'5N · 6D', 'price'=>'From ₹3,00,000/couple','desc'=>'Burj Al Arab suite, helicopter tour, private desert safari, yacht dinner.'],
      ['name'=>'Maldives Private Island',   'duration'=>'7N · 8D', 'price'=>'From ₹5,00,000/couple','desc'=>'Private island resort, seaplane transfer, underwater dining, spa.'],
      ['name'=>'Swiss Alps Grand Tour',     'duration'=>'10N · 11D','price'=>'From ₹4,00,000/couple','desc'=>'Glacier Express, Zermatt, Jungfraujoch, luxury chalets throughout.'],
      ['name'=>'Amalfi & Capri',            'duration'=>'8N · 9D', 'price'=>'From ₹3,50,000/couple','desc'=>'Le Sirenuse Positano, private yacht, Capri villa, Michelin dining.'],
    ],
    'destinations' => ['dubai','maldives','switzerland','amalfi','santorini','paris'],
    'testimonial' => ['quote'=>'The level of detail and personalisation was extraordinary. Every hotel knew our names, our preferences, our anniversary. Truly world-class service.','author'=>'Ananya & Arjun Mehta, Mumbai'],
  ],
  'family' => [
    'title'    => 'Family Holidays',
    'tagline'  => 'Memories for a Lifetime',
    'icon'     => 'fas fa-users',
    'hero_img' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=1600&q=85',
    'intro'    => 'Family travel is our speciality — because we know that keeping everyone happy, from grandparents to toddlers, requires a very particular kind of expertise. We design itineraries that balance adventure with relaxation, culture with fun, and always ensure that the logistics are seamless so parents can actually enjoy the holiday.',
    'includes' => [
      ['icon'=>'fas fa-child',       'title'=>'Kid-Friendly Activities','desc'=>'Age-appropriate experiences that children will love'],
      ['icon'=>'fas fa-hotel',       'title'=>'Family Rooms/Villas',  'desc'=>'Spacious accommodation with connecting rooms or private villas'],
      ['icon'=>'fas fa-utensils',    'title'=>'Family Dining',        'desc'=>'Restaurants with children\'s menus and flexible dining times'],
      ['icon'=>'fas fa-car',         'title'=>'Private Transfers',    'desc'=>'Spacious vehicles with child seats and extra luggage space'],
      ['icon'=>'fas fa-first-aid',   'title'=>'Medical Support',      'desc'=>'Paediatric-aware guides and emergency medical contacts'],
      ['icon'=>'fas fa-plane',       'title'=>'Flights',              'desc'=>'Family seating arrangements and priority boarding'],
      ['icon'=>'fas fa-map',         'title'=>'Flexible Itinerary',   'desc'=>'Built-in flexibility for nap times, slow mornings and spontaneity'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Family concierge available around the clock'],
    ],
    'packages' => [
      ['name'=>'Singapore & Bali Family',   'duration'=>'10N · 11D','price'=>'From ₹1,80,000/family','desc'=>'Universal Studios, Singapore Zoo, Bali water parks, beach resort.'],
      ['name'=>'Thailand Family Adventure', 'duration'=>'8N · 9D', 'price'=>'From ₹1,20,000/family','desc'=>'Bangkok temples, Chiang Mai elephants, Phuket beach resort.'],
      ['name'=>'Sydney & Gold Coast',       'duration'=>'10N · 11D','price'=>'From ₹2,50,000/family','desc'=>'Sydney Opera House, Taronga Zoo, Gold Coast theme parks, beaches.'],
      ['name'=>'Dubai Family Fun',          'duration'=>'6N · 7D', 'price'=>'From ₹1,50,000/family','desc'=>'Dubai Mall, Legoland, desert safari, Atlantis Aquaventure.'],
    ],
    'destinations' => ['singapore','bali','sydney','dubai','thailand','malaysia'],
    'testimonial' => ['quote'=>'Travelling with three kids under 10 used to be stressful. TravelWorld made our Bali trip the most relaxed and fun holiday we\'ve ever had.','author'=>'The Sharma Family, Bangalore'],
  ],
  'corporate' => [
    'title'    => 'Corporate Travel',
    'tagline'  => 'Business Class, Every Time',
    'icon'     => 'fas fa-briefcase',
    'hero_img' => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1600&q=85',
    'intro'    => 'Corporate travel demands precision, reliability and discretion. We manage end-to-end business travel for companies of all sizes — from individual executive trips to large-scale MICE events and incentive programmes. Our corporate clients trust us because we deliver, every time.',
    'includes' => [
      ['icon'=>'fas fa-plane',       'title'=>'Flight Management',    'desc'=>'Business class bookings, upgrades and flexible change policies'],
      ['icon'=>'fas fa-hotel',       'title'=>'Hotel Contracts',      'desc'=>'Negotiated corporate rates at preferred hotels worldwide'],
      ['icon'=>'fas fa-car',         'title'=>'Ground Transport',     'desc'=>'Chauffeur service, airport transfers and local transport'],
      ['icon'=>'fas fa-calendar',    'title'=>'MICE Events',          'desc'=>'Meetings, incentives, conferences and exhibitions managed end-to-end'],
      ['icon'=>'fas fa-file-invoice','title'=>'Expense Reporting',    'desc'=>'Detailed invoicing and expense management for finance teams'],
      ['icon'=>'fas fa-shield-alt',  'title'=>'Travel Insurance',     'desc'=>'Comprehensive corporate travel insurance for all employees'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Dedicated corporate account manager and emergency line'],
      ['icon'=>'fas fa-chart-line',  'title'=>'Travel Analytics',     'desc'=>'Monthly reports on travel spend, patterns and savings'],
    ],
    'packages' => [
      ['name'=>'Executive Travel Management','duration'=>'Ongoing',  'price'=>'Custom Pricing',       'desc'=>'Dedicated account manager, preferred rates, 24/7 support.'],
      ['name'=>'Incentive Trip — Dubai',    'duration'=>'4N · 5D', 'price'=>'From ₹80,000/person', 'desc'=>'Desert safari, Burj Khalifa, yacht dinner, luxury hotel.'],
      ['name'=>'Team Retreat — Bali',       'duration'=>'5N · 6D', 'price'=>'From ₹70,000/person', 'desc'=>'Private villa, team activities, spa, cultural experiences.'],
      ['name'=>'Conference — Singapore',    'duration'=>'3N · 4D', 'price'=>'From ₹60,000/person', 'desc'=>'Marina Bay Sands conference facilities, gala dinner, city tour.'],
    ],
    'destinations' => ['dubai','singapore','new-york','istanbul','bali','thailand'],
    'testimonial' => ['quote'=>'TravelWorld manages all our corporate travel. Their attention to detail and responsiveness is unmatched — they\'ve saved us both time and money.','author'=>'Rajesh Kumar, CFO, TechCorp India'],
  ],
  'cruise' => [
    'title'    => 'Cruise Packages',
    'tagline'  => 'Sail the World in Style',
    'icon'     => 'fas fa-ship',
    'hero_img' => 'https://images.unsplash.com/photo-1548574505-5e239809ee19?w=1600&q=85',
    'intro'    => 'A cruise is the most effortless way to see the world — unpack once, wake up in a new destination every morning, and enjoy world-class dining, entertainment and service throughout. We partner with the world\'s finest cruise lines to offer itineraries across every ocean.',
    'includes' => [
      ['icon'=>'fas fa-ship',        'title'=>'Cruise Booking',       'desc'=>'Best cabins on the world\'s finest cruise lines'],
      ['icon'=>'fas fa-plane',       'title'=>'Flights',              'desc'=>'Flights to and from embarkation ports'],
      ['icon'=>'fas fa-hotel',       'title'=>'Pre/Post Hotels',      'desc'=>'Hotel stays before and after your cruise'],
      ['icon'=>'fas fa-car',         'title'=>'Port Transfers',       'desc'=>'Private transfers between airport, hotel and port'],
      ['icon'=>'fas fa-map',         'title'=>'Shore Excursions',     'desc'=>'Curated excursions at every port of call'],
      ['icon'=>'fas fa-utensils',    'title'=>'Dining Packages',      'desc'=>'Specialty restaurant reservations and dining credits'],
      ['icon'=>'fas fa-spa',         'title'=>'Spa Credits',          'desc'=>'Onboard spa packages and wellness credits'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Dedicated cruise concierge throughout your voyage'],
    ],
    'packages' => [
      ['name'=>'Mediterranean Splendour',   'duration'=>'10N · 11D','price'=>'From ₹2,00,000/couple','desc'=>'Barcelona, Marseille, Rome, Athens, Santorini, Dubrovnik.'],
      ['name'=>'Norwegian Fjords',          'duration'=>'8N · 9D', 'price'=>'From ₹2,50,000/couple','desc'=>'Bergen, Flam, Geiranger, Alesund — fjords and Northern Lights.'],
      ['name'=>'Caribbean Paradise',        'duration'=>'7N · 8D', 'price'=>'From ₹1,80,000/couple','desc'=>'Miami, Bahamas, Jamaica, Cayman Islands, Cozumel.'],
      ['name'=>'Southeast Asia Cruise',     'duration'=>'10N · 11D','price'=>'From ₹1,50,000/couple','desc'=>'Singapore, Penang, Phuket, Ho Chi Minh City, Hong Kong.'],
    ],
    'destinations' => ['santorini','dubrovnik','singapore','istanbul','amsterdam','sydney'],
    'testimonial' => ['quote'=>'Our Mediterranean cruise was the perfect holiday — new cities every day, incredible food, and we never had to worry about logistics. Pure bliss.','author'=>'Meera & Suresh Patel, Ahmedabad'],
  ],
  'group' => [
    'title'    => 'Group Tours',
    'tagline'  => 'Better Together',
    'icon'     => 'fas fa-people-group',
    'hero_img' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=1600&q=85',
    'intro'    => 'There is something magical about sharing a journey with others — the shared wonder at a new landscape, the laughter over a meal, the friendships that form when strangers become travel companions. Our group tours are carefully curated for small groups of 8–16 people, ensuring a personal experience with the energy of a group.',
    'includes' => [
      ['icon'=>'fas fa-user-tie',    'title'=>'Tour Leader',          'desc'=>'Experienced, multilingual tour leader throughout'],
      ['icon'=>'fas fa-hotel',       'title'=>'Accommodation',        'desc'=>'Handpicked hotels — twin sharing with single supplement option'],
      ['icon'=>'fas fa-bus',         'title'=>'Group Transport',      'desc'=>'Private coach or minibus for all group transfers'],
      ['icon'=>'fas fa-utensils',    'title'=>'Meals',                'desc'=>'Breakfast daily, select lunches and dinners included'],
      ['icon'=>'fas fa-ticket-alt',  'title'=>'Entrance Fees',        'desc'=>'All major attraction entrance fees included'],
      ['icon'=>'fas fa-plane',       'title'=>'Flights',              'desc'=>'Group flights with preferred seating arrangements'],
      ['icon'=>'fas fa-camera',      'title'=>'Photography Stops',    'desc'=>'Planned stops at the most photogenic locations'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Emergency support line active throughout the tour'],
    ],
    'packages' => [
      ['name'=>'Best of Europe',            'duration'=>'14N · 15D','price'=>'From ₹1,80,000/person','desc'=>'Paris, Swiss Alps, Venice, Rome, Amalfi, Barcelona.'],
      ['name'=>'Southeast Asia Explorer',   'duration'=>'12N · 13D','price'=>'From ₹1,20,000/person','desc'=>'Bangkok, Chiang Mai, Bali, Singapore, Kuala Lumpur.'],
      ['name'=>'Morocco & Spain',           'duration'=>'10N · 11D','price'=>'From ₹1,40,000/person','desc'=>'Marrakech, Sahara, Fes, Seville, Granada, Barcelona.'],
      ['name'=>'Japan Discovery',           'duration'=>'12N · 13D','price'=>'From ₹2,00,000/person','desc'=>'Tokyo, Kyoto, Osaka, Hiroshima, Nara, Mt. Fuji.'],
    ],
    'destinations' => ['paris','marrakech','tokyo','bali','istanbul','amsterdam'],
    'testimonial' => ['quote'=>'I was nervous about travelling with strangers, but by day 3 we were all friends. The TravelWorld group tour to Japan was the best decision I ever made.','author'=>'Sneha Nair, Solo Traveller, Chennai'],
  ],
  'solo' => [
    'title'    => 'Solo Travel',
    'tagline'  => 'Your Journey, Your Rules',
    'icon'     => 'fas fa-person-walking',
    'hero_img' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600&q=85',
    'intro'    => 'Solo travel is one of the most transformative experiences a person can have — the freedom to go where you want, when you want, at your own pace. But it can also be daunting. We specialise in creating solo itineraries that give you complete freedom while ensuring you have the safety net of expert support whenever you need it.',
    'includes' => [
      ['icon'=>'fas fa-plane',       'title'=>'Flights',              'desc'=>'Best fares with flexible change and cancellation policies'],
      ['icon'=>'fas fa-hotel',       'title'=>'Accommodation',        'desc'=>'Solo-friendly hotels, boutique guesthouses and hostels'],
      ['icon'=>'fas fa-map',         'title'=>'Detailed Itinerary',   'desc'=>'Day-by-day plan with flexibility built in'],
      ['icon'=>'fas fa-car',         'title'=>'Transfers',            'desc'=>'Airport transfers and key transport arranged'],
      ['icon'=>'fas fa-user-tie',    'title'=>'Local Contacts',       'desc'=>'Trusted local contacts at every destination'],
      ['icon'=>'fas fa-shield-alt',  'title'=>'Safety Briefing',      'desc'=>'Destination-specific safety advice and emergency contacts'],
      ['icon'=>'fas fa-sim-card',    'title'=>'Local SIM',            'desc'=>'Local SIM card arranged for connectivity'],
      ['icon'=>'fas fa-headset',     'title'=>'24/7 Support',         'desc'=>'Emergency support line — you\'re never truly alone'],
    ],
    'packages' => [
      ['name'=>'Japan Solo Discovery',      'duration'=>'12N · 13D','price'=>'From ₹1,80,000/person','desc'=>'Tokyo, Kyoto, Osaka, Hiroshima — the perfect solo destination.'],
      ['name'=>'Iceland Solo Adventure',    'duration'=>'8N · 9D', 'price'=>'From ₹2,00,000/person','desc'=>'Ring Road, Northern Lights, geysers, waterfalls, glacier hike.'],
      ['name'=>'Portugal Solo Explorer',    'duration'=>'8N · 9D', 'price'=>'From ₹1,20,000/person','desc'=>'Lisbon, Sintra, Porto, Douro Valley — safe and welcoming.'],
      ['name'=>'Bali Solo Retreat',         'duration'=>'10N · 11D','price'=>'From ₹90,000/person', 'desc'=>'Ubud yoga retreat, temple tours, cooking class, beach time.'],
    ],
    'destinations' => ['tokyo','iceland','bali','amsterdam','lisbon','new-zealand'],
    'testimonial' => ['quote'=>'As a solo female traveller, I was worried about safety. TravelWorld\'s Japan itinerary was perfect — I felt safe, supported and completely free.','author'=>'Divya Krishnan, Solo Traveller, Hyderabad'],
  ],
];

if (!isset($services[$slug])) {
  header('Location: /services/');
  exit;
}

$s = $services[$slug];
$rootPath      = '../';
$serviceTitle  = $s['title'];
$pageTitle     = $serviceTitle . ' — Travel World';
$pageDesc      = substr($s['intro'] ?? '', 0, 160);
$pageKeywords  = $serviceTitle . ', luxury ' . strtolower($serviceTitle) . ', ' . strtolower($serviceTitle) . ' travel, Travel World ' . strtolower($serviceTitle);
$pageCanonical = 'https://www.travelworld.com/services/' . $slug;
$ogType        = 'website';
$ogImage       = $s['hero_img'] ?? 'https://www.travelworld.com/assets/image/logo.webp';

// ── JSON-LD: Service + BreadcrumbList ─────────────────────────────
$jsonLd = json_encode([
  '@context' => 'https://schema.org',
  '@graph'   => [
    [
      '@type'       => 'Service',
      '@id'         => 'https://www.travelworld.com/services/' . $slug . '#service',
      'name'        => $serviceTitle,
      'description' => $pageDesc,
      'url'         => 'https://www.travelworld.com/services/' . $slug,
      'provider'    => ['@id' => 'https://www.travelworld.com/#organization'],
      'serviceType' => $serviceTitle,
      'areaServed'  => 'Worldwide',
      'image'       => $ogImage,
      'offers'      => [
        '@type'       => 'Offer',
        'name'        => $serviceTitle,
        'description' => $pageDesc,
        'url'         => 'https://www.travelworld.com/services/' . $slug,
        'seller'      => ['@id' => 'https://www.travelworld.com/#organization'],
      ],
    ],
    [
      '@type'           => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => 'https://www.travelworld.com/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://www.travelworld.com/services/'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $serviceTitle, 'item' => 'https://www.travelworld.com/services/' . $slug],
      ],
    ],
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include __DIR__ . '/../includes/page-header.php';

$relatedImages = [
  'dubai'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80',
  'bali'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80',
  'maldives'=>'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80',
  'santorini'=>'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=600&q=80',
  'paris'=>'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80',
  'amalfi'=>'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=600&q=80',
  'switzerland'=>'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80',
  'zermatt'=>'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=600&q=80',
  'singapore'=>'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=600&q=80',
  'sydney'=>'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=600&q=80',
  'thailand'=>'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=80',
  'malaysia'=>'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=600&q=80',
  'marrakech'=>'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=600&q=80',
  'nepal'=>'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=80',
  'iceland'=>'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600&q=80',
  'new-zealand'=>'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=600&q=80',
  'istanbul'=>'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=600&q=80',
  'amsterdam'=>'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=600&q=80',
  'new-york'=>'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=600&q=80',
  'tokyo'=>'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80',
  'dubrovnik'=>'https://images.unsplash.com/photo-1555990793-da11153b2473?w=600&q=80',
  'lisbon'=>'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?w=600&q=80',
];
?>

<!-- Hero -->
<section class="page-hero">
  <div class="page-hero-bg" style="background-image:url('<?php echo $s['hero_img']; ?>')"></div>
  <div class="page-hero-overlay"></div>
  <div class="page-hero-content">
    <div class="page-hero-breadcrumb">
      <a href="/">Home</a><span>›</span>
      <a href="/services">Services</a><span>›</span>
      <span><?php echo $s['title']; ?></span>
    </div>
    <h1 class="page-hero-title"><?php echo $s['title']; ?></h1>
    <p class="page-hero-tagline"><?php echo $s['tagline']; ?></p>
  </div>
</section>

<!-- Intro -->
<section class="inner-section">
  <div class="overview-grid">
    <div class="overview-text reveal">
      <div class="section-label">About This Service</div>
      <h2 class="section-title"><?php echo $s['tagline']; ?></h2>
      <p><?php echo $s['intro']; ?></p>
    </div>
    <div class="reveal" style="display:flex;flex-direction:column;gap:1rem;">
      <div class="tip-card" style="margin:0;">
        <i class="<?php echo $s['icon']; ?>"></i>
        <h5>Why Choose TravelWorld for <?php echo $s['title']; ?>?</h5>
        <p>Our specialists have personally experienced every destination and service we recommend. We don't just book travel — we craft experiences.</p>
      </div>
      <div class="tip-card" style="margin:0;">
        <i class="fas fa-phone"></i>
        <h5>Free Consultation</h5>
        <p>Call us on +91 99040 40001 or WhatsApp us to discuss your <?php echo strtolower($s['title']); ?> plans — free, no obligation.</p>
      </div>
    </div>
  </div>
</section>

<!-- What's Included -->
<section class="inner-section alt">
  <div class="section-label reveal">What's Included</div>
  <h2 class="section-title reveal">Everything Taken Care Of</h2>
  <div class="tips-grid" style="margin-top:2rem;">
    <?php foreach ($s['includes'] as $inc): ?>
    <div class="tip-card reveal">
      <i class="<?php echo $inc['icon']; ?>"></i>
      <h5><?php echo $inc['title']; ?></h5>
      <p><?php echo $inc['desc']; ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Packages -->
<section class="inner-section">
  <div class="section-label reveal">Our Packages</div>
  <h2 class="section-title reveal">Popular <?php echo $s['title']; ?></h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;margin-top:2.5rem;">
    <?php foreach ($s['packages'] as $pkg): ?>
    <div class="tip-card reveal" style="position:relative;">
      <i class="fas fa-map-marked-alt"></i>
      <h5><?php echo $pkg['name']; ?></h5>
      <p style="margin-bottom:0.8rem;"><?php echo $pkg['desc']; ?></p>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;padding-top:0.8rem;border-top:1px solid rgba(255,255,255,0.06);">
        <span style="font-family:'Inter',sans-serif;font-size:0.7rem;color:var(--gray);"><?php echo $pkg['duration']; ?></span>
        <span style="font-family:'Inter',sans-serif;font-size:0.78rem;color:var(--gold);font-weight:600;"><?php echo $pkg['price']; ?></span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Popular Destinations for this service -->
<section class="inner-section alt">
  <div class="section-label reveal">Top Destinations</div>
  <h2 class="section-title reveal">Best Places for <?php echo $s['title']; ?></h2>
  <div class="related-grid" style="margin-top:2.5rem;">
    <?php foreach (array_slice($s['destinations'], 0, 3) as $dSlug): ?>
    <?php
      $dImg  = $relatedImages[$dSlug] ?? 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=600&q=80';
      $dName = ucwords(str_replace('-', ' ', $dSlug));
      $dDataFile = __DIR__ . '/../destinations/data/' . $dSlug . '.php';
      if (file_exists($dDataFile)) {
        $dData = include $dDataFile;
        $dName = $dData['name'];
        $dImg  = $dData['hero_image'];
      }
    ?>
    <a href="/destinations/<?php echo $dSlug; ?>" class="related-card reveal">
      <img src="<?php echo $dImg; ?>" alt="<?php echo $dName; ?>" loading="lazy">
      <div class="related-card-overlay">
        <div class="related-card-name"><?php echo $dName; ?></div>
        <div class="related-card-tag">Explore →</div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Testimonial -->
<section class="inner-section">
  <div class="section-label reveal">What Our Clients Say</div>
  <div class="reveal" style="max-width:700px;margin:2rem auto;text-align:center;">
    <div style="font-size:3rem;color:var(--gold);margin-bottom:1rem;opacity:0.4;">"</div>
    <p style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:300;color:var(--white);line-height:1.6;margin-bottom:1.5rem;font-style:italic;">
      <?php echo $s['testimonial']['quote']; ?>
    </p>
    <p style="font-family:'Inter',sans-serif;font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);">
      — <?php echo $s['testimonial']['author']; ?>
    </p>
  </div>
</section>

<!-- CTA -->
<section class="enquiry-cta">
  <div class="section-label">Start Planning</div>
  <h2 class="section-title">Book Your <?php echo $s['title']; ?></h2>
  <p class="section-subtitle" style="margin:0 auto 2.5rem;">Tell us your dream — our specialists will craft the perfect itinerary.</p>
  <div style="max-width:700px;margin:0 auto;">
    <form class="enquiry-form" id="enquiryForm">
      <input type="text"  name="name"  placeholder="Your Name"       required>
      <input type="email" name="email" placeholder="Email Address"    required>
      <input type="tel"   name="phone" placeholder="Phone / WhatsApp" required>
      <input type="text"  name="dest"  placeholder="Preferred Destination(s)">
      <input type="text"  name="dates" placeholder="Travel Dates">
      <select name="budget">
        <option value="" disabled selected>Budget Range</option>
        <option>Under ₹1,00,000</option>
        <option>₹1,00,000 – ₹2,00,000</option>
        <option>₹2,00,000 – ₹5,00,000</option>
        <option>₹5,00,000+</option>
      </select>
      <textarea name="message" placeholder="Tell us more about your plans…" style="grid-column:1/-1;"></textarea>
      <button type="submit" class="btn-submit" style="grid-column:1/-1;">
        Enquire Now <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
      </button>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/page-footer.php'; ?>