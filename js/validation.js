
const validarEmailPanell = (email) => {
    console.log("validarEmail");
    //expressió regular que verifica si té el format de mail correcte
    const emailFormat = /^[a-zA-Z0-9-_]{2,}@[a-zA-Z0-9-]{3,}\.[a-zA-Z]{2,}$/;
    return emailFormat.test(email);
};
console.log("validation.js carregat");

const validarBuit = (pass) => {
    console.log(pass);
    if (pass.length <=0) {
        console.log("valida NO");
        return false;
    }
    console.log("valida OK");
    return true;
};