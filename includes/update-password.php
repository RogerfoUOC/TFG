<?php
session_start();
include 'connexio.php';
include 'functions.php';

if (!isset($_POST['pass-actual']) || !isset($_POST['pass-nou']) || !isset($_SESSION['usuari_id'])) {
    header("Location: ../panell.php");
    exit;
}

$passActual     = $_POST['pass-actual'];
$passNou        = $_POST['pass-nou'];
$passConfirm    = $_POST['pass-confirm'];
$userId         = $_SESSION['usuari_id'];
$passwordFormat = "/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':\"\\\\|,.<>\/?])[^\s]{8,}$/";

function errorCanviPassGeneric() {
    $_SESSION['toast_error']     = "Error en el canvi de contrasenya, torna-ho a intentar.";
    header("Location: ../panell.php");
    exit;
}

if (($passActual == '')||($passNou == '')||($passConfirm == ''))   errorCanviPassGeneric();
if ($passNou !== $passConfirm)                                     errorCanviPassGeneric();
if (!preg_match($passwordFormat, $passNou))                        errorCanviPassGeneric();
if ($passActual === $passNou)                                      errorCanviPassGeneric();

// buscar l'usuari a la base de dades
$stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    errorCanviPassGeneric();
}

// verificar que el pass actual és correcte
if (!password_verify($passActual, $row['password_hash'])) {
    $_SESSION['toast_error'] = "La contrasenya actual no és correcta.";
    header("Location: ../panell.php");
    exit;
}

// actualitzar la contrasenya
$passwordHash = password_hash($passNou, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
$stmt->bind_param("si", $passwordHash, $userId);
$stmt->execute();

$_SESSION['ok_password'] = "Contrasenya actualitzada correctament!";
header("Location: ../panell.php");
exit;

?>