console.log("panell.js carregat");
const btnEditarmail     = document.getElementById("btn-editar-mail");
const spanUserMail      = document.getElementById("span-user-mail");  
const inputUserPass     = document.getElementById("input-user-pass");
const btnGuardarMail    = document.getElementById("btn-guardar-mail");


if (btnEditarmail) {
    btnEditarmail.addEventListener('click', () => {
        console.log("click");
        btnEditarmail.classList.add('ocult');
        spanUserMail.classList.add('ocult');
        inputUserPass.classList.remove('ocult');
        btnGuardarMail.classList.remove('ocult');
    });
}

if (btnGuardarMail) {
    btnGuardarMail.addEventListener('click', () => {
        spanUserMail.classList.remove('ocult');
        btnEditarmail.classList.remove('ocult');
        inputUserPass.classList.add('ocult');
        btnGuardarMail.classList.add('ocult');
    });
}   

