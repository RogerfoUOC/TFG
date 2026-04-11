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

