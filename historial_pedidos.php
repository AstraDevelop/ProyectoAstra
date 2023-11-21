<?php
include("conexion.php");
session_start();

$usuarioI = $_SESSION['username'];

// Obtener historial de pedidos del usuario
$sql = "SELECT p.ID AS pedidoID, MAX(p.fechaRealizado) AS fechaRealizado, p.estado, uv.Nombre AS nombreVendedor, SUM(dp.cantidad * dp.precio) AS totalPagar
        FROM pedidos p
        JOIN detalle_pedido dp ON p.ID = dp.pedidoID
        JOIN productos pr ON dp.productoID = pr.ID
        JOIN usuarios uv ON pr.vendedorID = uv.ID
        WHERE p.usuarioNombre = '$usuarioI'
        GROUP BY pedidoID
        ORDER BY fechaRealizado DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/pedidos.css">
    <title>Historial de Pedidos - ASTRA</title>
</head>
<body>  
    <header>
        <a href="index.php">
            <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
            <a href="perfil.php"><button class="btnVerPerfil">Ver Perfil</button></a>
            <a href="cerrarSesion.php"><button class="cerrarSesion">CERRAR SESION</button></a>
        </nav>
    </header>

    <div class="historial-pedidos">
        <h1>Historial de Pedidos</h1>
        <table class="tabla-historial-pedidos">
            <tr>
                <th>ID del Pedido</th>
                <th>Fecha Realizado</th>
                <th>Nombre del Vendedor</th>
                <th>Estado</th>
                <th>Total a Pagar</th>
                <th>Detalles</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['pedidoID']; ?></td>
                    <td><?php echo $row['fechaRealizado']; ?></td>
                    <td><?php echo $row['nombreVendedor']; ?></td>
                    <td class="<?php echo strtolower($row['estado']); ?>"><?php echo $row['estado']; ?></td>
                    <td>$<?php echo $row['totalPagar']; ?></td>
                    <td>
                        <form method="post" action="detalle_del_pedido.php">
                            <input type="hidden" name="pedidoID" value="<?php echo $row['pedidoID']; ?>">
                            <button class="btnDetalles" type="submit">Ver Detalles</button>
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
