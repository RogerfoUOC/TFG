<div class="panell">
    <h1>Alertes</h1>

    <!-- FORMULARI NOVA ALERTA -->
    <div class="marc nova-alerta">
        <div id="alert-header" class="nova-alerta-header">
            <span id="plus-alert" class="nova-alerta-ico"><i class="fa-solid fa-square-plus"></i></span>
            <span id="less-alert" class="nova-alerta-ico ocult"><i class="fa-solid fa-square-minus"></i></span>
            <span class="nova-alerta-titol">Crear alerta</span>
        </div>
        
        <form method="POST" id="form-alerts" class="formulari-nova-alerta ocult" action="./includes/add-alert.php"> <!-- TODO: fitxer pendent de creació -->
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
                </div>
            </div>

            <!-- columna dreta -->
            <div class="alerta-col">
                <div class="alerta-grup">
                    <span class="alerta-label">Condició</span>
                    <select name="condicio" class="select-alerta">
                        <option value="lt">Menor que ... (&lt;)</option>
                        <option value="gt">Major que ... (&gt;)</option>
                        <option value="eq">Igual a ... (=)</option>
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
                            <input type="range" name="temperatura" id="slider-temp" min="0" max="40" value="20" class="slider-alerta">
                            <span id="display-temp">20ºC</span>
                        </div>
                </div>

                <div class="alerta-grup alerta-grup-boto">
                    <button type="submit" class="btn-alerta">Crear alerta</button>
                </div>
            </div>
        </form>

    </div>

    <!-- Llistat d'alertes -->
    <div class="marc llistat-alerta">
        Alertes creades
    </div>

    <!-- Registre d'alertes -->
    <div class="marc registre-alerta">
        Registre d'alertes
    </div>
</div>    
<script defer src="js/alerts.js"></script>