const validarEmailPanell = (email) => {
    console.log("validarEmail");
    //expressió regular que verifica si té el format de mail correcte
    const emailFormat = /^[a-zA-Z0-9-_]{2,}@[a-zA-Z0-9-]{3,}\.[a-zA-Z]{2,}$/;
    return emailFormat.test(email);
};

console.log("validation.js carregat");

