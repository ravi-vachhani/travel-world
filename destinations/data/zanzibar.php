<?php
return [
    'name' => 'Zanzibar',
    'country' => 'Tanzania',
    'continent' => 'Africa',
    'slug' => 'zanzibar',
    'tagline' => 'The Spice Island of the Indian Ocean',
    'hero_image' => 'https://images.unsplash.com/photo-1590523741831-ab7e8b8f9c7f?w=1600&q=80',
    'best_time' => 'Jun–Oct, Dec–Feb',
    'duration' => '5–8 Days',
    'currency' => 'Tanzanian Shilling (TZS)',
    'language' => 'Swahili, English',
    'visa' => 'e-Visa Required',
    'flight_time' => '~10 hrs from India',
    'budget' => '₹1,20,000–₹2,50,000',
    'overview' => 'Zanzibar is a dream island — a semi-autonomous archipelago off the coast of Tanzania where turquoise Indian Ocean waters lap against powder-white beaches, ancient dhows sail at sunset, and the air is perfumed with cloves, cinnamon, and vanilla. The UNESCO-listed Stone Town is a labyrinth of carved wooden doors, mosques, and bazaars that reflects centuries of Arab, Persian, Indian, and African trade. For Indian travelers, Zanzibar holds a special resonance — the island\'s history is deeply intertwined with Indian Ocean trade, and the Swahili culture bears unmistakable Indian influences.',

    'must_visit' => [
        [
            'name' => 'Stone Town',
            'category' => 'UNESCO Heritage',
            'desc' => 'A UNESCO World Heritage city of winding alleys, ornate carved doors, and a fascinating blend of African, Arab, and Indian cultures.',
            'img' => 'https://images.unsplash.com/photo-1590523741831-ab7e8b8f9c7f?w=800&q=80',
        ],
        [
            'name' => 'Nungwi Beach',
            'category' => 'Beach',
            'desc' => 'Zanzibar\'s most beautiful beach — powdery white sand, crystal-clear turquoise water, and stunning dhow sunsets.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Spice Farm Tour',
            'category' => 'Cultural Experience',
            'desc' => 'Visit a traditional spice farm to see, smell, and taste cloves, vanilla, cardamom, and cinnamon growing in their natural habitat.',
            'img' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
        ],
        [
            'name' => 'Prison Island',
            'category' => 'Island Excursion',
            'desc' => 'A short boat ride from Stone Town, home to giant Aldabra tortoises and a historic 19th-century quarantine station.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Jozani Forest',
            'category' => 'Nature Reserve',
            'desc' => 'Zanzibar\'s only national park, home to the rare endemic red colobus monkey and ancient mahogany trees.',
            'img' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&q=80',
        ],
        [
            'name' => 'Mnemba Atoll',
            'category' => 'Marine Reserve',
            'desc' => 'A pristine coral atoll with some of East Africa\'s finest snorkeling and diving — sea turtles, dolphins, and vibrant reefs.',
            'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'name' => 'Forodhani Night Market',
            'category' => 'Food Market',
            'desc' => 'Stone Town\'s legendary waterfront night market — Zanzibar pizza, grilled seafood, sugarcane juice, and Swahili street food.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Snorkeling & Diving', 'desc' => 'Explore Zanzibar\'s coral reefs at Mnemba Atoll, Chumbe Island, and Pemba Island — among East Africa\'s best dive sites.'],
            ['title' => 'Dolphin Swimming', 'desc' => 'Swim with wild spinner dolphins in Kizimkazi Bay — a magical early morning experience in the Indian Ocean.'],
            ['title' => 'Kitesurfing Paje', 'desc' => 'Paje Beach on Zanzibar\'s east coast is one of the world\'s top kitesurfing destinations, with consistent trade winds.'],
        ],
        'culture' => [
            ['title' => 'Stone Town Walking Tour', 'desc' => 'Explore the UNESCO-listed Stone Town with a local guide — carved doors, the old slave market, and Freddie Mercury\'s birthplace.'],
            ['title' => 'Swahili Cooking Class', 'desc' => 'Learn to cook traditional Zanzibari dishes — pilau, biryani, and coconut fish curry — with a local family.'],
            ['title' => 'Sunset Dhow Cruise', 'desc' => 'Sail on a traditional wooden dhow at sunset, sipping cocktails as the sky turns gold over the Indian Ocean.'],
        ],
        'food' => [
            ['title' => 'Zanzibar Pizza', 'desc' => 'Try the unique Zanzibar pizza — a thin crepe filled with meat, egg, and vegetables, cooked on a griddle at Forodhani Market.'],
            ['title' => 'Seafood Feast', 'desc' => 'Feast on freshly caught lobster, prawns, and octopus grilled with Zanzibari spices at a beachside restaurant.'],
            ['title' => 'Spice-Infused Cuisine', 'desc' => 'Savor the unique Zanzibari fusion of Indian, Arab, and African flavors in fragrant curries and coconut-based dishes.'],
        ],
        'shopping' => [
            ['title' => 'Zanzibar Spices', 'desc' => 'Take home fragrant Zanzibari spices — cloves, cardamom, cinnamon, and vanilla — from the island\'s spice farms and markets.'],
            ['title' => 'Tinga Tinga Art', 'desc' => 'Buy vibrant Tinga Tinga folk paintings — Tanzania\'s distinctive colorful wildlife art — from Stone Town galleries.'],
            ['title' => 'Kangas & Kikois', 'desc' => 'Shop for colorful kanga and kikoi fabrics — traditional East African textiles used as wraps, sarongs, and home décor.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Stone Town Arrival', 'activities' => ['Arrive Zanzibar', 'Stone Town check-in', 'Forodhani Night Market', 'Waterfront stroll']],
            ['day' => 'Day 2', 'title' => 'Stone Town & Spices', 'activities' => ['UNESCO Stone Town walk', 'Spice farm tour', 'Prison Island tortoises', 'Sunset dhow cruise']],
            ['day' => 'Day 3', 'title' => 'North Beaches', 'activities' => ['Drive to Nungwi', 'Beach & snorkeling', 'Turtle sanctuary', 'Beachside seafood dinner']],
            ['day' => 'Day 4', 'title' => 'Marine Adventures', 'activities' => ['Mnemba Atoll snorkeling', 'Dolphin swimming Kizimkazi', 'Jozani Forest colobus monkeys', 'Sunset beach']],
            ['day' => 'Day 5', 'title' => 'Farewell', 'activities' => ['Morning beach', 'Spice shopping', 'Last Zanzibar pizza', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Arrival', 'activities' => ['Arrive, Stone Town', 'Forodhani Night Market']],
            ['day' => 'Day 2', 'title' => 'Stone Town', 'activities' => ['UNESCO walk', 'Slave market', 'Freddie Mercury house', 'Dhow cruise']],
            ['day' => 'Day 3', 'title' => 'Spices & Islands', 'activities' => ['Spice farm tour', 'Prison Island', 'Cooking class']],
            ['day' => 'Day 4', 'title' => 'Nungwi', 'activities' => ['North beach', 'Snorkeling', 'Turtle sanctuary', 'Sunset']],
            ['day' => 'Day 5', 'title' => 'East Coast', 'activities' => ['Paje beach', 'Kitesurfing lesson', 'Jozani Forest']],
            ['day' => 'Day 6', 'title' => 'Marine Day', 'activities' => ['Mnemba Atoll diving', 'Dolphin swimming', 'Kendwa beach']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['Last beach morning', 'Spice market shopping', 'Departure']],
        ],
    ],

    'related' => ['tanzania', 'cape-town', 'maldives'],
];