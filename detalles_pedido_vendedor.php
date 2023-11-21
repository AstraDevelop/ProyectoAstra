<?php
include("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pedidoID = $_POST["pedidoID"];

    // Obtener detalles del pedido basado en el pedidoID
    $sqlDetalles = "SELECT p.ID AS pedidoID, p.usuarioNombre, dp.productoID, pr.nombreProducto, dp.cantidad, dp.precio
        FROM pedidos p
        JOIN detalle_pedido dp ON p.ID = dp.pedidoID
        JOIN productos pr ON dp.productoID = pr.ID
        WHERE p.ID = $pedidoID";

    $resultDetalles = $conn->query($sqlDetalles);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/tablasPedidos.css">
    <title>Detalles del Pedido - ASTRA</title>
</head>
<body id="body-pedidos">  
    <header>
        <a href="index.php">
            <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
            <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
            <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESIÓN</button></a>
        </nav>
    </header>

    <div class="detalle-pedido">
        <h1>Detalles del Pedido</h1>
        <?php if ($resultDetalles->num_rows > 0) : ?>
            <table class="tabla-detalle-pedido">
                <tr>
                    <th>ID del Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total Precio Unitario</th>
                </tr>
                <?php 
                    $totalPagar = 0;
                    while ($row = $resultDetalles->fetch_assoc()) : 
                        $totalPrecioUnitario = $row['cantidad'] * $row['precio'];
                        $totalPagar += $totalPrecioUnitario;
                ?>
                    <tr>
                        <td><?php echo $row['pedidoID']; ?></td>
                        <td><?php echo $row['usuarioNombre']; ?></td>
                        <td><?php echo $row['nombreProducto']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td>$<?php echo $row['precio']; ?></td>
                        <td>$<?php echo $totalPrecioUnitario; ?></td>
                    </tr>
                <?php endwhile; ?>
                <!-- Mostrar el total a pagar fuera del bucle -->
                <tr>
                <td colspan="5"><strong>Total a Pagar:</strong></td>
                <td><strong>$<?php echo number_format($totalPagar, 2); ?></strong></td>
                </tr>
            </table>
        <?php else : ?>
            <p>No hay detalles disponibles para este pedido.</p>
        <?php endif; ?>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
