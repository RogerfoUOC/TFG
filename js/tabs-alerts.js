    const btnAlertesTab  = document.getElementById('btn-alertes-tab');
    const btnLogTab      = document.getElementById('btn-log-tab');
    const tabAlertes     = document.getElementById('tab-alertes');
    const tabLog         = document.getElementById('tab-log');

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
