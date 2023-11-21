<?php
include("../conexion.php");
session_start();

$usuarioI = $_SESSION['username'];

// Vaciar carrito
$sqlVaciarCarrito = "DELETE FROM carrito WHERE usuarioNombre = '$usuarioI'";
$conn->query($sqlVaciarCarrito);

// Redirigir a la página del carrito
header('location: ../ver_carrito.php');
exit();
?>
