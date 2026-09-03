/* ═══════════════════════════════════════════════════════
   TRAVEL WORLD — Main JavaScript
   Parallax · Scroll Reveal · Counter · Drag Scroll · Menu
═══════════════════════════════════════════════════════ */

'use strict';

/* ── DOM Ready ── */
document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initMobileMenu();
    initParallax();
    initScrollReveal();
    initCounters();
    initDestSlider();
    initWhatsAppFloat();
    initCursorDot();
});

/* ══════════════════════════════════════════
   HEADER — Scroll State
══════════════════════════════════════════ */
function initHeader() {
    const header = document.getElementById('header');
    if (!header) return;

    const onScroll = () => {
        if (window.scrollY > 60) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ══════════════════════════════════════════
   MOBILE MENU
══════════════════════════════════════════ */
function initMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeBtn  = document.getElementById('mobileMenuClose');
    if (!hamburger || !mobileMenu) return;

    // Create backdrop element
    let backdrop = document.querySelector('.mobile-menu-backdrop');
    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'mobile-menu-backdrop';
        document.body.appendChild(backdrop);
    }

    function closeMenu() {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('open');
        backdrop.classList.remove('open');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.toggle('open');
        hamburger.classList.toggle('open', isOpen);
        backdrop.classList.toggle('open', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close button inside menu
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);

    // Close on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    // Close on backdrop click
    backdrop.addEventListener('click', closeMenu);
}

/* ══════════════════════════════════════════
   PARALLAX — Multi-layer
══════════════════════════════════════════ */
function initParallax() {
    const mapBg    = document.getElementById('mapBg');
    const mapSvg   = document.getElementById('mapSvg');
    const mapPhoto = document.getElementById('mapPhoto');
    const heroText = document.getElementById('heroText');
    const statementImg = document.getElementById('statementImg');
    const ctaBgImg = document.getElementById('ctaBgImg');

    let ticking = false;

    const onScroll = () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const scrollY = window.scrollY;

                // Hero parallax layers (different speeds)
                if (mapBg)    mapBg.style.transform    = `translateY(${scrollY * 0.15}px)`;
                if (mapSvg)   mapSvg.style.transform   = `translateY(${scrollY * 0.25}px)`;
                if (mapPhoto) mapPhoto.style.transform  = `translateY(${scrollY * 0.35}px)`;
                if (heroText) heroText.style.transform  = `translateY(${scrollY * 0.2}px)`;

                // Statement section parallax
                if (statementImg) {
                    const section = statementImg.closest('.statement-section');
                    if (section) {
                        const rect = section.getBoundingClientRect();
                        const offset = (rect.top + rect.height / 2 - window.innerHeight / 2);
                        statementImg.style.transform = `translateY(${offset * 0.12}px) scale(1.1)`;
                    }
                }

                // CTA parallax
                if (ctaBgImg) {
                    const section = ctaBgImg.closest('.cta-new');
                    if (section) {
                        const rect = section.getBoundingClientRect();
                        const offset = (rect.top + rect.height / 2 - window.innerHeight / 2);
                        ctaBgImg.style.transform = `translateY(${offset * 0.1}px) scale(1.1)`;
                    }
                }

                ticking = false;
            });
            ticking = true;
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });

    // Mouse parallax on hero map
    const heroSection = document.getElementById('hero');
    if (heroSection && mapSvg) {
        heroSection.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const cx = window.innerWidth / 2;
            const cy = window.innerHeight / 2;
            const dx = (clientX - cx) / cx;
            const dy = (clientY - cy) / cy;

            const scrollY = window.scrollY;
            mapSvg.style.transform   = `translateY(${scrollY * 0.25}px) translate(${dx * 12}px, ${dy * 8}px)`;
            if (mapPhoto) mapPhoto.style.transform = `translateY(${scrollY * 0.35}px) translate(${dx * 18}px, ${dy * 12}px)`;
        });
    }
}

/* ══════════════════════════════════════════
   SCROLL REVEAL — Intersection Observer
══════════════════════════════════════════ */
function initScrollReveal() {
    const elements = document.querySelectorAll('.reveal-text, .reveal-fade');

    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -60px 0px'
    });

    elements.forEach(el => observer.observe(el));
}

/* ══════════════════════════════════════════
   COUNTERS — Animated Numbers
══════════════════════════════════════════ */
function initCounters() {
    const counters = document.querySelectorAll('.stat-num');
    if (!counters.length) return;

    const easeOut = (t) => 1 - Math.pow(1 - t, 3);

    const animateCounter = (el) => {
        const target = parseInt(el.dataset.target, 10);
        const duration = 2000;
        const start = performance.now();

        const update = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.round(easeOut(progress) * target);
            el.textContent = value;
            if (progress < 1) requestAnimationFrame(update);
        };

        requestAnimationFrame(update);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(el => observer.observe(el));
}

/* ══════════════════════════════════════════
   DRAG SCROLL — Destinations Track
══════════════════════════════════════════ */
function initDestSlider() {
    const outer   = document.getElementById('destOuter');
    const section = document.getElementById('destinations');
    const track   = document.getElementById('destTrack');
    if (!outer || !section || !track) return;

    const cards = track.querySelectorAll('.dest-card-new');
    const TOTAL = cards.length;
    const STEP  = 340; // px per card scroll step in outer container

    // Set outer height: viewport height (section) + one STEP per card transition
    const outerH = window.innerHeight + (TOTAL - 1) * STEP;
    outer.style.height = outerH + 'px';

    function update() {
        const outerTop = outer.getBoundingClientRect().top;
        // How far we've scrolled into the outer container
        const scrolled = Math.max(0, -outerTop);
        // Which card index to show
        const idx = Math.min(TOTAL - 1, Math.floor(scrolled / STEP));
        const CARD_W = cards[0].offsetWidth + 24;
        track.scrollTo({ left: idx * CARD_W, behavior: 'smooth' });
    }

    window.addEventListener('scroll', update, { passive: true });
    update();
}

/* ══════════════════════════════════════════
   WHATSAPP FLOAT — Show after scroll
══════════════════════════════════════════ */
function initWhatsAppFloat() {
    const btn = document.querySelector('.whatsapp-float');
    if (!btn) return;

    btn.style.opacity = '0';
    btn.style.transform = 'scale(0.8)';
    btn.style.transition = 'opacity 0.4s, transform 0.4s';

    const show = () => {
        if (window.scrollY > 300) {
            btn.style.opacity = '1';
            btn.style.transform = 'scale(1)';
        } else {
            btn.style.opacity = '0';
            btn.style.transform = 'scale(0.8)';
        }
    };

    window.addEventListener('scroll', show, { passive: true });
}

/* ══════════════════════════════════════════
   CUSTOM CURSOR DOT
══════════════════════════════════════════ */
function initCursorDot() {
    // Only on desktop
    if (window.matchMedia('(pointer: coarse)').matches) return;

    const dot = document.createElement('div');
    dot.className = 'cursor-dot';
    dot.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#9a6f28"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/></svg>`;
    dot.style.cssText = `
        position: fixed;
        width: 22px;
        height: 22px;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%) rotate(45deg);
        transition: transform 0.15s, opacity 0.3s;
        opacity: 0;
        filter: drop-shadow(0 2px 4px rgba(154,111,40,0.4));
    `;

    const ring = document.createElement('div');
    ring.className = 'cursor-ring';
    ring.style.cssText = `
        position: fixed;
        width: 36px;
        height: 36px;
        border: 1px solid rgba(201,168,76,0.5);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9998;
        transform: translate(-50%, -50%);
        transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), width 0.3s, height 0.3s, opacity 0.3s;
        opacity: 0;
    `;

    document.body.appendChild(dot);
    document.body.appendChild(ring);

    let mouseX = 0, mouseY = 0;
    let ringX = 0, ringY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        dot.style.left = mouseX + 'px';
        dot.style.top  = mouseY + 'px';
        dot.style.opacity = '1';
        ring.style.opacity = '1';
    });

    // Smooth ring follow
    const animateRing = () => {
        ringX += (mouseX - ringX) * 0.12;
        ringY += (mouseY - ringY) * 0.12;
        ring.style.left = ringX + 'px';
        ring.style.top  = ringY + 'px';
        requestAnimationFrame(animateRing);
    };
    animateRing();

    // Expand on hover over interactive elements
    const interactives = document.querySelectorAll('a, button, .service-panel, .dest-card-new, .why-card');
    interactives.forEach(el => {
        el.addEventListener('mouseenter', () => {
            dot.style.width  = '14px';
            dot.style.height = '14px';
            ring.style.width  = '56px';
            ring.style.height = '56px';
        });
        el.addEventListener('mouseleave', () => {
            dot.style.width  = '8px';
            dot.style.height = '8px';
            ring.style.width  = '36px';
            ring.style.height = '36px';
        });
    });

    document.addEventListener('mouseleave', () => {
        dot.style.opacity = '0';
        ring.style.opacity = '0';
    });
}

/* ══════════════════════════════════════════
   SMOOTH ANCHOR SCROLL
══════════════════════════════════════════ */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
        const target = document.querySelector(anchor.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

/* ══════════════════════════════════════════
   CONTINENT HOVER GLOW on Map
══════════════════════════════════════════ */
document.querySelectorAll('.continent').forEach(path => {
    path.addEventListener('mouseenter', () => {
        path.style.fill = '#8b6914';
        path.style.filter = 'drop-shadow(0 0 16px rgba(201,168,76,0.6))';
    });
    path.addEventListener('mouseleave', () => {
        path.style.fill = '#5c3d0e';
        path.style.filter = 'drop-shadow(0 0 8px rgba(139,105,20,0.3))';
    });
});

/* ══════════════════════════════════════════
   WHATSAPP FLOAT CSS (injected)
══════════════════════════════════════════ */
const style = document.createElement('style');
style.textContent = `
.whatsapp-float {
    position: fixed;
    bottom: 32px;
    right: 32px;
    width: 56px;
    height: 56px;
    background: #25D366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    z-index: 900;
    box-shadow: 0 4px 20px rgba(37,211,102,0.4);
    transition: transform 0.3s, box-shadow 0.3s;
}
.whatsapp-float:hover {
    transform: scale(1.12) translateY(-3px);
    box-shadow: 0 8px 30px rgba(37,211,102,0.5);
}
@media (max-width: 768px) {
    .whatsapp-float { bottom: 20px; right: 20px; width: 50px; height: 50px; font-size: 22px; }
}
`;
document.head.appendChild(style);