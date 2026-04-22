
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