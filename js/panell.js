console.log("panell.js carregat");
const formMailPanell        = document.getElementById("form-email");
const formPassPanell        = document.getElementById("form-pass");
const btnEditarEmailPanell  = document.getElementById("btn-editar-mail");
const btnEditarPassPanell   = document.getElementById("btn-editar-pass");
const spanUserMailPanell    = document.getElementById("span-user-mail");  
const emailInputPanell      = document.getElementById("input-user-mail");
const btnGuardarMailPanell  = document.getElementById("btn-guardar-mail");
const btnCancelMailPanell   = document.getElementById("btn-cancelar-mail");
const btnCancelPassPanell   = document.getElementById("btn-cancelar-pass");
const modalPassPanell       = document.getElementById("modal-pass");
const passActualPanell   = document.getElementById("pass-actual");
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
        const passActual    = passActualPanell.value;
        const passNou       = passwordNouPanell.value;
        const passConfirmat = passwordConfirmPanell.value;
        if (!validarPassBuitPanell(passActualPanell, passActual)) valid = false;
        if (!validarNouPassPanell(passwordNouPanell, passNou)) valid = false;
        //if (!validarNouPassPanell(passwordConfirmPanell, passConfirmat)) valid = false;
        //if (!confirmarPassPanell(passwordConfirmPanell, passNou, passConfirmat)) valid = false;
        if (passwordNouPanell.classList.contains('input-correct') && passActual === passNou) {
            passwordNouPanell.classList.remove('input-correct');
            passwordNouPanell.classList.add('input-error');
            netejarError(passwordNouPanell);
            crearError(passwordNouPanell, 'La nova contrasenya no pot ser igual que l\'actual.');
            valid = false;
        }

        if (passwordNouPanell.classList.contains('input-correct')) {
            if (!confirmarPassPanell(passwordConfirmPanell, passNou, passConfirmat)) valid = false;
        } else {
            // netejar l'estat de pass2 si pass1 no és vàlid
            passwordConfirmPanell.classList.remove('input-correct');
            passwordConfirmPanell.classList.add('input-error');
            netejarError(passwordConfirmPanell);
            crearError(passwordConfirmPanell, 'Primer has d\'introduir una contrasenya vàlida.');
            valid = false;
        }



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

const validarEmailPanell = (email) => {
    console.log("validarEmail");
    //expressió regular que verifica si té el format de mail correcte
    const emailFormat = /^[a-zA-Z0-9-_]{2,}@[a-zA-Z0-9-]{3,}\.[a-zA-Z]{2,}$/;
    return emailFormat.test(email);
};
console.log("validation.js carregat");

const validarPassBuitPanell = (camp, pass) => {
    console.log(pass);
    netejarError(camp);
    if (pass.length <8) {
        crearError(camp, 'La contrasenya ha de tenir com a mínim 8 caràcters');
        console.log("valida NO");
        camp.classList.add('input-error');
        camp.classList.remove('input-correct');
        return false;
    }
    camp.classList.remove('input-error');
    camp.classList.add('input-correct');
    console.log("valida OK");
    return true;
};


const validarNouPassPanell = (camp, password) => {
    netejarError(camp);
    //expressió regular que verifica si té lletres, números, com a mínim un caràcter especial, i com a mínim 8 caràcters
    const passwordFormat = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[^\s]{8,}$/;
    if (passwordFormat.test(password) == true) {
        camp.classList.remove('input-error');
        camp.classList.add('input-correct');
        return true;
    }
    camp.classList.add('input-error');
    camp.classList.remove('input-correct');
    crearError(camp,'La contrasenya ha de tenir mínim 8 caràcters, lletres, números, mínim un caràcter especial i sense espais.');  
    return false;
};

const confirmarPassPanell = (camp, password1, password2) => {
    netejarError(camp);
    console.log(password1);
    console.log(password2); 

    if (password1 === password2) {
        camp.classList.remove('input-error');
        camp.classList.add('input-correct');
        console.log("pass iguals");
        return true;
    } 
    console.log("pass diferents");
    camp.classList.add('input-error');
    camp.classList.remove('input-correct');
    crearError(camp,'Les contrasenyes no coincideixen.'); 
    return false;
}; 


const netejarError = (camp) => {
    const fila = camp.closest('.fila');
    if (fila) {
        fila.querySelector('.error-container').innerHTML = '';
    } else {
        const error = camp.closest('.grup-form')?.querySelector('.label-error');
        if (error) error.remove();
    }
};

//funció per crear els errors a cada input després de la validació
const crearError = (camp, missatge) => {
    netejarError(camp);
    const errorElement = document.createElement('p');
    errorElement.className = 'label-error';
    errorElement.textContent = missatge;
    
    const fila = camp.closest('.fila');
    if (fila) {
        fila.querySelector('.error-container').appendChild(errorElement);
    } else {
        camp.insertAdjacentElement('afterend', errorElement);
    }
};



    passActualPanell.addEventListener('blur', () => {
        netejarError(passActualPanell);
        validarPassBuitPanell(passActualPanell, passActualPanell.value);
        console.log( passwordNouPanell.value);
        console.log(passActualPanell.value);
        if (passwordNouPanell.value !== '' &&  passActualPanell.value === passwordNouPanell.value) {

                passwordNouPanell.classList.remove('input-correct');
                passwordNouPanell.classList.add('input-error');
                crearError(passwordNouPanell, 'La nova contrasenya no pot ser igual que l\'actual.');
                return;
        }
        if (passwordNouPanell.value !== '') {
            validarNouPassPanell(passwordNouPanell, passwordNouPanell.value);
        }
    });

    passwordNouPanell.addEventListener('blur', () => {
        netejarError(passwordNouPanell);
        validarNouPassPanell(passwordNouPanell, passwordNouPanell.value);
        if (passwordNouPanell.classList.contains('input-correct') && passActualPanell.value !== '') {
            if (passActualPanell.value === passwordNouPanell.value) {
                passwordNouPanell.classList.remove('input-correct');
                passwordNouPanell.classList.add('input-error');
                crearError(passwordNouPanell, 'La nova contrasenya no pot ser igual que l\'actual.');
                return;
            }
        }                                                                   
        if (passwordConfirmPanell.value !== '' || passwordConfirmPanell.classList.contains('input-error')) {
            netejarError(passwordConfirmPanell);
            if (passwordNouPanell.classList.contains('input-correct')) {
                confirmarPassPanell(passwordConfirmPanell, passwordNouPanell.value, passwordConfirmPanell.value);            } else {
                passwordConfirmPanell.classList.remove('input-correct');
                passwordConfirmPanell.classList.add('input-error');
                crearError(passwordConfirmPanell, 'Primer has d\'introduir una contrasenya vàlida.');
            }
        }
    });

    passwordConfirmPanell.addEventListener('blur', () => {
        netejarError(passwordConfirmPanell);
        if (passwordNouPanell.classList.contains('input-correct')) {
            confirmarPassPanell(passwordConfirmPanell, passwordNouPanell.value, passwordConfirmPanell.value);
        } else {
            passwordConfirmPanell.classList.remove('input-correct');
            passwordConfirmPanell.classList.add('input-error');
            crearError(passwordConfirmPanell, 'Primer has d\'introduir una contrasenya vàlida.');
        }
    });