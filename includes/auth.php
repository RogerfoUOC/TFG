<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'connexio.php';

if (!isset($_POST['accio'])) {
    header("Location: ../panell.php");
    exit;
    }
    
$passwordFormat = "/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};':\"\\\\|,.<>\/?])[^\s]{8,}$/";


function errorRegistreGeneric() {
    $_SESSION['error_registre']     = "Error en el registre, torna-ho a intentar.";
    $_SESSION['tab_actiu'] = 'registre';
    header("Location: ../panell.php");
    exit;
}

    function errorLoginGeneric() {
    $_SESSION['error_login']     = "Error d'accés, torna-ho a intentar.";
    $_SESSION['tab_actiu'] = 'login';
    header("Location: ../panell.php");
    exit;
}
    
if ($_POST['accio'] === 'registre') {
    //variables registre
    $usuari = trim($_POST['username']);
    $email  = mb_strtolower(trim($_POST['email']), 'UTF-8'); //passem mail a minuscules per més seguretat
    $pass1  = $_POST['password1'];
    $pass2  = $_POST['password2'];

    if (empty($usuari) || empty($email) || empty($pass1) || empty($pass2))  errorRegistreGeneric();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))                         errorRegistreGeneric();
    if (!preg_match('/^[A-Za-z]{3,15}$/', $usuari))                         errorRegistreGeneric();
    if ($pass1 !== $pass2)                                                  errorRegistreGeneric();
    if (!preg_match($passwordFormat, $pass1))                               errorRegistreGeneric();

    $password_hash = password_hash($pass1, PASSWORD_DEFAULT);

    $sql    = "SELECT id FROM users WHERE email = ?";
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_registre']     = "Aquest correu electrònic ja existeix.";
        $_SESSION['tab_actiu'] = 'registre';
        $_SESSION['form_data'] = ['email' => $email, 'username' => $usuari];
        header("Location: ../panell.php");
        exit;    
    } else {
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usuari, $email, $password_hash);
        $stmt->execute();
        $_SESSION['usuari_id'] = $conn->insert_id;
        $_SESSION['nom_usuari'] = $usuari;
        $_SESSION['email'] = $email;
        header("Location: ../panell.php");
        exit;
    }
    $stmt->close();
}

if ($_POST['accio'] === 'login') {
    //variables login
    $mailLogin = mb_strtolower(trim($_POST['mail-login']), 'UTF-8'); //passem a minuscules per buscar a la base de dades que ja l'hem guardat en minuscules
    $passLogin = $_POST['password-login'];

    if (empty($mailLogin) || empty($passLogin)) errorLoginGeneric();

    $sql = "SELECT id, username, email, password_hash FROM users WHERE email = ?";
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("s", $mailLogin);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) { //si no existeix el mail a la base de dades
        $_SESSION['error_login'] = "Credencials incorrectes.";
        $_SESSION['tab_actiu']   = 'login';
        header("Location: ../panell.php");
        exit;
        //errorLoginGeneric();
    } else {  
        $row = $result->fetch_assoc();
        if (password_verify($passLogin, $row['password_hash'])) { //aqui entrem si el login és correcte
            $_SESSION['usuari_id']  = $row['id'];
            $_SESSION['nom_usuari'] = $row['username'];
            $_SESSION['email']      = $row['email'];
            $stmt = $conn->prepare ("UPDATE users SET last_login = NOW() WHERE id = ?"); //actualitzem la data d'accés per mostrar última connexió.
            $stmt->bind_param("i", $_SESSION['usuari_id']);
            $stmt->execute();
            header("Location: ../panell.php");
            exit;
        } else { //si el mail existeix pero no coincideix la contrasenya
            $_SESSION['error_login'] = "Credencials incorrectes.";
            $_SESSION['tab_actiu']   = 'login';
            header("Location: ../panell.php");
            exit;
        }
    }
    $stmt->close();
}
?>