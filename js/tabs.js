    const btnLoginTab    = document.getElementById('btn-login-tab');
    const btnRegistreTab = document.getElementById('btn-registre-tab');
    const tabLogin       = document.getElementById('tab-login');
    const tabRegistre    = document.getElementById('tab-registre');
    const btnAlertesTab  = document.getElementById('btn-alertes-tab');
    const btnLogTab      = document.getElementById('btn-log-tab');
    const tabAlertes     = document.getElementById('tab-alertes');
    const tabLog         = document.getElementById('tab-log');

    
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
    
    //canvi de pestanya a alertes creades
    if (btnAlertesTab) {
        btnAlertesTab.addEventListener('click', () => {
            tabAlertes.classList.add('active');
            tabLog.classList.remove('active');
            btnAlertesTab.classList.add('active');
            btnLogTab.classList.remove('active');
        });
    }
    //canvi de pestanya al log d'alertes
    if (btnLogTab) {
        btnLogTab.addEventListener('click', () => {
            tabAlertes.classList.remove('active');
            tabLog.classList.add('active');
            btnAlertesTab.classList.remove('active');
            btnLogTab.classList.add('active');
        });
    }

    console.log("tabs.js carregat");