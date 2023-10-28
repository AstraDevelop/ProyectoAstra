<?php
include("conexion.php");
session_start();

$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.html');
    exit();
}

// Verificar si se ha enviado un ID de producto para eliminar
if(isset($_GET['productoID'])) {
    $productoID = $_GET['productoID'];
    
    // Consulta SQL para eliminar producto del carrito
    $sql = "DELETE FROM carrito WHERE usuarioNombre = '$usuarioI' AND productoID = '$productoID'";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: ver_carrito.php');
        exit();
    } else {
        echo "Error al eliminar producto: " . $conn->error;
    }
    
    $conn->close();
} else {
    echo "No se especificó un producto para eliminar.";
}
?>
