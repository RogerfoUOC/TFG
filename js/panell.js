console.log("panell.js carregat");
const btnEditarmail     = document.getElementById("btn-editar-mail");
const spanUserMail      = document.getElementById("span-user-mail");  
const emailInput        = document.getElementById("input-user-mail");
const btnGuardarMail    = document.getElementById("btn-guardar-mail");
const btnCancelMail     = document.getElementById("btn-cancelar-mail");
let emailOriginal       = emailInput.value;
const formulariMail     = document.getElementById("form-email");

if (btnEditarmail) {
    btnEditarmail.addEventListener('click', () => {
        console.log("click");
        emailInput.value = emailOriginal;
        btnEditarmail.classList.add('ocult');
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

                // 🔥 FORÇAR MODE EDICIÓ
                spanUserMail.classList.add('ocult');
                btnEditarmail.classList.add('ocult');

                emailInput.classList.remove('ocult');
                btnGuardarMail.classList.remove('ocult');
                btnCancelMail.classList.remove('ocult');

                // ❌ error visual
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
        btnEditarmail.classList.remove('ocult');
        btnCancelMail.classList.add('ocult');
        emailInput.classList.add('ocult');
        btnGuardarMail.classList.add('ocult');
        emailInput.classList.remove('input-error');
        emailInput.classList.remove('input-correct');
        emailInput.value = emailOriginal;
    });
}  

const netejarError = (camp) => {
    const container = camp.closest('.fila')?.querySelector('.error-container');
    if (container) {
        container.innerHTML = '';
    }
};

//funció per crer els errors a cada input després de la validació
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