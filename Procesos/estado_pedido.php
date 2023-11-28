<?php
include("../conexion.php");
session_start();

$vendedorI = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedidoID = $_POST['pedidoID'];
    $accion = $_POST['accion'];

    // Verificar stock solo si la acción es 'Aceptado'
    if ($accion == 'Aceptado') {
        // Obtener detalles del pedido
        $sqlDetalles = "SELECT dp.productoID, dp.cantidad 
                        FROM detalle_pedido dp
                        WHERE dp.pedidoID = $pedidoID";
        $resultDetalles = $conn->query($sqlDetalles);

        $productosConStockInsuficiente = [];

        while ($detalle = $resultDetalles->fetch_assoc()) {
            $productoID = $detalle['productoID'];
            $cantidad = $detalle['cantidad'];

            // Verificar si hay suficiente stock
            $sqlStock = "SELECT stock FROM productos WHERE ID = $productoID";
            $resultStock = $conn->query($sqlStock);
            $rowStock = $resultStock->fetch_assoc();
            $stockDisponible = $rowStock['stock'];

            if ($cantidad > $stockDisponible) {
                // Almacenar información sobre el producto sin stock suficiente
                $productosConStockInsuficiente[] = $productoID;
            }
        }

        // Si hay stock suficiente, realizar las actualizaciones
        if (empty($productosConStockInsuficiente)) {
            // Restar la cantidad del pedido al stock de cada producto
            foreach ($resultDetalles as $detalle) {
                $productoID = $detalle['productoID'];
                $cantidad = $detalle['cantidad'];

                // Actualizar el stock del producto
                $sqlUpdateStock = "UPDATE productos SET stock = stock - $cantidad WHERE ID = $productoID";
                $conn->query($sqlUpdateStock);
            }
        } else {
            // Mostrar mensaje de error con detalles de los productos sin stock suficiente
            echo "Error: Stock insuficiente para los siguientes productos:<br>";

            foreach ($productosConStockInsuficiente as $productoID) {
                echo "- Producto ID: $productoID<br>";
            }

            exit();
        }
    }

    // Actualizar el estado del pedido
    $sqlUpdateEstado = "UPDATE pedidos SET estado = '$accion' WHERE ID = $pedidoID";
    $conn->query($sqlUpdateEstado);

    // Redirigir a la página de pedidos pendientes
    header('location: ../pedidos_pendientes.php');
    exit();
} else {
    // Redirigir a la página principal si no es una solicitud POST
    header('location: ../index.php');
    exit();
}
?>