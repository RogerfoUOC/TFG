<?php
session_start();
include 'connexio.php';
 
// redirigim si no hi ha sessió o no arriben les dades necessàries
if (!isset($_SESSION['usuari_id'])) {
    header("Location: ../panell.php");
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../alertes.php");
    exit;
}

$user       = $_SESSION['usuari_id'];
$tipus_dada = $_POST['tipus_dada'] ?? null;
$ubicacio   = $_POST['ubicacio'] ?? null;
$avis_web   = isset($_POST['avis_web']) ? 1 : 0;  //operador ternari per convertir a 1 o 0 segons si està marcat o no
$avis_mail  = isset($_POST['avis_mail']) ? 1 : 0;


echo '<pre>';
print_r($_POST);
echo '</pre>';
die();

function errorAlertaGenerica() {
    $_SESSION['toast_error'] = "Error en crear l'alerta, torna-ho a intentar.";
    header("Location: ../alertes.php");
    exit;
}
?>