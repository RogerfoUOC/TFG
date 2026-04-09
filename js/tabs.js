    const btnLoginTab    = document.getElementById('btn-login-tab');
    const btnRegistreTab = document.getElementById('btn-registre-tab');
    const tabLogin       = document.getElementById('tab-login');
    const tabRegistre    = document.getElementById('tab-registre');

    //canvi de pestanya de Login
    if (btnLoginTab) {
        btnLoginTab.addEventListener('click', () => {
            tabLogin.classList.add('active');
            tabRegistre.classList.remove('active');
            btnLoginTab.classList.add('active');
            btnRegistreTab.classList.remove('active');
        });
    }   
    //canvi de pestanya a Registre
    if (btnRegistreTab) {
        btnRegistreTab.addEventListener('click', () => {
            tabLogin.classList.remove('active');
            tabRegistre.classList.add('active');
            btnLoginTab.classList.remove('active');
            btnRegistreTab.classList.add('active');
        });
    }  

    // Obrim el tab correcte segons si hi ha error de PHP
if (typeof tabInicial !== 'undefined' && tabInicial === 'registre') {
    tabLogin.classList.remove('active');
    tabRegistre.classList.add('active');
    btnLoginTab.classList.remove('active');
    btnRegistreTab.classList.add('active');
}

