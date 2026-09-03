<?php
return [
    'name' => 'Venice',
    'country' => 'Italy',
    'continent' => 'Europe',
    'slug' => 'venice',
    'tagline' => 'The Floating City of Canals & Romance',
    'hero_image' => 'https://images.unsplash.com/photo-1514890547357-a9ee288728e0?w=1600&q=80',
    'best_time' => 'Apr–Jun, Sep–Nov',
    'duration' => '3–5 Days',
    'currency' => 'Euro (€)',
    'language' => 'Italian',
    'visa' => 'Schengen Visa',
    'flight_time' => '~9 hrs from India',
    'budget' => '₹1,60,000–₹2,80,000',
    'overview' => 'Venice is unlike any other city on Earth — a miraculous labyrinth of canals, bridges, and palaces built on 118 small islands in a lagoon. For centuries the capital of a maritime empire, Venice dazzles with its Gothic and Byzantine architecture, world-class art, and an atmosphere of timeless romance. Glide through the Grand Canal on a gondola, lose yourself in the maze of calli (narrow streets), and discover hidden campi (squares) where locals still live their daily lives. Venice is a city that must be experienced slowly, on foot and by water, to truly reveal its magic.',

    'must_visit' => [
        [
            'name' => 'St. Mark\'s Basilica',
            'category' => 'UNESCO Heritage',
            'desc' => 'A breathtaking Byzantine cathedral adorned with golden mosaics, marble columns, and the famous Pala d\'Oro altarpiece.',
            'img' => 'https://images.unsplash.com/photo-1514890547357-a9ee288728e0?w=800&q=80',
        ],
        [
            'name' => 'Grand Canal',
            'category' => 'Iconic Waterway',
            'desc' => 'Venice\'s main artery — a 3.8 km S-shaped canal lined with over 170 palaces and churches, best seen from a vaporetto.',
            'img' => 'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=800&q=80',
        ],
        [
            'name' => 'Doge\'s Palace',
            'category' => 'Historic Palace',
            'desc' => 'The magnificent Gothic palace that was the seat of Venetian power for centuries, with stunning state rooms and the Bridge of Sighs.',
            'img' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80',
        ],
        [
            'name' => 'Rialto Bridge',
            'category' => 'Iconic Bridge',
            'desc' => 'Venice\'s oldest and most famous bridge, spanning the Grand Canal with its distinctive arch and bustling market stalls.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Murano & Burano Islands',
            'category' => 'Island Excursion',
            'desc' => 'Visit Murano for world-famous glassblowing and Burano for its rainbow-colored fishermen\'s houses and lace-making tradition.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
        [
            'name' => 'Gallerie dell\'Accademia',
            'category' => 'Art Museum',
            'desc' => 'Venice\'s premier art museum, housing the world\'s finest collection of Venetian paintings from the 14th to 18th centuries.',
            'img' => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800&q=80',
        ],
        [
            'name' => 'Gondola Ride',
            'category' => 'Iconic Experience',
            'desc' => 'Glide through Venice\'s narrow canals on a traditional gondola — the most romantic and quintessentially Venetian experience.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Kayaking the Canals', 'desc' => 'Paddle through Venice\'s quieter canals by kayak for a unique perspective on the city\'s hidden corners.'],
            ['title' => 'Lagoon Boat Tour', 'desc' => 'Explore the Venetian Lagoon by private boat, visiting remote islands, salt marshes, and abandoned monasteries.'],
            ['title' => 'Sunrise Walk', 'desc' => 'Experience Venice before the crowds — wander the empty calli at dawn when the city belongs only to you.'],
        ],
        'culture' => [
            ['title' => 'Venice Carnival', 'desc' => 'Experience the world\'s most spectacular carnival (February) with elaborate masks, costumes, and centuries-old traditions.'],
            ['title' => 'Glassblowing in Murano', 'desc' => 'Watch master glassblowers create intricate Murano glass sculptures in workshops that have operated for 700 years.'],
            ['title' => 'La Fenice Opera', 'desc' => 'Attend a performance at Teatro La Fenice, one of the world\'s most beautiful and historic opera houses.'],
        ],
        'food' => [
            ['title' => 'Cicchetti Bar Crawl', 'desc' => 'Graze through Venice\'s bacari (wine bars) sampling cicchetti — Venetian tapas of crostini, seafood, and local bites.'],
            ['title' => 'Rialto Market', 'desc' => 'Browse the historic Rialto fish and produce market, operating since 1097, for the freshest Adriatic seafood.'],
            ['title' => 'Risotto al Nero di Seppia', 'desc' => 'Taste Venice\'s signature black squid ink risotto at a traditional osteria along a quiet canal.'],
        ],
        'shopping' => [
            ['title' => 'Murano Glass', 'desc' => 'Buy authentic hand-blown Murano glass jewelry, vases, and chandeliers directly from island workshops.'],
            ['title' => 'Venetian Masks', 'desc' => 'Find handcrafted papier-mâché carnival masks from artisan workshops in the Dorsoduro and San Polo districts.'],
            ['title' => 'Burano Lace', 'desc' => 'Purchase exquisite handmade Burano lace — tablecloths, collars, and decorative pieces from island artisans.'],
        ],
    ],

    'itineraries' => [
        '3days' => [
            ['day' => 'Day 1', 'title' => 'Heart of Venice', 'activities' => ['St. Mark\'s Basilica & Campanile', 'Doge\'s Palace & Bridge of Sighs', 'Grand Canal vaporetto ride', 'Gondola ride at sunset']],
            ['day' => 'Day 2', 'title' => 'Islands & Art', 'activities' => ['Murano glassblowing visit', 'Burano colorful island', 'Gallerie dell\'Accademia', 'Cicchetti bar crawl in Cannaregio']],
            ['day' => 'Day 3', 'title' => 'Hidden Venice', 'activities' => ['Rialto market morning', 'Dorsoduro neighborhood', 'Peggy Guggenheim Collection', 'Farewell dinner by canal']],
        ],
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Arrival & San Marco', 'activities' => ['Check in, Piazza San Marco', 'St. Mark\'s Basilica', 'Doge\'s Palace', 'Evening passeggiata']],
            ['day' => 'Day 2', 'title' => 'Grand Canal & Rialto', 'activities' => ['Rialto market', 'Grand Canal by gondola', 'Ca\' d\'Oro palace', 'Cannaregio Jewish Ghetto']],
            ['day' => 'Day 3', 'title' => 'Islands Day', 'activities' => ['Murano glass factory', 'Burano lace & lunch', 'Torcello ancient mosaics', 'Return by sunset']],
            ['day' => 'Day 4', 'title' => 'Art & Dorsoduro', 'activities' => ['Gallerie dell\'Accademia', 'Peggy Guggenheim Collection', 'Zattere waterfront walk', 'Aperitivo in Campo Santa Margherita']],
            ['day' => 'Day 5', 'title' => 'Slow Venice & Departure', 'activities' => ['Morning kayak tour', 'Mask workshop', 'Last cicchetti lunch', 'Departure by water taxi']],
        ],
    ],

    'related' => ['rome', 'amalfi', 'dubrovnik'],
];