<?php 
$page = 'historic';
include 'includes/header.php'; 
include 'includes/connexio.php';
include 'includes/functions.php';

// variable per controlar si s'han mostrar el resultat
$mostrarDades = false;

// data triada al formulari
$diaSeleccionat1 = isset($_GET['data']) && $_GET['data'] !== '' ? $_GET['data'] : '';


// carregar consultes a base de dades
include 'includes/queries.php';

// comprovar si s'ha triat una data per mostrar les dades
if ($diaSeleccionat1 !== '') {
    $mostrarDades = true;
}

// executem les consultes
$resultInterior     = getDadesInterior($conn, $diaConsulta1);
$resultExterior     = getDadesExterior($conn, $diaConsulta1);
$resultatHistoric   = getDadesHistoric1($conn, $diaSeleccionat1);

var_dump($resultatHistoric);
exit;

// arrays pels horais de  la gràfica
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

/* --- LLEGIR ESTADÍSTIQUES DEL DIA (min / max / avg) --- */
$stats = [
    "Interior" => null,
    "Exterior" => null
];

while ($row = $resultatHistoric->fetch_assoc()) {
    $stats[$row["location"]] = $row;
}

/* --- CALCULAR DIFERÈNCIES INTERIOR - EXTERIOR --- */
if (is_numeric($stats["Interior"]["temp_mitjana"]) && is_numeric($stats["Exterior"]["temp_mitjana"])) {
    $diferenciaMitjaTemp = $stats["Interior"]["temp_mitjana"] - $stats["Exterior"]["temp_mitjana"];
}

if (is_numeric($stats["Interior"]["humitat_mitjana"]) && is_numeric($stats["Exterior"]["humitat_mitjana"])) {
    $diferenciaMitjaHum = $stats["Interior"]["humitat_mitjana"] - $stats["Exterior"]["humitat_mitjana"];
}

$conn->close();
?>
<!-- MOSTRAR CONTINGUT -->
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">
        <h1>Històric de dades</h1>
        <!-- FORMULARI -->
        <form method="GET" action="historic.php" class="formulariFiltre">
            <fieldset>
                <legend>Selecciona un dia:</legend>  
                <div class="date-group">          
                    <input type="date" id="inputData" name="data" value="<?= htmlspecialchars($diaSeleccionat1) ?>">
                    <div class="fastData">
                        <button type="button" onclick="getAvui()">Avui</button>
                        <button type="button" onclick="getAhir()">Ahir</button>
                    </div>
                </div>          
                <button type="submit" class="btn-submit">Mostrar dades</button>
            </fieldset>
        </form>

        <!-- CAIXES DADES -->
        <?php if ($mostrarDades): ?>
            <div id="dia">
            <?= formatarData($diaSeleccionat1) ?>
            </div>         
            <div class="dades historic">     
                <div class="grid-historic">
                    <!--  BLOC INTERIOR -->
                    <div class="marc interior">
                        <h3 class="titol interior">Interior</h3>
                        <div class="grid-dades-interior"> 
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <div class="grup-valor"> 
                                <img src="icons/min.svg" class="ico-secundaria-grid">
                                <span class="valor-grid"><?= formatTemp($stats["Interior"]["temp_minima"]) ?>º</span>
                            </div>
                            <div class="grup-valor"> 
                                <img src="icons/max.svg" class="ico-secundaria-grid">
                                <span class="valor-grid"><?= formatTemp($stats["Interior"]["temp_maxima"]) ?>º</span>
                            </div>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <div class="grup-valor"> 
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
                    <div class="marc exterior">
                        <h3 class="titol exterior">Exterior</h3>
                        <div class="grid-dades-interior"> 
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <div class="grup-valor"> 
                                <img src="icons/min.svg" class="ico-secundaria-grid">
                                <span class="valor-grid"><?= formatTemp($stats["Exterior"]["temp_minima"]) ?>º</span>
                            </div>
                            <div class="grup-valor"> 
                                <img src="icons/max.svg" class="ico-secundaria-grid">
                                <span class="valor-grid"><?= formatTemp($stats["Exterior"]["temp_maxima"]) ?>º</span>
                            </div>
                            <img src="icons/hum.svg" class="ico-principal-grid">
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
                    <!--  BLOC MITJANA INTERIOR -->
                    <div class="marc mitjana-interior">
                        <h3 class="titol interior">Mitjana Interior</h3>
                        <div class="grid-dades-mitjana">
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= formatTemp($stats["Interior"]["temp_mitjana"]) ?>º</span>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= round($stats["Interior"]["humitat_mitjana"]) ?>%</span>
                        </div>
                    </div>
                    <!--  BLOC MITJANA EXTERIOR -->
                    <div class="marc mitjana-exterior">
                        <h3 class="titol exterior">Mitjana Exterior</h3>
                        <div class="grid-dades-mitjana">
                            <img src="icons/temp.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= formatTemp($stats["Exterior"]["temp_mitjana"]) ?>º</span>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= round($stats["Exterior"]["humitat_mitjana"]) ?>%</span>
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
                            <!-- fem servir l’operador ternari per la condicio de mostrar el signe positiu si el valor és superior a 0 -->
                            <span class="valor-mitjana"><?= ($diferenciaMitjaTemp > 0 ? '+' : '') . formatTemp($diferenciaMitjaTemp) ?>º</span>
                            <img src="icons/hum.svg" class="ico-principal-grid">
                            <span class="valor-mitjana"><?= ($diferenciaMitjaHum > 0 ? '+' : '') . round($diferenciaMitjaHum) ?>%</span>
                        </div>
                    </div>
                </div><!-- Final "parent"> -->
            </div><!--  Final "dades historic -->              
            <!-- GRÀFICA -->
            <?php include 'grafica.php'; ?>
            <!--  BLOC UPDATES  -->
            <div class="updateData">
                <div class="data-fila">
                    <span><strong> Dades del dia seleccionat:</strong> </span>
                    <span><?= date('d/m/Y', strtotime($diaSeleccionat1)) ?></span>
                </div>
            </div>
        <?php else: ?>
            <div class="sensedates">Selecciona una data al formulari per veure les dades.</div>
        <?php endif; ?>    
    </div> <!-- Final "content"> --> 
</div> <!-- Final "main-container"> -->


