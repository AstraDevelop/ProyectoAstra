<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.php');
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
$sql = "SELECT ID, imagenProducto, nombreProducto, descripcion, precio
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
            <a href="comprador.php">
                <span class="icon-carro">
                <ion-icon name="caret-back"></ion-icon>
                </span>
            </a>
            <a href="index.php">
                <h2 class="logo">ASTRA</h2>
            </a>
            <!-- Mostrar el nombre del vendedor y el título "Catálogo" -->
            <h2>Catálogo de <?php echo $nombreVendedor; ?></h2>
            <a href="ver_carrito.php">
                <span class="icon-carro">
                    <p>Carrito</p>
                    <ion-icon name="cart"></ion-icon>
                </span>
            </a>
            <nav class="navigation">
                <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
                <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
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

    <form class="carProd" action="agregar_carrito.php" method="POST">
        <input type="hidden" name="productoID" value="<?php echo $row['ID']; ?>">
        <input type="number" name="cantidad" value="1" min="1">
        <input type="hidden" name="vendedorID" value="<?php echo $vendedorID; ?>">  <!-- Añade esta línea -->
        <button class="btnAgreCar" type="submit">Agregar al Carrito</button>
    </form>
</div>
            <?php endwhile; ?>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
