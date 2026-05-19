<?php
session_start();
include 'connexio.php';

if (!isset($_SESSION['usuari_id']) || !isset($_POST['log_id'])) {
    header("Location: ../index.php");
    exit;
}

$log_id = intval($_POST['log_id']);

$sql = "UPDATE alert_logs SET tancada = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $log_id);
$stmt->execute();
$stmt->close();
$conn->close();

$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../index.php';
header("Location: " . $redirect);
exit;
?>