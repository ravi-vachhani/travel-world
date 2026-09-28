</main><!-- /.crm-content -->
</div><!-- /.crm-main -->

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
</script>
</body>
</html>