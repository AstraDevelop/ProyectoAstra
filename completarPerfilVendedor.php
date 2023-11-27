<?php
include("conexion.php");
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Verificar si el usuario es un vendedor
if ($_SESSION['rol'] != 2) {
    header("location: index.php"); // Redirigir a la página principal o a la adecuada para compradores
    exit;
}

$usuario = $_SESSION['username'];
$mensajeAlerta = "";
$claseAlerta = "";

// Verificar si el usuario ya tiene un perfil registrado
$sqlVerificar = "SELECT * FROM perfil_vendedor WHERE Usuario = '$usuario'";
$resultadoVerificar = $conn->query($sqlVerificar);

if ($resultadoVerificar->num_rows > 0) {
    // El usuario ya tiene un perfil registrado, redirigir a la página del vendedor
    header("location: vendedor.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $descripcion = $_POST['descripcion'];

    // Procesar y guardar la foto de perfil si se ha cargado
    $fotoPerfil = null;
    if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
        $fotoPerfil = subirFotoPerfil($_FILES['fotoPerfil'], $usuario);
    }

    // Guardar los datos en la tabla perfil_vendedor
    $sql = "INSERT INTO perfil_vendedor (Usuario, FotoPerfil, Descripcion) VALUES ('$usuario', '$fotoPerfil', '$descripcion')";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página del vendedor después de completar el perfil
        header("location: vendedor.php");
        exit;
    } else {
        $mensajeAlerta = "Error al guardar el perfil del vendedor: " . $conn->error;
        $claseAlerta = "alerta-rojo";
    }
}

// Función para subir la foto de perfil
function subirFotoPerfil($foto, $usuario) {
    $carpetaDestino = "fotosVendedor/";
    $nombreArchivo = $usuario . "_" . basename($foto["name"]);
    $rutaCompleta = $carpetaDestino . $nombreArchivo;

    if (move_uploaded_file($foto["tmp_name"], $rutaCompleta)) {
        return $rutaCompleta;
    } else {
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/compPerfil.css">
    <title>Completar Perfil Vendedor ASTRA</title>
</head>
<body>
    <header>
        <a href="">
            <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
            <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
        </nav>
    </header>

        <div class="cuadroCompletarPerfil">
            <a href="index.php">
                <span class="icon-close">
                    <ion-icon name="close-outline"></ion-icon>
                </span>
            </a>
            <div class="form-box completar-perfil">
                <h2>Completar Perfil</h2>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="input-box">
                        <label for="">Foto de Perfil</label>
                        <input type="file" name="fotoPerfil" accept="image/*">
                    </div>
                    <div class="input-box">
                        <label for="">Descripción</label>
                        <textarea name="descripcion" required></textarea>
                    </div>
                    <button type="submit" class="btn">Completar Perfil</button>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
