<?php
// Establecer la conexión a la base de datos (asegúrate de configurar tus credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datosastra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}
?>