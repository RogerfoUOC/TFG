document.addEventListener('DOMContentLoaded', () => {
    //evitem tancar els toast d'alertes
    const toasts = document.querySelectorAll('.toast:not(.toast-alerta)');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 5000);
    });
});


// MOSTRAR CONTRASENYES:
//funció reutilitzable per a cada input de password, pels botons de mostrar/ocultar password
const toggleContrasenya = (inputId, showBtnId, hideBtnId) => {
    const input   = document.getElementById(inputId);
    const btnShow = document.getElementById(showBtnId);
    const btnHide = document.getElementById(hideBtnId);

    if (!input || !btnShow || !btnHide) return;

    btnShow.addEventListener('click', () => {
        input.type = 'text';
        btnHide.classList.remove('ocult');
        btnShow.classList.add('ocult');
    });

    btnHide.addEventListener('click', () => {
        input.type = 'password';
        btnHide.classList.add('ocult');
        btnShow.classList.remove('ocult');
    });
};

//cridem la funció segons a quin botó de mostrar/amagar password fem click
document.addEventListener('DOMContentLoaded', () => {
    toggleContrasenya ('password-login', 'show-pass0', 'hide-pass0');
    toggleContrasenya ('password1', 'show-pass1', 'hide-pass1');
    toggleContrasenya ('password2', 'show-pass2', 'hide-pass2');
    toggleContrasenya ('pass-actual', 'show-pass-actual', 'hide-pass-actual');
    toggleContrasenya ('pass-nou', 'show-pass-nou', 'hide-pass-nou');
    toggleContrasenya ('pass-confirm', 'show-pass-confirm', 'hide-pass-confirm');
    toggleContrasenya('pass-actual', 'show-pass-actual', 'hide-pass-actual');
    toggleContrasenya('pass-nou', 'show-pass-nou', 'hide-pass-nou');
    toggleContrasenya('pass-confirm', 'show-pass-confirm', 'hide-pass-confirm');

});

//console.log("UI OK");
//modal d'el botó ajuda amb informació de cada pàgina
const btnAjuda  = document.getElementById('boto-ajuda');
const modal = document.getElementById('modal-ajuda');
const btnTancar = document.getElementById('tancar-modal');

btnAjuda.addEventListener('click', () => modal.classList.add('actiu'));
btnTancar.addEventListener('click', () => modal.classList.remove('actiu'));
modal.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.remove('actiu');
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') modal.classList.remove('actiu');
});
