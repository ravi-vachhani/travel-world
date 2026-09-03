<?php
return [
    'name' => 'Cape Town',
    'country' => 'South Africa',
    'continent' => 'Africa',
    'slug' => 'cape-town',
    'tagline' => 'The Mother City at the Edge of the World',
    'hero_image' => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=1600&q=80',
    'best_time' => 'Nov–Mar (Summer)',
    'duration' => '7–10 Days',
    'currency' => 'South African Rand (ZAR)',
    'language' => 'English, Afrikaans, Xhosa',
    'visa' => 'Visa Required',
    'flight_time' => '~11 hrs from India',
    'budget' => '₹1,80,000–₹3,50,000',
    'overview' => 'Cape Town is one of the world\'s most beautiful cities — a spectacular metropolis where the iconic Table Mountain rises above a city of beaches, vineyards, and vibrant neighborhoods. Perched at the southwestern tip of Africa where the Atlantic and Indian Oceans meet, Cape Town offers an extraordinary blend of natural wonder, cultural diversity, and cosmopolitan sophistication. From the penguin colonies of Boulders Beach to the world-class wines of Stellenbosch, from the historic Robben Island to the colorful Bo-Kaap quarter, Cape Town is a city that captivates every sense.',

    'must_visit' => [
        [
            'name' => 'Table Mountain',
            'category' => 'Natural Wonder',
            'desc' => 'Cape Town\'s iconic flat-topped mountain, a UNESCO World Heritage Site, with a cable car to the summit for 360° views.',
            'img' => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=800&q=80',
        ],
        [
            'name' => 'Cape of Good Hope',
            'category' => 'Landmark',
            'desc' => 'The dramatic southwestern tip of Africa where two oceans meet — a UNESCO Biosphere Reserve with stunning coastal scenery.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Robben Island',
            'category' => 'UNESCO Heritage',
            'desc' => 'The island prison where Nelson Mandela was held for 18 years — a powerful symbol of South Africa\'s struggle for freedom.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Boulders Beach Penguins',
            'category' => 'Wildlife',
            'desc' => 'Walk among a colony of 3,000 African penguins on this sheltered beach near Simon\'s Town — a uniquely South African experience.',
            'img' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=800&q=80',
        ],
        [
            'name' => 'V&A Waterfront',
            'category' => 'Waterfront',
            'desc' => 'Cape Town\'s vibrant working harbor, with world-class restaurants, shops, museums, and Table Mountain as a backdrop.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
        [
            'name' => 'Stellenbosch Wine Route',
            'category' => 'Wine Region',
            'desc' => 'South Africa\'s premier wine region, just 45 minutes from Cape Town, with over 150 estates producing world-class wines.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
        [
            'name' => 'Bo-Kaap',
            'category' => 'Historic Quarter',
            'desc' => 'Cape Town\'s most colorful neighborhood — pastel-painted houses, cobblestone streets, and the Cape Malay Muslim heritage.',
            'img' => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Table Mountain Hike', 'desc' => 'Hike the Platteklip Gorge trail to the summit of Table Mountain for breathtaking views over Cape Town and the ocean.'],
            ['title' => 'Shark Cage Diving', 'desc' => 'Dive with great white sharks off Gansbaai — one of the world\'s most thrilling wildlife encounters.'],
            ['title' => 'Paragliding Signal Hill', 'desc' => 'Tandem paraglide from Signal Hill over the Atlantic Seaboard for spectacular aerial views of Cape Town.'],
        ],
        'culture' => [
            ['title' => 'Robben Island Tour', 'desc' => 'Take the ferry to Robben Island for a guided tour by a former political prisoner — a deeply moving experience.'],
            ['title' => 'Bo-Kaap Cooking Class', 'desc' => 'Learn to cook Cape Malay cuisine — fragrant curries, bobotie, and koeksisters — with a local family in Bo-Kaap.'],
            ['title' => 'District Six Museum', 'desc' => 'Explore the powerful museum documenting the forced removal of 60,000 residents during apartheid.'],
        ],
        'food' => [
            ['title' => 'Cape Malay Cuisine', 'desc' => 'Taste the unique Cape Malay fusion of Malay, Indonesian, and African flavors — bobotie, bredie, and koeksisters.'],
            ['title' => 'Braai Culture', 'desc' => 'Experience South Africa\'s beloved braai (barbecue) tradition with boerewors sausages, sosaties, and pap.'],
            ['title' => 'Stellenbosch Wine & Food', 'desc' => 'Pair world-class Pinotage and Chenin Blanc wines with gourmet farm-to-table cuisine at Stellenbosch estates.'],
        ],
        'shopping' => [
            ['title' => 'Greenmarket Square', 'desc' => 'Browse Cape Town\'s oldest market for African crafts, jewelry, clothing, and curios from across the continent.'],
            ['title' => 'V&A Waterfront Shops', 'desc' => 'Shop for South African design, diamonds, wine, and luxury goods at the Waterfront\'s 450+ stores.'],
            ['title' => 'Neighbourgoods Market', 'desc' => 'Visit the Saturday market in Woodstock for artisan food, local design, vintage finds, and Cape Town\'s creative scene.'],
        ],
    ],

    'itineraries' => [
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Arrival & Waterfront', 'activities' => ['Arrive Cape Town', 'V&A Waterfront', 'Table Mountain cable car', 'Waterfront dinner']],
            ['day' => 'Day 2', 'title' => 'Cape Peninsula', 'activities' => ['Cape of Good Hope', 'Boulders Beach penguins', 'Chapman\'s Peak drive', 'Hout Bay harbor']],
            ['day' => 'Day 3', 'title' => 'City & Culture', 'activities' => ['Robben Island ferry', 'Bo-Kaap walk', 'District Six Museum', 'Long Street evening']],
            ['day' => 'Day 4', 'title' => 'Stellenbosch', 'activities' => ['Wine tasting at 3 estates', 'Franschhoek village', 'Wine tram', 'Gourmet dinner']],
            ['day' => 'Day 5', 'title' => 'Adventure Day', 'activities' => ['Table Mountain hike', 'Paragliding Signal Hill', 'Camps Bay beach', 'Sunset cocktails']],
            ['day' => 'Day 6', 'title' => 'Garden Route Start', 'activities' => ['Drive to Hermanus', 'Whale watching (seasonal)', 'Overberg coast', 'Knysna arrival']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['Greenmarket Square', 'Cape Malay cooking class', 'Last braai lunch', 'Departure']],
        ],
        '10days' => [
            ['day' => 'Day 1', 'title' => 'Cape Town Arrival', 'activities' => ['Arrive, V&A Waterfront', 'Table Mountain cable car']],
            ['day' => 'Day 2', 'title' => 'Cape Peninsula', 'activities' => ['Cape of Good Hope', 'Boulders penguins', 'Chapman\'s Peak']],
            ['day' => 'Day 3', 'title' => 'City Culture', 'activities' => ['Robben Island', 'Bo-Kaap', 'District Six Museum']],
            ['day' => 'Day 4', 'title' => 'Stellenbosch', 'activities' => ['Wine estates', 'Franschhoek', 'Wine tram']],
            ['day' => 'Day 5', 'title' => 'Adventure', 'activities' => ['Table Mountain hike', 'Shark cage diving Gansbaai', 'Paragliding']],
            ['day' => 'Day 6', 'title' => 'Garden Route', 'activities' => ['Drive to Knysna', 'Wilderness beach', 'Knysna Heads']],
            ['day' => 'Day 7', 'title' => 'Tsitsikamma', 'activities' => ['Tsitsikamma National Park', 'Storms River suspension bridge', 'Bloukrans bungee jump']],
            ['day' => 'Day 8', 'title' => 'Oudtshoorn', 'activities' => ['Cango Caves', 'Ostrich farm', 'Klein Karoo']],
            ['day' => 'Day 9', 'title' => 'Return to Cape Town', 'activities' => ['Scenic Route 62', 'Montagu hot springs', 'Cape Town return']],
            ['day' => 'Day 10', 'title' => 'Farewell', 'activities' => ['Neighbourgoods Market', 'Last wine tasting', 'Departure']],
        ],
    ],

    'related' => ['tanzania', 'zanzibar', 'mauritius'],
];