<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['user']) || $_SESSION['rol'] != '2') {
    header('Location: login.php');
    exit();
}

$mensajeAlerta = "";

// Verificar mensajes a través de parámetros en la URL
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'productoAñadido') {
        $mensajeAlerta = "Producto añadido exitosamente!";
    } elseif ($_GET['mensaje'] == 'productoEliminado') {
        $mensajeAlerta = "Producto eliminado exitosamente!";
    }
}

// Obtenemos el ID del usuario logueado basándonos en el correo electrónico
$sqlID = "SELECT ID FROM usuarios WHERE CorreoElectronico = '".$_SESSION['user']."'";
$resultID = $conn->query($sqlID);
if(!$resultID) {
    die("Error en la consulta: " . $conn->error);
}

if($resultID->num_rows > 0) {
    $userData = $resultID->fetch_assoc();
    $userID = $userData['ID'];
} else {
    die("Error: Usuario no encontrado.");
}

// Cuando el vendedor sube un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subir'])) {
    $nombreProducto = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    
    // Manejo de la imagen
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imagenProducto"]["name"]);
    $uploadOk = 1;

    // Verifica si el archivo es una imagen real o una imagen falsa
    $check = getimagesize($_FILES["imagenProducto"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $mensajeAlerta = "El archivo no es una imagen.";
        $uploadOk = 0;
    }
    
    // Intenta mover el archivo al directorio
    if ($uploadOk == 1 && move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO productos (vendedorID, nombreProducto, descripcion, precio, imagenProducto) VALUES ('$userID', '$nombreProducto', '$descripcion', '$precio', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            header('Location: vendedor.php?mensaje=productoAñadido'); // Redirección
            exit();
        } else {
            $mensajeAlerta = "Error al añadir producto: " . $conn->error;
        }
    } else {
        $mensajeAlerta .= " Error al subir la imagen.";
    }
}

// Cuando el vendedor desea eliminar un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $idProducto = $_POST['idProducto'];

    $sql = "DELETE FROM productos WHERE ID = '$idProducto' AND vendedorID = '$userID'";
    if ($conn->query($sql) === TRUE) {
        header('Location: vendedor.php?mensaje=productoEliminado'); // Redirección
        exit();
    } else {
        $mensajeAlerta = "Error al eliminar producto: " . $conn->error;
    }
}

// Obtener la lista de productos del vendedor actual
$sql = "SELECT * FROM productos WHERE vendedorID = '$userID'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="vendedor.css">
    <title>Vendedor - ASTRA</title>
</head>

<body>
    <div class="container">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
            <button class="btnPerfil">Ver Perfil</button>
        </header>

        <div class="contenidoVendedor">

            <!-- Sección de subida de producto -->
            <section class="leftSection">
    <div class="subirProducto">
        <h2>Subir Producto</h2>
        <form action="vendedor.php" method="POST" enctype="multipart/form-data">
            <!-- Nombre del Producto -->
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" name="nombreProducto" required>

            <!-- Descripción -->
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>

            <!-- Precio -->
            <label for="precio">Precio:</label>
            <input type="text" name="precio" required>

            <!-- Imagen del Producto -->
            <label for="imagenProducto">Imagen del Producto:</label>
            <input type="file" name="imagenProducto" required>

            <!-- Botón para Subir Producto -->
            <button type="submit" name="subir">Subir Producto</button>
        </form>
    </div>
</section>

            
            
            <!-- Mensajes de alerta -->
            <?php if (!empty($mensajeAlerta)) : ?>
                <div class="alerta"><?php echo $mensajeAlerta; ?></div>
            <?php endif; ?>
        </div>
        <div class="contenidoVendedor" id="awebao">
        <!-- Sección de productos -->
                    <section class="rightSection">
                    <div class="listaProductos">
                        <h2>Mis Productos</h2>
                        <ul>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <li>
                                    <div class="productoContainer">
                                        <img src="<?php echo $row['imagenProducto']; ?>" alt="Imagen del producto">
                                        <div class="productoInfo">
                                            <p class="descripcionProducto"><?php echo $row['descripcion']; ?></p>
                                            <p class="nombreProducto"><?php echo $row['nombreProducto']; ?></p> <p id="precio">$<?php echo $row['precio']; ?></p>
                                            
                                        </div>
                                        <form action="vendedor.php" method="POST">
                                                <input type="hidden" name="idProducto" value="<?php echo $row['ID']; ?>">
                                                <button type="submit" id="bombardeo" name="eliminar">Eliminar</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    </section>

        </div>

    </div>
</body>
</html>