console.log("panell.js carregat");
const formulariMail     = document.getElementById("form-email");
const formulariPass     = document.getElementById("form-pass");
const btnEditarEmail     = document.getElementById("btn-editar-mail");
const btnEditarPass     = document.getElementById("btn-editar-pass");
const spanUserMail      = document.getElementById("span-user-mail");  
const emailInput        = document.getElementById("input-user-mail");
const btnGuardarMail    = document.getElementById("btn-guardar-mail");
const btnCancelMail     = document.getElementById("btn-cancelar-mail");
const btnCancelPass     = document.getElementById("btn-cancelar-pass");
const modalPass         = document.getElementById("modal-pass");
let emailOriginal       = emailInput.value;

if (btnEditarEmail) {
    btnEditarEmail.addEventListener('click', () => {
        console.log("click editar mail");
        emailInput.value = emailOriginal;
        btnEditarEmail.classList.add('ocult');
        spanUserMail.classList.add('ocult');
        emailInput.classList.remove('ocult');
        btnGuardarMail.classList.remove('ocult');
        btnCancelMail.classList.remove('ocult');
    });
}

if (btnGuardarMail) {
    if (formulariMail) {
        formulariMail.addEventListener('submit', (e) => {
            netejarError(emailInput);

            if (!validarEmail(emailInput.value)) {
                e.preventDefault();
                spanUserMail.classList.add('ocult');
                btnEditarEmail.classList.add('ocult');
                emailInput.classList.remove('ocult');
                btnGuardarMail.classList.remove('ocult');
                btnCancelMail.classList.remove('ocult');
                emailInput.classList.add('input-error');
                crearError(emailInput, 'El correu electrònic no té el format correcte, o està buit.');
                return;
            }
        });
    }
}

if (btnCancelMail) {
    btnCancelMail.addEventListener('click', () => {
        netejarError(emailInput);
        spanUserMail.classList.remove('ocult');
        btnEditarEmail.classList.remove('ocult');
        btnCancelMail.classList.add('ocult');
        emailInput.classList.add('ocult');
        btnGuardarMail.classList.add('ocult');
        emailInput.classList.remove('input-error');
        emailInput.classList.remove('input-correct');
        emailInput.value = emailOriginal;
    });
}  

if (btnEditarPass) {
    btnEditarPass.addEventListener('click', () => {
        console.log("click editar pass");
        modalPass.classList.add('actiu');
    });
};

//TANCAR MODAL
function tancarModalPass() {
    modalPass.classList.remove('actiu');
}
    // clic fora
    modalPass.addEventListener('click', (e) => { 
        if (e.target === modalPass) {
            tancarModalPass();
        }
    });
    //click ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tancarModalPass();
        }
    });
    // botó cancel
    btnCancelPass.addEventListener('click', tancarModalPass);


const netejarError = (camp) => {
    const container = camp.closest('.fila')?.querySelector('.error-container');
    if (container) {
        container.innerHTML = '';
    }
};

//funció per crear els errors a cada input després de la validació
const crearError = (camp, missatge) => {
    const container = camp.closest('.fila').querySelector('.error-container');

    //container.innerHTML = ''; // netejar
    netejarError(camp);
    const errorElement = document.createElement('p');
    errorElement.className = 'label-error';
    errorElement.textContent = missatge;
    container.appendChild(errorElement);
};

document.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');

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
//TODO: per ara està duplicat aquí i a auth.js. Cal unificar-ho a un sol .js si cal

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

document.addEventListener('DOMContentLoaded', () => {

    toggleContrasenya('pass-actual', 'show-pass-actual', 'hide-pass-actual');
    toggleContrasenya('pass-nova', 'show-pass-nova', 'hide-pass-nova');
    toggleContrasenya('pass-confirm', 'show-pass-confirm', 'hide-pass-confirm');

});