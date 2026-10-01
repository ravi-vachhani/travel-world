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