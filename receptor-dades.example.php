<?php

//Codi modificat del projecte de Rui Santos a: https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/

$servername = "localhost";
$dbname = "database";
$username = "user";
$password = "password";

// API per recollir dades al fitxer php web
$api_key_value = "api-key";

$api_key= $sensor = $location = $value1 = $value2 = $value3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $location = test_input($_POST["location"]);
        $value1 = test_input($_POST["value1"]);
        $value2 = test_input($_POST["value2"]);
        $value3 = test_input($_POST["value3"]);
        
        // crea la connexió
        $conn = new mysqli($servername, $username, $password, $dbname);
        // comprova la connexió
        if ($conn->connect_error) {
			die("Error de connexió");
		}

		$sql = "INSERT INTO SensorData (sensor, location, value1, value2, value3) VALUES (?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssss", $sensor, $location, $value1, $value2, $value3);

		if ($stmt->execute()) {
			echo "Dades guardades correctament";
		} else {
			echo "Error: " . $conn->error;
		}
		$stmt->close();
		$conn->close();
    }
    else {
        echo "API incorrecte";
    }

}
else {
    echo "Sense dades a HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}