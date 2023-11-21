<?php
include("../conexion.php");
session_start();

$vendedorI = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedidoID = $_POST['pedidoID'];
    $accion = $_POST['accion'];

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
