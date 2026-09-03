/* ═══════════════════════════════════════════════════════════════
   TRAVELWORLD — INNER PAGES JS
   ═══════════════════════════════════════════════════════════════ */

const WA_NUMBER = '919876543210'; // WhatsApp number (no + sign)

/* Build WhatsApp URL from form fields */
function buildWhatsAppURL(form) {
  const dest    = form.querySelector('[name="dest"]')?.value || '';
  const name    = form.querySelector('[name="name"]')?.value || '';
  const dates   = form.querySelector('[name="dates"]')?.value || '';
  const travellers = form.querySelector('[name="travellers"]')?.value || '';
  const duration   = form.querySelector('[name="duration"]')?.value || '';
  const budget     = form.querySelector('[name="budget"]')?.value || '';
  const message    = form.querySelector('[name="message"]')?.value || '';
  const phone      = form.querySelector('[name="phone"]')?.value || '';
  const service    = form.querySelector('[name="service"]')?.value || '';

  // Detect page context from URL
  const path = window.location.pathname;
  let context = 'TravelWorld Enquiry';
  if (path.includes('/destinations/')) {
    const slug = path.split('/destinations/')[1]?.replace(/\//g,'') || '';
    context = slug ? `Destination Enquiry: ${slug.replace(/-/g,' ').replace(/\b\w/g,c=>c.toUpperCase())}` : 'Destination Enquiry';
  } else if (path.includes('/services/')) {
    const slug = path.split('/services/')[1]?.replace(/\//g,'') || '';
    context = slug ? `Service Enquiry: ${slug.replace(/-/g,' ').replace(/\b\w/g,c=>c.toUpperCase())}` : 'Service Enquiry';
  } else if (path.includes('/contact')) {
    context = 'Contact Enquiry';
  } else if (path.includes('/about')) {
    context = 'General Enquiry';
  }

  let text = `*${context}*\n\n`;
  if (name)       text += `👤 Name: ${name}\n`;
  if (phone)      text += `📞 Phone: ${phone}\n`;
  if (dest)       text += `📍 Destination: ${dest}\n`;
  if (dates)      text += `📅 Dates: ${dates}\n`;
  if (travellers) text += `👥 Travellers: ${travellers}\n`;
  if (duration)   text += `⏱ Duration: ${duration}\n`;
  if (budget)     text += `💰 Budget: ${budget}\n`;
  if (service)    text += `🎯 Service: ${service}\n`;
  if (message)    text += `\n💬 Message: ${message}\n`;
  text += `\nSent from TravelWorld website`;

  return `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(text)}`;
}

document.addEventListener('DOMContentLoaded', () => {

  /* ── NAVBAR SCROLL ─────────────────────────────────────────── */
  const header = document.getElementById('header');
  if (header) {
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 60);
    });
  }

  /* ── MOBILE MENU ───────────────────────────────────────────── */
  const hamburger  = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  const closeBtn   = document.getElementById('mobileMenuClose');

  if (hamburger && mobileMenu) {
    function closeMenu() {
      mobileMenu.classList.remove('open');
      hamburger.classList.remove('open');
      document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('open');
      hamburger.classList.toggle('open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    if (closeBtn) closeBtn.addEventListener('click', closeMenu);

    mobileMenu.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', closeMenu);
    });

    // Close on backdrop tap
    mobileMenu.addEventListener('click', (e) => {
      if (e.target === mobileMenu) closeMenu();
    });
  }

  /* ── SCROLL REVEAL ─────────────────────────────────────────── */
  const reveals = document.querySelectorAll('.reveal');
  if (reveals.length) {
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
          }
        });
      }, { threshold: 0, rootMargin: '0px 0px -40px 0px' });
      reveals.forEach(el => observer.observe(el));
    } else {
      // Fallback: make all visible immediately
      reveals.forEach(el => el.classList.add('visible'));
    }
  }

  /* ── EXPERIENCE TABS ───────────────────────────────────────── */
  document.querySelectorAll('.tabs-nav').forEach(nav => {
    const btns   = nav.querySelectorAll('.tab-btn');
    const section = nav.closest('section, .inner-section');
    const panels = section ? section.querySelectorAll('.tab-panel') : [];
    btns.forEach((btn, i) => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.classList.remove('active'));
        panels.forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        if (panels[i]) panels[i].classList.add('active');
      });
    });
    if (btns[0]) btns[0].classList.add('active');
    if (panels[0]) panels[0].classList.add('active');
  });

  /* ── ITINERARY TABS ────────────────────────────────────────── */
  document.querySelectorAll('.itinerary-tabs').forEach(nav => {
    const btns   = nav.querySelectorAll('.itin-btn');
    const section = nav.closest('section, .inner-section');
    const panels = section ? section.querySelectorAll('.itin-panel') : [];
    btns.forEach((btn, i) => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.classList.remove('active'));
        panels.forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        if (panels[i]) panels[i].classList.add('active');
      });
    });
    if (btns[0]) btns[0].classList.add('active');
    if (panels[0]) panels[0].classList.add('active');
  });

  /* ── DESTINATION LIST FILTER ───────────────────────────────── */
  const filterBtns  = document.querySelectorAll('.filter-btn[data-filter]');
  const destCards   = document.querySelectorAll('.dest-list-card[data-continent]');
  const searchInput = document.querySelector('.filter-search input');

  function applyFilter() {
    const activeBtn    = document.querySelector('.filter-btn[data-filter].active');
    const activeFilter = activeBtn ? activeBtn.dataset.filter : 'all';
    const searchVal    = searchInput ? searchInput.value.toLowerCase() : '';
    destCards.forEach(card => {
      const continent  = card.dataset.continent || '';
      const name       = (card.dataset.name || '').toLowerCase();
      const matchFilter = activeFilter === 'all' || continent === activeFilter;
      const matchSearch = !searchVal || name.includes(searchVal);
      card.style.display = (matchFilter && matchSearch) ? 'block' : 'none';
    });
  }

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyFilter();
    });
  });
  if (searchInput) searchInput.addEventListener('input', applyFilter);

  /* ── ALL FORMS → WHATSAPP ──────────────────────────────────── */
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const url = buildWhatsAppURL(form);
      window.open(url, '_blank');
    });
  });

  /* ── ALL "ENQUIRE" / "CONTACT" BUTTONS → WHATSAPP ─────────── */
  // Any standalone button/link with these classes that is NOT inside a form
/* ── CURSOR DOT (plane icon — same as home page) ── */
(function initCursorDot() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const dot = document.createElement('div');
  dot.className = 'cursor-dot';
  dot.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#9a6f28"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/></svg>`;
  dot.style.cssText = `
    position:fixed;width:22px;height:22px;pointer-events:none;z-index:9999;
    transform:translate(-50%,-50%) rotate(45deg);transition:transform 0.15s,opacity 0.3s;
    opacity:0;filter:drop-shadow(0 2px 4px rgba(154,111,40,0.4));
  `;

  const ring = document.createElement('div');
  ring.className = 'cursor-ring';
  ring.style.cssText = `
    position:fixed;width:36px;height:36px;border:1px solid rgba(154,111,40,0.4);
    border-radius:50%;pointer-events:none;z-index:9998;
    transform:translate(-50%,-50%);transition:left 0.12s ease-out,top 0.12s ease-out,opacity 0.3s;
    opacity:0;
  `;

  document.body.appendChild(ring);
  document.body.appendChild(dot);

  document.addEventListener('mousemove', e => {
    dot.style.left  = e.clientX + 'px';
    dot.style.top   = e.clientY + 'px';
    dot.style.opacity = '1';
    ring.style.left = e.clientX + 'px';
    ring.style.top  = e.clientY + 'px';
    ring.style.opacity = '1';
  });

  document.addEventListener('mouseleave', () => {
    dot.style.opacity  = '0';
    ring.style.opacity = '0';
  });

  document.querySelectorAll('a,button,[role="button"]').forEach(el => {
    el.addEventListener('mouseenter', () => {
      dot.style.transform  = 'translate(-50%,-50%) rotate(45deg) scale(1.4)';
      ring.style.transform = 'translate(-50%,-50%) scale(1.5)';
    });
    el.addEventListener('mouseleave', () => {
      dot.style.transform  = 'translate(-50%,-50%) rotate(45deg) scale(1)';
      ring.style.transform = 'translate(-50%,-50%) scale(1)';
    });
  });
})();
  document.querySelectorAll('.btn-submit:not(form .btn-submit), a.btn-enquire, a[data-wa]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      if (btn.tagName === 'A' && btn.href && !btn.href.includes('wa.me')) {
        // only intercept if not already a WA link
        e.preventDefault();
        window.open(`https://wa.me/${WA_NUMBER}?text=${encodeURIComponent('Hello, I would like to enquire about a trip.')}`, '_blank');
      }
    });
  });

  /* ── HERO PARALLAX ─────────────────────────────────────────── */
  const heroBg = document.querySelector('.page-hero-bg');
  if (heroBg) {
    window.addEventListener('scroll', () => {
      heroBg.style.transform = `scale(1.05) translateY(${window.scrollY * 0.25}px)`;
    }, { passive: true });
  }

});