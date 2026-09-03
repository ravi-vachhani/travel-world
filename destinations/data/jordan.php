<?php
return [
    'name' => 'Jordan',
    'country' => 'Jordan',
    'continent' => 'Asia',
    'slug' => 'jordan',
    'tagline' => 'Petra, Wadi Rum & the Dead Sea',
    'hero_image' => 'https://images.unsplash.com/photo-1548786811-dd6e453ccca7?w=1600&q=80',
    'best_time' => 'Mar–May, Sep–Nov',
    'duration' => '5–8 Days',
    'currency' => 'Jordanian Dinar (JOD)',
    'language' => 'Arabic, English',
    'visa' => 'Jordan Pass (includes visa)',
    'flight_time' => '~5 hrs from Mumbai',
    'budget' => '₹80,000–₹1,80,000',
    'overview' => 'Jordan is a land of extraordinary ancient wonders — the rose-red city of Petra carved into sandstone cliffs, the otherworldly desert landscape of Wadi Rum where Lawrence of Arabia roamed, and the Dead Sea where you float effortlessly in the world\'s saltiest body of water. Despite being surrounded by regional conflicts, Jordan is one of the Middle East\'s safest and most welcoming destinations. The Jordanian people are renowned for their hospitality, and the country\'s compact size makes it possible to experience ancient history, desert adventure, and Red Sea diving all in one trip.',

    'must_visit' => [
        [
            'name' => 'Petra',
            'category' => 'UNESCO Wonder',
            'desc' => 'The rose-red Nabataean city carved into sandstone cliffs — one of the New Seven Wonders of the World and Jordan\'s most iconic sight.',
            'img' => 'https://images.unsplash.com/photo-1548786811-dd6e453ccca7?w=800&q=80',
        ],
        [
            'name' => 'Wadi Rum',
            'category' => 'Desert',
            'desc' => 'A vast, silent desert of red sand and dramatic sandstone mountains — camp overnight under a sky blazing with stars.',
            'img' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=800&q=80',
        ],
        [
            'name' => 'Dead Sea',
            'category' => 'Natural Wonder',
            'desc' => 'Float effortlessly in the world\'s saltiest lake at 430m below sea level — the lowest point on Earth, with mineral-rich mud.',
            'img' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
        ],
        [
            'name' => 'Jerash',
            'category' => 'Roman Ruins',
            'desc' => 'One of the best-preserved Roman cities outside Italy — colonnaded streets, temples, and theatres dating to the 1st century AD.',
            'img' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80',
        ],
        [
            'name' => 'Amman',
            'category' => 'Capital City',
            'desc' => 'Jordan\'s modern capital built on seven hills, with the ancient Citadel, Roman Theatre, and a vibrant café and food scene.',
            'img' => 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800&q=80',
        ],
        [
            'name' => 'Petra by Night',
            'category' => 'Iconic Experience',
            'desc' => 'Walk the candlelit Siq to the Treasury under a sky full of stars — one of the world\'s most magical evening experiences.',
            'img' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800&q=80',
        ],
        [
            'name' => 'Aqaba Red Sea',
            'category' => 'Diving',
            'desc' => 'Jordan\'s only coastal city on the Red Sea — world-class diving and snorkeling in crystal-clear waters with vibrant coral reefs.',
            'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
    ],

    'experiences' => [
        'adventure' => [
            ['title' => 'Wadi Rum Desert Camp', 'desc' => 'Sleep under the stars in a Bedouin camp in Wadi Rum — jeep safari by day, campfire and stargazing by night.'],
            ['title' => 'Dead Sea Float', 'desc' => 'Float effortlessly in the Dead Sea\'s hyper-saline water and cover yourself in mineral-rich black mud for a natural spa treatment.'],
            ['title' => 'Aqaba Diving', 'desc' => 'Dive the Red Sea\'s pristine coral reefs and WWII shipwrecks off Aqaba — some of the world\'s most accessible diving.'],
        ],
        'culture' => [
            ['title' => 'Petra by Night', 'desc' => 'Walk the candlelit Siq to the Treasury on Monday, Wednesday, and Thursday evenings — a magical, unforgettable experience.'],
            ['title' => 'Jerash Roman City', 'desc' => 'Explore the remarkably preserved Roman city of Jerash — colonnaded streets, temples, and a chariot racing demonstration.'],
            ['title' => 'Madaba Mosaic Map', 'desc' => 'See the oldest surviving map of the Holy Land — a 6th-century Byzantine mosaic floor map in Madaba\'s St. George Church.'],
        ],
        'food' => [
            ['title' => 'Mansaf', 'desc' => 'Eat Jordan\'s national dish — mansaf, a whole lamb slow-cooked in fermented yogurt sauce, served on a bed of rice and flatbread.'],
            ['title' => 'Amman Street Food', 'desc' => 'Graze through Amman\'s Rainbow Street and downtown for falafel, hummus, knafeh, and freshly squeezed pomegranate juice.'],
            ['title' => 'Bedouin Tea in Wadi Rum', 'desc' => 'Sip sweet sage tea with Bedouin hosts around a desert campfire — a simple ritual that embodies Jordanian hospitality.'],
        ],
        'shopping' => [
            ['title' => 'Rainbow Street Amman', 'desc' => 'Browse Rainbow Street\'s boutiques for Jordanian olive oil soap, Dead Sea products, and artisan crafts.'],
            ['title' => 'Dead Sea Minerals', 'desc' => 'Buy authentic Dead Sea mineral products — mud masks, salt scrubs, and skincare — from reputable shops.'],
            ['title' => 'Petra Sand Bottles', 'desc' => 'Watch artisans create intricate sand art inside glass bottles — a uniquely Jordanian souvenir from Petra.'],
        ],
    ],

    'itineraries' => [
        '5days' => [
            ['day' => 'Day 1', 'title' => 'Amman Arrival', 'activities' => ['Arrive Amman', 'Citadel & Roman Theatre', 'Rainbow Street', 'Mansaf dinner']],
            ['day' => 'Day 2', 'title' => 'Jerash & Dead Sea', 'activities' => ['Jerash Roman city', 'Ajloun Castle', 'Dead Sea float', 'Mud bath']],
            ['day' => 'Day 3', 'title' => 'Petra', 'activities' => ['Drive to Petra', 'The Siq & Treasury', 'Street of Facades', 'Petra by Night']],
            ['day' => 'Day 4', 'title' => 'Petra & Wadi Rum', 'activities' => ['Petra Monastery hike', 'Drive to Wadi Rum', 'Jeep safari', 'Desert camp overnight']],
            ['day' => 'Day 5', 'title' => 'Farewell', 'activities' => ['Wadi Rum sunrise', 'Drive to Amman', 'Last falafel & hummus', 'Departure']],
        ],
        '7days' => [
            ['day' => 'Day 1', 'title' => 'Amman', 'activities' => ['Arrive, Citadel', 'Roman Theatre', 'Rainbow Street']],
            ['day' => 'Day 2', 'title' => 'Jerash', 'activities' => ['Jerash Roman city', 'Ajloun Castle', 'Amman return']],
            ['day' => 'Day 3', 'title' => 'Dead Sea', 'activities' => ['Madaba mosaic map', 'Mount Nebo', 'Dead Sea float & mud']],
            ['day' => 'Day 4', 'title' => 'Petra', 'activities' => ['Drive to Petra', 'Siq & Treasury', 'Street of Facades']],
            ['day' => 'Day 5', 'title' => 'Petra Full Day', 'activities' => ['Monastery hike', 'High Place of Sacrifice', 'Petra by Night']],
            ['day' => 'Day 6', 'title' => 'Wadi Rum', 'activities' => ['Wadi Rum jeep safari', 'Lawrence\'s Spring', 'Desert camp & stargazing']],
            ['day' => 'Day 7', 'title' => 'Aqaba & Farewell', 'activities' => ['Aqaba Red Sea snorkeling', 'Seafood lunch', 'Fly to Amman', 'Departure']],
        ],
    ],

    'related' => ['dubai', 'istanbul', 'oman'],
];