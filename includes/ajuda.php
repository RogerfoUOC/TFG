<?php
//array associatiu $ajuda on cada clau es l'id de la pàgina que detecta, i permet contextualitzar el contingut. 
$ajuda = [
    'home' => [
        'titol' => 'Inici — Dades actuals',
        'text'  => '
            <p>Cada targeta mostra les dades d\'una ubicació:</p>
            <ul>
                <li><img src="icons/temp.svg" class="ico-secundaria-grid" alt="">Temperatura actual</li>
                <li><img src="icons/hum.svg" class="ico-secundaria-grid" alt="">Humitat actual</li>
                <li><img src="icons/min.svg" class="ico-secundaria-grid" alt="">Valor mínim del dia</li>
                <li><img src="icons/max.svg" class="ico-secundaria-grid" alt="">Valor màxim del dia</li>
            </ul>
            <p>La targeta <strong>Diferència</strong> indica quant difereix l\'interior respecte l\'exterior. La gràfica mostra l\'evolució horària del dia.</p>
            <p>Pots alternar entre <strong>línies de punts</strong> (valors d\'humitat) i <strong>barres verticals</strong> (valors de temperatura) amb els botons de dalt a la dreta.</p>
        '
    ],
    'panell' => [
        'titol' => 'Panell d\'usuari',
        'text'  => 'Gestiona el teu compte. Si has iniciat sessió pots canviar el correu electrònic i la contrasenya, i accedir a la gestió d\'alertes. Si no has iniciat sessió, pots fer login o crear un compte nou.'
    ],
    'alertes' => [
        'titol' => 'Gestió d\'alertes',
        'text'  => '<p>Configura alertes per rebre avisos quan la temperatura o la humitat superin els límits que defineixis. Pots crear alertes per a l\'interior, l\'exterior o tots dos sensors.</p>
                    <p> Podràs rebre un <strong>avís per correu electrònic</strong> o veure un </strong>avís a la web</strong>. Necessites sessió iniciada per accedir.</p>
                    <p> El numero amb # és <strong>l\'id de l\'alerta</strong>, el número entre parentesis respresenta els <strong>cops que s\'ha disparat aquesta alerta.</strong></p>
                    <p><span class="alerta-led led-activa"></span> alerta activa.</p>  
                    <p><span class="alerta-led led-inactiva"></span> alerta inactiva.</p>'
    ],
    'historic' => [
        'titol' => 'Històric de dades',
        'text'  => 'Consulta les dades d\'un dia concret. Selecciona una data al formulari per veure els valors mínims, màxims i mitjanes del dia, així com la gràfica horària. Pots usar els botons "Avui" i "Ahir" per accés ràpid.'
    ],
    'compara' => [
        'titol' => 'Comparativa de dies',
        'text'  => 'Compara les estadístiques de dos dies diferents. Selecciona dos dates i prem "Comparar dades" per veure els resultats en paral·lel. El botó "Avui i Ahir" omple les dues dates automàticament.'
    ],
    'log' => [
        'titol' => 'Registres de dades',
        'text'  => 'Mostra tots els registres en brut enviats pels sensors. Filtra per data i per ubicació (interior, exterior o tots). Cada fila és una lectura individual amb temperatura, humitat, hora, data identificador del sensor i identificador únic del registre dins el sistema.'
    ],
    'projecte' => [
        'titol' => 'Sobre el projecte',
        'text'  => 'Descripció del sistema TwinSens: dos dispositius <strong>Arduino ESP8266</strong> amb sensors <strong>BME280</strong> que envien dades cada 10 minuts a aquest servidor. Inclou informació del maquinari, la pila tecnològica web i l\'enllaç al repositori GitHub.'
    ],
];
//Missatge de seguretat si existeix alguna pàgina sense info
$info = $ajuda[$page] ?? ['titol' => 'Ajuda', 'text' => 'No hi ha informació disponible per aquesta pàgina.'];
?>

<!-- Icona d'AJUDA -->
<button id="boto-ajuda" aria-label="Ajuda">?</button>

<!--  MODAL d'AJUDA -->
<div id="modal-ajuda" class="capa-modal">
    <div id="caixa-modal" class="modal-pass" role="dialog" aria-modal="true" aria-labelledby="caixa-modal-titol">
        <button id="tancar-modal" aria-label="Tancar ajuda">&times;</button>
        <h2 id="caixa-modal-titol"><?= htmlspecialchars($info['titol']) ?></h2>
        <p><?= $info['text'] ?></p>
    </div>
</div>

