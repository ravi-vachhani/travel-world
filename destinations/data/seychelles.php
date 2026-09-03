<?php
return [
    'name' => 'Seychelles',
    'country' => 'Seychelles',
    'continent' => 'Africa',
    'slug' => 'seychelles',
    'tagline' => 'Paradise Islands of the Indian Ocean',
    'hero_image' => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=1600&q=80',
    'best_time' => 'Apr–May, Oct–Nov',
    'duration' => '5–8 Days',
    'currency' => 'Seychellois Rupee (SCR)',
    'language' => 'Seychellois Creole, English, French',
    'visa' => 'Visa on Arrival',
    'flight_time' => '~6 hrs from India',
    'budget' => '₹2,00,000–₹5,00,000',
    'overview' => 'Seychelles is the definition of paradise — an archipelago of 115 granite and coral islands scattered across the Indian Ocean, with beaches so perfect they seem computer-generated. The iconic pink-granite boulders of Anse Source d\'Argent on La Digue are among the most photographed beaches on Earth. Seychelles offers extraordinary biodiversity: the Vallée de Mai palm forest where the legendary coco de mer grows, giant Aldabra tortoises roaming free, and coral reefs teeming with marine life. For Indian travelers, Seychelles is a short flight away and offers a visa on arrival — making it one of the most accessible luxury island destinations.',

    'must_visit' => [
        [
            'name' => 'Anse Source d\'Argent',
            'category' => 'Iconic Beach',
            'desc' => 'Consistently ranked among the world\'s most beautiful beaches — pink granite boulders, turquoise lagoon, and white sand on La Digue.',
            'img' => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=800&q=80',
        ],
        [
            'name' => 'Vallée de Mai',
            'category' => 'UNESCO Heritage',
            'desc' => 'A primeval palm forest on Praslin island, UNESCO World Heritage Site, home to the legendary coco de mer palm.',
            'img' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80',
        ],
        [
            'name' => 'Aldabra Atoll',
            'category' => 'UNESCO Heritage',
            'desc' => 'The world\'s largest raised coral atoll and UNESCO site, home to 100,000 giant Aldabra tortoises.',
            'img' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=800&q=80',
        ],
        [
            'name' => 'Anse Lazio',
            'category' => 'Beach',
            'desc' => 'Praslin\'s most beautiful beach — a crescent of golden sand framed by granite boulders and crystal-clear water.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Mahé Island',
            'category' => 'Main Island',
            'desc' => 'The largest island with the capital Victoria, Morne Seychellois National Park, and some of the finest beaches.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'La Digue Island',
            'category' => 'Island',
            'desc' => 'A car-free island of extraordinary beauty — explore by bicycle past granite boulders, vanilla plantations, and turquoise coves.',
            'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'name' => 'Coral Reef Snorkeling',
            'category' => 'Marine Life',
            'desc' => 'Snorkel and dive among vibrant coral gardens, sea turtles, manta rays, and whale sharks in the Indian Ocean.',
            'img' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Snorkeling & Diving', 'desc' => 'Explore Seychelles\' pristine coral reefs at Sainte Anne Marine Park, Shark Bank, and the outer islands.'],
            ['title' => 'Island Hopping', 'desc' => 'Take ferries and speedboats between Mahé, Praslin, and La Digue — each island with its own distinct character.'],
            ['title' => 'Deep Sea Fishing', 'desc' => 'Charter a boat for deep-sea fishing in the Indian Ocean — marlin, sailfish, and yellowfin tuna abound.'],
        ],
        'culture' => [
            ['title' => 'Victoria Market', 'desc' => 'Explore the colorful Sir Selwyn Selwyn-Clarke Market in Victoria for tropical fruits, spices, and Creole crafts.'],
            ['title' => 'Creole Festival', 'desc' => 'Experience the annual Creole Festival in October — music, dance, food, and the vibrant Seychellois culture.'],
            ['title' => 'Giant Tortoise Sanctuary', 'desc' => 'Visit the Seychelles Giant Tortoise Sanctuary on Curieuse Island to walk among these ancient creatures.'],
        ],
        'food' => [
            ['title' => 'Creole Cuisine', 'desc' => 'Savor Seychellois Creole cooking — grilled fish with coconut curry, octopus salad, and breadfruit chips.'],
            ['title' => 'Fresh Seafood', 'desc' => 'Feast on the freshest Indian Ocean seafood — red snapper, parrotfish, lobster, and prawns at beachside restaurants.'],
            ['title' => 'Coco de Mer Products', 'desc' => 'Try unique Seychellois products made from the legendary coco de mer — the world\'s largest seed.'],
        ],
        'shopping' => [
            ['title' => 'Coco de Mer Souvenirs', 'desc' => 'Buy authentic coco de mer products — the world\'s largest nut, unique to Seychelles, as a one-of-a-kind souvenir.'],
            ['title' => 'Seychellois Crafts', 'desc' => 'Find handmade batik fabrics, coconut shell crafts, and local artwork at Victoria\'s craft markets.'],
            ['title' => 'Vanilla & Spices', 'desc' => 'Take home Seychellois vanilla pods, cinnamon, and exotic spices from the island\'s spice gardens.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Mahé Arrival', 'activities' => ['Arrive Mahé', 'Victoria market', 'Beau Vallon beach', 'Creole dinner']],
            ['day' => 'Day 2', 'title' => 'Mahé Exploration', 'activities' => ['Morne Seychellois hike', 'Tea factory visit', 'Anse Intendance beach', 'Sunset cocktails']],
            ['day' => 'Day 3', 'title' => 'Praslin Island', 'activities' => ['Ferry to Praslin', 'Vallée de Mai UNESCO forest', 'Anse Lazio beach', 'Overnight Praslin']],
            ['day' => 'Day 4', 'title' => 'La Digue', 'activities' => ['Ferry to La Digue', 'Bicycle to Anse Source d\'Argent', 'Grand Anse beach', 'Sunset at Anse Cocos']],
            ['day' => 'Day 5', 'title' => 'Farewell', 'activities' => ['Morning snorkeling', 'Return to Mahé', 'Last Creole lunch', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Mahé Arrival', 'activities' => ['Arrive, Victoria', 'Beau Vallon beach', 'Welcome dinner']],
            ['day' => 'Day 2', 'title' => 'Mahé', 'activities' => ['Morne Seychellois', 'Tea factory', 'Anse Intendance']],
            ['day' => 'Day 3', 'title' => 'Marine Park', 'activities' => ['Sainte Anne Marine Park snorkeling', 'Moyenne Island tortoises', 'Sunset cruise']],
            ['day' => 'Day 4', 'title' => 'Praslin', 'activities' => ['Ferry to Praslin', 'Vallée de Mai', 'Anse Lazio']],
            ['day' => 'Day 5', 'title' => 'La Digue', 'activities' => ['La Digue by bicycle', 'Anse Source d\'Argent', 'Grand Anse']],
            ['day' => 'Day 6', 'title' => 'Outer Islands', 'activities' => ['Curieuse Island tortoises', 'St. Pierre snorkeling', 'Anse Georgette']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['Return to Mahé', 'Last beach', 'Departure']],
        ],
    ],

    'related' => ['maldives', 'zanzibar', 'mauritius'],
];