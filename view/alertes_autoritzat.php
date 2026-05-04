<?php 
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
    <div class="tabs-auth">
        <button id="btn-alertes-tab" class="tab-btn active">Alertes creades</button>
        <button id="btn-log-tab" class="tab-btn">Registre d'alertes</button>
    </div>

    <div id="tab-alertes" class="tab-content active">
        <!-- llistat d'alertes -->
        ALERTES CREADES
    </div>

    <div id="tab-log" class="tab-content">
        <!-- registre d'alertes -->
         LOG D'ALERTES
    </div>

</div>    
<script defer src="js/alerts.js"></script>
<script defer src="js/tabs.js"></script>