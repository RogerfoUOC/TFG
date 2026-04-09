<?php 
    $page = 'projecte';
    include 'includes/header.php'; 
    include 'includes/connexio.php';
?>

<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">
        <h1>Projecte</h1>
        <div class="projecte-container">
            <div class="projecte-layout">
                <div class="projecte-text">
                    <p>
                        Aquest projecte consisteix en un sistema de monitoratge de temperatura i humitat 
                        que combina una part física amb una plataforma web pròpia. Mitjançant dos dispositius 
                        <strong>Arduino</strong> amb connexió <strong>WiFi</strong> i sensors ambientals, es recullen dades tant d’un espai interior 
                        com de l’exterior per poder comparar com varien les condicions ambientals al llarg del temps.
                    </p>
                    <p>
                        Cada dispositiu incorpora una <strong>placa ESP8266</strong> i un <strong>sensor BME280</strong>, capaç de mesurar 
                        temperatura i humitat amb precisió. Tots dos circuits estan encapsulats i protegit tant per evitar desconexions de 
                        cables com per la possible pluja i pols de l'exterior. Tots dos dispositius envien les dades a un servidor web cada 10 minuts, on s’emmagatzemen 
                        en una base de dades per poder ser mostrades i filtrades des de la web.
                    </p>
                </div>
                <div class="projecte-imatge">
                    <img src="./img/sensor-01.png" alt="Placa + Sensor">
                </div>
            </div>
            <div class="projecte-layout layout2">
                <div class="projecte-imatge">
                    <img src="./img/sensor-02.png" alt="Sensor encapsulat">
                </div>
                <div class="projecte-text">
                    <p>
                        La web permet visualitzar les dades de manera clara i accessible, 
                        consultar valors actuals i revisar l’historial de registres. La interfície està dissenyada 
                        per ser senzilla i usable, adaptant-se a diferents dispositius, i facilita entendre 
                        d’un cop d’ull com canvien la temperatura i la humitat segons la ubicació i el moment del dia.
                    </p>
                    <p>
                        En conjunt, el projecte mostra com és possible connectar el món físic amb el digital, passant de 
                        la captació de dades reals amb sensors a una visualització web útil, personalitzada i pensada per 
                        a l’ús quotidià.
                    </p>
                </div>
            </div>
            <div class="projecte-layout">
                <div class="projecte-text">
                    <p>
                        La part web del projecte s’ha desenvolupat amb tecnologies <strong>HTML</strong>, <strong>CSS</strong> i <strong>JavaScript</strong>,
                        juntament amb <strong>PHP</strong> i una base de dades <strong>MySQL</strong>. Aquesta combinació permet rebre les dades enviades
                        pels dispositius <strong>Arduino</strong>, emmagatzemar-les de forma estructurada i mostrar-les de manera clara
                        i accessible a través del navegador.
                    </p>
                    <p>
                        Tot el codi del projecte, tant de la part web com de la comunicació amb els dispositius, està
                        disponible al repositori de <a href="https://github.com/RogerfoUOC/projecte3" target="_blank" ">GitHub</a>.
                    </p>
                    <p>
                        Aquest projecte s’ha desenvolupat en el marc de l’assignatura del darrer semestre del <strong>Grau de Tècniques 
                        d’Interacció Digital i Multimèdia</strong> de la <strong>UOC</strong>, com a part del treball final de l’assignatura Projecte 3. 
                        El seu desenvolupament s’ha dut a terme durant el desembre de 2025, integrant coneixements de programació, 
                        disseny web i interacció amb dispositius físics.
                    </p>
                </div>
                <div class="projecte-imatge">
                    <img src="./img/sensor-03.png" alt="Sensor a l'exterior">
                </div>
            </div>
        </div>
    </div>
</div>