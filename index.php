<?php include __DIR__ . '/includes/header.php'; ?>

<!-- ═══════════════════════════════════════════
     HERO — Split Layout: Text Left, Map Right
═══════════════════════════════════════════ -->
<section class="hero-map" id="hero">

    <!-- LEFT: Editorial text panel -->
    <div class="hero-left" id="heroText">
        <div class="hero-eyebrow">
            <span class="eyebrow-line"></span>
            <span class="eyebrow-text">LUXURY TRAVEL MANAGEMENT</span>
        </div>
        <h1 class="hero-headline">
            <span class="line line-1">WITH YOU</span>
            <span class="line line-2">AT EVERY</span>
            <span class="line line-3">HORIZON</span>
        </h1>
        <p class="hero-sub">We manage travel end to end — flights, hotels, visas, transfers — for individuals and businesses worldwide.</p>
        <div class="hero-actions">
            <a href="https://wa.me/919904040001?text=Hello%2C%20I%20want%20to%20explore%20destinations!" target="_blank" class="btn-discover">
                <span>START YOUR JOURNEY</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#services" class="btn-ghost-hero">OUR SERVICES</a>
        </div>
        <!-- Trust badges -->
        <div class="hero-trust">
            <div class="trust-item">
                <span class="trust-num">241+</span>
                <span class="trust-label">Destinations</span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <span class="trust-num">24K+</span>
                <span class="trust-label">Happy Travelers</span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <span class="trust-num">7+</span>
                <span class="trust-label">Years Experience</span>
            </div>
        </div>
    </div>

    <!-- RIGHT: Map visual panel -->
    <div class="hero-right" id="mapSvg">
        <div class="map-frame">
            <img src="assets/image/map.png" alt="World Map" class="world-map-img" id="mapBg">
            <!-- Destination pins -->
            <div class="map-pin pin-paris" title="Paris">
                <div class="pin-dot"></div>
                <div class="pin-pulse"></div>
                <span class="pin-label">Paris</span>
            </div>
            <div class="map-pin pin-dubai" title="Dubai">
                <div class="pin-dot"></div>
                <div class="pin-pulse"></div>
                <span class="pin-label">Dubai</span>
            </div>
            <div class="map-pin pin-bali" title="Bali">
                <div class="pin-dot"></div>
                <div class="pin-pulse"></div>
                <span class="pin-label">Bali</span>
            </div>
            <div class="map-pin pin-tokyo" title="Tokyo">
                <div class="pin-dot"></div>
                <div class="pin-pulse"></div>
                <span class="pin-label">Tokyo</span>
            </div>
            <!-- Animated flight paths over map -->
            <svg class="map-flight-svg" viewBox="0 0 700 500" xmlns="http://www.w3.org/2000/svg">
                <path class="flight-path" d="M 120 200 Q 280 80 420 180" />
                <path class="flight-path" d="M 300 160 Q 450 240 580 160" />
                <path class="flight-path" d="M 150 300 Q 350 180 520 260" />
            </svg>
            <!-- Floating dots -->
            <div class="flight-dots">
                <div class="dot dot-1"></div>
                <div class="dot dot-2"></div>
                <div class="dot dot-3"></div>
            </div>
        </div>
        <!-- Decorative floating card — auto-cycling departures -->
        <div class="hero-float-card" id="nextDepartureCard">
            <div class="float-card-icon">✈</div>
            <div class="float-card-text">
                <span class="float-card-title">Next Departure</span>
                <span class="float-card-sub" id="nextDepartureSub">Maldives · 3 seats left</span>
            </div>
        </div>
        <script>
        (function(){
            var departures = [
                'Maldives · 3 seats left',
                'Bali · 5 seats left',
                'Dubai · 2 seats left',
                'Paris · 4 seats left',
                'Tokyo · 6 seats left',
                'Santorini · 2 seats left',
                'Switzerland · 3 seats left',
                'Singapore · 7 seats left',
                'Thailand · 4 seats left',
                'Bhutan · 2 seats left',
            ];
            var el = document.getElementById('nextDepartureSub');
            var card = document.getElementById('nextDepartureCard');
            var idx = 0;
            function next() {
                idx = (idx + 1) % departures.length;
                // Wipe out: slide current text to the right
                el.style.transition = 'transform 0.35s ease-in, opacity 0.35s ease-in';
                el.style.transform = 'translateX(60px)';
                el.style.opacity = '0';
                setTimeout(function(){
                    el.textContent = departures[idx];
                    // Reset to left, then slide in
                    el.style.transition = 'none';
                    el.style.transform = 'translateX(-60px)';
                    el.style.opacity = '0';
                    requestAnimationFrame(function(){
                        requestAnimationFrame(function(){
                            el.style.transition = 'transform 0.4s ease-out, opacity 0.4s ease-out';
                            el.style.transform = 'translateX(0)';
                            el.style.opacity = '1';
                        });
                    });
                }, 380);
            }
            setInterval(next, 3000);
        })();
        </script>
    </div>

    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <div class="scroll-line"></div>
        <span>SCROLL</span>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     SERVICES — Creative Bento Grid
═══════════════════════════════════════════ -->
<section class="services-section" id="services">
    <div class="services-header">
        <div class="services-eyebrow">
            <span class="svc-line"></span>
            <span class="svc-eyebrow-text">WHAT WE OFFER</span>
        </div>
        <h2 class="services-title reveal-text">TRAVEL DESIGNED<br>AROUND YOU</h2>
        <p class="services-subtitle reveal-fade">Two distinct journeys. One dedicated partner.</p>
    </div>

    <div class="services-bento">

        <!-- Card 1 — Private Travel (large, left) -->
        <div class="svc-card svc-card--large" id="panel-private">
            <div class="svc-img-wrap">
                <img src="assets/image/privatetravel.png" alt="Private Travel" class="svc-img">
                <div class="svc-overlay"></div>
            </div>
            <div class="svc-badge">Private</div>
            <div class="svc-num">01</div>
            <div class="svc-body">
                <h3 class="svc-title">PRIVATE<br>TRAVEL</h3>
                <p class="svc-desc">Thoughtfully planned journeys for individuals and families. Every detail handled with care, discretion, and flexibility.</p>
                <a href="services/luxury" class="svc-cta">
                    Explore
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Right column: 2 stacked cards -->
        <div class="svc-right-col">

            <!-- Card 2 — Corporate Travel -->
            <div class="svc-card svc-card--half" id="panel-corporate">
                <div class="svc-img-wrap">
                    <img src="assets/image/corporatetravel.webp" alt="Corporate Travel" class="svc-img">
                    <div class="svc-overlay"></div>
                </div>
                <div class="svc-badge">Corporate</div>
                <div class="svc-num">02</div>
                <div class="svc-body">
                    <h3 class="svc-title">CORPORATE<br>TRAVEL</h3>
                    <p class="svc-desc">Efficient, reliable travel management for businesses and executives who need things done right.</p>
                    <a href="services/corporate" class="svc-cta">
                        Explore
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Card 3 — Group & Events -->
            <div class="svc-card svc-card--half svc-card--accent">
                <div class="svc-num svc-num--light">03</div>
                <div class="svc-body svc-body--dark">
                    <div class="svc-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="svc-title svc-title--dark">GROUP &amp;<br>EVENTS</h3>
                    <p class="svc-desc svc-desc--dark">Seamless coordination for group tours, MICE events, and corporate retreats across the globe.</p>
                    <a href="services/group" class="svc-cta svc-cta--dark">
                        Explore
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div><!-- /svc-right-col -->
    </div><!-- /services-bento -->
</section>

<!-- ═══════════════════════════════════════════
     STATS — Counter Strip
═══════════════════════════════════════════ -->
<section class="stats-section">
    <div class="stats-inner">
        <div class="stat-block">
            <div class="stat-num" data-target="500">0</div>
            <div class="stat-plus">+</div>
            <div class="stat-label">Destinations</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-block">
            <div class="stat-num" data-target="50">0</div>
            <div class="stat-plus">K+</div>
            <div class="stat-label">Happy Travelers</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-block">
            <div class="stat-num" data-target="15">0</div>
            <div class="stat-plus">+</div>
            <div class="stat-label">Years Experience</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-block">
            <div class="stat-num" data-target="98">0</div>
            <div class="stat-plus">%</div>
            <div class="stat-label">Client Satisfaction</div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     VISA SERVICES — Home Section
═══════════════════════════════════════════ -->
<section class="visa-home-section" id="visa">
    <div class="visa-home-inner">
        <div class="visa-home-header">
            <div class="visa-eyebrow">
                <span class="visa-line"></span>
                <span class="visa-eyebrow-text">VISA SERVICES</span>
            </div>
            <h2 class="visa-home-title reveal-text">HASSLE-FREE VISA<br>ASSISTANCE</h2>
            <p class="visa-home-sub reveal-fade">Expert visa guidance for 50+ countries. 90% success rate on USA visas. We handle documentation, appointments & follow-ups end to end.</p>
        </div>

        <!-- USA Highlight Card -->
        <div class="visa-usa-highlight reveal-fade">
            <div class="visa-usa-badge">⭐ 90% Success Rate</div>
            <div class="visa-usa-content">
                <div class="visa-usa-flag"><img src="https://flagcdn.com/w80/us.png" alt="USA Flag"></div>
                <div class="visa-usa-text">
                    <h3>USA Visa — B1/B2 Tourist & Business</h3>
                    <p>Our USA visa specialists have helped 5,000+ applicants secure their US visa. Complete documentation support, mock interview preparation, and DS-160 assistance.</p>
                    <div class="visa-usa-stats">
                        <span><strong>90%</strong> Approval Rate</span>
                        <span><strong>5,000+</strong> Visas Processed</span>
                        <span><strong>7 Days</strong> Avg Processing</span>
                    </div>
                </div>
            </div>
            <a href="visa/usa" class="visa-usa-cta">Apply for USA Visa →</a>
        </div>

        <!-- Other Countries Grid -->
        <div class="visa-countries-grid">
            <a href="visa/uk" class="visa-country-card reveal-fade">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/gb.png" alt="UK"></span>
                <span class="visa-country-name">United Kingdom</span>
                <span class="visa-country-type">Tourist / Business</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/schengen" class="visa-country-card reveal-fade delay-1">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/eu.png" alt="EU"></span>
                <span class="visa-country-name">Schengen (Europe)</span>
                <span class="visa-country-type">26 Countries</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/canada" class="visa-country-card reveal-fade delay-2">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/ca.png" alt="Canada"></span>
                <span class="visa-country-name">Canada</span>
                <span class="visa-country-type">Tourist / Student</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/australia" class="visa-country-card reveal-fade">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/au.png" alt="Australia"></span>
                <span class="visa-country-name">Australia</span>
                <span class="visa-country-type">Tourist / ETA</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/dubai" class="visa-country-card reveal-fade delay-1">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/ae.png" alt="UAE"></span>
                <span class="visa-country-name">Dubai / UAE</span>
                <span class="visa-country-type">Visa on Arrival / E-Visa</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/singapore" class="visa-country-card reveal-fade delay-2">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/sg.png" alt="Singapore"></span>
                <span class="visa-country-name">Singapore</span>
                <span class="visa-country-type">Tourist / Transit</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/thailand" class="visa-country-card reveal-fade">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/th.png" alt="Thailand"></span>
                <span class="visa-country-name">Thailand</span>
                <span class="visa-country-type">Visa on Arrival / E-Visa</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/japan" class="visa-country-card reveal-fade delay-1">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/jp.png" alt="Japan"></span>
                <span class="visa-country-name">Japan</span>
                <span class="visa-country-type">Tourist / Business</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa/new-zealand" class="visa-country-card reveal-fade delay-2">
                <span class="visa-flag"><img src="https://flagcdn.com/w80/nz.png" alt="New Zealand"></span>
                <span class="visa-country-name">New Zealand</span>
                <span class="visa-country-type">Tourist / NZeTA</span>
                <span class="visa-arrow">→</span>
            </a>
            <a href="visa" class="visa-country-card visa-view-all reveal-fade">
                <span class="visa-flag">🌍</span>
                <span class="visa-country-name">50+ Countries</span>
                <span class="visa-country-type">View All Visa Services</span>
                <span class="visa-arrow">→</span>
            </a>
        </div>

        <div class="visa-home-cta">
            <a href="https://wa.me/919904040001?text=Hello%2C%20I%20need%20visa%20assistance!" target="_blank" class="btn-visa-wa">
                <i class="fab fa-whatsapp"></i> Get Free Visa Consultation
            </a>
            <a href="visa" class="btn-visa-all">View All Visa Services →</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     DESTINATIONS — Horizontal Scroll Cards
═══════════════════════════════════════════ -->
<div class="dest-scroll-outer" id="destOuter">
<section class="destinations-section" id="destinations">
    <div class="dest-section-header">
        <div class="dest-label">DESTINATIONS</div>
        <h2 class="dest-title reveal-text">EXPLORE THE WORLD</h2>
        <a href="destinations" class="dest-view-all">View All <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="dest-scroll-track" id="destTrack">
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=700&q=80" alt="Paris">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Europe</span>
                <h3><a href="destinations/paris" style="color:inherit;text-decoration:none;">Paris, France</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">5N · 6D · Romantic</span>
                    <a href="destinations/paris" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=700&q=80" alt="Bali">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Asia</span>
                <h3><a href="destinations/bali" style="color:inherit;text-decoration:none;">Bali, Indonesia</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">6N · 7D · Cultural</span>
                    <a href="destinations/bali" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=700&q=80" alt="Tokyo">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Asia</span>
                <h3><a href="destinations/tokyo" style="color:inherit;text-decoration:none;">Tokyo, Japan</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">7N · 8D · Adventure</span>
                    <a href="destinations/tokyo" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=700&q=80" alt="Dubai">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Middle East</span>
                <h3><a href="destinations/dubai" style="color:inherit;text-decoration:none;">Dubai, UAE</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">4N · 5D · Luxury</span>
                    <a href="destinations/dubai" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=700&q=80" alt="Swiss Alps">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Europe</span>
                <h3><a href="destinations/switzerland" style="color:inherit;text-decoration:none;">Swiss Alps</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">8N · 9D · Scenic</span>
                    <a href="destinations/switzerland" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=700&q=80" alt="Thailand">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Asia</span>
                <h3><a href="destinations/thailand" style="color:inherit;text-decoration:none;">Thailand</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">5N · 6D · Beach</span>
                    <a href="destinations/thailand" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=700&q=80" alt="Maldives">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Indian Ocean</span>
                <h3><a href="destinations/maldives" style="color:inherit;text-decoration:none;">Maldives</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">4N · 5D · Overwater</span>
                    <a href="destinations/maldives" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=700&q=80" alt="Santorini">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Europe</span>
                <h3><a href="destinations/santorini" style="color:inherit;text-decoration:none;">Santorini, Greece</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">6N · 7D · Romantic</span>
                    <a href="destinations/santorini" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=700&q=80" alt="Australia">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Oceania</span>
                <h3><a href="destinations/sydney" style="color:inherit;text-decoration:none;">Sydney, Australia</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">9N · 10D · Explorer</span>
                    <a href="destinations/sydney" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
        <div class="dest-card-new">
            <div class="dest-card-img">
                <img src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=700&q=80" alt="Italy">
                <div class="dest-card-overlay"></div>
            </div>
            <div class="dest-card-info">
                <span class="dest-region">Europe</span>
                <h3><a href="destinations/amalfi" style="color:inherit;text-decoration:none;">Amalfi, Italy</a></h3>
                <div class="dest-card-footer">
                    <span class="dest-tag">7N · 8D · Coastal</span>
                    <a href="destinations/amalfi" class="dest-book">Enquire →</a>
                </div>
            </div>
        </div>
       
    </div>
    <!-- Drag hint -->
    <div class="drag-hint">← Scroll to explore →</div>
</section>
</div><!-- /dest-scroll-outer -->
<script>
// Make entire destination card clickable
document.querySelectorAll('.dest-card-new').forEach(function(card) {
    var link = card.querySelector('h3 a');
    if (!link) return;
    var href = link.getAttribute('href');
    var overlay = document.createElement('a');
    overlay.href = href;
    overlay.className = 'dest-card-link-overlay';
    overlay.setAttribute('aria-hidden', 'true');
    overlay.setAttribute('tabindex', '-1');
    card.insertBefore(overlay, card.firstChild);
});
</script>

<!-- ═══════════════════════════════════════════
     WHY US — Dark Feature Grid
═══════════════════════════════════════════ -->
<section class="why-section" id="why">
    <div class="why-inner">
        <div class="why-left">
            <span class="why-label">WHY TRAVEL WORLD</span>
            <h2 class="why-title reveal-text">YOUR JOURNEY,<br>OUR OBSESSION</h2>
            <p class="why-desc reveal-fade">We go beyond booking. We become your dedicated travel partner — handling every complexity so your experience is seamless, every time.</p>
            <a href="https://wa.me/919904040001?text=Tell%20me%20more%20about%20your%20services" target="_blank" class="btn-dark">Get In Touch</a>
        </div>
        <div class="why-right">
            <div class="why-card reveal-fade">
                <div class="why-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <h4>Safe & Secure</h4>
                    <p>All tours fully insured with strict safety protocols and 24/7 emergency support.</p>
                </div>
            </div>
            <div class="why-card reveal-fade delay-1">
                <div class="why-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div>
                    <h4>24/7 Support</h4>
                    <p>Our dedicated team is available round the clock — before, during, and after your trip.</p>
                </div>
            </div>
            <div class="why-card reveal-fade delay-2">
                <div class="why-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <div>
                    <h4>Personalised Experience</h4>
                    <p>Every itinerary is crafted uniquely for you — your preferences, your pace, your journey.</p>
                </div>
            </div>
            <div class="why-card reveal-fade delay-3">
                <div class="why-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                    <h4>Award Winning</h4>
                    <p>Recognised as India's best travel company for 5 consecutive years by leading associations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     TESTIMONIALS — Elegant Cards
═══════════════════════════════════════════ -->
<section class="testimonials-section" id="testimonials">
    <div class="test-header">
        <span class="test-label">TESTIMONIALS</span>
        <h2 class="test-title reveal-text">WHAT OUR TRAVELERS SAY</h2>
    </div>
    <div class="test-grid">
        <div class="test-card reveal-fade">
            <div class="test-quote">"</div>
            <p>TravelWorld ne hamare honeymoon ko bilkul magical bana diya! Bali trip mein har cheez perfect thi — hotel, transfers, activities sab. Ek baar zaroor try karein!</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=47" alt="Priya Sharma">
                <div>
                    <strong>Priya &amp; Rohan Sharma</strong>
                    <span>Mumbai, Maharashtra</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
        <div class="test-card reveal-fade delay-1">
            <div class="test-quote">"</div>
            <p>Switzerland trip was beyond our dreams! The team arranged everything flawlessly — from Zurich to Zermatt. Best travel agency we have ever used. Highly recommended!</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=12" alt="Arjun Mehta">
                <div>
                    <strong>Arjun Mehta</strong>
                    <span>Ahmedabad, Gujarat</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
        <div class="test-card reveal-fade delay-2">
            <div class="test-quote">"</div>
            <p>Dubai family trip with 2 kids was stress-free thanks to TravelWorld. Desert safari, Burj Khalifa, everything was pre-arranged. 24/7 support is a lifesaver!</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=45" alt="Anjali Patel">
                <div>
                    <strong>Anjali &amp; Suresh Patel</strong>
                    <span>Surat, Gujarat</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
        <div class="test-card reveal-fade delay-3">
            <div class="test-quote">"</div>
            <p>Solo trip to Japan was my best decision ever! TravelWorld's itinerary was perfect — Tokyo, Kyoto, Osaka. As a solo female traveller I felt completely safe and supported.</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=49" alt="Sneha Nair">
                <div>
                    <strong>Sneha Nair</strong>
                    <span>Bengaluru, Karnataka</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
        <div class="test-card reveal-fade delay-1">
            <div class="test-quote">"</div>
            <p>Maldives overwater villa experience was absolutely breathtaking. TravelWorld got us the best deal and handled every detail. Our anniversary trip was unforgettable!</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=15" alt="Vikram Singh">
                <div>
                    <strong>Vikram &amp; Kavita Singh</strong>
                    <span>New Delhi, Delhi</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
        <div class="test-card reveal-fade delay-2">
            <div class="test-quote">"</div>
            <p>Europe trip covering Paris, Rome and Barcelona in 12 days — TravelWorld planned it perfectly. Visa assistance was smooth and the hotels were excellent value!</p>
            <div class="test-author">
                <img src="https://i.pravatar.cc/80?img=32" alt="Deepika Joshi">
                <div>
                    <strong>Deepika Joshi</strong>
                    <span>Pune, Maharashtra</span>
                    <div class="test-stars">★★★★★</div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- ═══════════════════════════════════════════
     CTA — Full Bleed Dark
═══════════════════════════════════════════ -->
<section class="cta-new" id="cta">
    <div class="cta-bg">
        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600&q=80" alt="Adventure" class="cta-bg-img" id="ctaBgImg">
        <div class="cta-overlay"></div>
    </div>
    <div class="cta-content">
        <span class="cta-label">START YOUR JOURNEY</span>
        <h2 class="cta-headline reveal-text">READY TO EXPLORE<br>THE WORLD?</h2>
        <p class="reveal-fade">Book your dream vacation today and get exclusive early bird discounts up to 30% off.</p>
        <div class="cta-actions">
            <a href="https://wa.me/919904040001?text=Hello%2C%20I%20want%20to%20plan%20my%20trip!" target="_blank" class="btn-cta-primary">
                <i class="fab fa-whatsapp"></i> Plan My Trip
            </a>
            <a href="https://wa.me/919904040001?text=Hello%2C%20I%20need%20help%20with%20a%20tour%20booking." target="_blank" class="btn-cta-outline">
                Chat With Us
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>