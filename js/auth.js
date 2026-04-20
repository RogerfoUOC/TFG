    const userInput             = document.getElementById('username');
    const emailInput            = document.getElementById('email');
    const passwordInput1        = document.getElementById('password1');
    const passwordInput2        = document.getElementById('password2');
    const mailInputLogin        = document.getElementById('mail-login');
    const passwordInputLogin    = document.getElementById('password-login');
    const btnLogin              = document.getElementById('btn-login');
    const btnRegistre           = document.getElementById('btn-registre');
    const formRegistre          = document.getElementById('form-registre');
    const formLogin             = document.getElementById('form-login');
    let formulariRegValidat     = true;
    let formulariLoginValidat   = true;
    
// VALIDACIO REGISTRE:

    //escoltem el click del botó del formulari de registre
    formRegistre.addEventListener('submit', function (event){
        event.preventDefault();
        formulariRegValidat = true;
        //primer de tot eliminem possibles missatges d'error anteriors
        document.querySelectorAll('.label-error').forEach(errorElement => {
            errorElement.remove();
        });
        //guardem els elements de cada inptut del formulari 
         const username  = userInput.value;
         const email     = emailInput.value;
         const password1 = passwordInput1.value;
         const password2 = passwordInput2.value;
         //cridem les funcions per validar els camps
         validarNomReg(username); 
         if (!validarEmail(email, emailInput)) formulariRegValidat = false;
         validarPassword1(password1);
         if (passwordInput1.classList.contains('input-correct')) {
            validarPassword2(password1, password2);
        } else {
            // netejar l'estat de pass2 si pass1 no és vàlid
            passwordInput2.classList.remove('input-correct');
            passwordInput2.classList.add('input-error');
            netejarError(passwordInput2);
            crearError(passwordInput2, 'Primer has d\'introduir una contrasenya vàlida.');
        }
        if (formulariRegValidat) {
              formRegistre.submit();
        };
    });
   
    const validarNomReg = (username) => {
        const regex = /^[A-Za-z]{3,15}$/;

        if (regex.test(username)) {
            userInput.classList.remove('input-error');
            userInput.classList.add('input-correct');
        } else {
            userInput.classList.add('input-error');
            userInput.classList.remove('input-correct');
            inputElement = userInput;
            textContent = 'El nom d\'usuari ha de tenir entre 3 i 15 lletres i sense espais.';
            crearError(inputElement, textContent);
            formulariRegValidat = false;
        }
        //console.log(formulariRegValidat);
    };


    const validarEmail = (email, inputElement) => {
        //expressió regular que verifica si té el format de mail correcte
        const emailFormat = /^[a-zA-Z0-9-_]{2,}@[a-zA-Z0-9-]{3,}\.[a-zA-Z]{2,}$/;
        if (emailFormat.test(email) == true) {
            inputElement.value = inputElement.value.toLowerCase() //passem mail a minuscules 
            //alert("mailOk");
            inputElement.classList.remove('input-error'); //elimina la classe per error del input
            //inputElement.classList.add('input-correct'); //afegeix la classe per error al input
            if (inputElement === emailInput) inputElement.classList.add('input-correct');
            return true;
        } else {
            //alert(missatgeError)
            inputElement.classList.add('input-error');
            inputElement.classList.remove('input-correct');
            crearError(inputElement, 'El correu electrònic no té el format correcte, o està buit.');
            return false;
        }
    };

    const validarPassword1 = (password) => {
        //expressió regular que verifica si té lletres, números, com a mínim un caràcter especial, i com a mínim 8 caràcters
        const passwordFormat = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[^\s]{8,}$/;
        if (passwordFormat.test(password) == true) {
            passwordInput1.classList.remove('input-error');
            passwordInput1.classList.add('input-correct');
        } else {
            passwordInput1.classList.add('input-error');
            passwordInput1.classList.remove('input-correct');
            inputElement = passwordInput1;
            textContent = 'La contrasenya ha de tenir mínim 8 caràcters, lletres, números, mínim un caràcter especial i sense espais.';
            crearError(inputElement,textContent);  
            formulariRegValidat = false;
        }
        console.log(formulariRegValidat);
    };

    const validarPassword2 = (password1, password2) => {
        if (password1 === password2) {
            passwordInput2.classList.remove('input-error');
            passwordInput2.classList.add('input-correct');
        } else {
            passwordInput2.classList.add('input-error');
            passwordInput2.classList.remove('input-correct');
            inputElement = passwordInput2;
            textContent = 'Les contrasenyes no coincideixen.';
            crearError(inputElement,textContent); 
            formulariRegValidat = false;
        }
        console.log(formulariRegValidat);
    };

    //funció per crer els errors a cada input després de la validació
    const crearError = (camp, missatge) => {
        const errorElement = document.createElement('p');
        errorElement.className = 'label-error';
        errorElement.textContent = missatge;
        inputElement = camp;
        //afegim l'element <p> creat, sota l'element rebut per parametre
        inputElement.insertAdjacentElement('afterend', errorElement);
    }

    const netejarError = (input) => {
        const grupForm = input.closest('.grup-form');
        const error = grupForm.querySelector('.label-error');
        if (error) error.remove();
    }

    //validem els camps en el moment de marxar del input per tenir feedback més directe abans d'enviar el formulari
    userInput.addEventListener('blur', () => {        
        netejarError(userInput);
        validarNomReg(userInput.value);
    });
    emailInput.addEventListener('blur', () => {
        netejarError(emailInput);
        validarEmail(emailInput.value, emailInput);
    });

    passwordInput1.addEventListener('blur', () => {
        netejarError(passwordInput1);
        validarPassword1(passwordInput1.value);
        if (passwordInput2.value !== '' || passwordInput2.classList.contains('input-error')) {
            netejarError(passwordInput2);
            if (passwordInput1.classList.contains('input-correct')) {
                validarPassword2(passwordInput1.value, passwordInput2.value);
            } else {
                passwordInput2.classList.remove('input-correct');
                passwordInput2.classList.add('input-error');
                crearError(passwordInput2, 'Primer has d\'introduir una contrasenya vàlida.');
            }
        }
    });

    passwordInput2.addEventListener('blur', () => {
        netejarError(passwordInput2);
        //console.log('pass1 correcte?', passwordInput1.classList.contains('input-correct'));
        //console.log('classes pass2:', passwordInput2.classList);
        if (passwordInput1.classList.contains('input-correct')) {
            validarPassword2(passwordInput1.value, passwordInput2.value);
        } else {
            passwordInput2.classList.remove('input-correct');
            passwordInput2.classList.add('input-error');
            crearError(passwordInput2, 'Primer has d\'introduir una contrasenya vàlida.');
        }
    });


// VALIDACIO LOGIN:
    formLogin.addEventListener('submit', function (event){
        event.preventDefault();
        formulariLoginValidat = true;
        document.querySelectorAll('.label-error').forEach(errorElement => {
            errorElement.remove();
        });
        const loginMail = mailInputLogin.value;
        const loginPass = passwordInputLogin.value;
        if (!validarEmail(loginMail, mailInputLogin)) formulariLoginValidat = false;
        if (loginPass.length <=0) {
            //passwordInputLogin.classList.remove('input-correct');
            passwordInputLogin.classList.add('input-error');
            crearError(passwordInputLogin, 'La contrasenya no pot estar buida.');
            formulariLoginValidat = false; 
            console.log("Login NO enviat");
        }
        //console.log ("submit login form ");
        if (formulariLoginValidat) {
            console.log("Login enviat");
            formLogin.submit();
        };
    });

    mailInputLogin.addEventListener('blur', () => {
        netejarError(mailInputLogin);
        validarEmail(mailInputLogin.value, mailInputLogin);
    }); 

    passwordInputLogin.addEventListener('blur', () =>{
        netejarError(passwordInputLogin);
        passwordInputLogin.classList.remove('input-error');
        if (passwordInputLogin.value.length <=0) {
            passwordInputLogin.classList.add('input-error');
            crearError(passwordInputLogin, 'La contrasenya no pot estar buida.');
        }

    });
    
    const netejarFormulari = (formulari) => {
        // treure missatges d'error
        formulari.querySelectorAll('.label-error').forEach(e => e.remove());
        // treure classes dels inputs
        formulari.querySelectorAll('input').forEach(input => {
            input.classList.remove('input-error', 'input-correct');
        });
    };
    
    btnLoginTab.addEventListener('click', () => {
        netejarFormulari(formRegistre);
    });

    btnRegistreTab.addEventListener('click', () => {
        netejarFormulari(formLogin);
    });