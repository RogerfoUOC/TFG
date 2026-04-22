console.log("panell.js carregat");
const formMailPanell   = document.getElementById("form-email");
const formPassPanell   = document.getElementById("form-pass");
const btnEditarEmailPanell  = document.getElementById("btn-editar-mail");
const btnEditarPassPanell   = document.getElementById("btn-editar-pass");
const spanUserMailPanell    = document.getElementById("span-user-mail");  
const emailInputPanell      = document.getElementById("input-user-mail");
const btnGuardarMailPanell  = document.getElementById("btn-guardar-mail");
const btnCancelMailPanell   = document.getElementById("btn-cancelar-mail");
const btnCancelPassPanell   = document.getElementById("btn-cancelar-pass");
const modalPassPanell       = document.getElementById("modal-pass");
const passwordInputPanell   = document.getElementById("pass-actual");
const passwordNouPanell     = document.getElementById("pass-nova");
const passwordConfirmPanell = document.getElementById("pass-confirm");
let emailOriginalPanell     = emailInputPanell.value;

btnEditarEmailPanell.addEventListener('click', () => {
    console.log("click editar mail");
    emailInputPanell.value = emailOriginalPanell;
    btnEditarEmailPanell.classList.add('ocult');
    spanUserMailPanell.classList.add('ocult');
    emailInputPanell.classList.remove('ocult');
    btnGuardarMailPanell.classList.remove('ocult');
    btnCancelMailPanell.classList.remove('ocult');
});

formPassPanell.addEventListener('submit', (event) => {
    event.preventDefault();
    let valid = true;
        const passActual    = passwordInputPanell.value;
        const passNou       = passwordNouPanell.value;
        const passConfirmat = passwordConfirmPanell.value;
        if (!validarBuit(passActual, 'Introdueix la contrasenya actual.')) valid = false;
        if (!validarBuit(passNou, 'Introdueix la nova contrasenya.')) valid = false;
        if (!validarBuit(passConfirmat, 'Confirma la nova contrasenya.')) valid = false;
        if (valid) { 
            console.log("submit pass form OK");
            formPassPanell.submit();
        } else {
            console.log("submit pass form NO"); 
        }
});    

formMailPanell.addEventListener('submit', (event) => {
    netejarError(emailInputPanell);

    if (!validarEmailPanell(emailInputPanell.value)) {
        event.preventDefault();
        spanUserMailPanell.classList.add('ocult');
        btnEditarEmailPanell.classList.add('ocult');
        emailInputPanell.classList.remove('ocult');
        btnGuardarMailPanell.classList.remove('ocult');
        btnCancelMailPanell.classList.remove('ocult');
        emailInputPanell.classList.add('input-error');
        crearError(emailInputPanell, 'El correu electrònic no té el format correcte, o està buit.');
        return;
    }
});

btnCancelMailPanell.addEventListener('click', () => {
    netejarError(emailInputPanell);
    spanUserMailPanell.classList.remove('ocult');
    btnEditarEmailPanell.classList.remove('ocult');
    btnCancelMailPanell.classList.add('ocult');
    emailInputPanell.classList.add('ocult');
    btnGuardarMailPanell.classList.add('ocult');
    emailInputPanell.classList.remove('input-error');
    emailInputPanell.classList.remove('input-correct');
    emailInputPanell.value = emailOriginalPanell;
});


btnEditarPassPanell.addEventListener('click', () => {
    console.log("click editar pass");
    modalPassPanell.classList.add('actiu');
});


//TANCAR MODAL
function tancarmodalPassPanell() {
    modalPassPanell.classList.remove('actiu');
}
    // clic fora
    modalPassPanell.addEventListener('click', (e) => { 
        if (e.target === modalPassPanell) {
            tancarmodalPassPanell();
        }
    });
    //click ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            tancarmodalPassPanell();
        }
    });
    // botó cancel
    btnCancelPassPanell.addEventListener('click', tancarmodalPassPanell);


const netejarError = (camp) => {
    const container = camp.closest('.fila')?.querySelector('.error-container');
    if (container) {
        container.innerHTML = '';
    }
};

//funció per crear els errors a cada input després de la validació
const crearError = (camp, missatge) => {
    const container = camp.closest('.fila').querySelector('.error-container');
    netejarError(camp);
    const errorElement = document.createElement('p');
    errorElement.className = 'label-error';
    errorElement.textContent = missatge;
    container.appendChild(errorElement);
};

