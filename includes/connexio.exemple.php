<?php
    $servername = "servedrname";
    $dbname     = "dbname";
    $username   = "username";
    $password   = "password";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Error de connexió amb la base de dades");
	}

	// charset modern
	$conn->set_charset("utf8mb4");
?>