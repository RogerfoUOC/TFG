const alertHeader   = document.getElementById('alert-header');
const newAlertForm  = document.getElementById('form-alerts');
const plusAlert     = document.getElementById('plus-alert');
const lessAlert     = document.getElementById('less-alert');
const radios        = document.querySelectorAll('input[name="tipus_dada"]');
const sliderHum     = document.getElementById('slider-hum');
const sliderTemp    = document.getElementById('slider-temp');
const displayHum    = document.getElementById('display-hum');
const displayTemp   = document.getElementById('display-temp');
const wrapperHum    = document.getElementById('slider-humitat');
const wrapperTemp   = document.getElementById('slider-temperatura');
const checkAvisWeb  = document.querySelector('input[name="avis_web"]');
const checkAvisMail = document.querySelector('input[name="avis_mail"]');
const errorAvis     = document.getElementById('error-avis');

// inicialitzem
displayHum.textContent  = sliderHum.value + '%';
displayTemp.textContent = sliderTemp.value + 'ºC';

sliderHum.addEventListener('input', () => {
    displayHum.textContent = sliderHum.value + '%';
});

sliderTemp.addEventListener('input', () => {
    displayTemp.textContent = sliderTemp.value + 'ºC';
});


alertHeader.addEventListener('click', (event)=> {
    //console.log("header alert click");
    if (alertHeader.classList.contains('active')) {
        alertHeader.classList.remove('active');
        newAlertForm.classList.add('ocult');
        plusAlert.classList.remove('ocult');
        lessAlert.classList.add('ocult');
    } else {
        
        alertHeader.classList.add('active');
        newAlertForm.classList.remove('ocult');
        plusAlert.classList.add('ocult');
        lessAlert.classList.remove('ocult');
    }

});


// radio buttons per mostrar/ocultar
radios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'humitat') {
            wrapperHum.classList.remove('ocult');
            wrapperTemp.classList.add('ocult');
        } else {
            wrapperTemp.classList.remove('ocult');
            wrapperHum.classList.add('ocult');
        }
    });
});


const actualitzarColorSlider = (slider) => {
    const val     = parseFloat(slider.value);
    const min     = parseFloat(slider.min);
    const max     = parseFloat(slider.max);
    const percent = (val - min) / (max - min) * 100;
    slider.style.background = `linear-gradient(to right, #1a5495 ${percent}%, #ddd ${percent}%)`;
};

// inicialitzem colors
actualitzarColorSlider(sliderHum);
actualitzarColorSlider(sliderTemp);

sliderHum.addEventListener('input', () => {
    displayHum.textContent = sliderHum.value + '%';
    actualitzarColorSlider(sliderHum);
});

sliderTemp.addEventListener('input', () => {
    displayTemp.textContent = sliderTemp.value + 'ºC';
    actualitzarColorSlider(sliderTemp);
});


// validació del formulari abans d'enviar
newAlertForm.addEventListener('submit', (event) => {
    // comprovem que com a mínim un avís estigui marcat
    if (!checkAvisWeb.checked && !checkAvisMail.checked) {
        event.preventDefault();
        errorAvis.classList.remove('ocult');
        return;
    }
    errorAvis.classList.add('ocult');
    // si tot és correcte, el formulari s'envia normalment
});
 
// amaguem l'error d'avís quan l'usuari marca un checkbox
[checkAvisWeb, checkAvisMail].forEach(cb => {
    cb.addEventListener('change', () => {
        if (checkAvisWeb.checked || checkAvisMail.checked) {
            errorAvis.classList.add('ocult');
        }
    });
});