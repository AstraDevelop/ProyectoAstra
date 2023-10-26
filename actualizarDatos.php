<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];

// Si el usuario ha iniciado sesión, se ejecuta esto
if (isset($usuarioI)) {

    $nombre = '';
    $usuario = '';
    $correo = '';
    $rol = '';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar los datos del formulario
        $nombre = $_POST['nombre'];
        $usuarioN = $_POST['usuario'];
        $correoN = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $confirmarContraseña = $_POST['confirmarContraseña'];
        $rol = $_POST['rol'];

        if (isset($_POST['rol'])) {
            $rol = $_POST['rol'];
    
            // Verifica si el rol se ha seleccionado
            if (empty($rol) || !in_array($rol, ['2', '3'])) {
                $mensajeAlerta = "Por favor, seleccione un rol válido (Vendedor o Comprador).";
            } else {
                // Verifica que los campos no estén vacíos
                $req = (strlen($nombre) * strlen($usuario) * strlen($correo) * strlen($contraseña) * strlen($confirmarContraseña)) or $mensajeAlerta = "No se han llenado todos los campos";
    
                // Verifica que las contraseñas coincidan
                if ($contraseña != $confirmarContraseña) {
                    $mensajeAlerta = "Las contraseñas no coinciden, Verifique";
                } else {
                    
                        // Encripta la contraseña usando password_hash
                        $contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);
                
                        // Verifica si el usuario ya está registrado
                        $sqlVerificacionUsuario = "SELECT * FROM usuarios WHERE Usuario = '$usuarioN'";
                        $resultadoVerificacionUsuario = $conn->query($sqlVerificacionUsuario);

                        if ($resultadoVerificacionUsuario->num_rows > 0) {
                            $mensajeAlerta = "El usuario ya existe, por favor Cambiar.";
                        } else {
                            // Verifica si el correo ya está registrado
                            $sqlVerificacionCorreo = "SELECT * FROM usuarios WHERE CorreoElectronico = '$correo'";
                            $resultadoVerificacionCorreo = $conn->query($sqlVerificacionCorreo);
    
                            if ($resultadoVerificacionCorreo->num_rows > 0) {
                                $mensajeAlerta = "El correo ya existe, por favor Cambiar.";
                            } else {
                                $updateQuery = "UPDATE usuarios SET Nombre = '$nombre', Usuario = '$usuario', CorreoElectronico = '$correo', rol = '$rol' WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";

                                if ($conn->query($updateQuery) === TRUE) {
                                    $mensajeAlerta = "Datos actualizados con éxito.";
                                    $_SESSION['username'] = $usuario;
                                    $usuarioI = $_SESSION['username'];
                                } else {
                                    $mensajeAlerta = "Error al actualizar los datos: " . $conn->error;
                                }
                            }
                        }       
                }
                
            }
        } else {
            $mensajeAlerta = "Por favor, seleccione un rol válido (Vendedor o Comprador).";
        }      
    }

    // Realizar la consulta SQL para obtener los datos del usuario
    $query = "SELECT Nombre, Usuario, CorreoElectronico, Contraseña, rol FROM usuarios WHERE (CorreoElectronico = '$usuarioI' OR Usuario = '$usuarioI')";

    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();

        // Asignar los valores de la base de datos a las variables
        $nombre = $row['Nombre'];
        $usuario = $row['Usuario'];
        $correo = $row['CorreoElectronico'];
        $rol = $row['rol'];
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
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>

        <div class="cuadroRegistro">
            <!-- Caja del registro -->
            <div class="form-box register">
                <a href="perfil.php">
                    <span class="icon-close">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                </a>
                <h2>Datos Del Usuario</h2>
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
                    <p class="mensaje">Para poder guardar los datos escriba su contraseña</p>
                    <div class="input-box contraseña">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="contraseña" required>
                        <label for="">Contraseña</label>
                    </div>
                    <div class="input-box contraseña">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" name="confirmarContraseña" required>
                        <label for="">Confirmar Contraseña</label>
                    </div>

                    <button type="submit" class="btn">Actualizar Datos</button>
                </form>
            </div>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>
<?php
    }else {
    echo "Error al recuperar datos del usuario: " . $mysqli->error;
    }
} else {
    header('location: index.html');
}
?>