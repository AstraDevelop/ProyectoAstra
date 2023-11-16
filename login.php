<?php
include("conexion.php");
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
    $rol = $_SESSION['rol'];
    if ($rol == 2) {
        header("location: vendedor.php");
        exit;
    } elseif ($rol == 3) {
        header("location: comprador.php");
        exit;
    }
}

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
// Las lineas de arriba fueron añadidas para el testeo de CSS durante el desarrollo
// No necesariamente deben estar ahí en el proyecto final, chequear en caso de problemas con cache

$mensajeAlerta = ""; // Inicializa el mensaje de alerta
$claseAlerta = "";

// Inicializa las variables de los campos con valores predeterminados
$user = "";
$contraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $user = $_POST['user'];
    $contraseñaIngresada = $_POST['contraseña'];


    // Consulta SQL para verificar si el usuario existe
    $sqlUsuario = "SELECT Usuario, Contraseña, Rol FROM usuarios WHERE CorreoElectronico = '$user' OR Usuario = '$user'";
    $resultUsuario = $conn->query($sqlUsuario);
    $row = $resultUsuario->fetch_assoc();
    

    if ($resultUsuario->num_rows == 1) {
<<<<<<< HEAD
<<<<<<< HEAD
=======
        $rol = $row['Rol'];
>>>>>>> 02e46ab (mejoramos todo)
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
<<<<<<< HEAD
                echo "<script>alert('Inicio de sesión exitoso. Bienvenido, $user!');</script>";
                echo '<script>window.location.href = "./index.html";</script>'; 
=======
                $_SESSION['username'] = $user;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                header("location: perfil.php");
>>>>>>> af733a6 (implementacion de inicio de sesion)
=======
=======
                $_SESSION['rol'] = $rol;
>>>>>>> 02e46ab (mejoramos todo)
                if($rol == 2){
                    header("location: vendedor.php");
                }
                if($rol == 3){
                    header("location: comprador.php");
                }
>>>>>>> 15e4fa0 (redireccion a vendedor/comprador)
=======
                // Dependiendo del rol, redirige al usuario a la página correspondiente
                if ($resultUsuario->fetch_assoc()['Rol'] == 3) {
                    header("location: comprador.php");
                } else {
                    header("location: vendedor.php");
                }
                exit;  // Es importante hacer un "exit" después de "header".
>>>>>>> f76eb9c (Cambie colores alertas, redirecciones, actuallizacion problema formulario)
            } else {
                $mensajeAlerta = "Contraseña incorrecta.";
                if ($mensajeAlerta === "Contraseña incorrecta.") {
                    $claseAlerta = "alerta-rojo";
                } elseif ($mensajeAlerta === "Usuario no encontrado.") {
                    $claseAlerta = "alerta-rojo";
                }
                // Restablece la contraseña después de un intento fallido de inicio de sesión
                $contraseña = "";
=======
        $userData = $resultUsuario->fetch_assoc();
        $hashContraseñaAlmacenada = $userData['Contraseña'];
    
        // Verificar la contraseña utilizando password_verify
        if (password_verify($contraseñaIngresada, $hashContraseñaAlmacenada)) {
            // Inicio de sesión exitoso
            session_start(); // Iniciar la sesión
            $_SESSION['user'] = $user; // Almacenar el nombre de usuario en la sesión
            $_SESSION['rol'] = $userData['Rol']; // Almacenar el rol en la sesión
    
            if ($userData['Rol'] == '2') {
                // Si el usuario es vendedor
                header('Location: vendedor.php'); // Redireccionar a la página de vendedor
                exit();
            } elseif ($userData['Rol'] == '3') {
                // Si el usuario es comprador
                header('Location: comprador.php'); // Redireccionar a la página de comprador
                exit();
>>>>>>> 60d5df1 (Nuevas implementaciones)
            }
        } else {
            $mensajeAlerta = "Contraseña incorrecta.";
            if ($mensajeAlerta === "Contraseña incorrecta.") {
                $claseAlerta = "alerta-rojo";
            } elseif ($mensajeAlerta === "Usuario no encontrado.") {
                $claseAlerta = "alerta-rojo";
            }
            // Restablece la contraseña después de un intento fallido de inicio de sesión
            $contraseña = "";
        }
    } else {
        $mensajeAlerta = "Usuario no encontrado.";
        if ($mensajeAlerta === "Contraseña incorrecta.") {
            $claseAlerta = "alerta-rojo";
        } elseif ($mensajeAlerta === "Usuario no encontrado.") {
            $claseAlerta = "alerta-rojo";
        }
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
            <a href="index.php">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>

        <div class="cuadroLogin">
                <a href="index.php">
                    <span class="icon-close">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                </a>
            <!-- Caja del login -->
            <div class="form-box login">
                <h2>Iniciar Sesion</h2>
                <!-- Mostrar alerta si hay un mensaje -->
                <?php if (!empty($mensajeAlerta)) : ?>
                       <div id="alerta" class="<?php echo $claseAlerta; ?>"><?php echo $mensajeAlerta; ?></div>
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
