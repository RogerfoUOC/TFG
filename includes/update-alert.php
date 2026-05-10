<?php
session_start();
include 'connexio.php';

if (!isset($_SESSION['usuari_id'])) {
    header("Location: ../panell.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../alertes.php");
    exit;
}

$usuariId = $_SESSION['usuari_id'];
$alertaId = $_POST['alerta_id'] ?? null;
$activa   = $_POST['activa'] ?? null;

/*
if ($activa  === '1') {
    echo 'Activar alerta ' . $alertaId;
} else {
    echo 'Desactivar alerta ' . $alertaId;
}
die();
*/


//validem que es torna una petició POST amb 0 o 1, per evitar enviar informació no vàlida a la base de dades
if (!$alertaId || !in_array($activa, ['0', '1'])) {
    $_SESSION['error_alerta'] = "Error en modificar l'alerta.";
    header("Location: ../alertes.php");
    exit;
}

$sql  = "UPDATE alerts SET activa = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param ("iii", $activa, $alertaId, $usuariId);
$stmt->execute();

//tornem a alertes.php amb la info del resultat de l'acció
if ($stmt->affected_rows === 1) {
    $_SESSION['ok_alerta'] = $activa === '1' ? "Alerta #{$alertaId} activada." : "Alerta #{$alertaId} desactivada.";
} else {
    $_SESSION['error_alerta'] = "No s'ha pogut modificar l'alerta.";
}

$stmt->close();
header("Location: ../alertes.php");
exit;

?>