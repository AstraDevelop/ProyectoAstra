<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$mensajeAlerta = $_SESSION['mensajeAlerta'] ?? "";
$claseAlerta = $_SESSION['claseAlerta'] ?? "";
unset($_SESSION['mensajeAlerta'], $_SESSION['claseAlerta']);

if (isset($usuarioI)) {
    $nombre = '';
    $usuario = '';
    $correo = '';
    $rol = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $usuarioN = $_POST['usuario'];
        $correoN = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $nuevaContraseña = $_POST['nuevaContraseña'] ?? '';
        $confirmarNuevaContraseña = $_POST['confirmarNuevaContraseña'] ?? '';
        $rol = $_POST['rol'];

        if (!empty($nuevaContraseña) && $nuevaContraseña != $confirmarNuevaContraseña) {
            $mensajeAlerta = "La nueva contraseña y su confirmación no coinciden.";
            $claseAlerta = "alerta-rojo";
        } else {
            $sqlCheckCurrentPassword = "SELECT Contraseña FROM usuarios WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";
            $resultPassword = $conn->query($sqlCheckCurrentPassword);
            $rowPassword = $resultPassword->fetch_assoc();

            if (password_verify($contraseña, $rowPassword['Contraseña'])) {
                if (!empty($nuevaContraseña)) {
                    $contraseñaEncriptada = password_hash($nuevaContraseña, PASSWORD_BCRYPT);
                } else {
                    $contraseñaEncriptada = $rowPassword['Contraseña'];
                }

                // Actualización de datos del usuario
                $updateQuery = "UPDATE usuarios SET Nombre = '$nombre', Usuario = '$usuarioN', CorreoElectronico = '$correoN', Contraseña = '$contraseñaEncriptada', rol = '$rol' WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";

                if ($conn->query($updateQuery) === TRUE) {
                    $mensajeAlerta = "Datos actualizados con éxito.";
                    $claseAlerta = "alerta-verde";
                    $_SESSION['username'] = $usuarioN;
                    $usuarioI = $usuarioN;
                } else {
                    $mensajeAlerta = "Error al actualizar los datos: " . $conn->error;
                    $claseAlerta = "alerta-rojo";
                }
            } else {
                $mensajeAlerta = "La contraseña actual ingresada es incorrecta.";
                $claseAlerta = "alerta-rojo";
            }
        }

        $_SESSION['mensajeAlerta'] = $mensajeAlerta;
        $_SESSION['claseAlerta'] = $claseAlerta;
        header("Location: actualizarDatos.php");
        exit;
    }

    $query = "SELECT Nombre, Usuario, CorreoElectronico, Contraseña, rol FROM usuarios WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();

        if ($row) {
            $nombre = $row['Nombre'];
            $usuario = $row['Usuario'];
            $correo = $row['CorreoElectronico'];
            $rol = $row['rol'];
        } else {
            echo "No se encontraron datos o hubo un error en la consulta.";
        }
    } else {
        echo "Error al recuperar datos del usuario";
    }
} else {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Datos Del Usuario</title>
</head>

<body>
    <div class="container">
        <header>
            <a href="index.php">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>
        <div class="cuadroRegistro" id="cuadroRegistro">
            <div class="form-box register">
                <a href="perfil.php">
                    <span class="icon-close">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                </a>
                <h2>Datos Del Usuario</h2>
                <?php if (!empty($mensajeAlerta)) : ?>
                <div id="alerta" class="<?php echo $claseAlerta; ?>"><?php echo $mensajeAlerta; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
                        <label for="">Nombre</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person"></ion-icon>
                        </span>
                        <input type="text" name="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
                        <label for="">Usuario</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type="email" name="correo" placeholder="Correo" value="<?php echo $correo; ?>">
                        <label for="">Correo</label>
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
                    <p class="mensaje">Para poder guardar los datos escriba su contraseña actual</p>
                    <div class="input-box contraseña">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" required>
                        <label for="">Contraseña Actual</label>
                    </div>
                    <p class="mensaje">Si desea actualizar su contraseña, ingrésela a continuación</p>
                    <div class="input-box contraseña">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="nuevaContraseña" placeholder="Nueva Contraseña">
                        <label for="">Nueva Contraseña</label>
                    </div>
                    <div class="input-box contraseña">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="confirmarNuevaContraseña" placeholder="Confirmar Nueva Contraseña">
                        <label for="">Confirmar Nueva Contraseña</label>
                    </div>
                    <button type="submit" class="btn" id="btn">Actualizar Datos</button>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
