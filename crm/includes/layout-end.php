</main><!-- /.crm-content -->
</div><!-- /.crm-main -->

<script src="/crm/assets/crm-smart.js"></script>
<script>
// Sidebar toggle (mobile)
const sidebarToggle  = document.getElementById('sidebarToggle');
const crmSidebar     = document.getElementById('crmSidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function openSidebar()  { crmSidebar.classList.add('open'); sidebarOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeSidebar() { crmSidebar.classList.remove('open'); sidebarOverlay.classList.remove('open'); document.body.style.overflow = ''; }

if (sidebarToggle)  sidebarToggle.addEventListener('click', openSidebar);
if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

// Auto-close flash messages
document.querySelectorAll('.flash').forEach(el => {
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }, 4000);
});

// ── Interactive UI layer ────────────────────────────────────────────────────
(function () {
  // 1) Button ripple on click
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn, .nav-item');
    if (!btn) return;
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const ink = document.createElement('span');
    ink.className = 'tw-ripple';
    ink.style.width = ink.style.height = size + 'px';
    ink.style.left = (e.clientX - rect.left - size / 2) + 'px';
    ink.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
    btn.appendChild(ink);
    setTimeout(() => ink.remove(), 600);
  });

  // 2) Top progress bar + content fade-out on internal navigation
  const bar = document.createElement('div');
  bar.id = 'tw-progress';
  document.body.appendChild(bar);
  function startProgress() {
    bar.classList.add('active');
    bar.style.width = '0';
    requestAnimationFrame(() => { bar.style.width = '72%'; });
  }
  function isInternal(a) {
    return a && a.href && a.target !== '_blank' && !a.hasAttribute('download') &&
           a.origin === location.origin && !a.getAttribute('href').startsWith('#') &&
           !a.getAttribute('href').startsWith('javascript');
  }
  document.addEventListener('click', function (e) {
    const a = e.target.closest('a');
    if (!isInternal(a)) return;
    // let modified clicks (new tab) behave normally
    if (e.metaKey || e.ctrlKey || e.shiftKey) return;
    startProgress();
    const main = document.querySelector('.crm-content');
    if (main) { main.style.transition = 'opacity .22s ease, transform .22s ease'; main.style.opacity = '0'; main.style.transform = 'translateY(-6px)'; }
  }, true);
  // On form submit, also show progress
  document.addEventListener('submit', function () { startProgress(); }, true);
  // Finish the bar once the new page is fully shown
  window.addEventListener('pageshow', function () { bar.style.width = '100%'; setTimeout(() => { bar.classList.remove('active'); bar.style.width = '0'; }, 250); });
})();

// ── Punch in / out widget ──────────────────────────────────────────────────
(function () {
  const widget = document.getElementById('punchWidget');
  if (!widget) return;
  const btn    = document.getElementById('punchBtn');
  const label  = document.getElementById('punchLabel');
  const timer  = document.getElementById('punchTimer');
  let state    = null;      // {open:bool, punch_in:ISO}
  let tick     = null;

  function fmt(ms) {
    const s = Math.floor(ms / 1000);
    const h = String(Math.floor(s / 3600)).padStart(2, '0');
    const m = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
    return h + ':' + m;
  }
  function startTimer(sinceISO) {
    stopTimer();
    const since = new Date(sinceISO).getTime();
    const update = () => { timer.textContent = fmt(Date.now() - since); };
    update();
    tick = setInterval(update, 30000);
  }
  function stopTimer() { if (tick) { clearInterval(tick); tick = null; } timer.textContent = ''; }

  function render() {
    if (!state) return;
    if (state.open) {
      btn.classList.add('punch-out');
      btn.classList.remove('punch-in');
      label.textContent = 'Punch Out';
      startTimer(state.punch_in);
    } else {
      btn.classList.add('punch-in');
      btn.classList.remove('punch-out');
      label.textContent = 'Punch In';
      stopTimer();
    }
  }

  async function load() {
    try {
      const r = await fetch('/crm/attendance/status.php', { credentials: 'same-origin' });
      state = await r.json();
      render();
    } catch (e) { label.textContent = 'Punch'; }
  }

  btn.addEventListener('click', async () => {
    btn.disabled = true;
    const action = (state && state.open) ? 'out' : 'in';
    try {
      const r = await fetch('/crm/attendance/punch.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=' + action
      });
      state = await r.json();
      render();
    } catch (e) {}
    btn.disabled = false;
  });

  load();
})();
</script>
</body>
</html>