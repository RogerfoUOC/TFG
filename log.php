<?php 
    $page = 'log';
    include 'includes/header.php'; 
    include 'includes/connexio.php';
    include 'includes/functions.php';

    // variable per controlar si s'han mostrar el resultat
    $mostrarLogs = false;
    
    
    // filtres i data triada al formulari
    $filtreLocalitzacio = isset($_GET['log']) ? $_GET['log'] : 'tot';
    $diaSeleccionatLog = $_GET['data'] ?? ''; 

    // carregar consultes a base de dades
    include 'includes/queries.php';

    // comprovar si s'ha triat una data per mostrar les dades
    if ($diaSeleccionatLog !== '') {
        $mostrarLogs = true;
    }
    
    // executem la consulta
    $resultLogs = $conn->query($filtreLog);

?>
<!-- MOSTRAR CONTINGUT -->
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">
        <h1>Logs</h1>
        <form method="GET" class="formulariFiltre">
            <fieldset>
                <legend>Filtre de dades:</legend>
                
                <!-- grup de radio buttons -->
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="complet" name="log" value="tot" 
                            <?= $filtreLocalitzacio === 'tot' ? 'checked' : '' ?> />
                        <label for="complet">Tot</label>
                    </div>
                    
                    <div class="radio-option">
                        <input type="radio" id="interior" name="log" value="int" 
                            <?= $filtreLocalitzacio === 'int' ? 'checked' : '' ?> />
                        <label for="interior">Interior</label>
                    </div>
                    
                    <div class="radio-option">
                        <input type="radio" id="exterior" name="log" value="ext" 
                            <?= $filtreLocalitzacio === 'ext' ? 'checked' : '' ?> />
                        <label for="exterior">Exterior</label>
                    </div>
                </div>
                
                <!-- grup data i botó -->
                <div class="date-group">
                    <input type="date" id="inputData" name="data" value="<?php echo $diaSeleccionatLog; ?>">
                    <div class="fastData">
                        <button type="button" onclick="getAvui()">Avui</button>
                        <button type="button" onclick="getAhir()">Ahir</button>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Veure logs</button>
            </fieldset>
        </form>
        <!-- MOSTRAR CONTINGUT -->
        <?php if ($mostrarLogs): ?>
            <div id="dia"><?= formatarData($diaSeleccionatLog) ?></div>  
            <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Ubicació</th>
                                <th>TMP (°C)</th>
                                <th>HMT (%)</th>
                                <th>Hora</th>
                                <th>Data</th>
                                <th>Sensor</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                while ($row = $resultLogs->fetch_assoc()): 
                                    $temp = number_format($row['value1'], 1);
                                    $humitat = round($row['value2']);
                                    $data = new DateTime($row['reading_time']);
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row["location"]) ?></td>
                                    <td class="temperature"><?= str_replace('.0', '', $temp) ?>º</td>
                                    <td class="humidity"><?= $humitat ?>%</td>
                                    <td class="timestamp"><?= htmlspecialchars($data->format('H:i')) ?></td>
                                    <td class="timestamp"><?= htmlspecialchars($data->format('d/m/Y')) ?></td>
                                    <td><?= htmlspecialchars($row["sensor"]) ?></td>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <?php endwhile;
                            ?>
                    </tbody>
                </table>
        <?php else: ?>
            <div class="sensedates">Selecciona un dia per mostrar el log.</div>
        <?php endif; ?>
        </div>
    </div>
</div>



