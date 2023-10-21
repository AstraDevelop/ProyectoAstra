<?php
include("conexion.php");

$mensajeAlerta = ""; // Inicializa el mensaje de alerta

// Inicializa las variables de los campos con valores predeterminados
$nombre = "";
$usuario = "";
$correo = "";
$contraseña = "";
$confirmarContraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmarContraseña = $_POST['confirmarContraseña'];

    // Verifica que los campos no estén vacíos
    $req = (strlen($nombre) * strlen($usuario) * strlen($correo) * strlen($contraseña) * strlen($confirmarContraseña)) or $mensajeAlerta = "No se han llenado todos los campos";

    // Verifica que las contraseñas coincidan
    if ($contraseña != $confirmarContraseña) {
        $mensajeAlerta = "Las contraseñas no coinciden, Verifique";
    } else {
        // Encripta la contraseña
        $contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);

        // Consulta para verificar si el usuario o el correo ya existen
        $sqlVerificacion = "SELECT * FROM usuarios WHERE Usuario = '$usuario' OR CorreoElectronico = '$correo'";
        $resultadoVerificacion = $conn->query($sqlVerificacion);

        // Verifica si el usuario ya está registrado
        $sqlVerificacionUsuario = "SELECT * FROM usuarios WHERE Usuario = '$usuario'";
        $resultadoVerificacionUsuario = $conn->query($sqlVerificacionUsuario);

        if ($resultadoVerificacionUsuario->num_rows > 0) {
            $mensajeAlerta = "El usuario ya está registrado.";
        } else {
            // Verifica si el correo ya está registrado
            $sqlVerificacionCorreo = "SELECT * FROM usuarios WHERE CorreoElectronico = '$correo'";
            $resultadoVerificacionCorreo = $conn->query($sqlVerificacionCorreo);

            if ($resultadoVerificacionCorreo->num_rows > 0) {
                $mensajeAlerta = "El correo ya está registrado.";
            } else {
                // INSERT con la contraseña encriptada
                $sqlInsercion = "INSERT INTO usuarios (Nombre, Usuario, CorreoElectronico, Contraseña, Rol) VALUES ('$nombre', '$usuario', '$correo', '$contraseñaEncriptada', '3')";

                if ($conn->query($sqlInsercion) === TRUE) {
                    $mensajeAlerta = "Datos guardados con éxito.";
                } else {
                    $mensajeAlerta = "Error al guardar los datos: " . $conn->error;
                }
            }
        }
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
    <title>REGISTRO ASTRA</title>
</head>
<body>
    <div class="container">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>

        <div class="cuadroRegistro">
            <!-- Caja del registro -->
            <div class="form-box register">
                <h2>Registro</h2>
                <!-- Mostrar alerta si hay un mensaje -->
                <?php if (!empty($mensajeAlerta)) : ?>
                    <div id="alerta"><?php echo $mensajeAlerta; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type="text" name="nombre" required value="<?php echo $nombre; ?>">
                        <label for="">Nombre</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type="text" name="usuario" required value="<?php echo $usuario; ?>">
                        <label for="">Usuario</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type="email" name="correo" required value="<?php echo $correo; ?>">
                        <label for="">Correo</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" required value="<?php echo $contraseña; ?>">
                        <label for="">Contraseña</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="confirmarContraseña" required value="<?php echo $confirmarContraseña; ?>">
                        <label for="">Confirmar Contraseña</label>
                    </div> 
                    
                    <button type="submit" class="btn">Registrar</button>
                    <div class="login-register">
                        <p>¿Ya Tienes Una Cuenta? <a href="login.php" class="login-link">Inicia Sesion Aqui</a></p>
                    </div>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>