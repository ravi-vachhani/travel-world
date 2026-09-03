# Travel World — SEO Action Plan
**Date:** 2026-09-03  
**Priority:** High → Medium → Low

---

## ✅ COMPLETED (This Session)

| # | Action | Impact | Files Changed |
|---|---|---|---|
| 1 | Created `robots.txt` with AI crawler rules (GPTBot, ClaudeBot, PerplexityBot, Google-Extended, etc.) | 🔴 Critical | `robots.txt` |
| 2 | Created `sitemap.xml` with 70+ URLs | 🔴 Critical | `sitemap.xml` |
| 3 | Created `llms.txt` for AI search readiness | 🔴 Critical | `llms.txt` |
| 4 | Added HTTPS + www canonical redirects to `.htaccess` | 🔴 Critical | `.htaccess` |
| 5 | Enhanced security headers (HSTS, X-XSS-Protection, Permissions-Policy) | ⚠️ Warning | `.htaccess` |
| 6 | Updated `includes/page-header.php` — canonical, OG, Twitter Card, JSON-LD slot | 🔴 Critical | `includes/page-header.php` |
| 7 | Updated `includes/header.php` — full meta tags + TravelAgency + WebSite JSON-LD | 🔴 Critical | `includes/header.php` |
| 8 | Added TouristDestination + BreadcrumbList schema to `destinations/country.php` | 🔴 Critical | `destinations/country.php` |
| 9 | Added Service + BreadcrumbList schema to `visa/visa.php` | 🔴 Critical | `visa/visa.php` |
| 10 | Added BlogPosting + BreadcrumbList schema to `blog/post.php` | 🔴 Critical | `blog/post.php` |
| 11 | Added AboutPage + Organization + BreadcrumbList schema to `about.php` | ⚠️ Warning | `about.php` |
| 12 | Added ContactPage + BreadcrumbList schema to `contact.php` | ⚠️ Warning | `contact.php` |
| 13 | Added CollectionPage + BreadcrumbList schema to `destinations/index.php` | ⚠️ Warning | `destinations/index.php` |
| 14 | Added CollectionPage + BreadcrumbList schema to `visa/index.php` | ⚠️ Warning | `visa/index.php` |
| 15 | Added CollectionPage + BreadcrumbList schema to `services/index.php` | ⚠️ Warning | `services/index.php` |
| 16 | Added Blog + BreadcrumbList schema to `blog/index.php` | ⚠️ Warning | `blog/index.php` |

---

## 🔴 CRITICAL — Do Immediately (Week 1)

### 1. Submit Sitemap to Search Engines
- Google Search Console: https://search.google.com/search-console → Add property → Submit sitemap
- Bing Webmaster Tools: https://www.bing.com/webmasters → Submit sitemap
- **Impact:** Ensures all 70+ pages are indexed quickly

### 2. Add Favicon
```html
<!-- Add to includes/header.php and includes/page-header.php <head> -->
<link rel="icon" type="image/png" href="/assets/image/favicon.png">
<link rel="apple-touch-icon" href="/assets/image/apple-touch-icon.png">
```
- Create a 32×32 favicon.ico and 180×180 apple-touch-icon.png from the logo

### 3. Add Service Schema to `services/service.php`
- Pattern: same as `visa/visa.php` — add `$pageKeywords`, `$pageCanonical`, `$ogType`, `$jsonLd` with `Service` type before `include '../includes/page-header.php'`

### 4. Verify Schema with Google Rich Results Test
- URL: https://search.google.com/test/rich-results
- Test: `/destinations/dubai`, `/visa/usa`, `/blog/top-10-things-dubai`

---

## ⚠️ WARNING — Fix Within 1 Month

### 5. Add Author Bio Pages for E-E-A-T
- Create `/blog/author/arjun-mehta.php` and `/blog/author/priya-sharma.php`
- Add `Person` schema with credentials, social profiles
- Link author names in blog posts to these pages
- **Impact:** Improves E-E-A-T signals for AI engines (Gemini, Perplexity, Claude)

### 6. Add FAQ Sections to Key Pages (Plain HTML — NOT FAQPage schema)
- Destination pages: "When to visit?", "Visa required?", "Best hotels?"
- Visa pages: "How long does it take?", "What documents do I need?", "What is the success rate?"
- **Impact:** Captures featured snippets and AI answer boxes

### 7. Optimize Images
- Convert all Unsplash-hosted images to locally hosted WebP files
- Add `loading="lazy"` to all below-fold `<img>` tags
- Ensure all images have descriptive `alt` text with destination keywords
- Target: < 100KB per image

### 8. Add `AggregateRating` Schema to Destination Pages
```php
'aggregateRating' => [
  '@type'       => 'AggregateRating',
  'ratingValue' => '4.8',
  'reviewCount' => '124',
  'bestRating'  => '5',
]
```
- Collect real reviews via WhatsApp/email and display them on pages

### 9. Create a Dynamic Sitemap
- Replace static `sitemap.xml` with `sitemap.php` that auto-generates from data files
- Add `<lastmod>` based on file modification time

### 10. Add `hreflang` if Targeting Multiple Languages
- If adding Hindi or regional language pages, add `<link rel="alternate" hreflang="hi" href="...">` in `page-header.php`

---

## ℹ️ INFO — Ongoing / Long-Term

### 11. Content Strategy
- Publish 2–4 blog posts per month targeting long-tail keywords:
  - "best time to visit Maldives"
  - "Schengen visa requirements for Indians"
  - "Dubai honeymoon package cost"
  - "Japan travel tips first time"
- Each post: 1000+ words, one H1, multiple H2s, internal links to destination pages

### 12. Build Backlinks (Off-Page SEO)
- Submit to travel directories: TripAdvisor, Lonely Planet, Holidify
- Guest post on travel blogs
- Get listed on Google Business Profile (local SEO)
- Earn mentions from travel influencers

### 13. Google Business Profile
- Create/claim: https://business.google.com/
- Add: business name, address, phone, hours, photos, services
- **Impact:** Appears in Google Maps and local search results

### 14. Core Web Vitals Optimization
- Target: LCP < 2.5s, INP < 200ms, CLS < 0.1
- Use PageSpeed Insights: https://pagespeed.web.dev/
- Defer non-critical CSS/JS, preload hero images, use CDN for static assets

### 15. Monitor with Google Search Console
- Track: impressions, clicks, CTR, average position
- Fix: crawl errors, manual actions, mobile usability issues
- Set up: email alerts for coverage issues

---

## Quick Reference — Key URLs to Submit

| Tool | URL |
|---|---|
| Google Search Console | https://search.google.com/search-console |
| Bing Webmaster Tools | https://www.bing.com/webmasters |
| Google Rich Results Test | https://search.google.com/test/rich-results |
| PageSpeed Insights | https://pagespeed.web.dev/ |
| Schema Validator | https://validator.schema.org/ |
| Google Business Profile | https://business.google.com/ |