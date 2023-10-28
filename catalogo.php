<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.html');
    exit();
}

$vendedorID = isset($_GET['vendedorID']) ? $_GET['vendedorID'] : "";
// Consulta SQL para obtener el nombre del vendedor basado en vendedorID
$sqlVendedor = "SELECT Nombre FROM usuarios WHERE ID = '$vendedorID'";
$resultVendedor = $conn->query($sqlVendedor);
if($resultVendedor && $resultVendedor->num_rows > 0) {
    $vendedorData = $resultVendedor->fetch_assoc();
    $nombreVendedor = $vendedorData['Nombre'];
} else {
    die("Error: Vendedor no encontrado.");
}

// Consulta SQL para obtener todos los productos del vendedor seleccionado
$sql = "SELECT imagenProducto, nombreProducto, descripcion, precio
        FROM productos 
        WHERE vendedorID = '$vendedorID'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Catálogo - ASTRA</title>
</head>

<body id="body-catalogo">
    <div class="container" id="catalogoPage">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
            <nav>
                <!-- Mostrar el nombre del vendedor y el título "Catálogo" -->
                <h2>Catálogo de <?php echo $nombreVendedor; ?></h2>
            </nav>
        </header>
        
        
        <!-- Mostrar productos del vendedor seleccionado -->
        <div class="comp-productos">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="comp-producto">
                    <img src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>">
                    <h3><?php echo $row['nombreProducto']; ?></h3>
                    <p><?php echo $row['descripcion']; ?></p>
                    <p>$<?php echo $row['precio']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>
