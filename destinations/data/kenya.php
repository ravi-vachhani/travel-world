<?php
return [
    'name' => 'Kenya',
    'country' => 'Kenya',
    'continent' => 'Africa',
    'slug' => 'kenya',
    'tagline' => 'Safari Capital of the World',
    'hero_image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1600&q=80',
    'best_time' => 'Jul–Oct (Great Migration), Jan–Feb',
    'duration' => '8–12 Days',
    'currency' => 'Kenyan Shilling (KES)',
    'language' => 'Swahili, English',
    'visa' => 'e-Visa Required',
    'flight_time' => '~9 hrs from India',
    'budget' => '₹2,00,000–₹4,00,000',
    'overview' => 'Kenya is the birthplace of the African safari — a land of sweeping savannahs, snow-capped equatorial peaks, and the world\'s greatest wildlife spectacle. The Maasai Mara National Reserve hosts the dramatic Great Migration, where millions of wildebeest cross the crocodile-infested Mara River in a primal drama that has unfolded for millennia. Beyond the Mara, Kenya offers extraordinary diversity: the flamingo-pink shores of Lake Nakuru, the elephant paradise of Amboseli with Kilimanjaro as a backdrop, the pristine beaches of Diani, and the vibrant cosmopolitan energy of Nairobi.',

    'must_visit' => [
        [
            'name' => 'Maasai Mara',
            'category' => 'Safari',
            'desc' => 'Kenya\'s most famous reserve — home to the Great Migration and year-round Big Five sightings on the golden savannah.',
            'img' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80',
        ],
        [
            'name' => 'Amboseli National Park',
            'category' => 'Safari',
            'desc' => 'Famous for its large elephant herds and iconic views of Mount Kilimanjaro rising above the African plains.',
            'img' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=800&q=80',
        ],
        [
            'name' => 'Lake Nakuru',
            'category' => 'National Park',
            'desc' => 'A soda lake famous for its flamingo flocks, white rhinos, and diverse birdlife in the Great Rift Valley.',
            'img' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=80',
        ],
        [
            'name' => 'Mount Kenya',
            'category' => 'Mountain',
            'desc' => 'Africa\'s second-highest peak and a UNESCO World Heritage Site — a dramatic equatorial mountain with glaciers and unique flora.',
            'img' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
        ],
        [
            'name' => 'Diani Beach',
            'category' => 'Beach',
            'desc' => 'Kenya\'s most beautiful beach — 17 km of white sand and turquoise Indian Ocean water south of Mombasa.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Nairobi',
            'category' => 'Capital City',
            'desc' => 'Africa\'s most dynamic capital — with the world\'s only urban national park, the Giraffe Centre, and a thriving food scene.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Lamu Island',
            'category' => 'UNESCO Heritage',
            'desc' => 'A UNESCO World Heritage island town — the oldest and best-preserved Swahili settlement in East Africa, car-free and timeless.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Hot Air Balloon Safari', 'desc' => 'Float over the Maasai Mara at dawn in a hot air balloon, watching the Great Migration from above the golden plains.'],
            ['title' => 'Mount Kenya Trek', 'desc' => 'Trek to Point Lenana (4,985m) on Africa\'s second-highest peak through moorlands, glaciers, and unique giant lobelias.'],
            ['title' => 'White Water Rafting', 'desc' => 'Raft the Tana River through dramatic gorges near Mount Kenya for thrilling Class IV rapids.'],
        ],
        'culture' => [
            ['title' => 'Maasai Village Visit', 'desc' => 'Visit an authentic Maasai manyatta (village) to experience warrior culture, traditional dances, and beadwork.'],
            ['title' => 'Karen Blixen Museum', 'desc' => 'Visit the farm of "Out of Africa" author Karen Blixen in Nairobi\'s Karen suburb, with views of the Ngong Hills.'],
            ['title' => 'Lamu Cultural Festival', 'desc' => 'Experience the annual Lamu Cultural Festival with dhow races, donkey races, and traditional Swahili performances.'],
        ],
        'food' => [
            ['title' => 'Nyama Choma', 'desc' => 'Feast on Kenya\'s beloved nyama choma (roasted goat or beef) at a local carnivore restaurant with ugali and sukuma wiki.'],
            ['title' => 'Swahili Coast Cuisine', 'desc' => 'Savor coconut-based Swahili dishes — pilau, biryani, and grilled seafood — along the Mombasa and Lamu coast.'],
            ['title' => 'Nairobi Food Scene', 'desc' => 'Explore Nairobi\'s thriving restaurant scene, from Indian restaurants in Westlands to rooftop bars in Kilimani.'],
        ],
        'shopping' => [
            ['title' => 'Maasai Market', 'desc' => 'Browse Nairobi\'s rotating Maasai Market for beaded jewelry, shukas, carvings, and authentic Kenyan crafts.'],
            ['title' => 'Kazuri Beads', 'desc' => 'Visit the Kazuri Bead Factory in Karen for handmade ceramic beads and jewelry made by local women artisans.'],
            ['title' => 'African Fabrics', 'desc' => 'Shop for colorful kanga and kitenge fabrics, Maasai blankets, and handwoven baskets from local markets.'],
        ],
    ],

    'itineraries' => [
        '8days' => [
            ['day' => 'Day 1', 'title' => 'Nairobi Arrival', 'activities' => ['Arrive Nairobi', 'Giraffe Centre', 'David Sheldrick Elephant Orphanage', 'Karen Blixen Museum']],
            ['day' => 'Day 2', 'title' => 'Nairobi National Park', 'activities' => ['Morning game drive in Nairobi NP', 'Nairobi city tour', 'Carnivore restaurant dinner']],
            ['day' => 'Day 3', 'title' => 'Amboseli', 'activities' => ['Drive to Amboseli', 'Afternoon game drive', 'Kilimanjaro views', 'Elephant herds']],
            ['day' => 'Day 4', 'title' => 'Amboseli Safari', 'activities' => ['Full day game drives', 'Big Five search', 'Maasai village visit', 'Sundowner']],
            ['day' => 'Day 5', 'title' => 'Maasai Mara', 'activities' => ['Fly to Maasai Mara', 'Afternoon game drive', 'Big cat sightings', 'Tented camp']],
            ['day' => 'Day 6', 'title' => 'Great Migration', 'activities' => ['Full day Mara game drives', 'River crossing (Jul–Oct)', 'Hot air balloon option', 'Bush dinner']],
            ['day' => 'Day 7', 'title' => 'Mara & Nairobi', 'activities' => ['Morning game drive', 'Fly back to Nairobi', 'Maasai Market shopping', 'Farewell dinner']],
            ['day' => 'Day 8', 'title' => 'Departure', 'activities' => ['Morning at leisure', 'Last Nairobi sights', 'Departure']],
        ],
        '12days' => [
            ['day' => 'Day 1', 'title' => 'Nairobi', 'activities' => ['Arrive, Giraffe Centre', 'Elephant Orphanage']],
            ['day' => 'Day 2', 'title' => 'Nairobi', 'activities' => ['Nairobi NP', 'Karen Blixen', 'City tour']],
            ['day' => 'Day 3', 'title' => 'Lake Nakuru', 'activities' => ['Drive to Nakuru', 'Flamingos', 'White rhinos']],
            ['day' => 'Day 4', 'title' => 'Lake Naivasha', 'activities' => ['Boat safari', 'Hippos', 'Hell\'s Gate cycling']],
            ['day' => 'Day 5', 'title' => 'Maasai Mara', 'activities' => ['Drive to Mara', 'Afternoon game drive']],
            ['day' => 'Day 6', 'title' => 'Mara Safari', 'activities' => ['Full day game drives', 'River crossings']],
            ['day' => 'Day 7', 'title' => 'Balloon & Mara', 'activities' => ['Hot air balloon safari', 'Maasai village', 'Sundowner']],
            ['day' => 'Day 8', 'title' => 'Amboseli', 'activities' => ['Fly to Amboseli', 'Kilimanjaro views', 'Elephants']],
            ['day' => 'Day 9', 'title' => 'Amboseli', 'activities' => ['Full day game drives', 'Observation Hill']],
            ['day' => 'Day 10', 'title' => 'Mombasa', 'activities' => ['Fly to Mombasa', 'Old Town', 'Fort Jesus']],
            ['day' => 'Day 11', 'title' => 'Diani Beach', 'activities' => ['Diani beach day', 'Snorkeling', 'Seafood dinner']],
            ['day' => 'Day 12', 'title' => 'Departure', 'activities' => ['Last beach morning', 'Departure from Mombasa']],
        ],
    ],

    'related' => ['tanzania', 'zanzibar', 'cape-town'],
];