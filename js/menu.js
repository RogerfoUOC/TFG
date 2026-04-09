// gestió d'obertura i tancament del menú lateral
const btnOpen   = document.getElementById('menu-toggle');
const btnClose  = document.getElementById('close-menu');
const menu      = document.querySelector('.sidebar');

// obrir menú
btnOpen.addEventListener('click', () => {
    menu.classList.add('open');
    btnOpen.classList.add('hidden');  
});

// tancar menú amb botó de tancament
btnClose.addEventListener('click', () => {
    menu.classList.remove('open');
    btnOpen.classList.remove('hidden');  
});

// tancar si es toca fora del menú
document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !btnOpen.contains(e.target)) {
        menu.classList.remove('open');
        btnOpen.classList.remove('hidden'); 
    }
});

// ── Theme toggle ──────────────────────────────────────────
(function () {
  const KEY      = 'twinsens-tema';
  const CSS_DARK = 'css/style2.css';
  const CSS_LIGHT = 'css/style.css';

  const link   = document.getElementById('main-css');
  const btn    = document.getElementById('theme-toggle');
  const label  = btn?.querySelector('.theme-toggle__label');

  function applyTheme(dark) {
    link.href = dark ? CSS_DARK : CSS_LIGHT;
    btn.classList.toggle('is-dark', dark);
    if (label) label.textContent = dark ? 'Tema clar' : 'Tema fosc';
    localStorage.setItem(KEY, dark ? 'dark' : 'light');
  }

  // Recupera preferència guardada (o preferència del sistema)
  const saved = localStorage.getItem(KEY);
  const prefersDark = saved
    ? saved === 'dark'
    : window.matchMedia('(prefers-color-scheme: dark)').matches;

  applyTheme(prefersDark);

  btn?.addEventListener('click', () => {
    applyTheme(!btn.classList.contains('is-dark'));
  });
})();