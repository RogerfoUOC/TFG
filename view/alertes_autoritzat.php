<div class="panell">
    <h1>Alertes</h1>

    <!-- FORMULARI NOVA ALERTA -->
    <div class="marc nova-alerta">
        <div id="alert-header" class="nova-alerta-header">
            <span id="plus-alert" class="nova-alerta-ico"><i class="fa-solid fa-square-plus"></i></span>
            <span id="less-alert" class="nova-alerta-ico ocult"><i class="fa-solid fa-square-minus"></i></span>
            <span class="nova-alerta-titol">Crear alerta</span>
        </div>
        
        <form method="POST" id="form-alerts" class="formulari-nova-alerta ocult" action="./includes/add-alert.php">
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
                    <button type="button" class="btn-alerta">Crear alerta</button>
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
<style>



    .nova-alerta,
    .tabs-alerta,
    .llistat-alerta,
    .registre-alerta{
        max-width: 750px;
        margin-bottom:20px;
    }
    .fa-square-plus,
    .fa-square-minus{
        color: #1a5495;
    }
    .nova-alerta-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        color: #444;
        cursor: pointer;
    }
    
    .formulari-nova-alerta{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        padding: 16px 20px 16px 20px;
        column-gap: 40px;  
        margin-bottom: 0px;
    }

    .alerta-col {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .alerta-grup {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Radio buttons personalitzats */
    .radio-group-alerta {
        display: flex;
        gap: 16px;
    }

    .radio-alerta {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        color: #333;
    }

    .radio-alerta input[type="radio"] {
        accent-color: #1a5495;
        width: 15px;
        height: 15px;
        cursor: pointer;
    }

    /* Checkboxes personalitzats */
    .checkbox-group-alerta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .checkbox-alerta {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        color: #333;
    }

    .checkbox-alerta input[type="checkbox"] {
        accent-color: #1a5495;
        width: 15px;
        height: 15px;
        cursor: pointer;
    }

    /* Select condició */
    .select-alerta {
        padding: 7px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.9rem;
        font-family: inherit;
        background: #fff;
        color: #333;
        cursor: pointer;
        max-width: 220px;
    }

    .select-alerta:focus {
        outline: none;
        border-color: #1a5495;
    }

    /* Slider */
    .slider-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .slider-alerta {
        flex: 1;
        accent-color: #1a5495;
        height: 4px;
        cursor: pointer;
    }

    .slider-valor {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a5495;
        min-width: 42px;
        text-align: right;
    }

    .slider-alerta {
        flex: 1;
        -webkit-appearance: none;
        appearance: none;
        height: 6px;
        border-radius: 5px;
        background: #ddd;
        cursor: pointer;
        outline: none;
    }

    .slider-alerta::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #1a5495;
        cursor: pointer;
    }

    .slider-alerta::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #1a5495;
        cursor: pointer;
        border: none;
    }

    .ocult {
        display:none;   
    }

</style>    
<script defer src="js/alerts.js"></script>