<?php
return [
    'name' => 'Patagonia',
    'country' => 'Argentina / Chile',
    'continent' => 'Americas',
    'slug' => 'patagonia',
    'tagline' => 'End of the World — Raw & Untamed',
    'hero_image' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1600&q=80',
    'best_time' => 'Nov–Mar (Southern Summer)',
    'duration' => '10–14 Days',
    'currency' => 'Argentine Peso / Chilean Peso',
    'language' => 'Spanish',
    'visa' => 'Visa on Arrival',
    'flight_time' => '~24 hrs from India',
    'budget' => '₹2,50,000–₹4,50,000',
    'overview' => 'Patagonia is the last great wilderness on Earth — a vast, wind-swept region at the southern tip of South America shared between Argentina and Chile. Here, jagged granite towers pierce the sky, ancient glaciers calve into milky turquoise lakes, and condors soar on thermals above endless pampas. Torres del Paine National Park in Chile and Los Glaciares National Park in Argentina are among the world\'s most spectacular trekking destinations. Patagonia is not just a place — it is a state of mind, a call to the wild that draws adventurers, photographers, and dreamers from across the globe.',

    'must_visit' => [
        [
            'name' => 'Torres del Paine',
            'category' => 'National Park',
            'desc' => 'Chile\'s crown jewel — a UNESCO Biosphere Reserve with iconic granite towers, glaciers, and the legendary W Trek.',
            'img' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80',
        ],
        [
            'name' => 'Perito Moreno Glacier',
            'category' => 'Glacier',
            'desc' => 'One of the world\'s few advancing glaciers — a 30 km wall of blue ice that dramatically calves into Lago Argentino.',
            'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80',
        ],
        [
            'name' => 'Fitz Roy & El Chaltén',
            'category' => 'Mountain',
            'desc' => 'The jagged Fitz Roy massif rising above the trekking village of El Chaltén — Argentina\'s national trekking capital.',
            'img' => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800&q=80',
        ],
        [
            'name' => 'Ushuaia',
            'category' => 'Southernmost City',
            'desc' => 'The world\'s southernmost city — gateway to Antarctica, with Tierra del Fuego National Park and Beagle Channel cruises.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Los Glaciares National Park',
            'category' => 'UNESCO Heritage',
            'desc' => 'Argentina\'s largest national park, home to Perito Moreno Glacier, Fitz Roy, and the Southern Patagonian Ice Field.',
            'img' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
        ],
        [
            'name' => 'Carretera Austral',
            'category' => 'Scenic Drive',
            'desc' => 'Chile\'s legendary 1,240 km highway through remote Patagonian wilderness — fjords, volcanoes, and ancient forests.',
            'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        ],
        [
            'name' => 'Punta Arenas',
            'category' => 'Gateway City',
            'desc' => 'The historic Strait of Magellan city, gateway to Torres del Paine and Tierra del Fuego, with Magellanic penguin colonies nearby.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'W Trek in Torres del Paine', 'desc' => 'Hike the iconic 5-day W Trek through Torres del Paine, passing glaciers, lakes, and the legendary granite towers.'],
            ['title' => 'Ice Trekking on Perito Moreno', 'desc' => 'Strap on crampons and walk across the surface of the Perito Moreno Glacier with expert guides.'],
            ['title' => 'Kayaking the Fjords', 'desc' => 'Paddle through Patagonia\'s remote fjords and channels, surrounded by glaciers and dramatic mountain scenery.'],
        ],
        'culture' => [
            ['title' => 'Gaucho Culture', 'desc' => 'Experience the legendary gaucho (cowboy) culture of the Patagonian pampas at an estancia (ranch).'],
            ['title' => 'Penguin Colonies', 'desc' => 'Visit Magellanic penguin colonies at Punta Tombo or Isla Magdalena — hundreds of thousands of penguins up close.'],
            ['title' => 'End of the World Train', 'desc' => 'Ride the historic Tren del Fin del Mundo through Tierra del Fuego National Park near Ushuaia.'],
        ],
        'food' => [
            ['title' => 'Patagonian Lamb', 'desc' => 'Feast on slow-roasted Patagonian lamb (cordero al palo) — the region\'s signature dish, cooked over an open fire.'],
            ['title' => 'King Crab in Ushuaia', 'desc' => 'Savor fresh centolla (king crab) in Ushuaia — the world\'s southernmost seafood, pulled from the Beagle Channel.'],
            ['title' => 'Mate & Empanadas', 'desc' => 'Share mate (herbal tea) with locals and try freshly baked empanadas at a traditional Patagonian estancia.'],
        ],
        'shopping' => [
            ['title' => 'Wool & Leather Goods', 'desc' => 'Buy handcrafted Patagonian wool products, leather goods, and gaucho accessories from local artisans.'],
            ['title' => 'Mapuche Crafts', 'desc' => 'Find traditional Mapuche indigenous textiles, silver jewelry, and weavings in Bariloche and Punta Arenas.'],
            ['title' => 'Patagonian Wine', 'desc' => 'Take home bottles of Patagonian Malbec and Pinot Noir from the vineyards of Mendoza and Río Negro.'],
        ],
    ],

    'itineraries' => [
        '10days' => [
            ['day' => 'Day 1', 'title' => 'Buenos Aires Arrival', 'activities' => ['Arrive Buenos Aires', 'La Boca & San Telmo', 'Tango show dinner']],
            ['day' => 'Day 2', 'title' => 'Buenos Aires', 'activities' => ['Recoleta Cemetery', 'Palermo parks', 'Puerto Madero waterfront']],
            ['day' => 'Day 3', 'title' => 'Fly to El Calafate', 'activities' => ['Flight to El Calafate', 'Lago Argentino views', 'Estancia dinner']],
            ['day' => 'Day 4', 'title' => 'Perito Moreno', 'activities' => ['Perito Moreno Glacier walkways', 'Ice trekking', 'Boat safari']],
            ['day' => 'Day 5', 'title' => 'El Chaltén', 'activities' => ['Drive to El Chaltén', 'Laguna de los Tres hike', 'Fitz Roy views']],
            ['day' => 'Day 6', 'title' => 'Trekking', 'activities' => ['Laguna Torre hike', 'Condor spotting', 'El Chaltén village']],
            ['day' => 'Day 7', 'title' => 'Torres del Paine', 'activities' => ['Cross to Chile', 'Torres del Paine arrival', 'Mirador Las Torres']],
            ['day' => 'Day 8', 'title' => 'W Trek Day 1', 'activities' => ['Valle del Francés hike', 'Glacier Grey views', 'Mountain refuge overnight']],
            ['day' => 'Day 9', 'title' => 'W Trek Day 2', 'activities' => ['Base Las Torres hike', 'Iconic tower views', 'Return to Puerto Natales']],
            ['day' => 'Day 10', 'title' => 'Departure', 'activities' => ['Punta Arenas', 'Penguin colony visit', 'Departure flight']],
        ],
        '14days' => [
            ['day' => 'Day 1', 'title' => 'Buenos Aires', 'activities' => ['Arrive, city exploration', 'Tango show']],
            ['day' => 'Day 2', 'title' => 'Buenos Aires', 'activities' => ['Recoleta', 'Palermo', 'Puerto Madero']],
            ['day' => 'Day 3', 'title' => 'Mendoza Wine', 'activities' => ['Fly to Mendoza', 'Malbec wine tasting', 'Andes views']],
            ['day' => 'Day 4', 'title' => 'El Calafate', 'activities' => ['Fly to El Calafate', 'Lago Argentino', 'Estancia']],
            ['day' => 'Day 5', 'title' => 'Perito Moreno', 'activities' => ['Glacier walkways', 'Ice trekking', 'Boat tour']],
            ['day' => 'Day 6', 'title' => 'El Chaltén', 'activities' => ['Drive to El Chaltén', 'Fitz Roy hike']],
            ['day' => 'Day 7', 'title' => 'Trekking', 'activities' => ['Laguna Torre', 'Condors', 'Village evening']],
            ['day' => 'Day 8', 'title' => 'Ushuaia', 'activities' => ['Fly to Ushuaia', 'End of the World train', 'Beagle Channel']],
            ['day' => 'Day 9', 'title' => 'Tierra del Fuego', 'activities' => ['National park hike', 'King crab lunch', 'Penguin colony']],
            ['day' => 'Day 10', 'title' => 'Torres del Paine', 'activities' => ['Fly to Punta Arenas', 'Drive to Torres del Paine']],
            ['day' => 'Day 11', 'title' => 'W Trek Day 1', 'activities' => ['Valle del Francés', 'Glacier Grey']],
            ['day' => 'Day 12', 'title' => 'W Trek Day 2', 'activities' => ['Base Las Torres', 'Iconic sunrise views']],
            ['day' => 'Day 13', 'title' => 'W Trek Day 3', 'activities' => ['Lago Pehoé', 'Mirador Nordenskjöld', 'Puerto Natales']],
            ['day' => 'Day 14', 'title' => 'Departure', 'activities' => ['Punta Arenas', 'Magellanic penguins', 'Departure']],
        ],
    ],

    'related' => ['peru', 'rio', 'costa-rica'],
];