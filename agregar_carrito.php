<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['username']) || $_SESSION['rol'] != '3') {
    header('location: index.html');
    exit();
}

$usuarioNombre = $_SESSION['username'];
$productoID = $_POST['productoID'];
$cantidad = $_POST['cantidad'];
$vendedorID = $_POST['vendedorID'];

// Comprobar si el producto ya está en el carrito del usuario.
$check_sql = "SELECT * FROM carrito WHERE usuarioNombre = '$usuarioNombre' AND productoID = '$productoID'";
$check_result = $conn->query($check_sql);

if($check_result->num_rows > 0) {
    // Si el producto ya está en el carrito, solo actualiza la cantidad.
    $update_sql = "UPDATE carrito SET cantidad = cantidad + '$cantidad' WHERE usuarioNombre = '$usuarioNombre' AND productoID = '$productoID'";
    if(!$conn->query($update_sql)) {
        echo "Error: " . $conn->error;
    }
} else {
    // Si no, inserta un nuevo registro en el carrito.
    $sql = "INSERT INTO carrito (usuarioNombre, productoID, cantidad) VALUES ('$usuarioNombre', '$productoID', '$cantidad')";
    if(!$conn->query($sql)) {
        echo "Error: " . $conn->error;
    }
}

header('location: catalogo.php?vendedorID=' . $vendedorID);
$conn->close();
?>

