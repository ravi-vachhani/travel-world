/* ============================================================
   Travel World CRM — Smart fields (autocomplete, mobile lookup,
   auto-fill). Progressive enhancement: works without touching
   existing form submission.
   ============================================================ */
(function () {
  'use strict';

  function debounce(fn, ms) {
    let t;
    return function () {
      const args = arguments, ctx = this;
      clearTimeout(t);
      t = setTimeout(() => fn.apply(ctx, args), ms);
    };
  }

  async function apiSearch(type, q) {
    const url = '/crm/api/search.php?type=' + encodeURIComponent(type) + '&q=' + encodeURIComponent(q);
    const r = await fetch(url, { credentials: 'same-origin' });
    return (await r.json()).results || [];
  }

  // ── Autocomplete widget ────────────────────────────────────────────────
  // Markup: <input data-autocomplete="customer" data-fill-prefix="cust_">
  // On select, fires a CustomEvent('crm:select', {detail:{id,label,data}}) and
  // auto-fills any field named <prefix><key> from result.data.
  function initAutocomplete(input) {
    const type = input.getAttribute('data-autocomplete');
    const box = document.createElement('div');
    box.className = 'ac-box';
    box.style.display = 'none';
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(box);

    let results = [], active = -1;

    function close() { box.style.display = 'none'; active = -1; }
    function render() {
      if (!results.length) { close(); return; }
      box.innerHTML = results.map((r, i) =>
        '<div class="ac-item' + (i === active ? ' active' : '') + '" data-i="' + i + '">' +
          '<div class="ac-label">' + escapeHtml(r.label) + '</div>' +
          (r.sub ? '<div class="ac-sub">' + escapeHtml(r.sub) + '</div>' : '') +
        '</div>').join('');
      box.style.display = 'block';
    }
    function choose(i) {
      const r = results[i];
      if (!r) return;
      input.value = r.label;
      input.setAttribute('data-selected-id', r.id);
      // Auto-fill sibling fields
      const prefix = input.getAttribute('data-fill-prefix');
      if (prefix && r.data) {
        Object.keys(r.data).forEach(k => {
          const el = input.form && input.form.querySelector('[name="' + prefix + k + '"], [name="' + k + '"]');
          if (el && el !== input && !el.dataset.noAutofill) el.value = r.data[k] != null ? r.data[k] : '';
        });
      }
      input.dispatchEvent(new CustomEvent('crm:select', { bubbles: true, detail: r }));
      close();
    }

    const run = debounce(async () => {
      const q = input.value.trim();
      if (q.length < 2) { close(); return; }
      try { results = await apiSearch(type, q); render(); } catch (e) { close(); }
    }, 250);

    input.addEventListener('input', () => { input.removeAttribute('data-selected-id'); run(); });
    input.addEventListener('keydown', (e) => {
      if (box.style.display === 'none') return;
      if (e.key === 'ArrowDown') { e.preventDefault(); active = Math.min(active + 1, results.length - 1); render(); }
      else if (e.key === 'ArrowUp') { e.preventDefault(); active = Math.max(active - 1, 0); render(); }
      else if (e.key === 'Enter') { if (active >= 0) { e.preventDefault(); choose(active); } }
      else if (e.key === 'Escape') { close(); }
    });
    box.addEventListener('mousedown', (e) => {
      const item = e.target.closest('.ac-item');
      if (item) { e.preventDefault(); choose(parseInt(item.dataset.i, 10)); }
    });
    document.addEventListener('click', (e) => { if (!input.parentNode.contains(e.target)) close(); });
  }

  // ── Mobile lookup panel ────────────────────────────────────────────────
  // Markup: <input data-mobile-lookup> and <div data-mobile-result></div>
  function initMobileLookup(input) {
    const panel = input.form.querySelector('[data-mobile-result]');
    if (!panel) return;

    const run = debounce(async () => {
      const v = input.value.trim();
      const digits = v.replace(/\D/g, '');
      if (digits.length < 10) { panel.innerHTML = ''; return; }
      try {
        const r = await fetch('/crm/api/lookup.php?mobile=' + encodeURIComponent(v), { credentials: 'same-origin' });
        const d = await r.json();
        if (d.found) {
          const c = d.customer, k = d.counts;
          panel.innerHTML =
            '<div class="lookup-card found">' +
              '<div class="lookup-head"><span class="badge badge-confirmed">Existing Customer</span></div>' +
              '<div class="lookup-name">' + escapeHtml(c.name) + '</div>' +
              '<div class="lookup-mobile">' + escapeHtml(c.phone) + '</div>' +
              '<div class="lookup-counts">' +
                'Enquiries: ' + k.enquiries + ' · Quotations: ' + k.quotations +
                ' · Bookings: ' + k.bookings + ' · Follow-ups: ' + k.followups +
              '</div>' +
              '<div class="lookup-actions">' +
                '<a class="btn btn-secondary btn-sm" href="/crm/customers/view.php?id=' + c.id + '">View Customer</a>' +
                '<button type="button" class="btn btn-primary btn-sm" data-use-customer>Use Customer</button>' +
              '</div>' +
            '</div>';
          panel.querySelector('[data-use-customer]').addEventListener('click', () => {
            fillCustomer(input.form, c);
            input.setAttribute('data-selected-id', c.id);
            const hidden = input.form.querySelector('[name="customer_id"]');
            if (hidden) hidden.value = c.id;
            panel.querySelector('.lookup-card').classList.add('used');
          });
        } else {
          panel.innerHTML =
            '<div class="lookup-card none">' +
              '<div>No existing customer found.</div>' +
              '<a class="btn btn-secondary btn-sm" href="/crm/customers/create.php">Create New Customer</a>' +
            '</div>';
        }
      } catch (e) { panel.innerHTML = ''; }
    }, 350);

    input.addEventListener('input', run);
    if (input.value.trim()) run();
  }

  function fillCustomer(form, c) {
    const map = {
      customer_name: c.name, name: c.name, customer_phone: c.phone,
      phone: c.phone, alt_phone: c.alt_phone, customer_email: c.email,
      email: c.email, city: c.city, state: c.state, country: c.country, address: c.address
    };
    Object.keys(map).forEach(k => {
      const el = form.querySelector('[name="' + k + '"]');
      if (el && !el.dataset.noAutofill && map[k] != null && map[k] !== '') el.value = map[k];
    });
  }

  function escapeHtml(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, m =>
      ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  }

  // ── Boot ────────────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-autocomplete]').forEach(initAutocomplete);
    document.querySelectorAll('[data-mobile-lookup]').forEach(initMobileLookup);
  });

  window.CRMSmart = { fillCustomer };
})();
