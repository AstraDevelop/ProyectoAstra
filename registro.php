<?php
include("conexion.php");
session_start(); 

$mensajeAlerta = $_SESSION['mensajeAlerta'] ?? "";  // <-- Aquí va
$claseAlerta = $_SESSION['claseAlerta'] ?? "";      // <-- Aquí va

// Luego, justo después de esas líneas, limpia los mensajes de la sesión:
unset($_SESSION['mensajeAlerta'], $_SESSION['claseAlerta']);  

// Inicializa las variables de los campos con valores predeterminados
$nombre = "";
$usuario = "";
$correo = "";
$contraseña = "";
$confirmarContraseña = "";
$rol = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmarContraseña = $_POST['confirmarContraseña'];

    // Verifica si la clave "rol" está definida en el array $_POST
    if (isset($_POST['rol'])) {
        $rol = $_POST['rol'];

        // Verifica si el rol se ha seleccionado
        if (empty($rol) || !in_array($rol, ['2', '3'])) {
            $mensajeAlerta = "Por favor, seleccione un rol válido (Vendedor o Comprador).";
            $claseAlerta = "alerta-rojo";
        } else {
            // Verifica que los campos no estén vacíos
            $req = (strlen($nombre) * strlen($usuario) * strlen($correo) * strlen($contraseña) * strlen($confirmarContraseña)) or $mensajeAlerta = "No se han llenado todos los campos";

            // Verifica que las contraseñas coincidan
            if ($contraseña != $confirmarContraseña) {
                $mensajeAlerta = "Las contraseñas no coinciden, Verifique";
                $claseAlerta = "alerta-rojo";
            } else {
                if (strlen($contraseña) < 8) {
                    $mensajeAlerta = "La contraseña debe tener al menos 8 caracteres.";
                    $claseAlerta = "alerta-rojo";
                    
                } elseif (!preg_match('/[A-Z]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos una letra mayúscula.";
                    $claseAlerta = "alerta-rojo";
                } elseif (!preg_match('/[a-z]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos una letra minúscula.";
                    $claseAlerta = "alerta-rojo";
                } elseif (!preg_match('/[0-9]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos un número.";
                    $claseAlerta = "alerta-rojo";
                } elseif (!preg_match('/[!@#$%^&*]/', $contraseña)) {
                    $mensajeAlerta = "La contraseña debe contener al menos un carácter especial. (! @ # $ % ^ & *)";
                    $claseAlerta = "alerta-rojo";
                } else {
                    // Encripta la contraseña usando password_hash
                    $contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);
            
                    // Consulta para verificar si el usuario o el correo ya existen
                    $sqlVerificacion = "SELECT * FROM usuarios WHERE Usuario = '$usuario' OR CorreoElectronico = '$correo'";
                    $resultadoVerificacion = $conn->query($sqlVerificacion);
            
                    // Verifica si el usuario ya está registrado
                    $sqlVerificacionUsuario = "SELECT * FROM usuarios WHERE Usuario = '$usuario'";
                    $resultadoVerificacionUsuario = $conn->query($sqlVerificacionUsuario);

                    if ($resultadoVerificacionUsuario->num_rows > 0) {
                        $mensajeAlerta = "El usuario ya existe, por favor Cambiar.";
                        $claseAlerta = "alerta-rojo";
                    } else {
                        // Verifica si el correo ya está registrado
                        $sqlVerificacionCorreo = "SELECT * FROM usuarios WHERE CorreoElectronico = '$correo'";
                        $resultadoVerificacionCorreo = $conn->query($sqlVerificacionCorreo);

                        if ($resultadoVerificacionCorreo->num_rows > 0) {
                            $mensajeAlerta = "El correo ya existe, por favor Cambiar.";
                            $claseAlerta = "alerta-rojo";
                        } else {
                            // INSERT con la contraseña encriptada
                            $sqlInsercion = "INSERT INTO usuarios (Nombre, Usuario, CorreoElectronico, Contraseña, Rol) VALUES ('$nombre', '$usuario', '$correo', '$contraseñaEncriptada', '$rol')";

                            if ($conn->query($sqlInsercion) === TRUE) {
                                $_SESSION['mensajeAlerta'] = "Datos guardados con éxito. El registro fue exitoso";
                                $_SESSION['claseAlerta'] = "alerta-verde";
                                header('Location: registro.php');  // Redireccionar de nuevo a la página de registro
                                exit;
                            } else {
                                $_SESSION['mensajeAlerta'] = "Error al guardar los datos: " . $conn->error;
                                $_SESSION['claseAlerta'] = "alerta-rojo";
                                header('Location: registro.php');  // Redireccionar de nuevo a la página de registro
                                exit;
                                }
                        }
                    }       
                }
            }
        }
    } else {
        $mensajeAlerta = "Por favor, seleccione un rol válido (Vendedor o Comprador).";
        $claseAlerta = "alerta-rojo";
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
            <a href="index.html">
                <span class="icon-close">
                    <ion-icon name="close-outline"></ion-icon>
                </span>
            </a>
            <!-- Caja del registro -->
            <div class="form-box register">
                <h2>Registro</h2>
                <!-- Mostrar alerta si hay un mensaje -->
                <?php if (!empty($mensajeAlerta)) : ?>
                       <div id="alerta" class="<?php echo $claseAlerta; ?>"><?php echo $mensajeAlerta; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type="text" name="nombre" required value="<?php echo $nombre; ?>">
                        <label for="">Nombre | Empresa (vendedor)</label>
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
                    <div class="rol">
                        <div class="option">
                            <input value="2" name="rol" type="radio" class="input-rol" <?php echo ($rol == '2') ? 'checked' : ''; ?>>
                            <div class="btnOpcion">
                                <span class="span-rol">Vendedor</span>
                            </div>
                        </div>
                        <div class="option">
                            <input value="3" name="rol" type="radio" class="input-rol" <?php echo ($rol == '3') ? 'checked' : ''; ?>>
                            <div class="btnOpcion">
                                <span class="span-rol">Comprador</span>
                            </div>  
                        </div>
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
