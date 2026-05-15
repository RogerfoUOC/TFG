<?php 
include_once 'includes/queries.php';
// llegim la pàgina del log de la URL (?log_pagina=2), mínim 1 per evitar valors invàlids
$paginaLog  = isset($_GET['log_pagina']) ? max(1, (int)$_GET['log_pagina']) : 1;
$limit      = $paginaLog * 10;
$userId     = $_SESSION['usuari_id'];
$alertes    = getAlertesUsuari($conn, $userId);
$LogAlertes = getAlertsLogs($conn, $userId, $limit);

$error_alerta       = $_SESSION['error_alerta'] ?? null;
$formAlertaObert    = $_SESSION['form_alerta_obert'] ?? false;
$toastSuccess       = $_SESSION['ok_alerta'] ?? null;
unset($_SESSION['ok_alerta']);
unset($_SESSION['error_alerta']);
unset($_SESSION['form_alerta_obert']);
?>
<div class="panell">
    <h1>Alertes</h1>
    <?php
        if ($toastSuccess) echo '<div class="toast success-box">' . htmlspecialchars($toastSuccess) . '</div>';
        ?>
    <!-- FORMULARI NOVA ALERTA -->
    <div class="marc nova-alerta">
        <div id="alert-header" class="nova-alerta-header <?= $formAlertaObert ? 'active' : '' ?>">
            <span id="plus-alert" class="nova-alerta-ico <?= $formAlertaObert ? 'ocult' : '' ?>"><i class="fa-solid fa-square-plus"></i></span>
            <span id="less-alert" class="nova-alerta-ico <?= $formAlertaObert ? '' : 'ocult' ?>"><i class="fa-solid fa-square-minus"></i></span>
            <span class="nova-alerta-titol">Crear alerta</span>
        </div>
        
        <form method="POST" id="form-alerts" class="formulari-nova-alerta <?= $formAlertaObert ? '' : 'ocult' ?>" action="./includes/add-alert.php">
        <!-- columna esquerra -->
            <div class="alerta-col">
                <div class="alerta-grup">
                    <span class="alerta-label">Tipus de dada</span>
                    <div class="radio-group-alerta">
                        <label class="radio-alerta">
                            <input type="radio" name="tipus_dada" value="temperatura" checked>
                            <span>Temperatura</span>
                        </label>
                        <label class="radio-alerta">
                            <input type="radio" name="tipus_dada" value="humitat">
                            <span>Humitat</span>
                        </label>
                    </div>
                </div>

                <div class="alerta-grup">
                    <span class="alerta-label">Ubicació</span>
                    <div class="radio-group-alerta">
                        <label class="radio-alerta">
                            <input type="radio" name="ubicacio" value="Interior" checked>
                            <span>Interior</span>
                        </label>
                        <label class="radio-alerta">
                            <input type="radio" name="ubicacio" value="Exterior">
                            <span>Exterior</span>
                        </label>
                    </div>
                </div>

                <div class="alerta-grup">
                    <span class="alerta-label">Tipus d'avís</span>
                    <div class="checkbox-group-alerta">
                        <label class="checkbox-alerta">
                            <input type="checkbox" name="avis_web" checked>
                            <span>Notificació web</span>
                        </label>
                        <label class="checkbox-alerta">
                            <input type="checkbox" name="avis_mail">
                            <span>Correu electrònic</span>
                        </label>
                    </div>
                    <?php if ($error_alerta): ?>
                        <p class="error-box"><?= htmlspecialchars($error_alerta) ?></p>
                    <?php endif; ?>
                    <p id="error-avis" class="label-error ocult">Tria com a mínim un tipus d'avís.</p>
                </div>
            </div>

            <!-- columna dreta -->
            <div class="alerta-col">
                <div class="alerta-grup">
                    <span class="alerta-label">Condició</span>
                    <select name="condicio" class="select-alerta">
                        <option value="inferior">Inferior a ... (<=)</option>
                        <option value="superior">Superior a ... (>=)</option>
                    </select>
                </div>
                <div class="alerta-grup">
                    <span class="alerta-label">Valor</span>
                        <!-- Humitat -->
                        <div id="slider-humitat" class="slider-wrapper ocult">
                            <input type="range" name="humitat" id="slider-hum" min="0" max="100" value="50" class="slider-alerta">
                            <span id="display-hum">50%</span>
                        </div>
                        <!-- Temperatura -->
                        <div id="slider-temperatura" class="slider-wrapper">
                            <input type="range" name="temperatura" id="slider-temp" min="-10" max="50" value="20" class="slider-alerta">
                            <span id="display-temp">20ºC</span>
                        </div>
                </div>

                <div class="alerta-grup alerta-grup-boto">
                    <button type="submit" class="btn-alerta">Crear alerta</button>
                </div>
            </div>
        </form>

    </div>
    <div class="marc alertes-autoritzat">
        <div class="tabs-auth tabs-alerta-header">
            <button id="btn-alertes-tab" class="tab-btn active">Alertes creades</button>
            <button id="btn-log-tab" class="tab-btn">Registre d'alertes</button>
        </div>

        <div id="tab-alertes" class="tab-content active">
            <!-- llistat d'alertes -->
            <?php if ($alertes && $alertes->num_rows > 0): ?>
                <ul class="llista-alertes">
                    <?php while ($alerta = $alertes->fetch_assoc()):
                        $sensor   = $alerta['sensor'] === 'temperatura' ? 'temperatura' : 'humitat';
                        $unitat   = $alerta['sensor'] === 'temperatura' ? 'º' : '%';
                        $condicio = $alerta['condicio'] === 'inferior' ? 'inferior' : 'superior';
                        $avis_text = '';
                        if ($alerta['avis_mail'] && $alerta['avis_web']) {
                            $avis_text = 'un correu electrònic i avís web.';
                        } elseif ($alerta['avis_mail']) {
                            $avis_text = 'un correu electrònic.';
                        } elseif ($alerta['avis_web']) {
                            $avis_text = 'avís web.';
                        }
                    ?>
                    <li class="alerta-item">
                        <span class="alerta-id">#<?= $alerta['id'] ?>                                                                                                                                                                                                                                                  </span>    
                        <span class="alerta-led <?= $alerta['activa'] ? 'led-activa' : 'led-inactiva' ?>"></span>
                        <span class="alerta-desc">
                            Si la <strong><?= $sensor ?></strong>
                            <strong><?= htmlspecialchars(strtolower($alerta['localitzacio'])) ?></strong>
                            és <strong><?= $condicio ?></strong>
                            a <strong><?= htmlspecialchars($alerta['valor']) ?><?= $unitat ?></strong>
                            envia <?= htmlspecialchars($avis_text) ?>
                            <span class="alerta-count">(0)</span>
                        </span>
                        <div class="alerta-accions">
                            <form method="POST" action="./includes/update-alert.php">
                                <input type="hidden" name="alerta_id" value="<?= $alerta['id'] ?>">         
                                <input type="hidden" name="activa" value="<?= $alerta['activa'] ? 0 : 1?>"><!-- envia el valor invers a l'actual perquè el PHP no hagi de consultar la BD -->                       
                                <label class="toggle-switch">
                                    <input type="checkbox" <?= $alerta['activa'] ? 'checked' : '' ?> >
                                    <span class="toggle-track"></span>
                                </label>
                            </form> 
                            <button type="button" class="btn-icon-alerta btn-eliminar" data-id="<?= $alerta['id'] ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="sense-alertes">No tens alertes creades.</p>
            <?php endif; ?>
        </div>

        <div id="tab-log" class="tab-content">
            <!-- registre d'alertes -->
            <?php if ($LogAlertes && $LogAlertes->num_rows > 0): ?>
                <ul class="llista-alertes">
                    <?php while ($rowLog  = $LogAlertes->fetch_assoc()):
                        $idAlerta        = $rowLog ['alert_id'];
                        $dataLog         = date('d/m/Y H:i', strtotime($rowLog ['data_activacio']));
                        $sensorLog       = $rowLog ['sensor'] === 'temperatura' ? 'temperatura' : 'humitat';
                        $unitatLog       = $rowLog ['sensor'] === 'temperatura' ? 'º' : '%';
                        $localitzacioLog = $rowLog ['localitzacio'];
                        $condicioLog     = $rowLog ['condicio'] === 'inferior' ? 'inferior' : 'superior';
                        $valorLog        = $rowLog ['valor'];
                        $valorSensorLog  = $rowLog ['valor_sensor'];
                        $textLog         = '';
                    ?>
                    <li class="alerta-item">
                        <table class="alerta-log-taula">
                            <tr>
                                <td class="alerta-log-cap">
                                    <span class="alerta-id">Alerta #<?= $idAlerta ?></span>
                                    <span class="alerta-data"><?= $dataLog ?></span>
                                </td>
                          
                                <td class="alerta-log-desc">
                                    <span class="alerta-desc">
                                        <strong><?= ucfirst($sensorLog) ?></strong>
                                        <strong><?= htmlspecialchars(strtolower($localitzacioLog)) ?></strong>
                                        detectada <strong><?= $condicioLog ?></strong>
                                        a <strong><?= htmlspecialchars($valorLog) ?><?= $unitatLog ?></strong>
                                        (<?= htmlspecialchars($valorSensorLog) ?><?= $unitatLog ?>)
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </li>
                    <?php endwhile; ?>
                    <?php if ($LogAlertes->num_rows === $limit): ?>
                        <li class="mes-registres">
                            <a href="?log_pagina=<?= $paginaLog + 1 ?>#tab-log">Veure més registres</a>
                        </li>
                    <?php endif; ?>                
                </ul>
            <?php else: ?>
                <p class="sense-alertes">No hi ha registre d'alertes.</p>
            <?php endif; ?>
        </div>
    </div>
</div> 

<div id="modal-eliminar-alerta" class="capa-modal">
    <div class="modal-alerta marc">
        <h2>Segur que vols eliminar l'alerta <span id="modal-alerta-id"></span>?</h2>
        <form method="POST" id="form-eliminar" action="./includes/delete-alert.php">
            <input type="hidden" name="alerta_id" id="input-alerta-id">
            <div class="grup-btns">
                <button type="submit" class="btn-submit">Eliminar alerta</button>
                <button type="button" id="btn-cancel-eliminar" class="btn-cancel">Cancel·lar</button>
            </div>
        </form>
    </div>
</div>
<script defer src="js/alerts.js"></script>
<script defer src="js/tabs-alerts.js"></script>