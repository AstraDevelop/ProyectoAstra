<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "proveedores";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$user = $_POST['user'];
$contraseña = md5($_POST['contraseña']); // Encripta la contraseña ingresada con MD5 para compararla con la almacenada en la base de datos

// Consulta SQL para verificar el inicio de sesión
$sql = "SELECT * FROM usuarios WHERE (CorreoElectronico = '$user' OR Usuario = '$user') AND Contraseña = '$contraseña'";


$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Inicio de sesión exitoso
    echo "<script>alert('Inicio de sesión exitoso. Bienvenido, $user!');</script>";
    echo '<script>window.location.href = "../index.html";</script>';
} else {
    // Inicio de sesión fallido
    echo "<script>alert('Nombre de usuario o contraseña incorrectos.');</script>";
    echo '<script>window.location.href = "../index.html";</script>';
}

// Cierra la conexión
$conn->close();
?>
