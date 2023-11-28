<?php
include("conexion.php");
session_start();

// Verificar si el usuario ha iniciado sesión como vendedor
if (isset($_SESSION['username']) && $_SESSION['rol'] == 2) {
    $user = $_SESSION['username'];

    // Obtener información del perfil del vendedor
    $sqlPerfilVendedor = "SELECT * FROM perfil_vendedor WHERE Usuario = '$user'";
    $resultPerfilVendedor = $conn->query($sqlPerfilVendedor);

    if ($resultPerfilVendedor->num_rows == 1) {
        $rowPerfilVendedor = $resultPerfilVendedor->fetch_assoc();

        // Obtener información del usuario
        $sqlUsuario = "SELECT * FROM usuarios WHERE Usuario = '$user'";
        $resultUsuario = $conn->query($sqlUsuario);
        $rowUsuario = $resultUsuario->fetch_assoc();

        // Mostrar la información del perfil
        $nombre = $rowUsuario['Nombre'];
        $correoElectronico = $rowUsuario['CorreoElectronico'];
        $rol = $rowUsuario['Rol'];
        $fotoPerfil = $rowPerfilVendedor['FotoPerfil'];
        $descripcion = $rowPerfilVendedor['Descripcion'];
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/perfilVendedor.css">
            <title>Perfil del Vendedor ASTRA</title>
        </head>
        <body>
            <header>
                <a href="index.php">
                    <h2 class="logo">ASTRA</h2>
                </a>
                <nav class="navigation">
                    <a href="cerrarSesion.php"><button class="cerrarSesion">CERRAR SESION</button></a>
                </nav>
            </header>
            <div class="container">
                <div class="perfil-vendedor">
                    <a href="redireccionar.php?rol=<?php echo $rol; ?>">
                        <span class="icon-close">
                            <ion-icon name="close-outline"></ion-icon>
                        </span>
                    </a>
                    <h1>Perfil</h1>
                    <h2><?php echo $nombre; ?></h2>
                    <?php if ($fotoPerfil) : ?>
                        <img src="<?php echo $fotoPerfil; ?>" alt="Foto de Perfil" class="foto-perfil">
                    <?php endif; ?>
                    <div class="form-box">
                        <h4 class="datos">Usuario</h4>
                        <h4 class="inf"><?php echo $user; ?></h4>
                        <h4 class="datos">Correo Electronico</h4>
                        <h4 class="inf"><?php echo $correoElectronico; ?></h4>
                        <h4 class="datos">Rol</h4>
                        <h4 class="inf">
                            <?php
                            if ($rol == 1) {
                                echo "Admin";
                            } elseif ($rol == 2) {
                                echo "Vendedor";
                            } elseif ($rol == 3) {
                                echo "Comprador";
                            } else {
                                echo "Rol Desconocido";
                            }
                            ?>
                        </h4>
                        <h4 class="datos">Descripción de la Empresa:</h4>
                        <h4 class="inf"><?php echo $descripcion; ?></h4>

                        <a href="editarPerfilVend.php"><button type="submit" class="btn">Actualizar Datos</button></a>
                    </div>
                </div>
        </div>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        </body>
        </html>
        <?php
    } else {
        // Si no se encuentra el perfil del vendedor, redirige a completar el perfil
        header("location: completarPerfilVendedor.php");
        exit;
    }
} else {
    // Si el usuario no ha iniciado sesión o no es un vendedor, redirige a la página de inicio de sesión
    header("location: login.php");
    exit;
}
?>
