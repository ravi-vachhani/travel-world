<?php
return [
    'name' => 'Costa Rica',
    'country' => 'Costa Rica',
    'continent' => 'Americas',
    'slug' => 'costa-rica',
    'tagline' => 'Pura Vida — Nature\'s Ultimate Adventure',
    'hero_image' => 'https://images.unsplash.com/photo-1518259102261-b40117eabbc9?w=1600&q=80',
    'best_time' => 'Dec–Apr (Dry Season)',
    'duration' => '7–10 Days',
    'currency' => 'Costa Rican Colón (CRC)',
    'language' => 'Spanish',
    'visa' => 'Visa on Arrival (90 days)',
    'flight_time' => '~22 hrs from India',
    'budget' => '₹1,80,000–₹3,00,000',
    'overview' => 'Costa Rica is the world\'s premier eco-tourism destination — a tiny Central American nation that protects over 25% of its territory in national parks and reserves. Home to 5% of the world\'s biodiversity, Costa Rica packs extraordinary natural wonders into a small space: active volcanoes, cloud forests draped in mist, Pacific and Caribbean coastlines, and rainforests teeming with sloths, toucans, and jaguars. The national philosophy of "Pura Vida" (Pure Life) permeates everything, making Costa Rica not just a destination but a way of experiencing the world.',

    'must_visit' => [
        [
            'name' => 'Arenal Volcano',
            'category' => 'Volcano',
            'desc' => 'Costa Rica\'s most iconic volcano, rising 1,670m above the rainforest, with hot springs, zip-lines, and adventure activities.',
            'img' => 'https://images.unsplash.com/photo-1518259102261-b40117eabbc9?w=800&q=80',
        ],
        [
            'name' => 'Manuel Antonio',
            'category' => 'National Park',
            'desc' => 'A stunning national park where rainforest meets Pacific beaches — spot monkeys, sloths, and iguanas steps from the ocean.',
            'img' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80',
        ],
        [
            'name' => 'Monteverde Cloud Forest',
            'category' => 'Cloud Forest',
            'desc' => 'Walk suspended bridges through misty cloud forests, home to the resplendent quetzal, jaguars, and 400+ bird species.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Tortuguero',
            'category' => 'Wildlife Sanctuary',
            'desc' => 'A remote Caribbean jungle accessible only by boat or plane, famous for sea turtle nesting and canal wildlife tours.',
            'img' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=800&q=80',
        ],
        [
            'name' => 'Corcovado National Park',
            'category' => 'Rainforest',
            'desc' => 'National Geographic called it "the most biologically intense place on Earth" — pristine rainforest with tapirs, scarlet macaws, and pumas.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Nicoya Peninsula',
            'category' => 'Beach Paradise',
            'desc' => 'A Blue Zone peninsula with world-class surf beaches, yoga retreats, and some of Costa Rica\'s most beautiful Pacific coastline.',
            'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'name' => 'San José',
            'category' => 'Capital City',
            'desc' => 'Costa Rica\'s vibrant capital with excellent museums, the Central Market, and the gateway to all national parks.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'White Water Rafting', 'desc' => 'Raft the Pacuare River — one of the world\'s top 10 rafting rivers — through pristine jungle gorges and Class IV rapids.'],
            ['title' => 'Zip-lining', 'desc' => 'Soar through the Monteverde cloud forest canopy on zip-lines, some stretching over 1 km above the treetops.'],
            ['title' => 'Surfing', 'desc' => 'Catch world-class waves at Tamarindo, Jacó, Dominical, or Puerto Viejo — Costa Rica has breaks for all skill levels.'],
        ],
        'culture' => [
            ['title' => 'Coffee Farm Tour', 'desc' => 'Visit a traditional Costa Rican coffee farm in the Central Valley to learn how the world\'s finest coffee is grown and processed.'],
            ['title' => 'Indigenous Communities', 'desc' => 'Visit Boruca or Bribri indigenous communities to learn about traditional crafts, medicine, and Costa Rican heritage.'],
            ['title' => 'Pura Vida Cooking Class', 'desc' => 'Learn to cook traditional Costa Rican dishes — gallo pinto, casado, and tres leches cake — with a local family.'],
        ],
        'food' => [
            ['title' => 'Gallo Pinto', 'desc' => 'Start every morning with Costa Rica\'s beloved national dish — rice and black beans fried together with Lizano sauce.'],
            ['title' => 'Fresh Tropical Fruits', 'desc' => 'Feast on exotic fruits — maracuyá, guanábana, mamón chino, and star fruit — from roadside stands and markets.'],
            ['title' => 'Caribbean Cuisine', 'desc' => 'Try the distinct Afro-Caribbean flavors of Puerto Viejo — rice and beans cooked in coconut milk, jerk chicken, and patí.'],
        ],
        'shopping' => [
            ['title' => 'Mercado Central San José', 'desc' => 'Browse Costa Rica\'s largest covered market for coffee, spices, leather goods, and traditional crafts.'],
            ['title' => 'Boruca Masks', 'desc' => 'Buy hand-carved and painted balsa wood masks from the Boruca indigenous people — unique Costa Rican art.'],
            ['title' => 'Organic Coffee & Chocolate', 'desc' => 'Take home single-origin Costa Rican coffee and artisan chocolate from small-batch producers.'],
        ],
    ],

    'itineraries' => [
        '7days' => [
            ['day' => 'Day 1', 'title' => 'San José Arrival', 'activities' => ['Arrive San José', 'Pre-Columbian Gold Museum', 'Central Market', 'Welcome dinner']],
            ['day' => 'Day 2', 'title' => 'Arenal Volcano', 'activities' => ['Drive to La Fortuna', 'Arenal Volcano views', 'La Fortuna waterfall hike', 'Hot springs evening']],
            ['day' => 'Day 3', 'title' => 'Arenal Adventure', 'activities' => ['White water rafting Balsa River', 'Hanging bridges walk', 'Zip-lining', 'Tabacón hot springs']],
            ['day' => 'Day 4', 'title' => 'Monteverde', 'activities' => ['Drive to Monteverde', 'Cloud forest reserve', 'Suspended bridges', 'Hummingbird garden']],
            ['day' => 'Day 5', 'title' => 'Monteverde Activities', 'activities' => ['Zip-lining canopy tour', 'Coffee farm tour', 'Cheese factory visit', 'Sunset views']],
            ['day' => 'Day 6', 'title' => 'Manuel Antonio', 'activities' => ['Drive to Manuel Antonio', 'National park wildlife walk', 'Beach afternoon', 'Seafood dinner']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['Morning beach', 'Return to San José', 'Last gallo pinto breakfast', 'Departure']],
        ],
        '10days' => [
            ['day' => 'Day 1', 'title' => 'San José', 'activities' => ['Arrive, city exploration', 'Gold Museum', 'Barrio Amón']],
            ['day' => 'Day 2', 'title' => 'Coffee Valley', 'activities' => ['Coffee farm tour', 'Poás Volcano', 'La Paz Waterfall Gardens']],
            ['day' => 'Day 3', 'title' => 'Arenal', 'activities' => ['La Fortuna arrival', 'Waterfall hike', 'Hot springs']],
            ['day' => 'Day 4', 'title' => 'Arenal Adventure', 'activities' => ['Rafting Pacuare River', 'Hanging bridges', 'Zip-lining']],
            ['day' => 'Day 5', 'title' => 'Tortuguero', 'activities' => ['Boat to Tortuguero', 'Canal wildlife tour', 'Turtle nesting (seasonal)']],
            ['day' => 'Day 6', 'title' => 'Monteverde', 'activities' => ['Cloud forest reserve', 'Suspended bridges', 'Night walk']],
            ['day' => 'Day 7', 'title' => 'Nicoya Peninsula', 'activities' => ['Drive to Tamarindo', 'Surf lesson', 'Beach sunset']],
            ['day' => 'Day 8', 'title' => 'Pacific Coast', 'activities' => ['Snorkeling Catalina Islands', 'Playa Conchal', 'Sunset cruise']],
            ['day' => 'Day 9', 'title' => 'Manuel Antonio', 'activities' => ['National park', 'Wildlife spotting', 'Beach day']],
            ['day' => 'Day 10', 'title' => 'Departure', 'activities' => ['Return to San José', 'Last shopping', 'Departure']],
        ],
    ],

    'related' => ['cancun', 'peru', 'rio'],
];