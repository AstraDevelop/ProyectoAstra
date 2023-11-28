<?php
include("conexion.php");

$mensajeAlerta = ""; // Inicializa el mensaje de alerta

// Inicializa las variables de los campos con valores predeterminados
$usuario = "";
$correo = "";
$contraseña = "";
$confirmarContraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmarContraseña = $_POST['confirmarContraseña'];

       
            // Verifica que los campos no estén vacíos
            $req = (strlen($usuario) * strlen($correo) * strlen($contraseña) * strlen($confirmarContraseña)) or $mensajeAlerta = "No se han llenado todos los campos";

            // Verifica que las contraseñas coincidan
            if ($contraseña != $confirmarContraseña) {
                $mensajeAlerta = "Las contraseñas no coinciden, Verifique";
            } else {
                if (strlen($contraseña) < 8) {
                    $mensajeAlerta = "La contraseña debe tener al menos 8 caracteres.";
                } elseif (!preg_match('/[A-Z]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos una letra mayúscula.";
                } elseif (!preg_match('/[a-z]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos una letra minúscula.";
                } elseif (!preg_match('/[0-9]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos un número.";
                } elseif (!preg_match('/[!@#$%^&*]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos un carácter especial. (! @ # $ % ^ & *)";
                } else {
                    // Encripta la contraseña usando password_hash
                    $contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);
                    // Realizar la verificación en la base de datos (ejemplo de consulta SQL)
                    $sql = "SELECT * FROM usuarios WHERE Usuario = '$usuario' AND CorreoElectronico = '$correo'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Usuario y correo verificados, puedes permitir el cambio de contraseña
                        // Actualizar la contraseña en la base de datos
                        $sqlUpdate = "UPDATE usuarios SET Contraseña = '$contraseñaEncriptada' WHERE Usuario = '$usuario'";
                        if ($conn->query($sqlUpdate) === TRUE) {
                            // Contraseña actualizada con éxito
                            $mensajeAlerta = "Contraseña actualizada con éxito.";
                        } else {
                            // Error al actualizar la contraseña
                            $mensajeAlerta = "Error al actualizar la contraseña: " . $conn->error;
                        }
                    } else {
                        // No se encontró el usuario o el correo no coincide
                        // Mostrar un mensaje de error
                        $mensajeAlerta = "Error: Usuario o correo incorrectos.";
                    }
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <div class="container">
        <header>
            <a href="index.php">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>

        <div class="recuperar-contraseña">
            <!-- Caja del registro -->
            <div class="form-box register">
                <a href="login.php">
                    <span class="icon-close">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                </a>
                <h2>Recuperar Contraseña</h2>
                <!-- Mostrar alerta si hay un mensaje -->
                <?php if (!empty($mensajeAlerta)) : ?>
                    <div id="alerta"><?php echo $mensajeAlerta; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
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
                    <div class="input-box contraseña-nueva">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" required value="<?php echo $contraseña; ?>">
                        <label for="">Contraseña Nueva</label>
                    </div> 
                    <div class="input-box contraseña-nueva">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="confirmarContraseña" required value="<?php echo $confirmarContraseña; ?>">
                        <label for="">Confirmar Contraseña Nueva</label>
                    </div> 
                    <button type="submit" class="btn">Cambiar Contraseña</button>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>
