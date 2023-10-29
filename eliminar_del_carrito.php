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
    
    // Consulta SQL para obtener la cantidad actual en el carrito
    $sqlCheck = "SELECT cantidad FROM carrito WHERE productoID = $productoID AND usuarioNombre = '$usuarioI'";
    $resultCheck = $conn->query($sqlCheck);
    $row = $resultCheck->fetch_assoc();
    $cantidadActual = $row['cantidad'];

    // Si la cantidad después de la eliminación es 0 o menor, elimina el producto del carrito
    if ($cantidadActual - 1 <= 0) {
        $sql = "DELETE FROM carrito WHERE productoID = $productoID AND usuarioNombre = '$usuarioI'";
    } else {
        $sql = "UPDATE carrito SET cantidad = cantidad - 1 WHERE productoID = $productoID AND usuarioNombre = '$usuarioI'";
    }
    
    if ($conn->query($sql) === TRUE) {
        header('Location: ver_carrito.php');
        exit();
    } else {
        echo "Error al reducir la cantidad del producto: " . $conn->error;
    }
    
    $conn->close();
} else {
    echo "No se especificó un producto para reducir su cantidad.";
}
?>