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


/*
echo 'Eliminar alerta ' . $alertaId;
die();
*/

if (!$alertaId) {
    $_SESSION['error_alerta'] = "Error en eliminar l'alerta.";
    header("Location: ../alertes.php");
    exit;
}

$sql  = "DELETE FROM alerts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $alertaId, $usuariId);
$stmt->execute();

//tornem a alertes.php amb la info del resultat de l'acció
if ($stmt->affected_rows === 1) {
    $_SESSION['ok_alerta'] = "Alerta #{$alertaId} eliminada";
} else {
    $_SESSION['error_alerta'] = "No s'ha pogut eliminar l'alerta.";
}

$stmt->close();
header("Location: ../alertes.php");
exit;

?>