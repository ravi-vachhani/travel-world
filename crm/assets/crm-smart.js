/* ============================================================
   Travel World CRM — Smart fields
   Autocomplete + mobile lookup + auto-fill, with an inline
   loading spinner and a material-style dropdown.
   Progressive enhancement: never blocks normal form submit.
   ============================================================ */
(function () {
  'use strict';

  function debounce(fn, ms) {
    let t;
    return function () {
      const a = arguments, c = this;
      clearTimeout(t);
      t = setTimeout(() => fn.apply(c, a), ms);
    };
  }

  function escapeHtml(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, m =>
      ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  }

  function initials(name) {
    const p = String(name || '').trim().split(/\s+/).filter(Boolean);
    if (!p.length) return '?';
    return (p[0][0] + (p[1] ? p[1][0] : '')).toUpperCase();
  }

  async function apiSearch(type, q) {
    const url = '/crm/api/search.php?type=' + encodeURIComponent(type) + '&q=' + encodeURIComponent(q);
    const r = await fetch(url, { credentials: 'same-origin' });
    return (await r.json()).results || [];
  }

  // Wrap an input so we can show an inline spinner on its right edge.
  function wrap(input) {
    const parent = input.parentNode;
    parent.style.position = 'relative';
    let sp = parent.querySelector('.field-spinner');
    if (!sp) {
      sp = document.createElement('span');
      sp.className = 'field-spinner';
      sp.style.display = 'none';
      parent.appendChild(sp);
    }
    return sp;
  }
  function showSpin(sp) { sp.style.display = 'block'; }
  function hideSpin(sp) { sp.style.display = 'none'; }

  // ── Autocomplete widget ───────────────────────────────────────────────────
  function initAutocomplete(input) {
    const type   = input.getAttribute('data-autocomplete');
    const spin   = wrap(input);
    const box    = document.createElement('div');
    box.className = 'ac-box';
    box.style.display = 'none';
    input.parentNode.appendChild(box);

    let results = [], active = -1, lastQ = '';

    function close() { box.style.display = 'none'; active = -1; }

    function render(loading) {
      let html = '';
      if (loading) {
        html = '<div class="ac-state"><span class="ac-spin"></span> Searching…</div>';
      } else if (!results.length) {
        html = '<div class="ac-state ac-empty">No matches found</div>';
        if (type === 'customer') {
          html += '<div class="ac-create" data-create>＋ Create new customer “' + escapeHtml(lastQ) + '”</div>';
        }
      } else {
        html = results.map((r, i) => {
          const av = (type === 'customer' || type === 'user')
            ? '<span class="ac-avatar">' + initials(r.label) + '</span>' : '';
          return '<div class="ac-item' + (i === active ? ' active' : '') + '" data-i="' + i + '">' +
            av +
            '<div class="ac-text"><div class="ac-label">' + escapeHtml(r.label) + '</div>' +
            (r.sub ? '<div class="ac-sub">' + escapeHtml(r.sub) + '</div>' : '') + '</div>' +
          '</div>';
        }).join('');
        if (type === 'customer') {
          html += '<div class="ac-create" data-create>＋ Create new customer</div>';
        }
      }
      box.innerHTML = html;
      box.style.display = 'block';
    }

    function choose(i) {
      const r = results[i];
      if (!r) return;
      input.value = r.label;
      input.setAttribute('data-selected-id', r.id);
      const prefix = input.getAttribute('data-fill-prefix');
      if (prefix !== null && r.data) {
        Object.keys(r.data).forEach(k => {
          const el = input.form && input.form.querySelector('[name="' + prefix + k + '"], [name="' + k + '"]');
          if (el && el !== input && !el.dataset.noAutofill) el.value = r.data[k] != null ? r.data[k] : '';
        });
      }
      // Globally keep a hidden customer_id in sync for customer pickers.
      if (type === 'customer' && input.form) {
        const hidden = input.form.querySelector('[name="customer_id"]');
        if (hidden) hidden.value = r.id;
      }
      input.dispatchEvent(new CustomEvent('crm:select', { bubbles: true, detail: r }));
      close();
    }

    const run = debounce(async () => {
      const q = input.value.trim();
      lastQ = q;
      if (q.length < 2) { close(); hideSpin(spin); return; }
      showSpin(spin);
      render(true);
      try {
        results = await apiSearch(type, q);
      } catch (e) { results = []; }
      hideSpin(spin);
      render(false);
    }, 250);

    input.addEventListener('input', () => { input.removeAttribute('data-selected-id'); run(); });
    input.addEventListener('focus', () => { if (results.length) render(false); });
    input.addEventListener('keydown', (e) => {
      if (box.style.display === 'none' || !results.length) return;
      if (e.key === 'ArrowDown') { e.preventDefault(); active = Math.min(active + 1, results.length - 1); render(false); }
      else if (e.key === 'ArrowUp') { e.preventDefault(); active = Math.max(active - 1, 0); render(false); }
      else if (e.key === 'Enter') { if (active >= 0) { e.preventDefault(); choose(active); } }
      else if (e.key === 'Escape') { close(); }
    });
    box.addEventListener('mousedown', (e) => {
      if (e.target.closest('[data-create]')) {
        e.preventDefault();
        window.open('/crm/customers/create.php', '_blank');
        return;
      }
      const item = e.target.closest('.ac-item');
      if (item) { e.preventDefault(); choose(parseInt(item.dataset.i, 10)); }
    });
    document.addEventListener('click', (e) => { if (!input.parentNode.contains(e.target)) close(); });
  }

  // ── Mobile lookup panel ───────────────────────────────────────────────────
  function initMobileLookup(input) {
    const panel = input.form ? input.form.querySelector('[data-mobile-result]') : null;
    if (!panel) return;
    const spin = wrap(input);

    const run = debounce(async () => {
      const v = input.value.trim();
      const digits = v.replace(/\D/g, '');
      if (digits.length < 10) { panel.innerHTML = ''; hideSpin(spin); return; }
      showSpin(spin);
      panel.innerHTML = '<div class="lookup-loading"><span class="ac-spin"></span> Checking customer…</div>';
      try {
        const r = await fetch('/crm/api/lookup.php?mobile=' + encodeURIComponent(v), { credentials: 'same-origin' });
        const d = await r.json();
        hideSpin(spin);
        if (d.found) {
          const c = d.customer, k = d.counts;
          panel.innerHTML =
            '<div class="lookup-card found">' +
              '<div class="lookup-top">' +
                '<span class="ac-avatar lg">' + initials(c.name) + '</span>' +
                '<div><div class="lookup-name">' + escapeHtml(c.name) +
                  ' <span class="badge badge-confirmed">Existing</span></div>' +
                  '<div class="lookup-mobile">' + escapeHtml(c.phone) + '</div></div>' +
              '</div>' +
              '<div class="lookup-counts">' +
                '<span>📩 ' + k.enquiries + ' Enquiries</span>' +
                '<span>📄 ' + k.quotations + ' Quotations</span>' +
                '<span>🔖 ' + k.bookings + ' Bookings</span>' +
                '<span>📞 ' + k.followups + ' Follow-ups</span>' +
              '</div>' +
              '<div class="lookup-actions">' +
                '<a class="btn btn-secondary btn-sm" href="/crm/customers/view.php?id=' + c.id + '" target="_blank">View</a>' +
                '<button type="button" class="btn btn-primary btn-sm" data-use-customer>Use this Customer</button>' +
              '</div>' +
            '</div>';
          const btn = panel.querySelector('[data-use-customer]');
          if (btn) btn.addEventListener('click', () => {
            fillCustomer(input.form, c);
            const hidden = input.form.querySelector('[name="customer_id"]');
            if (hidden) hidden.value = c.id;
            panel.querySelector('.lookup-card').classList.add('used');
            btn.textContent = '✓ Using ' + c.name;
          });
        } else {
          panel.innerHTML =
            '<div class="lookup-card none">' +
              '<span>No existing customer with this number — a new one will be created.</span>' +
            '</div>';
        }
      } catch (e) { hideSpin(spin); panel.innerHTML = ''; }
    }, 350);

    input.addEventListener('input', run);
    if (input.value.trim()) run();
  }

  function fillCustomer(form, c) {
    const map = {
      customer_name: c.name, name: c.name, customer_phone: c.phone, phone: c.phone,
      alt_phone: c.alt_phone, customer_email: c.email, email: c.email,
      city: c.city, state: c.state, country: c.country, address: c.address
    };
    Object.keys(map).forEach(k => {
      const el = form.querySelector('[name="' + k + '"]');
      if (el && !el.dataset.noAutofill && map[k] != null && map[k] !== '') el.value = map[k];
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-autocomplete]').forEach(initAutocomplete);
    document.querySelectorAll('[data-mobile-lookup]').forEach(initMobileLookup);
  });

  window.CRMSmart = { fillCustomer };
})();
