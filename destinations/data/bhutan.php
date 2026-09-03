<?php
return [
    'name' => 'Bhutan',
    'country' => 'Bhutan',
    'continent' => 'Asia',
    'slug' => 'bhutan',
    'tagline' => 'The Last Shangri-La — Kingdom of Happiness',
    'hero_image' => 'https://images.unsplash.com/photo-1553856622-d1b352e9a211?w=1600&q=80',
    'best_time' => 'Mar–May, Sep–Nov',
    'duration' => '6–8 Days',
    'currency' => 'Bhutanese Ngultrum (BTN)',
    'language' => 'Dzongkha',
    'visa' => 'Visa Required (licensed tour operator)',
    'flight_time' => '~4 hrs from Kolkata',
    'budget' => '₹1,20,000–₹2,50,000',
    'overview' => 'Bhutan is the world\'s only carbon-negative country and measures its success in Gross National Happiness rather than GDP. This tiny Himalayan kingdom has preserved its ancient Buddhist culture, pristine forests, and dramatic mountain landscapes with extraordinary care. From the iconic Tiger\'s Nest monastery clinging to a cliff face to the fertile Paro and Punakha valleys, Bhutan offers a deeply spiritual and visually stunning travel experience unlike anywhere else on Earth. Every visitor must travel with a licensed tour operator, ensuring tourism remains sustainable and the kingdom\'s unique identity is protected.',

    'must_visit' => [
        [
            'name' => 'Tiger\'s Nest (Paro Taktsang)',
            'category' => 'Iconic Landmark',
            'desc' => 'Bhutan\'s most sacred monastery, perched dramatically on a 900m cliff face above the Paro Valley. The 2-hour hike to reach it is one of the most rewarding in Asia.',
            'img' => 'https://images.unsplash.com/photo-1553856622-d1b352e9a211?w=800&q=80',
        ],
        [
            'name' => 'Punakha Dzong',
            'category' => 'UNESCO Heritage',
            'desc' => 'The most beautiful dzong (fortress-monastery) in Bhutan, built at the confluence of two rivers. Especially stunning during the spring rhododendron season.',
            'img' => 'https://images.unsplash.com/photo-1566296314736-6eaac1ca0cb9?w=800&q=80',
        ],
        [
            'name' => 'Thimphu',
            'category' => 'Capital City',
            'desc' => 'The world\'s only capital city without traffic lights. Visit the giant Buddha Dordenma statue, Tashichho Dzong, and the vibrant weekend market.',
            'img' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?w=800&q=80',
        ],
        [
            'name' => 'Dochula Pass',
            'category' => 'Scenic Viewpoint',
            'desc' => 'A high mountain pass at 3,100m adorned with 108 memorial chortens and offering panoramic views of the Himalayan peaks on clear days.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Haa Valley',
            'category' => 'Nature',
            'desc' => 'One of Bhutan\'s most remote and pristine valleys, only recently opened to tourists. Lush meadows, ancient temples, and traditional villages.',
            'img' => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=800&q=80',
        ],
        [
            'name' => 'Paro Valley',
            'category' => 'Cultural',
            'desc' => 'Bhutan\'s most visited valley, home to the international airport, Tiger\'s Nest, and numerous ancient temples and fortresses.',
            'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80',
        ],
        [
            'name' => 'Bumthang Valley',
            'category' => 'Spiritual Heartland',
            'desc' => 'Bhutan\'s spiritual heartland — a cluster of four valleys with ancient temples, monasteries, and the sacred Jambay Lhakhang dating to the 7th century.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Tiger\'s Nest Hike', 'desc' => 'Trek the iconic 2-hour trail through pine forests to the cliff-hanging Paro Taktsang monastery — Bhutan\'s most rewarding hike.'],
            ['title' => 'Snowman Trek', 'desc' => 'Attempt one of the world\'s hardest treks — a 25-day high-altitude journey through remote Bhutanese wilderness.'],
            ['title' => 'Rafting on Mo Chhu', 'desc' => 'Raft the Mo Chhu River near Punakha through scenic valleys and rapids with the Himalayas as a backdrop.'],
        ],
        'culture' => [
            ['title' => 'Tsechu Festival', 'desc' => 'Attend a Tsechu — Bhutan\'s vibrant masked dance festival held at dzongs across the country, celebrating Guru Rinpoche.'],
            ['title' => 'Monastery Meditation', 'desc' => 'Meditate with monks at a remote monastery and learn about Vajrayana Buddhism from resident lamas.'],
            ['title' => 'Traditional Farmhouse Visit', 'desc' => 'Stay in a traditional Bhutanese farmhouse and experience daily life, local cooking, and archery — the national sport.'],
        ],
        'food' => [
            ['title' => 'Ema Datshi', 'desc' => 'Bhutan\'s national dish — a fiery stew of chillies and local cheese that appears at every meal. Surprisingly addictive.'],
            ['title' => 'Red Rice & Phaksha Paa', 'desc' => 'Taste Bhutan\'s nutty red rice paired with phaksha paa (pork with red chillies) — a hearty Himalayan combination.'],
            ['title' => 'Butter Tea & Ara', 'desc' => 'Sip suja (salted butter tea) — an acquired taste beloved by Bhutanese — and try ara, the local rice wine.'],
        ],
        'shopping' => [
            ['title' => 'Thimphu Weekend Market', 'desc' => 'Browse the weekend market for traditional Bhutanese textiles, dried chillies, local cheese, and handmade crafts.'],
            ['title' => 'Thangka Paintings', 'desc' => 'Buy hand-painted thangka religious scrolls from certified artisans — a meaningful piece of Bhutanese Buddhist art.'],
            ['title' => 'Bhutanese Textiles', 'desc' => 'Shop for kira (women\'s dress) and gho (men\'s robe) fabric — intricate hand-woven textiles unique to Bhutan.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Arrive Paro', 'activities' => ['Arrive Paro Airport', 'Rinpung Dzong', 'Paro town walk', 'Welcome dinner']],
            ['day' => 'Day 2', 'title' => 'Tiger\'s Nest', 'activities' => ['Tiger\'s Nest hike (4–5 hrs)', 'Cafeteria viewpoint lunch', 'Kyichu Lhakhang temple', 'Paro evening']],
            ['day' => 'Day 3', 'title' => 'Thimphu', 'activities' => ['Drive to Thimphu', 'Buddha Dordenma statue', 'Tashichho Dzong', 'Weekend market']],
            ['day' => 'Day 4', 'title' => 'Punakha', 'activities' => ['Dochula Pass 108 chortens', 'Punakha Dzong', 'Suspension bridge walk', 'Chimi Lhakhang fertility temple']],
            ['day' => 'Day 5', 'title' => 'Departure', 'activities' => ['Morning at leisure', 'Last Ema Datshi breakfast', 'Return to Paro', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Arrive Paro', 'activities' => ['Arrive, Rinpung Dzong', 'Paro town', 'Welcome dinner']],
            ['day' => 'Day 2', 'title' => 'Tiger\'s Nest', 'activities' => ['Tiger\'s Nest hike', 'Kyichu Lhakhang', 'Paro valley walk']],
            ['day' => 'Day 3', 'title' => 'Thimphu', 'activities' => ['Buddha Dordenma', 'Tashichho Dzong', 'National Museum', 'Weekend market']],
            ['day' => 'Day 4', 'title' => 'Punakha', 'activities' => ['Dochula Pass', 'Punakha Dzong', 'Suspension bridge', 'Chimi Lhakhang']],
            ['day' => 'Day 5', 'title' => 'Punakha Valley', 'activities' => ['Khamsum Yulley Namgyal Chorten hike', 'Rafting on Mo Chhu', 'Village walk', 'Farmhouse dinner']],
            ['day' => 'Day 6', 'title' => 'Return to Paro', 'activities' => ['Haa Valley day trip', 'Traditional archery', 'Paro market', 'Farewell dinner']],
            ['day' => 'Day 7', 'title' => 'Departure', 'activities' => ['Morning meditation', 'Last temple visit', 'Departure from Paro']],
        ],
        '10days' => [
            ['day' => 'Day 1', 'title' => 'Paro Arrival', 'activities' => ['Arrive, Rinpung Dzong', 'Paro town']],
            ['day' => 'Day 2', 'title' => 'Tiger\'s Nest', 'activities' => ['Tiger\'s Nest hike', 'Kyichu Lhakhang']],
            ['day' => 'Day 3', 'title' => 'Thimphu', 'activities' => ['Buddha Dordenma', 'Tashichho Dzong', 'National Museum']],
            ['day' => 'Day 4', 'title' => 'Punakha', 'activities' => ['Dochula Pass', 'Punakha Dzong', 'Suspension bridge']],
            ['day' => 'Day 5', 'title' => 'Punakha Activities', 'activities' => ['Rafting Mo Chhu', 'Chimi Lhakhang', 'Village walk']],
            ['day' => 'Day 6', 'title' => 'Bumthang', 'activities' => ['Drive to Bumthang', 'Jakar Dzong', 'Jambay Lhakhang']],
            ['day' => 'Day 7', 'title' => 'Bumthang Temples', 'activities' => ['Kurjey Lhakhang', 'Tamshing Monastery', 'Bumthang brewery']],
            ['day' => 'Day 8', 'title' => 'Haa Valley', 'activities' => ['Drive to Haa Valley', 'Lhakhang Karpo & Nagpo', 'Traditional village']],
            ['day' => 'Day 9', 'title' => 'Return Paro', 'activities' => ['Paro market', 'Archery demonstration', 'Farewell dinner']],
            ['day' => 'Day 10', 'title' => 'Departure', 'activities' => ['Morning meditation', 'Last temple', 'Departure']],
        ],
    ],

    'related' => ['nepal', 'sri-lanka', 'vietnam'],
];