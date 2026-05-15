<?php
/* ###################################### CONSULTES INDEX.PHP ###################################### */
/* -- Consulta últims registres:
        - trobem els IDs més recents de cada ubicació
        - seleccionem les dades d'aquests IDs
        - ordenem sempre amb Interior primer
*/
function getUltimesDades($conn) {
    $sql = "SELECT location, 
                    value1 as temperatura,
                    value2 as humitat,
                    reading_time 
                    FROM SensorData 
                    WHERE id IN (
                    SELECT MAX(id) FROM SensorData 
                    WHERE location IN ('Interior', 'Exterior') 
                    GROUP BY location
                )
                ORDER BY location = 'Interior' DESC ";  // 'Interior' primer: l'expressió booleana retorna 1 per 'Interior' i 0 per la resta; DESC posa l'1 al capdavant
    return $conn->query($sql);
}
            
/* Consulta per calcular els valors minims màxims i mitjanes */
function getDadesDiaries($conn) {
    $sql = "SELECT location,
                    MIN(CAST(value1 AS DECIMAL(10, 2))) as temp_minima,
                    MAX(CAST(value1 AS DECIMAL(10, 2))) as temp_maxima,
                    AVG(CAST(value1 AS DECIMAL(10, 2))) as temp_mitjana,
                    MIN(CAST(value2 AS DECIMAL(10, 2))) as humitat_minima,
                    MAX(CAST(value2 AS DECIMAL(10, 2))) as humitat_maxima,
                    AVG(CAST(value2 AS DECIMAL(10, 2))) as humitat_mitjana
                FROM SensorData
                WHERE location IN ('Interior', 'Exterior')
                    AND DATE(reading_time) = CURDATE()
                GROUP BY location
                ORDER BY location = 'Interior' DESC";
    return $conn->query($sql);
}

/* Últim registre INTERIOR */
function getUltimaLecturaInterior($conn) {
    $sql = "SELECT reading_time
        FROM SensorData
        WHERE location = 'Interior'
        ORDER BY id DESC
        LIMIT 1";
    return $conn->query($sql);
}

/* Últim registre EXTERIOR */
function getUltimaLecturaExterior($conn) {
    $sql = "SELECT reading_time
        FROM SensorData
        WHERE location = 'Exterior'
        ORDER BY id DESC
        LIMIT 1";
    return $conn->query($sql);
}

/* ###################################### CONSULTES HISTORIC.php ###################################### */
/* -- Determinar el dia a consultar -- */
 function getDadesHistoric1($conn, $diaSeleccionat1) {
    $sql = "SELECT location, 
            MIN(CAST(value1 AS DECIMAL(10, 2))) as temp_minima,
            MAX(CAST(value1 AS DECIMAL(10, 2))) as temp_maxima,
            AVG(CAST(value1 AS DECIMAL(10, 2))) as temp_mitjana,
            MIN(CAST(value2 AS DECIMAL(10, 2))) as humitat_minima,
            MAX(CAST(value2 AS DECIMAL(10, 2))) as humitat_maxima,
            AVG(CAST(value2 AS DECIMAL(10, 2))) as humitat_mitjana
        FROM SensorData
        WHERE location IN ('Interior', 'Exterior')
            AND DATE(reading_time) = ?
        GROUP BY location
        ORDER BY location = 'Interior' DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $diaSeleccionat1);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getDadesHistoric2($conn, $diaSeleccionat2) {
    $sql = "SELECT location,
            MIN(CAST(value1 AS DECIMAL(10, 2))) as temp_minima,
            MAX(CAST(value1 AS DECIMAL(10, 2))) as temp_maxima,
            AVG(CAST(value1 AS DECIMAL(10, 2))) as temp_mitjana,
            MIN(CAST(value2 AS DECIMAL(10, 2))) as humitat_minima,
            MAX(CAST(value2 AS DECIMAL(10, 2))) as humitat_maxima,
            AVG(CAST(value2 AS DECIMAL(10, 2))) as humitat_mitjana
        FROM SensorData
        WHERE location IN ('Interior', 'Exterior')
            AND DATE(reading_time) = ?
        GROUP BY location
        ORDER BY location = 'Interior' DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $diaSeleccionat2);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/* ###################################### CONSULTA LOG ###################################### */

/* -- Permet consultar dades segons el filtre del formulari -- */
function getResultLogs($conn, $filtreLocalitzacio, $diaSeleccionatLog) {
     
    if ($filtreLocalitzacio == 'int') {
        $sql = "SELECT id, sensor, location, value1, value2, reading_time 
            FROM SensorData
            WHERE location = ?
            AND DATE(reading_time) = ?
            ORDER BY reading_time DESC";
        $stmt = $conn->prepare($sql);
        $location = 'Interior';
        $stmt->bind_param("ss", $location, $diaSeleccionatLog);
    } elseif ($filtreLocalitzacio == 'ext') {
        $sql = "SELECT id, sensor, location, value1, value2, reading_time 
            FROM SensorData
            WHERE location = ?
            AND DATE(reading_time) = ?
            ORDER BY reading_time DESC";
        $stmt = $conn->prepare($sql);
        $location = 'Exterior';
        $stmt->bind_param("ss", $location, $diaSeleccionatLog);
    } else {
        $sql = "SELECT id, sensor, location, value1, value2, reading_time 
            FROM SensorData
            WHERE DATE(reading_time) = ?
            ORDER BY reading_time DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $diaSeleccionatLog);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/* ###################################### CONSULTES CHART ###################################### */



/* -- Consultes per INTERIOR -- */
function getDadesInterior($conn, $diaConsulta1) {
    $sql = "SELECT 
        DATE_FORMAT(s.reading_time, '%H') AS hora,
        s.value1 AS temperatura,
        s.value2 AS humitat
            FROM SensorData s
            INNER JOIN (
                SELECT 
                    DATE_FORMAT(reading_time, '%H') AS hora,
                    MAX(reading_time) AS max_time
                FROM SensorData
                WHERE location = 'Interior'
                AND DATE(reading_time) = ?
                GROUP BY hora
            ) x 
            ON DATE_FORMAT(s.reading_time, '%H') = x.hora
            AND s.reading_time = x.max_time
            ORDER BY hora";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $diaConsulta1);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/* -- Consultes per EXTERIOR -- */
function getDadesExterior($conn, $diaConsulta1) {
    $sql = "SELECT 
    DATE_FORMAT(s.reading_time, '%H') AS hora,
        s.value1 AS temperatura,
        s.value2 AS humitat
        FROM SensorData s
        INNER JOIN (
            SELECT 
                DATE_FORMAT(reading_time, '%H') AS hora,
                MAX(reading_time) AS max_time
            FROM SensorData
            WHERE location = 'Exterior'
            AND DATE(reading_time) = ?
            GROUP BY hora
        ) x ON DATE_FORMAT(s.reading_time, '%H') = x.hora
        AND s.reading_time = x.max_time
        ORDER BY hora";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $diaConsulta1);  
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}



/* ###################################### CONSULTES USUARI ###################################### */
function dataRegistreUsuari($conn, $userId) {
    if (!$userId) return null;

    $query = "SELECT created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $data = new DateTime($row['created_at']);
        return $data->format('d/m/Y H:i:s');
    }
    return null;
}

/* ###################################### CONSULTES ALERTES.php ###################################### */

function getComptadorAlertes($conn, $userId) {
    $sql  = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN activa = 1 THEN 1 ELSE 0 END) as actives /**/
             FROM alerts 
             WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}


function getAlertesUsuari($conn, $userId) {
    $sql = "SELECT id, localitzacio, sensor, condicio, valor, avis_web, avis_mail, activa
            FROM alerts
            WHERE user_id = ?
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/* RECORREM LES ALERTES ACTIVES DE CADA LOCALITZACIO */
function getAlertesActivesLocalitzacio($conn, $location) {
    $sql = "SELECT alerts.id, user_id, users.email, localitzacio, sensor, condicio, valor, activa, avis_web, avis_mail, users.email 
            FROM alerts
            JOIN users on alerts.user_id = users.id
            WHERE localitzacio = ? and activa = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/* VALOR ANTERIOR A L'ULTIMA LECTURA DE CADA UBICACIÓ */
function getPenultimaLectura($conn, $location){
    $sql = "SELECT id, location, value1, value2 
            FROM SensorData 
            WHERE location = ?
            ORDER BY id DESC LIMIT 1 OFFSET 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function insertAlertLog($conn, $alert_id, $sensor_value){
    $sql  = "INSERT INTO alert_logs (alert_id, valor_sensor) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id",$alert_id, $sensor_value); //i=integer d=double (float pel valor del sensor)
    $stmt->execute();
    $stmt->close();
}

//limit dinàmic segons la crida del botó "Veure més"
function getAlertsLogs ($conn, $user_id, $limit = 10){
    $sql = "SELECT alert_logs.id, alert_id, valor_sensor, data_activacio, alerts.localitzacio, alerts.sensor, alerts.condicio, alerts.valor
            FROM alert_logs
            JOIN alerts ON alert_id = alerts.id 
            WHERE alerts.user_id = ?
            ORDER BY data_activacio DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
?>


