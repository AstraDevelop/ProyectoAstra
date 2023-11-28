<?php
include("conexion.php");
session_start();

$vendedorI = $_SESSION['username'];

// Obtener pedidos pendientes del vendedor
$sqlPendientes = "SELECT p.ID AS pedidoID, p.fechaRealizado, p.estado, GROUP_CONCAT(dp.productoID) AS productos, 
    SUM(dp.cantidad) AS totalCantidad, SUM(dp.cantidad * pr.precio) AS totalPrecio, u.Nombre AS nombreCliente 
    FROM pedidos p
    JOIN detalle_pedido dp ON p.ID = dp.pedidoID
    JOIN usuarios u ON p.usuarioNombre = u.Usuario
    JOIN productos pr ON dp.productoID = pr.ID
    WHERE pr.vendedorID = (SELECT ID FROM usuarios WHERE Usuario = '$vendedorI')
    AND p.estado = 'Pendiente'
    GROUP BY p.ID
    ORDER BY p.fechaRealizado DESC";

$resultPendientes = $conn->query($sqlPendientes);

// Obtener historial de pedidos aceptados y rechazados del vendedor
$sqlHistorial = "SELECT p.ID AS pedidoID, p.fechaRealizado, p.estado, GROUP_CONCAT(dp.productoID) AS productos, 
    SUM(dp.cantidad) AS totalCantidad, SUM(dp.cantidad * pr.precio) AS totalPrecio, u.Nombre AS nombreCliente 
    FROM pedidos p
    JOIN detalle_pedido dp ON p.ID = dp.pedidoID
    JOIN usuarios u ON p.usuarioNombre = u.Usuario
    JOIN productos pr ON dp.productoID = pr.ID
    WHERE pr.vendedorID = (SELECT ID FROM usuarios WHERE Usuario = '$vendedorI')
    AND (p.estado = 'Aceptado' OR p.estado = 'Rechazado')
    GROUP BY p.ID
    ORDER BY p.fechaRealizado DESC";

$resultHistorial = $conn->query($sqlHistorial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/pedidos.css">
    <title>Pedidos - ASTRA</title>
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

    <div class="historial-pedidos">
        <h1>Pedidos Pendientes</h1>
        <table class="tabla-historial-pedidos">
            <tr>
                <th>ID del Pedido</th>
                <th>Fecha Realizado</th>
                <th>Cliente</th>
                <th>Total Cantidad</th>
                <th>Total Precio</th>
                <th>Detalles</th>
                <th>Acción</th>
            </tr>
            <?php while ($row = $resultPendientes->fetch_assoc()) : ?>
                <tr class="<?php echo strtolower($row['estado']); ?>">
                    <td><?php echo $row['pedidoID']; ?></td>
                    <td><?php echo $row['fechaRealizado']; ?></td>
                    <td><?php echo $row['nombreCliente']; ?></td>
                    <td><?php echo $row['totalCantidad']; ?></td>
                    <td>$<?php echo $row['totalPrecio']; ?></td>
                    <td>
                        <form method="post" action="detalles_pedido_vendedor.php">
                            <input type="hidden" name="pedidoID" value="<?php echo $row['pedidoID']; ?>">
                            <button class="btnDetalles" type="submit">Detalles</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="Procesos/estado_pedido.php">
                            <input type="hidden" name="pedidoID" value="<?php echo $row['pedidoID']; ?>">
                            <button class="btnAceptado" type="submit" name="accion" value="Aceptado">Aceptar</button>
                            <button class="btnRechazado" type="submit" name="accion" value="Rechazado">Rechazar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="historial-pedidos">
        <h1>Historial de Pedidos</h1>
        <table class="tabla-historial-pedidos">
            <tr>
                <th>ID del Pedido</th>
                <th>Fecha Realizado</th>
                <th>Cliente</th>
                <th>Total Cantidad</th>
                <th>Total Precio</th>
                <th>Estado</th>
                <th>Detalles</th>
            </tr>
            <?php while ($row = $resultHistorial->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['pedidoID']; ?></td>
                    <td><?php echo $row['fechaRealizado']; ?></td>
                    <td><?php echo $row['nombreCliente']; ?></td>
                    <td><?php echo $row['totalCantidad']; ?></td>
                    <td>$<?php echo $row['totalPrecio']; ?></td>
                    <td class="<?php echo strtolower($row['estado']); ?>"><?php echo $row['estado']; ?></td>
                    <td>
                        <form method="post" action="detalles_pedido_vendedor.php">
                            <input type="hidden" name="pedidoID" value="<?php echo $row['pedidoID']; ?>">
                            <button class="btnDetalles" type="submit">Detalles</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
