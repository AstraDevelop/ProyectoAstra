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

        // Verificar la contraseña antes de realizar actualizaciones
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $contrasenaActual = $_POST['contrasenaActual'];

            // Verificar la contraseña actual del usuario
            if (password_verify($contrasenaActual, $rowUsuario['Contraseña'])) {
                // Contraseña actual es correcta, se permite la actualización

                // Obtener datos del formulario
                $nuevoNombre = $_POST['nuevoNombre'];
                $nuevoUsuario = $_POST['nuevoUsuario'];
                $nuevoCorreo = $_POST['nuevoCorreo'];
                $nuevaDescripcion = $_POST['nuevaDescripcion'];

                // Procesar la carga de la nueva imagen de perfil
                $nuevaFotoPerfil = $fotoPerfil;

                if ($_FILES['nuevaFotoPerfil']['error'] == 0) {
                    $uploadsDir = 'fotosVendedor/';
                    $tmpName = $_FILES['nuevaFotoPerfil']['tmp_name'];
                    $nuevaFotoPerfil = $uploadsDir . basename($_FILES['nuevaFotoPerfil']['name']);

                    move_uploaded_file($tmpName, $nuevaFotoPerfil);
                }

                // Actualizar información del usuario
                $sqlUpdateUsuario = "UPDATE usuarios SET Nombre = '$nuevoNombre', Usuario = '$nuevoUsuario', CorreoElectronico = '$nuevoCorreo' WHERE Usuario = '$user'";
                $conn->query($sqlUpdateUsuario);

                // Actualizar información del perfil del vendedor
                $sqlUpdatePerfilVendedor = "UPDATE perfil_vendedor SET Descripcion = '$nuevaDescripcion', FotoPerfil = '$nuevaFotoPerfil' WHERE Usuario = '$user'";
                $conn->query($sqlUpdatePerfilVendedor);

                // Redirigir después de la actualización
                header("location: perfilVendedor.php");
                exit;
            } else {
                // Contraseña incorrecta, puedes manejar esto según tus necesidades
                $errorContraseña = "La contraseña actual es incorrecta.";
            }
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/actualizarVendedor.css">
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
        <div class="perfil-container">
            <div class="info-box">
                <h1>Perfil Antiguo</h1>
                <h2><?php echo $nombre; ?></h2>
                <?php if ($fotoPerfil) : ?>
                    <img src="<?php echo $fotoPerfil; ?>" alt="Foto de Perfil" class="foto-perfil">
                <?php endif; ?>
                <div class="form-box">
                    <h4 class="datos">Usuario Antiguo</h4>
                    <h4 class="inf"><?php echo $user; ?></h4>
                    <h4 class="datos">Correo Electrónico Antiguo</h4>
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
                    <h4 class="datos">Descripción Antigua:</h4>
                    <h4 class="inf"><?php echo $descripcion; ?></h4>
                </div>
            </div>

            <div class="form-box">
                <h1>Perfil Nuevo</h1>
                <!-- Formulario de actualización -->
                <form action="#" method="POST" enctype="multipart/form-data">
                    <h4 class="datos">Nuevo Nombre:</h4>
                    <input type="text" name="nuevoNombre" required>

                    <h4 class="datos">Nuevo Usuario:</h4>
                    <input type="text" name="nuevoUsuario" required>

                    <h4 class="datos">Nuevo Correo Electrónico:</h4>
                    <input type="email" name="nuevoCorreo" required>

                    <h4 class="datos">Nueva Descripción:</h4>
                    <textarea name="nuevaDescripcion" required></textarea>

                    <h4 class="datos">Nueva Foto de Perfil:</h4>
                    <input type="file" name="nuevaFotoPerfil" accept="image/*" id="fileInput">
                    <img id="previewImg" class="preview-img" src="" alt="Vista previa de la imagen">

                    <!-- Campo para la contraseña actual -->
                    <h4 class="datos">Contraseña Actual:</h4>
                    <input type="password" name="contrasenaActual" required>

                    <!-- Manejo de errores de contraseña -->
                    <?php if (isset($errorContraseña)) : ?>
                        <p class="error"><?php echo $errorContraseña; ?></p>
                    <?php endif; ?>

                    <button type="submit" class="btn">Actualizar Datos</button>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // Función para mostrar la vista previa de la imagen
        function previewImage() {
            const fileInput = document.getElementById('fileInput');
            const previewImg = document.getElementById('previewImg');

            fileInput.addEventListener('change', function () {
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewImg.src = '';
                }
            });
        }

        // Llamada a la función de vista previa al cargar la página
        window.onload = function () {
            previewImage();
        };
    </script>
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
