<?php
// TODO⌛: passar queries de variables a funcions + statements
/* ###################################### CONSULTES INDEX.PHP ###################################### */
/* -- Consulta últims registres:
        - trobem els IDs més recents de cada ubicació
        - seleccionem les dades d'aquests IDs
        - ordenem sempre amb Interior primer
*/
$ultimesDades = "SELECT location, 
                value1 as temperatura,
                value2 as humitat,
                reading_time 
                FROM SensorData 
                WHERE id IN (
                SELECT MAX(id) FROM SensorData 
                WHERE location IN ('Interior', 'Exterior') 
                GROUP BY location
            )
            ORDER BY location = 'Interior' DESC ";
/* Consulta per calcular els valors minims màxims i mitjanes */
$dadesDiaries = "SELECT location,
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

/* Últim registre INTERIOR */
$sqlUltimaLecturaInterior = "SELECT reading_time
    FROM SensorData
    WHERE location = 'Interior'
    ORDER BY id DESC
    LIMIT 1";

/* Últim registre EXTERIOR */
$sqlUltimaLecturaExterior = "SELECT reading_time
    FROM SensorData
    WHERE location = 'Exterior'
    ORDER BY id DESC
    LIMIT 1";

/* ###################################### CONSULTES HISTORIC.php ###################################### */
/* -- Determinar el dia a consultar -- */
$dadesHistoric1 = "SELECT location,
                        MIN(CAST(value1 AS DECIMAL(10, 2))) as temp_minima,
                        MAX(CAST(value1 AS DECIMAL(10, 2))) as temp_maxima,
                        AVG(CAST(value1 AS DECIMAL(10, 2))) as temp_mitjana,
                        MIN(CAST(value2 AS DECIMAL(10, 2))) as humitat_minima,
                        MAX(CAST(value2 AS DECIMAL(10, 2))) as humitat_maxima,
                        AVG(CAST(value2 AS DECIMAL(10, 2))) as humitat_mitjana
                    FROM SensorData
                    WHERE location IN ('Interior', 'Exterior')
                        AND DATE(reading_time) = '$diaSeleccionat1'
                    GROUP BY location
                    ORDER BY location = 'Interior' DESC";

$dadesHistoric2 = "SELECT location,
                        MIN(CAST(value1 AS DECIMAL(10, 2))) as temp_minima,
                        MAX(CAST(value1 AS DECIMAL(10, 2))) as temp_maxima,
                        AVG(CAST(value1 AS DECIMAL(10, 2))) as temp_mitjana,
                        MIN(CAST(value2 AS DECIMAL(10, 2))) as humitat_minima,
                        MAX(CAST(value2 AS DECIMAL(10, 2))) as humitat_maxima,
                        AVG(CAST(value2 AS DECIMAL(10, 2))) as humitat_mitjana
                    FROM SensorData
                    WHERE location IN ('Interior', 'Exterior')
                        AND DATE(reading_time) = '$diaSeleccionat2'
                    GROUP BY location
                    ORDER BY location = 'Interior' DESC";                    

/* ###################################### CONSULTA LOG ###################################### */

/* -- Permet consultar dades segons el filtre del formulari -- */
$filtreLog = "SELECT id, sensor, location, value1, value2, reading_time 
        FROM SensorData";       
    if ($filtreLocalitzacio == 'int') {
        $filtreLog .= " WHERE location = 'Interior'";
        $filtreLog .= " AND DATE(reading_time) = '$diaSeleccionatLog'";
    } elseif ($filtreLocalitzacio == 'ext') {
        $filtreLog .= " WHERE location = 'Exterior'"; 
        $filtreLog .= " AND DATE(reading_time) = '$diaSeleccionatLog'";
    } else {
        $filtreLog .= " WHERE DATE(reading_time) = '$diaSeleccionatLog'";
    }
$filtreLog .= " ORDER BY id DESC";

/* ###################################### CONSULTES CHART ###################################### */

/* -- Determinar el dia a consultar -- */
$diaConsulta1 = isset($diaSeleccionat1) ? $diaSeleccionat1 : date('Y-m-d');

/* -- Consultes per INTERIOR -- */
$dadesInterior = "SELECT 
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
          AND DATE(reading_time) = '$diaConsulta1'
        GROUP BY hora
    ) x ON DATE_FORMAT(s.reading_time, '%H') = x.hora
      AND s.reading_time = x.max_time
    ORDER BY hora";

/* -- Consultes per EXTERIOR -- */
$dadesExterior = "SELECT 
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
          AND DATE(reading_time) = '$diaConsulta1'
        GROUP BY hora
    ) x ON DATE_FORMAT(s.reading_time, '%H') = x.hora
      AND s.reading_time = x.max_time
    ORDER BY hora";

/* ###################################### CONSULTES USUARI ###################################### */
function dataRegistreUsuari($conn, $userId) {
    if (!$userId) return null;

    $query = "SELECT created_at FROM users WHERE id = $userId";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['created_at'];
    }

    return null;
}


?>