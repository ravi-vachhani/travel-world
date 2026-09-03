<?php
return [
    'name' => 'New York City',
    'country' => 'USA',
    'continent' => 'Americas',
    'slug' => 'new-york',
    'tagline' => 'The City That Never Sleeps',
    'hero_image' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=1600&q=80',
    'best_time' => 'Apr–Jun, Sep–Nov',
    'duration' => '5–8 Days',
    'currency' => 'US Dollar (USD)',
    'language' => 'English',
    'visa' => 'US B1/B2 Visa',
    'flight_time' => '~15 hrs from India',
    'budget' => '₹2,00,000–₹4,00,000',
    'overview' => 'New York City is the world\'s most iconic metropolis — a dizzying, exhilarating, endlessly fascinating city where every neighborhood tells a different story. From the soaring skyscrapers of Manhattan to the bohemian streets of Brooklyn, from the neon-lit spectacle of Times Square to the serene paths of Central Park, New York defies easy description. It is the global capital of finance, fashion, art, theatre, and food. For Indian travelers, NYC offers a particularly warm welcome — with one of the world\'s largest Indian diaspora communities and a cultural diversity that makes everyone feel at home.',

    'must_visit' => [
        [
            'name' => 'Statue of Liberty',
            'category' => 'Iconic Monument',
            'desc' => 'The ultimate symbol of freedom and democracy — take the ferry to Liberty Island for close-up views of this iconic copper statue.',
            'img' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=800&q=80',
        ],
        [
            'name' => 'Central Park',
            'category' => 'Urban Park',
            'desc' => 'An 843-acre green oasis in the heart of Manhattan — cycle, row a boat, visit the zoo, or simply stroll among New Yorkers.',
            'img' => 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=800&q=80',
        ],
        [
            'name' => 'Times Square',
            'category' => 'Iconic District',
            'desc' => 'The dazzling "Crossroads of the World" — a sensory overload of neon billboards, Broadway theatres, and 24/7 energy.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
        [
            'name' => 'The Metropolitan Museum',
            'category' => 'World Museum',
            'desc' => 'One of the world\'s greatest art museums, with over 2 million works spanning 5,000 years of human civilization.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Brooklyn Bridge',
            'category' => 'Iconic Bridge',
            'desc' => 'Walk across the iconic 1883 suspension bridge for stunning views of the Manhattan skyline and East River.',
            'img' => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800&q=80',
        ],
        [
            'name' => 'Empire State Building',
            'category' => 'Skyscraper',
            'desc' => 'Ascend to the 86th-floor observation deck of this Art Deco masterpiece for panoramic views of the entire city.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'High Line & Chelsea',
            'category' => 'Urban Park',
            'desc' => 'Walk the elevated linear park built on a former railway line, with art installations, gardens, and Hudson River views.',
            'img' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Helicopter Tour', 'desc' => 'Soar over Manhattan\'s skyline on a thrilling helicopter tour for the ultimate bird\'s-eye view of New York City.'],
            ['title' => 'Cycling Central Park', 'desc' => 'Rent a bike and cycle the 6-mile loop around Central Park, stopping at Bethesda Fountain and Strawberry Fields.'],
            ['title' => 'Kayaking the Hudson', 'desc' => 'Paddle the Hudson River with free kayaking from Downtown Boathouse for unique views of the Manhattan skyline.'],
        ],
        'culture' => [
            ['title' => 'Broadway Show', 'desc' => 'Experience the magic of a Broadway musical or play — the pinnacle of live theatre entertainment in the world.'],
            ['title' => 'Museum Mile', 'desc' => 'Walk Fifth Avenue\'s Museum Mile, home to the Met, Guggenheim, and eight other world-class museums.'],
            ['title' => 'Jazz in Harlem', 'desc' => 'Experience live jazz at legendary Harlem venues like the Apollo Theater or Minton\'s Playhouse.'],
        ],
        'food' => [
            ['title' => 'NYC Pizza & Bagels', 'desc' => 'Grab a classic New York slice from a corner pizzeria and a fresh bagel with lox from a traditional deli.'],
            ['title' => 'Chelsea Market', 'desc' => 'Graze through this iconic food hall in a converted factory for artisan food, fresh lobster, and global cuisine.'],
            ['title' => 'Jackson Heights Little India', 'desc' => 'Explore Queens\' Jackson Heights for authentic Indian food — from chaat to biryani — that rivals anything back home.'],
        ],
        'shopping' => [
            ['title' => 'Fifth Avenue', 'desc' => 'Shop the world\'s most famous retail street — from Saks Fifth Avenue and Tiffany\'s to flagship stores of every luxury brand.'],
            ['title' => 'SoHo Boutiques', 'desc' => 'Browse SoHo\'s cast-iron buildings for independent boutiques, art galleries, and cutting-edge fashion.'],
            ['title' => 'Brooklyn Flea', 'desc' => 'Hunt for vintage treasures, artisan goods, and street food at Brooklyn\'s beloved weekend flea market.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Manhattan Icons', 'activities' => ['Arrive, check in Midtown', 'Times Square & Broadway', 'Empire State Building sunset', 'NYC pizza dinner']],
            ['day' => 'Day 2', 'title' => 'Downtown & Liberty', 'activities' => ['Statue of Liberty & Ellis Island', 'Wall Street & Charging Bull', 'Brooklyn Bridge walk', 'DUMBO Brooklyn lunch']],
            ['day' => 'Day 3', 'title' => 'Museums & Culture', 'activities' => ['Metropolitan Museum of Art', 'Central Park stroll', 'Guggenheim Museum', 'Upper East Side dinner']],
            ['day' => 'Day 4', 'title' => 'Modern NYC', 'activities' => ['High Line walk', 'Chelsea Market', 'One World Observatory', '9/11 Memorial']],
            ['day' => 'Day 5', 'title' => 'Neighborhoods & Farewell', 'activities' => ['SoHo shopping', 'Greenwich Village', 'Jackson Heights Indian food', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Arrival & Midtown', 'activities' => ['Arrive, Times Square', 'Empire State Building', 'Broadway show']],
            ['day' => 'Day 2', 'title' => 'Downtown', 'activities' => ['Statue of Liberty', 'Wall Street', 'Brooklyn Bridge', 'DUMBO']],
            ['day' => 'Day 3', 'title' => 'Museums', 'activities' => ['Metropolitan Museum', 'Central Park', 'Guggenheim']],
            ['day' => 'Day 4', 'title' => 'Modern NYC', 'activities' => ['High Line', 'Chelsea Market', 'Hudson Yards', 'One World Trade']],
            ['day' => 'Day 5', 'title' => 'Brooklyn', 'activities' => ['Brooklyn Flea', 'Smorgasburg food market', 'Prospect Park', 'Williamsburg']],
            ['day' => 'Day 6', 'title' => 'Outer Boroughs', 'activities' => ['Queens Jackson Heights', 'Flushing Chinatown', 'Citi Field area', 'Harlem jazz night']],
            ['day' => 'Day 7', 'title' => 'Farewell', 'activities' => ['SoHo & Greenwich Village', 'Last NYC bagel', 'Fifth Avenue shopping', 'Departure']],
        ],
    ],

    'related' => ['cancun', 'vancouver', 'rio'],
];