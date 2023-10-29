<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];

// Si el usuario ha iniciado sesión, se ejecuta esto
if (isset($usuarioI)) {
 // Realizar la consulta SQL para obtener los datos del usuario
 $query = "SELECT Nombre, Usuario, CorreoElectronico, Contraseña, Rol FROM usuarios WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";

 $result = $conn->query($query);

 if ($result) {
     $row = $result->fetch_assoc();
     // Asignar los valores de la base de datos a las variables
     $nombre = $row['Nombre'];
     $usuario = $row['Usuario'];
     $correo = $row['CorreoElectronico'];
     $rol = $row['Rol'];
    $Rol = "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Perfil</title>
</head>
<body>
<div class="container">
    <header>
        <a href="">
            <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
            <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
        </nav>
    </header>
    <div class="cuadroDeDatos">
        <a href="redireccionar.php?rol=<?php echo $rol; ?>">
            <span class="icon-close">
                <ion-icon name="close-outline"></ion-icon>
            </span>
        </a>
        <div class="form-box">
            <h1>Perfil</h1>
            <h4 class="datos">Nombre</h4>
            <h4 class="inf"><?php echo $nombre ?></h4>
            <h4 class="datos">Usuario</h4>
            <h4 class="inf"><?php echo $usuario ?></h4>
            <h4 class="datos">Correo Electronico</h4>
            <h4 class="inf"><?php echo $correo ?></h4>
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

            <a href="actualizarDatos.php"><button type="submit" class="btn">Actualizar Datos</button></a>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</div>
</body>
</html>
<?php
    }else {
    echo "Error al recuperar datos del usuario:";
    }
} else {
    header('location: index.html');
}
?>