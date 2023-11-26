<?php
include("conexion.php");
session_start();

// Verificar si el usuario ha iniciado sesión como vendedor
if (isset($_SESSION['username']) && $_SESSION['rol'] == 2) {
    $user = $_SESSION['username'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descripcion = $_POST['descripcion'];

        // Procesar la carga de la imagen de perfil
        $fotoPerfil = null;

        if ($_FILES['fotoPerfil']['error'] == 0) {
            $uploadsDir = 'fotosVendedor/';
            $tmpName = $_FILES['fotoPerfil']['tmp_name'];
            $fotoPerfil = $uploadsDir . basename($_FILES['fotoPerfil']['name']);

            move_uploaded_file($tmpName, $fotoPerfil);
        }

        // Insertar o actualizar el perfil del vendedor
        $sqlInsertOrUpdatePerfil = "INSERT INTO perfil_vendedor (Usuario, FotoPerfil, Descripcion) VALUES ('$user', '$fotoPerfil', '$descripcion') ON DUPLICATE KEY UPDATE FotoPerfil = '$fotoPerfil', Descripcion = '$descripcion'";
        $conn->query($sqlInsertOrUpdatePerfil);

        // Después de completar el perfil, redirige al vendedor a la página de vendedor normal
        header("location: vendedor.php");
        exit;
    }
} else {
    // Si el usuario no ha iniciado sesión o no es un vendedor, redirige a la página de inicio de sesión
    header("location: login.php");
    exit;
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
    <div class="container">
        <header>
            <a href="index.php">
                <h2 class="logo">ASTRA</h2>
            </a>
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
                        <input type="file" name="fotoPerfil" accept="image/*">
                        <label for="">Foto de Perfil</label>
                    </div>
                    <div class="input-box">
                        <textarea name="descripcion" required></textarea>
                        <label for="">Descripción</label>
                    </div>
                    <button type="submit" class="btn">Completar Perfil</button>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>
