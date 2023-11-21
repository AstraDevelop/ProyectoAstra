<?php
include("../conexion.php");
session_start();

$usuarioI = $_SESSION['username'];

// Obtener productos en el carrito del usuario
$sql = "SELECT c.productoID, c.cantidad, p.precio 
        FROM carrito c
        JOIN productos p ON c.productoID = p.ID
        WHERE c.usuarioNombre = '$usuarioI'";

$result = $conn->query($sql);

// Crear un nuevo pedido en la tabla "pedidos"
$sqlInsertPedido = "INSERT INTO pedidos (usuarioNombre, estado) VALUES ('$usuarioI', 'pendiente')";
$conn->query($sqlInsertPedido);
$pedidoID = $conn->insert_id;

// Insertar productos en la tabla "detalle_pedido" para el nuevo pedido
while ($row = $result->fetch_assoc()) {
    $productoID = $row['productoID'];
    $cantidad = $row['cantidad'];
    $precio = $row['precio'];

    $sqlInsertDetalle = "INSERT INTO detalle_pedido (pedidoID, productoID, cantidad, precio) 
                        VALUES ($pedidoID, $productoID, $cantidad, $precio)";
    $conn->query($sqlInsertDetalle);
}

// Vaciar carrito
$sqlVaciarCarrito = "DELETE FROM carrito WHERE usuarioNombre = '$usuarioI'";
$conn->query($sqlVaciarCarrito);

// Redirigir a la página de historial de pedidos
header('location: ../historial_pedidos.php');
exit();
?>
