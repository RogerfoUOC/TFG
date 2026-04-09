<?php
// Exemple de connexió (sense credencials reals)
$host = "localhost";
$user = "user";
$pass = "password";
$db = "database";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de connexió: " . $conn->connect_error);
    }
    //establim codificació de caràcters UTF-8
    $conn->set_charset("utf8");
?>