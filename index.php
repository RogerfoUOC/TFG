<?php 
$page = 'home';
include 'includes/header.php';    
include 'includes/connexio.php';
include 'includes/functions.php';

// assiganció del dia actual
$diaSeleccionat = date('d/m/Y');

// carregar consultes a base de dades
include 'includes/queries.php';

// executem les consultes
$resultUltimesDades = $conn->query($ultimesDades);
$resultatDiaris     = $conn->query($dadesDiaries);
$resultInterior     = $conn->query($dadesInterior);
$resultExterior     = $conn->query($dadesExterior);
$resultatUltimaLecturaInterior = $conn->query($sqlUltimaLecturaInterior );
$resultatUltimaLecturaExterior = $conn->query($sqlUltimaLecturaExterior);

// obtenim el registre associatiu de l'última lectura
$registreUltimaLecturaInterior = $resultatUltimaLecturaInterior -> fetch_assoc();
$registreUltimaLecturaExterior = $resultatUltimaLecturaExterior -> fetch_assoc();

// convertim la data de l'última lectura a objecte DateTime (o null si no existeix)
$dataHoraUltimaInterior = $registreUltimaLecturaInterior ? new DateTime($registreUltimaLecturaInterior['reading_time']) : null;
$dataHoraUltimaExterior = $registreUltimaLecturaExterior ? new DateTime($registreUltimaLecturaExterior['reading_time']) : null;

// inicialitzem arrays per guardar les dades horàries de la gràfica (24 hores)
$tempINT = array_fill(0, 24, null);
$humINT  = array_fill(0, 24, null);
$tempEXT = array_fill(0, 24, null);
$humEXT  = array_fill(0, 24, null);

// omplim arrays Interior
while ($fila = $resultInterior->fetch_assoc()) {
    $h = intval($fila['hora']);
    $tempINT[$h] = floatval($fila['temperatura']);
    $humINT[$h]  = floatval($fila['humitat']);
}

// omplim arrays Exterior
while ($fila = $resultExterior->fetch_assoc()) {
    $h = intval($fila['hora']);
    $tempEXT[$h] = floatval($fila['temperatura']);
    $humEXT[$h]  = floatval($fila['humitat']);
}

/* --- LLEGIR ÚLTIMA LECTURA DE CADA UBICACIÓ --- */
$actuals = [
    "Interior" => ["temp" => null, "hum" => null],
    "Exterior" => ["temp" => null, "hum" => null]
];

while ($row = $resultUltimesDades->fetch_assoc()) {
    $loc = $row["location"];
    $actuals[$loc]["temp"] = number_format($row["temperatura"], 1);
    $actuals[$loc]["hum"]  = round($row["humitat"]);
}

/* --- LLEGIR ESTADÍSTIQUES DEL DIA (min / max / avg) --- */
$stats = [
    "Interior" => null,
    "Exterior" => null
];

while ($row = $resultatDiaris->fetch_assoc()) {
    $stats[$row["location"]] = $row;
}

/* --- CALCULAR DIFERÈNCIES INTERIOR - EXTERIOR --- */
$diferenciaTemp = null;
$diferenciaHum  = null;

if (is_numeric($actuals["Interior"]["temp"]) && is_numeric($actuals["Exterior"]["temp"])) {
    $diferenciaTemp = (float)$actuals["Interior"]["temp"] - (float)$actuals["Exterior"]["temp"];
}

if (is_numeric($actuals["Interior"]["hum"]) && is_numeric($actuals["Exterior"]["hum"])) {
    $diferenciaHum = (int)$actuals["Interior"]["hum"] - (int)$actuals["Exterior"]["hum"];
}


$conn->close();
?>

<!-- MOSTRAR CONTINGUT -->
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">
        <h1>Dades actuals.</h1>
        <div id="dia">
        <?= $diaSeleccionat ?>
        </div>
        <div class="dades actuals">
            <!--  BLOC INTERIOR -->
            <div class="marc">
                <h3 class="titol interior">Interior</h3>
                <div class="grid-dades-actuals"> 
                    <img src="icons/temp.svg" class="ico-principal-grid">
                    <span class="valor-actual-grid"><?= formatTemp($actuals["Interior"]["temp"]) ?>º</span> <div class="grup-valor"> 
                        <img src="icons/min.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= formatTemp($stats["Interior"]["temp_minima"]) ?>º</span>
                    </div>
                    <div class="grup-valor"> 
                        <img src="icons/max.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= formatTemp($stats["Interior"]["temp_maxima"]) ?>º</span>
                    </div>
                    <img src="icons/hum.svg" class="ico-principal-grid">
                    <span class="valor-actual-grid"><?= $actuals["Interior"]["hum"] ?>%</span> <div class="grup-valor"> 
                        <img src="icons/min.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= round($stats["Interior"]["humitat_minima"]) ?>%</span>
                    </div>
                    <div class="grup-valor"> 
                        <img src="icons/max.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= round($stats["Interior"]["humitat_maxima"]) ?>%</span>
                    </div>
                </div>
            </div>
            <!--  BLOC EXTERIOR -->
            <div class="marc">
                <h3 class="titol exterior">Exterior</h3>
                <div class="grid-dades-actuals">
                    <img src="icons/temp.svg" class="ico-principal-grid">
                    <span class="valor-actual-grid"><?= formatTemp($actuals["Exterior"]["temp"]) ?>º</span>
                    <div class="grup-valor"> 
                        <img src="icons/min.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= formatTemp($stats["Exterior"]["temp_minima"]) ?>º</span>
                    </div>
                    <div class="grup-valor"> 
                        <img src="icons/max.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= formatTemp($stats["Exterior"]["temp_maxima"]) ?>º</span>
                    </div>
                    <img src="icons/hum.svg" class="ico-principal-grid">
                    <span class="valor-actual-grid"><?= $actuals["Exterior"]["hum"] ?>%</span>
                    <div class="grup-valor"> 
                        <img src="icons/min.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= round($stats["Exterior"]["humitat_minima"]) ?>%</span>
                    </div>
                    <div class="grup-valor"> 
                        <img src="icons/max.svg" class="ico-secundaria-grid">
                        <span class="valor-grid"><?= round($stats["Exterior"]["humitat_maxima"]) ?>%</span>
                    </div>
                </div>
            </div>
            <!--  BLOC DIFERÈNCIA -->
            <div class="marc diferencia">
                <h3 class="titol diferencia">
                    Diferència
                    <span class="info-icon">
                        <img src="icons/info.svg" alt="info">
                        <span class="tooltip">Diferència interior respecte exterior.</span>
                    </span>
                </h3>
                <div class="grid-dades-mitjana">
                    <img src="icons/temp.svg" class="ico-principal-grid">
                    <!-- fem servir l’operador ternari per la condicio de mostrar el signe positiu -->
                    <span class="valor-mitjana"><?= ($diferenciaTemp > 0 ? '+' : '') . formatTemp($diferenciaTemp) ?>º</span>
                    <img src="icons/hum.svg" class="ico-principal-grid">
                    <span class="valor-mitjana"><?= ($diferenciaHum > 0 ? '+' : '') . round($diferenciaHum) ?>%</span>
                </div>
            </div>
        </div>

         <!--  GRÀFICA -->
        <?php include 'grafica.php'; ?>
         <!--  BLOC UPDATES  -->
        <div class="updateData">
            <div class="data-fila">
                <span><strong>Última lectura interior:</strong></span>
                <span>
                    <?= $dataHoraUltimaInterior ? $dataHoraUltimaInterior->format('H:i:s d/m/Y') : "Sense dades" ?>
                </span>
            </div>
            <div class="data-fila">
                <span class="label"><strong>Última lectura exterior:</strong></span>
                <span class="value">
                    <?= $dataHoraUltimaExterior ? $dataHoraUltimaExterior->format('H:i:s d/m/Y') : "Sense dades" ?>
                </span>
            </div>
        </div>

    </div>
</div>