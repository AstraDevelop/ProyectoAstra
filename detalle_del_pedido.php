<?php
include("conexion.php");
session_start();

// Obtener el ID del pedido desde el formulario anterior
$pedidoID = $_POST['pedidoID'];

// Obtener detalles del pedido
$sql = "SELECT p.ID AS pedidoID, p.fechaRealizado, p.estado, pr.nombreProducto AS nombreProducto, dp.cantidad, dp.precio, uv.Nombre AS nombreVendedor 
        FROM pedidos p
        JOIN detalle_pedido dp ON p.ID = dp.pedidoID
        JOIN productos pr ON dp.productoID = pr.ID
        JOIN usuarios uv ON pr.vendedorID = uv.ID
        WHERE p.ID = '$pedidoID'";

$result = $conn->query($sql);

// Comprobar si hay resultados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalPagar = 0; // Inicializar la variable para el total a pagar

    // Obtener la fecha y hora actual
    $fechaHoraApertura = date("d-m-Y H:i:s");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/tablasPedidos.css">
    <title>Detalle del Pedido - ASTRA</title>
</head>
<body>  
    <header>
        <a href="index.php">
            <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
            <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
            <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESIÓN</button></a>
        </nav>
    </header>

    <div class="info-apertura">
        <p>Archivo abierto el: <?php echo $fechaHoraApertura; ?></p>
    </div>

    <div class="detalle-pedido">
        <h1>Detalle del Pedido</h1>
        <table class="tabla-detalle-pedido">
            <tr>
                <th>ID del Pedido</th>
                <th>Fecha Realizado</th>
                <th>Nombre del Vendedor</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td><?php echo $row['pedidoID']; ?></td>
                <td><?php echo $row['fechaRealizado']; ?></td>
                <td><?php echo $row['nombreVendedor']; ?></td>
                <td><?php echo $row['estado']; ?></td>
            </tr>
        </table>

        <h2>Productos en el Pedido</h2>
        <table class="tabla-productos-pedido">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total por Producto</th>
            </tr>
            <?php
                // Mostrar los productos asociados al pedido y calcular el total a pagar
                do {
                    echo "<tr>";
                    echo "<td>{$row['nombreProducto']}</td>";
                    echo "<td>{$row['cantidad']}</td>";
                    echo "<td>$" . number_format($row['precio'], 2) . "</td>";
                    echo "<td>$" . number_format($row['cantidad'] * $row['precio'], 2) . "</td>";
                    echo "</tr>";

                    // Calcular el total a pagar sumando el precio de cada producto
                    $totalPagar += $row['precio'] * $row['cantidad'];
                } while ($row = $result->fetch_assoc());
            ?>
            <tr>
                <td colspan="3"><strong>Total a Pagar:</strong></td>
                <td><strong>$<?php echo number_format($totalPagar, 2); ?></strong></td>
            </tr>
        </table>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
<?php
} else {
    // Si no hay resultados, mostrar un mensaje o redirigir a una página de error
    echo "No se encontraron detalles para el pedido seleccionado.";
}
?>
