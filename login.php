<?php
include("conexion.php");
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
    $rol = $_SESSION['rol'];

    // Si es un vendedor y es la primera vez que inicia sesión, redirige a completarPerfilVendedor.php
    if ($rol == 2 && !haCompletadoPerfilVendedor($_SESSION['username'])) {
        header("location: completarPerfilVendedor.php");
        exit;
    } elseif ($rol == 2) {
        header("location: vendedor.php");
        exit;
    } elseif ($rol == 3) {
        header("location: comprador.php");
        exit;
    }
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$mensajeAlerta = "";
$claseAlerta = "";

$user = "";
$contraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $contraseñaIngresada = $_POST['contraseña'];

    $sqlUsuario = "SELECT Usuario, Contraseña, Rol FROM usuarios WHERE CorreoElectronico = '$user' OR Usuario = '$user'";
    $resultUsuario = $conn->query($sqlUsuario);
    $row = $resultUsuario->fetch_assoc();

    if ($resultUsuario->num_rows == 1) {
        $rol = $row['Rol'];
        $contraseñaIngresada = $_POST['contraseña'];

        $sqlContraseña = "SELECT Contraseña FROM usuarios WHERE (CorreoElectronico = '$user' OR Usuario = '$user')";
        $resultContraseña = $conn->query($sqlContraseña);

        if ($resultContraseña->num_rows == 1) {
            $row = $resultContraseña->fetch_assoc();
            $hashContraseñaAlmacenada = $row['Contraseña'];

            if (password_verify($contraseñaIngresada, $hashContraseñaAlmacenada)) {
                $_SESSION['username'] = $user;
                $_SESSION['rol'] = $rol;

                // Si es un vendedor y es la primera vez que inicia sesión, redirige a completarPerfilVendedor.php
                if ($rol == 2 && !haCompletadoPerfilVendedor($user)) {
                    header("location: completarPerfilVendedor.php");
                    exit;
                }

                if ($rol == 2) {
                    header("location: vendedor.php");
                }

                if ($rol == 3) {
                    header("location: comprador.php");
                } else {
                    header("location: vendedor.php");
                }

                exit;
            } else {
                $mensajeAlerta = "Contraseña incorrecta.";
                if ($mensajeAlerta === "Contraseña incorrecta.") {
                    $claseAlerta = "alerta-rojo";
                } elseif ($mensajeAlerta === "Usuario no encontrado.") {
                    $claseAlerta = "alerta-rojo";
                }
                $contraseña = "";
            }
        } else {
            $mensajeAlerta = "Contraseña incorrecta.";
            if ($mensajeAlerta === "Contraseña incorrecta.") {
                $claseAlerta = "alerta-rojo";
            } elseif ($mensajeAlerta === "Usuario no encontrado.") {
                $claseAlerta = "alerta-rojo";
            }
            $contraseña = "";
        }
    } else {
        $mensajeAlerta = "Usuario no encontrado.";
        if ($mensajeAlerta === "Contraseña incorrecta.") {
            $claseAlerta = "alerta-rojo";
        } elseif ($mensajeAlerta === "Usuario no encontrado.") {
            $claseAlerta = "alerta-rojo";
        }
        $user = "";
        $contraseña = "";
    }
}

// Función para verificar si un vendedor ha completado el perfil
function haCompletadoPerfilVendedor($usuario) {
    global $conn;

    $sql = "SELECT ID FROM perfil_vendedor WHERE Usuario = '$usuario'";
    $result = $conn->query($sql);

    return $result->num_rows > 0;
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
            <div class="form-box login">
                <h2>Iniciar Sesión</h2>
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
                        <span class="icon" id="lockIcon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <span class="icon" id="showPassword">
                            <ion-icon name="eye"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" id="password" required value="<?php echo $contraseña; ?>">
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
        <script>
            document.getElementById("password").addEventListener("input", function() {
                var passwordField = document.getElementById("password");
                var lockIcon = document.getElementById("lockIcon");
                var showPassword = document.getElementById("showPassword");

                if (passwordField.value.trim() !== "") {
                    lockIcon.style.display = "none";
                    showPassword.style.display = "block";
                } else {
                    lockIcon.style.display = "block";
                    showPassword.style.display = "none";
                }
            });

            document.getElementById("showPassword").addEventListener("click", function() {
                var passwordField = document.getElementById("password");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                } else {
                    passwordField.type = "password";
                }
            });
        </script>
    </div>
</body>
</html>
