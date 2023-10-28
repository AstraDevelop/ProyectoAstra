<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.html');
    exit();
}

// Consulta SQL para obtener los productos en el carrito del usuario
$sql = "SELECT p.ID, p.nombreProducto, p.imagenProducto, c.cantidad, p.precio 
        FROM carrito c
        JOIN productos p ON c.productoID = p.ID
        WHERE c.usuarioNombre = '$usuarioI'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Carrito - ASTRA</title>
</head>

<body id="body-carrito">
    <div class="container" id="carritoPage">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
        </header>
        
        <!-- Mostrar productos en el carrito -->
        <div class="comp-productos">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="comp-producto">
                    <img src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>">
                    <h3><?php echo $row['nombreProducto']; ?></h3>
                    <p>Cantidad: <?php echo $row['cantidad']; ?></p>
                    <p>Precio unitario: $<?php echo $row['precio']; ?></p>
                    <p>Total: $<?php echo $row['cantidad'] * $row['precio']; ?></p>
                    <!-- Opción para eliminar producto del carrito -->
            <p><a href="eliminar_del_carrito.php?productoID=<?php echo $row['ID']; ?>">Eliminar</a></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>

