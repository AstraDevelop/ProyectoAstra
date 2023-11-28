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
        $sqlDetalles = "SELECT dp.productoID, dp.cantidad, p.nombreProducto  
                        FROM detalle_pedido dp
                        JOIN productos p ON dp.productoID = p.ID
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
                $productoInfo = [
                    'productoID' => $productoID,
                    'nombreProducto' => $detalle['nombreProducto'],
                    'cantidadPedido' => $cantidad,
                    'stockDisponible' => $stockDisponible,
                ];

                $productosConStockInsuficiente[] = $productoInfo;
            }
        }

        // Si hay stock suficiente, realizar las actualizaciones
        if (!empty($productosConStockInsuficiente)) {
            // Mostrar mensaje de error con detalles de los productos sin stock suficiente
            echo "Error: Stock insuficiente para los siguientes productos:<br>";

            foreach ($productosConStockInsuficiente as $productoInfo) {
                echo "- Producto ID: {$productoInfo['productoID']}, Nombre: {$productoInfo['nombreProducto']}, Cantidad Pedido: {$productoInfo['cantidadPedido']}, Stock Disponible: {$productoInfo['stockDisponible']}<br>";
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
