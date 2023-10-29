<?php
include("conexion.php");
session_start();

$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.html');
    exit();
}

// Si el usuario envía la solicitud para reducir la cantidad
if (isset($_POST['reducirCantidad'])) {
    $productoID = $_POST['productoID'];
    $cantidadEliminar = $_POST['cantidadEliminar'];
    
    // Actualizar la cantidad del producto en el carrito
    $sql = "UPDATE carrito SET cantidad = cantidad - $cantidadEliminar WHERE productoID = $productoID AND usuarioNombre = '$usuarioI'";
    $conn->query($sql);

    // Redirigir de nuevo a la página del carrito para evitar el reenvío del formulario
    header('location: ver_carrito.php');
    exit();
}

// Obtener los productos en el carrito del usuario
$sql = "SELECT p.ID, p.nombreProducto, p.imagenProducto, c.cantidad, p.precio 
        FROM carrito c
        JOIN productos p ON c.productoID = p.ID
        WHERE c.usuarioNombre = '$usuarioI'";

$result = $conn->query($sql);

$total = 0; // Variable para guardar el total de la compra
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
            <a href="comprador.php">
                <span class="icon-carro">
                <ion-icon name="caret-back"></ion-icon>
                </span>
            </a>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
            <nav class="navigation">
                <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
                <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
            </nav>
        </header>
        
        <!-- Mostrar productos en el carrito -->
        <div class="comp-productos">
            <form method="post" action="">
                <table class="tabla-de-prodcutos">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Eliminar Una unidad</th>
                        <!-- <th>Eliminar Cantidad Espesifica</th> -->
                    </tr>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><img src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>"></td>
                            <td><?php echo $row['nombreProducto']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td>$<?php echo $row['precio']; ?></td>
                            <td>$<?php
                                $subtotal = $row['cantidad'] * $row['precio'];
                                $total += $subtotal;
                                echo $subtotal;
                                ?>
                            </td>
                            <td>
                                <a id="btnELiPro" href="eliminar_del_carrito.php?productoID=<?php echo $row['ID']; ?>">Eliminar</a>
                            </td>
                            <!-- <td>
                                <input type="number" name="cantidadEliminar" min="1" max="<?php echo $row['cantidad']; ?>" value="1">
                                <input type="hidden" name="productoID" value="<?php echo $row['ID']; ?>">
                                <input type="submit" name="reducirCantidad" value="Reducir">
                            </td> -->
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="4"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$<?php echo $total; ?></strong></td>
                        <!-- <td></td> -->
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>