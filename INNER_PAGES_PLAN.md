# TravelWorld — Inner Pages Master Plan

---

## 1. SITE STRUCTURE OVERVIEW

```
travelworld/
├── index.php                  (Home — DONE)
│
├── destinations/
│   ├── index.php              (All Destinations — List Page)
│   ├── [country-slug].php     (Country Detail Page)
│   └── data/
│       └── [country-slug].php (Data file per country)
│
├── services/
│   ├── index.php              (All Services — List Page)
│   ├── honeymoon.php
│   ├── adventure.php
│   ├── corporate.php
│   ├── family.php
│   ├── luxury.php
│   └── cruise.php
│
├── about.php                  (About Us)
├── contact.php                (Contact / Enquire)
├── blog/
│   ├── index.php              (Blog List)
│   └── [post-slug].php        (Blog Detail)
│
└── includes/
    ├── header.php             (DONE)
    └── footer.php             (DONE)
```

---

## 2. PAGE TYPES & THEIR PURPOSE

### A. List Pages
| Page | URL | Purpose |
|------|-----|---------|
| All Destinations | `/destinations/` | Grid of all countries with filter by continent |
| All Services | `/services/` | Cards for each service type |
| Blog List | `/blog/` | Travel articles & guides |

### B. Detail Pages
| Page | URL | Purpose |
|------|-----|---------|
| Country Detail | `/destinations/dubai.php` | Full destination guide |
| Service Detail | `/services/honeymoon.php` | Service description + packages |
| Blog Post | `/blog/top-10-dubai.php` | Article content |

### C. Utility Pages
| Page | URL | Purpose |
|------|-----|---------|
| About Us | `/about.php` | Company story, team, values |
| Contact | `/contact.php` | Enquiry form + map |

---

## 3. DESTINATION DETAIL PAGE — STRUCTURE

Every country page (`/destinations/dubai.php`) will have these sections:

```
1. HERO BANNER
   - Full-width image of the destination
   - Country name + tagline
   - Quick stats: Best Time | Duration | Currency | Language

2. OVERVIEW
   - 2–3 paragraph intro about the destination
   - Highlights strip (icons): Weather | Visa | Flight Time | Budget Range

3. MUST VISIT PLACES (Main Section)
   - Grid of 6–10 attraction cards
   - Each card: Image + Place Name + Category tag + Short description
   - Example for Dubai:
     * Burj Khalifa — Iconic Landmark
     * Dubai Mall — Shopping & Entertainment
     * Palm Jumeirah — Island Experience
     * Desert Safari — Adventure
     * Dubai Creek — Heritage
     * Burj Al Arab — Luxury Stay
     * Dubai Frame — Architecture
     * Gold Souk — Shopping
     * Miracle Garden — Nature
     * Atlantis Aquaventure — Family Fun

4. EXPERIENCES / THINGS TO DO
   - Tabbed section: Adventure | Culture | Food | Nightlife | Shopping
   - Each tab: list of 5–8 activities with icon + name + short note

5. WHERE TO STAY
   - 3 budget tiers: Luxury | Mid-Range | Budget
   - 2–3 hotel recommendations per tier with star rating

6. FOOD & CUISINE
   - Must-try dishes + recommended restaurants
   - Image grid style

7. TRAVEL TIPS
   - Best time to visit (month-wise chart)
   - Visa info
   - Local transport
   - Do's & Don'ts
   - Packing tips

8. SAMPLE ITINERARIES
   - 3 Days / 5 Days / 7 Days tabs
   - Day-by-day breakdown

9. ENQUIRE / BOOK CTA
   - Full-width CTA with enquiry form
   - Package starting price (optional)

10. RELATED DESTINATIONS
    - 3–4 similar destination cards
```

---

## 4. ALL DESTINATIONS LIST PAGE — STRUCTURE

```
1. HERO — "Explore the World" banner

2. FILTER BAR
   - By Continent: All | Asia | Europe | Middle East | Americas | Africa | Oceania
   - By Type: Beach | Adventure | Cultural | Luxury | Family | Romantic
   - Search box

3. DESTINATION GRID
   - Card: Image + Country + Region + Tag + "Explore →" button
   - Lazy load / pagination (12 per page)

4. WORLD MAP (optional visual)
   - Interactive or static map with pins

5. FEATURED DESTINATIONS
   - 3 editor's picks highlighted
```

---

## 5. COMPLETE COUNTRY LIST (World Coverage)

### ASIA (20 countries)
| # | Country | Slug | Highlight |
|---|---------|------|-----------|
| 1 | Dubai, UAE | `dubai` | Burj Khalifa, Desert Safari |
| 2 | Bali, Indonesia | `bali` | Temples, Rice Terraces |
| 3 | Tokyo, Japan | `tokyo` | Mt. Fuji, Shibuya |
| 4 | Thailand | `thailand` | Phi Phi Islands, Temples |
| 5 | Maldives | `maldives` | Overwater Bungalows |
| 6 | Singapore | `singapore` | Marina Bay, Gardens |
| 7 | Istanbul, Turkey | `istanbul` | Hagia Sophia, Bosphorus |
| 8 | Vietnam | `vietnam` | Ha Long Bay, Hoi An |
| 9 | Sri Lanka | `sri-lanka` | Sigiriya, Tea Estates |
| 10 | Nepal | `nepal` | Everest, Pokhara |
| 11 | Bhutan | `bhutan` | Tiger's Nest, Happiness |
| 12 | Cambodia | `cambodia` | Angkor Wat |
| 13 | Malaysia | `malaysia` | Petronas, Langkawi |
| 14 | Philippines | `philippines` | Palawan, Chocolate Hills |
| 15 | Jordan | `jordan` | Petra, Wadi Rum |
| 16 | Oman | `oman` | Muscat, Wahiba Sands |
| 17 | Georgia | `georgia` | Tbilisi, Kazbegi |
| 18 | Armenia | `armenia` | Yerevan, Monasteries |
| 19 | Kazakhstan | `kazakhstan` | Almaty, Charyn Canyon |
| 20 | Uzbekistan | `uzbekistan` | Samarkand, Silk Road |

### EUROPE (20 countries)
| # | Country | Slug | Highlight |
|---|---------|------|-----------|
| 1 | Paris, France | `paris` | Eiffel Tower, Louvre |
| 2 | Swiss Alps | `switzerland` | Zermatt, Interlaken |
| 3 | Santorini, Greece | `santorini` | Caldera, Blue Domes |
| 4 | Amalfi, Italy | `amalfi` | Coastal Drive, Positano |
| 5 | Amsterdam, Netherlands | `amsterdam` | Canals, Tulip Fields |
| 6 | Zermatt, Switzerland | `zermatt` | Matterhorn, Skiing |
| 7 | Barcelona, Spain | `barcelona` | Sagrada Familia, Gaudi |
| 8 | Prague, Czech Republic | `prague` | Old Town, Castle |
| 9 | Vienna, Austria | `vienna` | Palaces, Opera |
| 10 | Budapest, Hungary | `budapest` | Thermal Baths, Danube |
| 11 | Dubrovnik, Croatia | `dubrovnik` | Old City Walls, Adriatic |
| 12 | Lisbon, Portugal | `lisbon` | Trams, Sintra |
| 13 | Edinburgh, Scotland | `edinburgh` | Castle, Highlands |
| 14 | Rome, Italy | `rome` | Colosseum, Vatican |
| 15 | Venice, Italy | `venice` | Gondolas, St. Mark's |
| 16 | Reykjavik, Iceland | `iceland` | Northern Lights, Geysers |
| 17 | Bruges, Belgium | `bruges` | Medieval Canals |
| 18 | Zurich, Switzerland | `zurich` | Lake, Old Town |
| 19 | Monaco | `monaco` | Grand Prix, Casinos |
| 20 | Mykonos, Greece | `mykonos` | Windmills, Beaches |

### AMERICAS (10 countries)
| # | Country | Slug | Highlight |
|---|---------|------|-----------|
| 1 | New York, USA | `new-york` | Times Square, Statue of Liberty |
| 2 | Machu Picchu, Peru | `peru` | Inca Trail, Cusco |
| 3 | Rio de Janeiro, Brazil | `rio` | Christ the Redeemer, Carnival |
| 4 | Patagonia, Argentina | `patagonia` | Torres del Paine |
| 5 | Cancun, Mexico | `cancun` | Chichen Itza, Cenotes |
| 6 | Havana, Cuba | `cuba` | Old Havana, Vintage Cars |
| 7 | Vancouver, Canada | `vancouver` | Rockies, Banff |
| 8 | Galapagos, Ecuador | `galapagos` | Wildlife, Darwin |
| 9 | Cartagena, Colombia | `cartagena` | Walled City, Caribbean |
| 10 | Costa Rica | `costa-rica` | Rainforest, Volcanoes |

### AFRICA (8 countries)
| # | Country | Slug | Highlight |
|---|---------|------|-----------|
| 1 | Marrakech, Morocco | `marrakech` | Medina, Sahara |
| 2 | Serengeti, Tanzania | `tanzania` | Safari, Migration |
| 3 | Cape Town, South Africa | `cape-town` | Table Mountain, Winelands |
| 4 | Zanzibar | `zanzibar` | Spice Island, Beaches |
| 5 | Cairo, Egypt | `cairo` | Pyramids, Nile |
| 6 | Nairobi, Kenya | `kenya` | Masai Mara, Amboseli |
| 7 | Seychelles | `seychelles` | Pristine Beaches, Coral |
| 8 | Mauritius | `mauritius` | Lagoons, Luxury Resorts |

### OCEANIA (4 countries)
| # | Country | Slug | Highlight |
|---|---------|------|-----------|
| 1 | Sydney, Australia | `sydney` | Opera House, Harbour Bridge |
| 2 | New Zealand | `new-zealand` | Fiordland, Hobbiton |
| 3 | Fiji | `fiji` | Coral Coast, Overwater |
| 4 | Bora Bora, French Polynesia | `bora-bora` | Lagoon, Overwater Bungalows |

**Total: 62 destination pages**

---

## 6. DATA ARCHITECTURE — HOW TO MANAGE 62 COUNTRIES

### Strategy: PHP Data Files (No Database Needed)

Each country has a data file at `destinations/data/dubai.php`:

```php
<?php
return [
  'name'        => 'Dubai',
  'country'     => 'UAE',
  'continent'   => 'Asia',
  'slug'        => 'dubai',
  'tagline'     => 'Where the Future Meets the Desert',
  'hero_image'  => 'dubai-hero.jpg',
  'best_time'   => 'November – March',
  'duration'    => '4–6 Days',
  'currency'    => 'AED (Dirham)',
  'language'    => 'Arabic / English',
  'visa'        => 'Visa on Arrival for Indians',
  'flight_time' => '3.5 hrs from Mumbai',
  'budget'      => '₹60,000 – ₹1,50,000 per person',
  'overview'    => '...',

  'must_visit'  => [
    ['name' => 'Burj Khalifa', 'category' => 'Landmark', 'desc' => '...', 'image' => '...'],
    // ...
  ],

  'experiences' => [
    'adventure' => ['Desert Safari', 'Skydiving over Palm', ...],
    'culture'   => ['Dubai Museum', 'Al Fahidi Fort', ...],
    'food'      => ['Al Hadheerah', 'Pierchic', ...],
    'shopping'  => ['Dubai Mall', 'Gold Souk', ...],
  ],

  'itineraries' => [
    '3days' => [...],
    '5days' => [...],
    '7days' => [...],
  ],

  'related'     => ['abu-dhabi', 'oman', 'qatar'],
];
```

### Single Template File
`destinations/country.php` — one template that reads the data file based on URL slug:
```php
$slug = $_GET['slug'] ?? 'dubai';
$data = include "data/{$slug}.php";
```

**This means: 1 template + 62 data files = 62 working pages**

---

## 7. SERVICES PAGES — STRUCTURE

Each service page (`/services/honeymoon.php`):

```
1. Hero — Service-specific banner
2. What's Included — Icon grid
3. Popular Packages — 3–4 package cards with price range
4. Why Choose Us for This — 3 USP points
5. Destinations for This Service — filtered destination cards
6. Testimonials — 2–3 relevant reviews
7. Enquiry CTA
```

### Services List:
- Honeymoon Packages
- Adventure Travel
- Corporate Travel
- Family Holidays
- Luxury Escapes
- Cruise Packages
- Group Tours
- Solo Travel

---

## 8. ABOUT PAGE — STRUCTURE

```
1. Hero — "Our Story" banner
2. Who We Are — Company intro
3. Our Mission & Vision
4. Key Stats — Years | Countries | Happy Travelers | Awards
5. Meet the Team — 4–6 team member cards
6. Our Values — Icon grid
7. Awards & Recognition
8. CTA — "Plan Your Journey"
```

---

## 9. CONTACT PAGE — STRUCTURE

```
1. Hero — "Let's Plan Your Dream Trip"
2. Enquiry Form — Name | Email | Phone | Destination | Travel Dates | Budget | Message
3. Contact Info — Phone | Email | Address | WhatsApp
4. Office Hours
5. Google Map embed
6. Social Links
```

---

## 10. IMPLEMENTATION PHASES

### Phase 1 — Foundation (Week 1)
- [ ] Create `destinations/index.php` (list page with filter)
- [ ] Create `destinations/country.php` (single template)
- [ ] Create `destinations/data/` folder
- [ ] Write data files for 16 existing home destinations first

### Phase 2 — Core Destinations (Week 2)
- [ ] Write data files for all 62 countries
- [ ] Add images (use Unsplash URLs or local)
- [ ] Test all 62 pages via slug routing

### Phase 3 — Services (Week 3)
- [ ] `services/index.php`
- [ ] Individual service pages (6–8 pages)

### Phase 4 — Utility Pages (Week 4)
- [ ] `about.php`
- [ ] `contact.php`
- [ ] `blog/index.php` + 3–5 sample posts

### Phase 5 — Polish (Week 5)
- [ ] SEO meta tags on all pages
- [ ] Breadcrumbs
- [ ] Related destinations logic
- [ ] Mobile optimization
- [ ] Page transitions (consistent with home)

---

## 11. SHARED COMPONENTS (PHP Includes)

```
includes/
├── header.php          (DONE — update nav links)
├── footer.php          (DONE)
├── destination-card.php  (reusable card component)
├── enquiry-form.php      (reusable form)
├── breadcrumb.php        (page breadcrumb)
└── page-hero.php         (reusable hero banner)
```

---

## 12. URL STRUCTURE

```
/                              → Home
/destinations/                 → All Destinations
/destinations/dubai            → Dubai Detail (via .htaccess rewrite)
/destinations/paris            → Paris Detail
/services/                     → All Services
/services/honeymoon            → Honeymoon Service
/about                         → About Us
/contact                       → Contact
/blog/                         → Blog List
/blog/top-places-dubai         → Blog Post
```

### .htaccess Rule:
```apache
RewriteRule ^destinations/([a-z-]+)/?$ destinations/country.php?slug=$1 [L,QSA]
RewriteRule ^services/([a-z-]+)/?$ services/service.php?slug=$1 [L,QSA]
```

---

## 13. PRIORITY ORDER (Start Here)

1. **`destinations/index.php`** — most linked from home
2. **`destinations/country.php`** — template for all 62
3. **Data files for 16 home destinations** — already have content
4. **`contact.php`** — every CTA links here
5. **`about.php`**
6. **Services pages**
7. **Remaining 46 country data files**
8. **Blog**

---

*Total pages to build: ~80 (62 destinations + 8 services + about + contact + blog list + 5 posts + list pages)*