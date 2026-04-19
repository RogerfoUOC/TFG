<?php
session_start();
include 'connexio.php';
include 'functions.php';

if (!isset($_POST['email']) || !isset($_SESSION['usuari_id']) || !isset($_SESSION['email'])) {
    header("Location: ../panell.php");
    exit;
}

$email = mb_strtolower(trim($_POST['email']), 'UTF-8');
$currentEmail = mb_strtolower(trim($_SESSION['email']), 'UTF-8');
$userId = $_SESSION['usuari_id'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast_error'] = "El format del correu no és correcte.";
    $_SESSION['old_email'] = $email;

    header("Location: ../panell.php");
    exit;
}

if ($email === $currentEmail) {
    $_SESSION['toast_error'] = "El correu introduït és igual que l'actual.";
    $_SESSION['old_email'] = $email;

    header("Location: ../panell.php");
    exit;
}

if (emailExisteix($conn, $email, $userId)) {
    $_SESSION['toast_error'] = "Aquest correu ja està en ús.";
    $_SESSION['old_email'] = $email;

    header("Location: ../panell.php");
    exit;
}

$stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
$stmt->bind_param("si", $email, $userId);
$stmt->execute();

$_SESSION['email'] = $email;
$_SESSION['ok_email'] = "Correu actualitzat correctament!";

header("Location: ../panell.php");
exit;