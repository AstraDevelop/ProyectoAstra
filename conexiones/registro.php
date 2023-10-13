<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proveedores";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmarContraseña = $_POST['confirmarContraseña'];

    // Verifica que los campos no estén vacíos
    $req = (strlen($nombre) * strlen($usuario) * strlen($correo) * strlen($contraseña) * strlen($confirmarContraseña)) or die("No se han llenado todos los campos");

    // Verifica que las contraseñas coincidan
    if ($contraseña != $confirmarContraseña) {
        die('Las contraseñas no coinciden, Verifique <br /> <a href="index.html">Volver</a>');
    }

    // Encripta la contraseña
    $contraseñaEncriptada = md5($contraseña);

    // Consulta para verificar si el usuario o el correo ya existen
    $sqlVerificacion = "SELECT * FROM usuarios WHERE Usuario = '$usuario' OR CorreoElectronico = '$correo'";
    $resultadoVerificacion = $conn->query($sqlVerificacion);

    if ($resultadoVerificacion->num_rows > 0) {
        // El usuario o el correo ya están registrados, muestra un mensaje de error y redirige al formulario de registro
        echo '<script>alert("El usuario o el correo ya están registrados.");</script>';
        echo '<script>window.location.href = "../index.html";</script>';
    } else {
        // Los datos son únicos, puedes proceder a insertar el nuevo registro
        $sqlInsercion = "INSERT INTO usuarios (Nombre, Usuario, CorreoElectronico, Contraseña) VALUES ('$nombre', '$usuario', '$correo', '$contraseñaEncriptada')";

        if ($conn->query($sqlInsercion) === TRUE) {
            // Éxito: mostrar un mensaje de alerta y redirigir a index.html
            echo '<script>alert("Datos guardados con éxito.");</script>';
            echo '<script>window.location.href = "../index.html";</script>';
        } else {
            // Error: mostrar un mensaje de alerta y redirigir a index.html
            echo '<script>alert("Error al guardar los datos: ' . $conn->error . '");</script>';
            echo '<script>window.location.href = "../index.html";</script>';
        }
    }
}

// Cierra la conexión
$conn->close();
?>
