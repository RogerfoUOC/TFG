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
    console.log("header alert click");
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
    const percent = (slider.value - slider.min) / (slider.max - slider.min) * 100;
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

