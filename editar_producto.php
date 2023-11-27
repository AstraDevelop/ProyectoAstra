<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (isset($usuarioI) && ($rol == 2)) {
    if (isset($_GET['id'])) {
        $productoID = $_GET['id'];
        
        $sql = "SELECT * FROM productos WHERE ID = $productoID";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $producto = $result->fetch_assoc();
        } else {
            echo "Producto no encontrado.";
            exit;
        }
    } else {
        echo "ID de producto no especificado.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
        $nuevoNombreProducto = $_POST['nombreProducto'];
        $nuevaDescripcion = $_POST['descripcion'];
        $nuevoPrecio = $_POST['precio'];
        $nuevoStock = $_POST['stock']; // Nuevo campo para el stock
        
        // Manejo de la imagen
        $target_dir = "uploads/";
        $nuevaImagen = $_FILES["imagenProducto"];

        if (!empty($nuevaImagen["name"])) {
            $target_file = $target_dir . basename($nuevaImagen["name"]);
            $uploadOk = 1;

            $check = getimagesize($nuevaImagen["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "El archivo no es una imagen.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1 && move_uploaded_file($nuevaImagen["tmp_name"], $target_file)) {
                // Si se ha cargado una nueva imagen, actualizar la ruta de la imagen en la base de datos
                $sqlUpdate = "UPDATE productos SET nombreProducto = '$nuevoNombreProducto', descripcion = '$nuevaDescripcion', precio = '$nuevoPrecio', stock = '$nuevoStock', imagenProducto = '$target_file' WHERE ID = $productoID";
            } else {
                echo "Error al subir la nueva imagen.";
            }
        } else {
            // Si no se ha proporcionado una nueva imagen, actualizar solo la información sin cambiar la imagen
            $sqlUpdate = "UPDATE productos SET nombreProducto = '$nuevoNombreProducto', descripcion = '$nuevaDescripcion', precio = '$nuevoPrecio', stock = '$nuevoStock' WHERE ID = $productoID";
        }

        if ($conn->query($sqlUpdate) === TRUE) {
            header('Location: vendedor.php');
            exit();
        } else {
            echo "Error al editar el producto: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="vendedor.css">
    <title>Actualizar - ASTRA</title>
</head>

<body>
    <div class="container">
        <header>
            <a href="">
                <h2 class="logo">ASTRA</h2>
            </a>
            <nav class="navigation">
                <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
                <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
            </nav>
        </header>

        <div class="contenidoEditarProducto">
            <!-- Sección de subida de producto -->
            <section class="leftSection">
                <div class="subirProducto">
                    <h2>Informacion Actual Del Producto</h2>
                    <form action="editar_producto.php?id=<?php echo $productoID; ?>" method="POST" enctype="multipart/form-data">
                        <!-- Campos de edición -->
                        <h2>Nombre del Producto:</h2>
                        <h4><?php echo $producto['nombreProducto']; ?></h4>

                        <h2>Descripción:</h2>
                        <h4><?php echo $producto['descripcion']; ?></h4>

                        <h2>Precio:</h2>
                        <h4><?php echo $producto['precio']; ?></h4>

                        <!-- Nuevo campo de stock -->
                        <h2>Stock:</h2>
                        <h4><?php echo $producto['stock']; ?></h4>

                        <!-- Mostrar la imagen antigua -->
                        <h2>Imagen Antigua:</h2>
                        <br>
                        <img class="imgAnt" src="<?php echo $producto['imagenProducto']; ?>" alt="Imagen Antigua del Producto">
                    </form>
                </div>
            </section>
        </div>

        <div class="contenidoEditarProducto izq">
            <!-- Sección de subida de producto -->
            <section class="leftSection">
                <div class="subirProducto">
                    <h2>Editar Del Producto</h2>
                    <form action="editar_producto.php?id=<?php echo $productoID; ?>" method="POST" enctype="multipart/form-data">
                        <!-- Campos de edición -->
                        <label for="nombreProducto">Nombre del Producto:</label>
                        <input type="text" name="nombreProducto" value="<?php echo $producto['nombreProducto']; ?>" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>

                        <label for="precio">Precio:</label>
                        <input type="text" name="precio" value="<?php echo $producto['precio']; ?>" required>

                        <!-- Nuevo campo de stock -->
                        <label for="stock">Stock:</label>
                        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>

                        <!-- Carga de nueva imagen -->
                        <label for="imagenProducto">Cargar Nueva Imagen del Producto:</label>
                        <input type="file" name="imagenProducto">

                        <!-- Botón para guardar los cambios -->
                        <button class="btnEditarInf" type="submit" name="editar">Guardar Cambios</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</body>
</html>

<?php  
} else {
    header('location: index.php');
}
?>
