<?php
return [
    'name' => 'Vienna',
    'country' => 'Austria',
    'continent' => 'Europe',
    'slug' => 'vienna',
    'tagline' => 'Imperial Grandeur & Classical Music Capital',
    'hero_image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=1600&q=80',
    'best_time' => 'Apr–Jun, Sep–Oct',
    'duration' => '4–6 Days',
    'currency' => 'Euro (€)',
    'language' => 'German',
    'visa' => 'Schengen Visa',
    'flight_time' => '~9 hrs from India',
    'budget' => '₹1,20,000–₹2,20,000',
    'overview' => 'Vienna is one of Europe\'s most magnificent imperial capitals — a city of grand boulevards, baroque palaces, world-class museums, and the finest classical music tradition on Earth. As the former seat of the Habsburg Empire, Vienna accumulated centuries of artistic and architectural treasures that make it a cultural destination of unparalleled richness. The Vienna Philharmonic, the Spanish Riding School, the Kunsthistorisches Museum, and the Schönbrunn Palace are just the beginning. Vienna also excels in the art of living — its coffee house culture, Sachertorte, and Heuriger wine taverns make it one of Europe\'s most pleasurable cities to simply inhabit.',

    'must_visit' => [
        [
            'name' => 'Schönbrunn Palace',
            'category' => 'UNESCO Heritage',
            'desc' => 'The Habsburg imperial summer palace — 1,441 rooms, magnificent baroque gardens, and the Gloriette hilltop pavilion with city views.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'St. Stephen\'s Cathedral',
            'category' => 'Gothic Masterpiece',
            'desc' => 'Vienna\'s most iconic landmark — a Gothic cathedral with a dazzling mosaic roof, 137m south tower, and Habsburg catacombs.',
            'img' => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800&q=80',
        ],
        [
            'name' => 'Kunsthistorisches Museum',
            'category' => 'World Museum',
            'desc' => 'One of the world\'s greatest art museums — Vermeer, Raphael, Titian, and Bruegel in a magnificent imperial building.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
        [
            'name' => 'Belvedere Palace',
            'category' => 'Palace & Museum',
            'desc' => 'A baroque palace complex housing Klimt\'s "The Kiss" — one of the most famous paintings in the world.',
            'img' => 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=800&q=80',
        ],
        [
            'name' => 'Vienna State Opera',
            'category' => 'Opera House',
            'desc' => 'One of the world\'s leading opera houses — attend a performance or take a guided tour of this magnificent neo-Renaissance building.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
        [
            'name' => 'Hofburg Palace',
            'category' => 'Imperial Palace',
            'desc' => 'The Habsburg winter residence — a vast complex housing the Imperial Apartments, Sisi Museum, and Spanish Riding School.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Vienna Coffee Houses',
            'category' => 'UNESCO Heritage',
            'desc' => 'Vienna\'s legendary coffee house culture — a UNESCO Intangible Heritage where time slows over a Melange and Sachertorte.',
            'img' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Danube Cycling', 'desc' => 'Cycle along the Danube River through Vienna\'s green spaces and the Prater park — a scenic urban adventure.'],
            ['title' => 'Vienna Woods Hike', 'desc' => 'Hike through the Wienerwald (Vienna Woods) to the Kahlenberg hill for panoramic views over the city and Danube.'],
            ['title' => 'Prater Giant Ferris Wheel', 'desc' => 'Ride the historic 1897 Riesenrad Ferris Wheel in the Prater amusement park for panoramic views of Vienna.'],
        ],
        'culture' => [
            ['title' => 'Vienna Philharmonic Concert', 'desc' => 'Attend a concert by the world-famous Vienna Philharmonic at the Musikverein — the gold hall with perfect acoustics.'],
            ['title' => 'Spanish Riding School', 'desc' => 'Watch the Lipizzaner stallions perform classical dressage at the Spanish Riding School in the Hofburg Palace.'],
            ['title' => 'Klimt & Schiele at Belvedere', 'desc' => 'See Klimt\'s "The Kiss" and Schiele\'s expressionist masterworks at the Upper Belvedere — Vienna\'s finest art experience.'],
        ],
        'food' => [
            ['title' => 'Sachertorte at Hotel Sacher', 'desc' => 'Eat the original Sachertorte at Hotel Sacher — Vienna\'s most famous chocolate cake, invented in 1832.'],
            ['title' => 'Wiener Schnitzel', 'desc' => 'Eat an authentic Wiener Schnitzel at a traditional Viennese Beisl — veal pounded thin, breaded, and pan-fried to golden perfection.'],
            ['title' => 'Heuriger Wine Tavern', 'desc' => 'Visit a Heuriger (wine tavern) in Grinzing or Neustift to taste new Viennese wine with cold buffet platters.'],
        ],
        'shopping' => [
            ['title' => 'Naschmarkt', 'desc' => 'Browse Vienna\'s most famous open-air market for Austrian cheeses, meats, spices, and international street food.'],
            ['title' => 'Kärntner Strasse', 'desc' => 'Shop Vienna\'s elegant pedestrian shopping street for Austrian crystal, porcelain, and international luxury brands.'],
            ['title' => 'Augarten Porcelain', 'desc' => 'Buy hand-painted Augarten Vienna porcelain — one of Europe\'s oldest porcelain manufacturers, founded in 1718.'],
        ],
    ],

    'itineraries' => [
        '4days' => [
            ['day' => 'Day 1', 'title' => 'Imperial Vienna', 'activities' => ['Arrive Vienna', 'St. Stephen\'s Cathedral', 'Hofburg Palace', 'Vienna State Opera evening']],
            ['day' => 'Day 2', 'title' => 'Schönbrunn & Belvedere', 'activities' => ['Schönbrunn Palace & gardens', 'Gloriette viewpoint', 'Upper Belvedere & The Kiss', 'Naschmarkt']],
            ['day' => 'Day 3', 'title' => 'Museums & Culture', 'activities' => ['Kunsthistorisches Museum', 'Maria Theresien Platz', 'Spanish Riding School', 'Coffee house afternoon']],
            ['day' => 'Day 4', 'title' => 'Farewell', 'activities' => ['Prater & Ferris Wheel', 'Sachertorte at Hotel Sacher', 'Kärntner Strasse shopping', 'Departure']],
        ],
        '6days' => [
            ['day' => 'Day 1', 'title' => 'Arrival', 'activities' => ['Arrive, St. Stephen\'s Cathedral', 'Hofburg', 'Opera evening']],
            ['day' => 'Day 2', 'title' => 'Schönbrunn', 'activities' => ['Schönbrunn Palace', 'Gardens', 'Gloriette', 'Naschmarkt']],
            ['day' => 'Day 3', 'title' => 'Art & Museums', 'activities' => ['Kunsthistorisches Museum', 'Belvedere & The Kiss', 'Klimt & Schiele']],
            ['day' => 'Day 4', 'title' => 'Music & Culture', 'activities' => ['Spanish Riding School', 'Vienna Philharmonic concert', 'Coffee house culture']],
            ['day' => 'Day 5', 'title' => 'Day Trip', 'activities' => ['Salzburg day trip', 'Mozart\'s birthplace', 'Hohensalzburg Castle', 'Return to Vienna']],
            ['day' => 'Day 6', 'title' => 'Farewell', 'activities' => ['Prater Ferris Wheel', 'Sachertorte', 'Augarten porcelain', 'Departure']],
        ],
    ],

    'related' => ['prague', 'amsterdam', 'paris'],
];