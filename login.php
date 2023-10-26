<?php
include("conexion.php");
session_start();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
// Las lineas de arriba fueron añadidas para el testeo de CSS durante el desarrollo
// No necesariamente deben estar ahí en el proyecto final, chequear en caso de problemas con cache

$mensajeAlerta = ""; // Inicializa el mensaje de alerta

// Inicializa las variables de los campos con valores predeterminados
$user = "";
$contraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $user = $_POST['user'];

    // Consulta SQL para verificar si el usuario existe
    $sqlUsuario = "SELECT * FROM usuarios WHERE CorreoElectronico = '$user' OR Usuario = '$user'";
    $resultUsuario = $conn->query($sqlUsuario);

    if ($resultUsuario->num_rows == 1) {
        // El usuario existe, ahora verifica la contraseña
        $contraseñaIngresada = $_POST['contraseña'];

        // Consulta SQL para obtener la contraseña almacenada en la base de datos
        $sqlContraseña = "SELECT Contraseña FROM usuarios WHERE (CorreoElectronico = '$user' OR Usuario = '$user')";
        $resultContraseña = $conn->query($sqlContraseña);

        if ($resultContraseña->num_rows == 1) {
            $row = $resultContraseña->fetch_assoc();
            $hashContraseñaAlmacenada = $row['Contraseña'];

            // Verificar la contraseña utilizando password_verify
            if (password_verify($contraseñaIngresada, $hashContraseñaAlmacenada)) {
                // Inicio de sesión exitoso
                echo "<script>alert('Inicio de sesión exitoso. Bienvenido, $user!');</script>";
                echo '<script>window.location.href = "./index.html";</script>'; 
            } else {
                $mensajeAlerta = "Contraseña incorrecta.";
                // Restablece la contraseña después de un intento fallido de inicio de sesión
                $contraseña = "";
            }
        }
    } else {
        $mensajeAlerta = "Usuario no encontrado.";
        // Restablece el usuario y la contraseña después de un intento fallido de inicio de sesión
        $user = "";
        $contraseña = "";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    
    <title>Iniciar Sesión ASTRA</title>
</head>
<body>
    <div class="container">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>

        <div class="cuadroLogin">
                <a href="index.html">
                    <span class="icon-close">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                </a>
            <!-- Caja del login -->
            <div class="form-box login">
                <h2>Iniciar Sesion</h2>
                <!-- Mostrar alerta si hay un mensaje -->
                <?php if (!empty($mensajeAlerta)) : ?>
                    <div id="alerta"><?php echo $mensajeAlerta; ?></div>
                <?php endif; ?>
                <form action="#" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type="text" name="user" required value="<?php echo $user; ?>">
                        <label for="">Usuario o Correo</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" required value="<?php echo $contraseña; ?>">
                        <label for="">Contraseña</label>
                    </div>
                    <div class="remember-forgot">
                        <a href="recuperarContraseña.php">¿Has Olvidado Tu Contraseña?</a>
                    </div>
                    <button type="submit" class="btn">Iniciar</button>
                    <div class="login-register">
                        <p>¿No Tienes Una Cuenta? <a href="registro.php" class="register-link">Registrate Aquí</a></p>
                    </div>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>
