<?php
return [
    'name' => 'Cancún',
    'country' => 'Mexico',
    'continent' => 'Americas',
    'slug' => 'cancun',
    'tagline' => 'Caribbean Paradise & Mayan Wonders',
    'hero_image' => 'https://images.unsplash.com/photo-1552074284-5e88ef1aef18?w=1600&q=80',
    'best_time' => 'Dec–Apr',
    'duration' => '5–8 Days',
    'currency' => 'Mexican Peso (MXN)',
    'language' => 'Spanish',
    'visa' => 'Visa on Arrival (180 days)',
    'flight_time' => '~20 hrs from India',
    'budget' => '₹1,50,000–₹2,80,000',
    'overview' => 'Cancún is Mexico\'s crown jewel — a dazzling Caribbean resort city where turquoise waters meet white-sand beaches, ancient Mayan ruins rise from the jungle, and world-class resorts line the famous Hotel Zone. Beyond the beach clubs and nightlife, the Yucatán Peninsula offers extraordinary experiences: swimming in sacred cenotes (natural sinkholes), exploring the magnificent ruins of Chichén Itzá, and snorkeling in the world\'s second-largest coral reef. Cancún is the perfect base for discovering the magic of Mexico\'s Caribbean coast.',

    'must_visit' => [
        [
            'name' => 'Chichén Itzá',
            'category' => 'World Wonder',
            'desc' => 'One of the New Seven Wonders of the World — the magnificent Mayan pyramid El Castillo and ancient astronomical observatory.',
            'img' => 'https://images.unsplash.com/photo-1552074284-5e88ef1aef18?w=800&q=80',
        ],
        [
            'name' => 'Cancún Hotel Zone',
            'category' => 'Beach Strip',
            'desc' => 'The iconic 22 km strip of Caribbean beachfront hotels, beach clubs, restaurants, and nightlife venues.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Cenotes',
            'category' => 'Natural Wonder',
            'desc' => 'Sacred Mayan sinkholes filled with crystal-clear freshwater — swim, snorkel, or dive in these magical underground pools.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Tulum',
            'category' => 'Mayan Ruins',
            'desc' => 'Dramatic Mayan cliff-top ruins overlooking the Caribbean Sea — one of the most photographed archaeological sites in Mexico.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Isla Mujeres',
            'category' => 'Island',
            'desc' => 'A charming car-free island just 20 minutes by ferry, with pristine beaches, colorful streets, and excellent snorkeling.',
            'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'name' => 'Cozumel',
            'category' => 'Diving Paradise',
            'desc' => 'World-renowned diving destination with the Mesoamerican Barrier Reef — the second-largest coral reef system on Earth.',
            'img' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
        ],
        [
            'name' => 'Playa del Carmen',
            'category' => 'Beach Town',
            'desc' => 'The Riviera Maya\'s hippest town — the pedestrian Fifth Avenue lined with boutiques, restaurants, and beach clubs.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Cenote Diving & Snorkeling', 'desc' => 'Explore the world\'s largest underwater cave system in the Yucatán\'s cenotes — a surreal freshwater diving experience.'],
            ['title' => 'Cozumel Scuba Diving', 'desc' => 'Dive the crystal-clear waters of Cozumel\'s Palancar Reef, teeming with sea turtles, rays, and tropical fish.'],
            ['title' => 'Zip-lining in the Jungle', 'desc' => 'Soar through the Yucatán jungle canopy on zip-lines at eco-parks like Xcaret, Xel-Há, or Selvatica.'],
        ],
        'culture' => [
            ['title' => 'Chichén Itzá Day Trip', 'desc' => 'Visit the ancient Mayan city of Chichén Itzá, including El Castillo pyramid, the Ball Court, and the Sacred Cenote.'],
            ['title' => 'Tulum Ruins', 'desc' => 'Explore the only Mayan city built on a cliff overlooking the Caribbean — dramatic ruins with a stunning beach below.'],
            ['title' => 'Xcaret Eco-Park', 'desc' => 'Experience Mexico\'s culture, wildlife, and underground rivers at this spectacular eco-archaeological theme park.'],
        ],
        'food' => [
            ['title' => 'Tacos & Cochinita Pibil', 'desc' => 'Feast on authentic Yucatecan cuisine — slow-roasted cochinita pibil tacos, sopa de lima, and fresh ceviche.'],
            ['title' => 'Seafood on the Beach', 'desc' => 'Enjoy fresh grilled fish, shrimp tacos, and ceviche at beachside palapa restaurants along the Riviera Maya.'],
            ['title' => 'Mezcal & Margaritas', 'desc' => 'Sip artisanal mezcal and classic margaritas at rooftop bars in Playa del Carmen and Tulum.'],
        ],
        'shopping' => [
            ['title' => 'Mercado 28', 'desc' => 'Browse Cancún\'s main artisan market for Mexican handicrafts, silver jewelry, textiles, and souvenirs.'],
            ['title' => 'Fifth Avenue Playa', 'desc' => 'Shop the pedestrian Fifth Avenue in Playa del Carmen for boutiques, jewelry, and Mexican fashion.'],
            ['title' => 'Mayan Crafts', 'desc' => 'Find hand-carved obsidian figurines, embroidered huipil blouses, and hammocks from Mayan artisans.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Arrival & Hotel Zone', 'activities' => ['Arrive Cancún, check in', 'Hotel Zone beach', 'Sunset cocktails', 'Seafood dinner']],
            ['day' => 'Day 2', 'title' => 'Chichén Itzá', 'activities' => ['Early departure to Chichén Itzá', 'El Castillo pyramid', 'Cenote Ik Kil swim', 'Valladolid colonial town']],
            ['day' => 'Day 3', 'title' => 'Tulum & Cenotes', 'activities' => ['Tulum cliff ruins', 'Cenote Gran Cenote swim', 'Tulum beach club', 'Playa del Carmen evening']],
            ['day' => 'Day 4', 'title' => 'Island & Reef', 'activities' => ['Ferry to Isla Mujeres', 'Snorkeling at MUSA underwater museum', 'Beach lunch', 'Return to Cancún']],
            ['day' => 'Day 5', 'title' => 'Farewell', 'activities' => ['Morning beach', 'Mercado 28 shopping', 'Last tacos lunch', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Arrival', 'activities' => ['Arrive, Hotel Zone check-in', 'Beach & pool', 'Welcome dinner']],
            ['day' => 'Day 2', 'title' => 'Chichén Itzá', 'activities' => ['Chichén Itzá ruins', 'Cenote Ik Kil', 'Valladolid']],
            ['day' => 'Day 3', 'title' => 'Tulum', 'activities' => ['Tulum ruins', 'Gran Cenote', 'Tulum beach clubs']],
            ['day' => 'Day 4', 'title' => 'Cozumel Diving', 'activities' => ['Ferry to Cozumel', 'Palancar Reef diving', 'San Miguel town', 'Return']],
            ['day' => 'Day 5', 'title' => 'Playa del Carmen', 'activities' => ['Fifth Avenue shopping', 'Xcaret eco-park', 'Beach club sunset']],
            ['day' => 'Day 6', 'title' => 'Isla Mujeres', 'activities' => ['Ferry to Isla Mujeres', 'Golf cart island tour', 'Snorkeling', 'Sunset dinner']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['Last beach morning', 'Mercado 28', 'Departure']],
        ],
    ],

    'related' => ['rio', 'peru', 'costa-rica'],
];