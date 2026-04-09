<?php 
$page = 'compara';
include 'includes/header.php'; 
include 'includes/connexio.php';
include 'includes/functions.php';

// variable per controlar si s'han mostrar el resultat$mostrarDades = false;
$mostrarDades = false;

// 1. Dades triades: Sense dia per defecte (seran strings buits si no estan a l'URL)
$diaSeleccionat1 = isset($_GET['data1']) && $_GET['data1'] !== '' ? $_GET['data1'] : '';
$diaSeleccionat2 = isset($_GET['data2']) && $_GET['data2'] !== '' ? $_GET['data2'] : '';

// incloure consultes corregides
include 'includes/queries.php';

// comprovar si s'han triat dues dates per mostrar les dades
if ($diaSeleccionat1 !== '' && $diaSeleccionat2 !== '') {
    $mostrarDades = true;
}

// executem les consultes
$resultatDia1   = $conn->query($dadesHistoric1);
$resultatDia2   = $conn->query($dadesHistoric2);

/* --- LLEGIR ESTADÍSTIQUES DEL DIA 1 (min / max / avg) --- */

$statsDia1 = [
    "Interior" => null,
    "Exterior" => null
];

while ($row = $resultatDia1->fetch_assoc()) {
    $statsDia1[$row["location"]] = $row;
}

/* --- CALCULAR DIFERÈNCIES INTERIOR - EXTERIOR DEL DIA 1--- */
$diferenciaMitjaTempDia1 = null;
$diferenciaMitjaHumDia1 = null;

if (is_numeric($statsDia1["Interior"]["temp_mitjana"]) && is_numeric($statsDia1["Exterior"]["temp_mitjana"])) {
    $diferenciaMitjaTempDia1 = $statsDia1["Interior"]["temp_mitjana"] - $statsDia1["Exterior"]["temp_mitjana"];
}

if (is_numeric($statsDia1["Interior"]["humitat_mitjana"]) && is_numeric($statsDia1["Exterior"]["humitat_mitjana"])) {
    $diferenciaMitjaHumDia1 = $statsDia1["Interior"]["humitat_mitjana"] - $statsDia1["Exterior"]["humitat_mitjana"];
}

/* --- LLEGIR ESTADÍSTIQUES DEL DIA 2 (min / max / avg) --- */

$statsDia2 = [
    "Interior" => null,
    "Exterior" => null
];

while ($row = $resultatDia2->fetch_assoc()) {
    $statsDia2[$row["location"]] = $row;
}
/* --- CALCULAR DIFERÈNCIES INTERIOR - EXTERIOR DEL DIA 2--- */
$diferenciaMitjaTempDia2 = null;
$diferenciaMitjaHumDia2 = null;

if (is_numeric($statsDia2["Interior"]["temp_mitjana"]) && is_numeric($statsDia2["Exterior"]["temp_mitjana"])) {
    $diferenciaMitjaTempDia2 = $statsDia2["Interior"]["temp_mitjana"] - $statsDia2["Exterior"]["temp_mitjana"];
}

if (is_numeric($statsDia2["Interior"]["humitat_mitjana"]) && is_numeric($statsDia2["Exterior"]["humitat_mitjana"])) {
    $diferenciaMitjaHumDia2 = $statsDia2["Interior"]["humitat_mitjana"] - $statsDia2["Exterior"]["humitat_mitjana"];
}


$conn->close();
?>

<!-- MOSTRAR CONTINGUT -->
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">
        <h1>Comparativa de dades diàries</h1>
        <form method="GET" action="compara.php" class="formulariFiltre">
            <fieldset>
                <legend>Selecciona els dos dies:</legend>
                <div class="date-group">
                    <label for="inputData1">Dia 1:</label>
                    <input type="date" id="inputData1" name="data1" value="<?= htmlspecialchars($diaSeleccionat1) ?>">
                    
                    <label for="inputData2">Dia 2:</label>
                    <input type="date" id="inputData2" name="data2" value="<?= htmlspecialchars($diaSeleccionat2) ?>">
                </div>
                <div class="fastData">
                    <button type="button" onclick="setDatesRapides()">Avui i Ahir</button>
                </div>
                <button type="submit">Comparar dades</button>
            </fieldset>
        </form>
        <!-- CAIXES DADES -->
        <?php if ($mostrarDades): ?>
             <!-- DIA 1 -->
            <?php if ($statsDia1["Interior"] && $statsDia1["Exterior"]): ?>
            <div id="dia">Dia 1: <?= formatarData($diaSeleccionat1) ?></div>
                <div class="dades historic">     
                    <div class="grid-historic">
                        <!--  BLOC INTERIOR -->
                        <div class="marc interior">
                            <h3 class="titol interior">Interior</h3>
                            <div class="grid-dades-interior">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia1["Interior"]["temp_minima"]) ?>º</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia1["Interior"]["temp_maxima"]) ?>º</span></div>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia1["Interior"]["humitat_minima"]) ?>%</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia1["Interior"]["humitat_maxima"]) ?>%</span></div>
                            </div>
                        </div>
                        <!--  BLOC EXTERIOR -->                        
                        <div class="marc exterior">
                            <h3 class="titol exterior">Exterior</h3>
                            <div class="grid-dades-interior">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia1["Exterior"]["temp_minima"]) ?>º</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia1["Exterior"]["temp_maxima"]) ?>º</span></div>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia1["Exterior"]["humitat_minima"]) ?>%</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia1["Exterior"]["humitat_maxima"]) ?>%</span></div>
                            </div>
                        </div>
                        <!--  BLOC MITJANA INTERIOR -->
                        <div class="marc mitjana-interior">
                            <h3 class="titol interior">Mitjana Interior</h3>
                            <div class="grid-dades-mitjana">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= formatTemp($statsDia1["Interior"]["temp_mitjana"]) ?>º</span>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= round($statsDia1["Interior"]["humitat_mitjana"]) ?>%</span>
                            </div>
                        </div>
                        <!--  BLOC MITJANA EXTERIOR -->
                        <div class="marc mitjana-exterior">
                            <h3 class="titol exterior">Mitjana Exterior</h3>
                            <div class="grid-dades-mitjana">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= formatTemp($statsDia1["Exterior"]["temp_mitjana"]) ?>º</span>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= round($statsDia1["Exterior"]["humitat_mitjana"]) ?>%</span>
                            </div>
                        </div>
                        <!--  BLOC DIFERÈNCIA MITJANA  -->
                        <div class="marc dif-mitjana">
                            <h3 class="titol diferencia">
                                Diferència mitjana
                                <span class="info-icon">
                                    <img src="icons/info.svg" alt="info">
                                    <span class="tooltip">Diferència de la mitjana interior respecte exterior.</span>
                                </span>
                            </h3>
                        <div class="grid-dades-mitjana">
                            <!-- fem servir l’operador ternari per la condicio de mostrar el signe positiu -->
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= ($diferenciaMitjaTempDia1 > 0 ? '+' : '') . formatTemp($diferenciaMitjaTempDia1) ?>º</span>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= ($diferenciaMitjaHumDia1 > 0 ? '+' : '') . round($diferenciaMitjaHumDia1) ?>%</span>
                        </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <p class="error-msg">No s'han trobat dades vàlides per al Dia 1 (<?= formatarData($diaSeleccionat1) ?>).</p>
                <?php endif; ?>

                <!-- DIA 2 -->
                <?php if ($statsDia2["Interior"] && $statsDia2["Exterior"]): ?>
                <div id="dia">Dia 2: <?= formatarData($diaSeleccionat2) ?></div>
                <div class="dades historic">     
                    <div class="grid-historic">
                        <!--  BLOC INTERIOR -->
                        <div class="marc interior">
                            <h3 class="titol interior">Interior</h3>
                            <div class="grid-dades-interior">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia2["Interior"]["temp_minima"]) ?>º</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia2["Interior"]["temp_maxima"]) ?>º</span></div>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia2["Interior"]["humitat_minima"]) ?>%</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia2["Interior"]["humitat_maxima"]) ?>%</span></div>
                            </div>
                        </div>
                        <!--  BLOC EXTERIOR -->                        
                        <div class="marc exterior">
                            <h3 class="titol exterior">Exterior</h3>
                            <div class="grid-dades-interior">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia2["Exterior"]["temp_minima"]) ?>º</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= formatTemp($statsDia2["Exterior"]["temp_maxima"]) ?>º</span></div>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <div class="grup-valor"><img src="icons/min.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia2["Exterior"]["humitat_minima"]) ?>%</span></div>
                                <div class="grup-valor"><img src="icons/max.svg" class="ico-secundaria-grid"><span class="valor-grid"><?= round($statsDia2["Exterior"]["humitat_maxima"]) ?>%</span></div>
                            </div>
                        </div>
                        <!--  BLOC MITJANA INTERIOR -->
                        <div class="marc mitjana-interior">
                            <h3 class="titol interior">Mitjana Interior</h3>
                            <div class="grid-dades-mitjana">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= formatTemp($statsDia2["Interior"]["temp_mitjana"]) ?>º</span>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= round($statsDia2["Interior"]["humitat_mitjana"]) ?>%</span>
                            </div>
                        </div>
                        <!--  BLOC MITJANA EXTERIOR -->
                        <div class="marc mitjana-exterior">
                            <h3 class="titol exterior">Mitjana Exterior</h3>
                            <div class="grid-dades-mitjana">
                                <img src="icons/temp.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= formatTemp($statsDia2["Exterior"]["temp_mitjana"]) ?>º</span>
                                <img src="icons/hum.svg" class="ico-principal-grid">
                                <span class="valor-mitjana"><?= round($statsDia2["Exterior"]["humitat_mitjana"]) ?>%</span>
                            </div>
                        </div>
                        <!--  BLOC DIFERÈNCIA MITJANA  -->
                        <div class="marc dif-mitjana">
                            <h3 class="titol diferencia">
                                Diferència mitjana
                                <span class="info-icon">
                                    <img src="icons/info.svg" alt="info">
                                    <span class="tooltip">Diferència de la mitjana interior respecte exterior.</span>
                                </span>
                            </h3>
                           <div class="grid-dades-mitjana">
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <!-- fem servir l’operador ternari per la condicio de mostrar el signe positiu -->
                            <span class="valor-mitjana"><?= ($diferenciaMitjaTempDia2 > 0 ? '+' : '') . formatTemp($diferenciaMitjaTempDia2) ?>º</span>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= ($diferenciaMitjaHumDia2 > 0 ? '+' : '') . round($diferenciaMitjaHumDia2) ?>%</span>
                        </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <p class="error-msg">No s'han trobat dades vàlides per al Dia 2 (<?= formatarData($diaSeleccionat2) ?>).</p>
                <?php endif; ?>
                <!-- final dia 2 -->
        <?php else: ?>
            <div class="sensedates">Selecciona dos dies per comparar dades.</div>
        <?php endif; ?>
    </div>
</div>