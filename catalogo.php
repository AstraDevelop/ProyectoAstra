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
    <link rel="stylesheet" href="css/comprador.css">
    <title>Catálogo - ASTRA</title>
</head>

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
<body>
<header>
        <a href="index.php">
            <h2 class="logo">ASTRA</h2>
        </a>
<<<<<<< HEAD
=======
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
>>>>>>> 9c7a85d (Agregue validación para que no vuelvan a iniciar sesión y ya hay una sesión iniciada y optimice las imágenes de fondo.)
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
        
        <form action="comprador.php" method="GET" id="comp-searchForm">
            <input class="cuadroBusq" type="text" name="buscar" placeholder="Buscar">
            <button class="btnBuscar" type="submit">Buscar</button>
        </form>
        <a class="btnCarHis" href="ver_carrito.php">
            <span class="icon-carro">
                <p>Carrito</p>
                <ion-icon name="cart"></ion-icon>
            </span>
        </a>
        <a class="btnCarHis" href="historial_pedidos.php">
            <span class="icon-historial">
                <p>Historial</p>
                <ion-icon name="clipboard-outline"></ion-icon>
            </span>
        </a>
        <nav class="navigation">
            <a href="perfil.php"><button class="btnVerPerfil">Ver Perfil</button></a>
            <a href="cerrarSesion.php"><button class="cerrarSesion">CERRAR SESION</button></a>
        </nav>
    </header>
        
        <h2 class="titulo">Catálogo de <?php echo $nombreVendedor; ?></h2>
        
        <!-- Mostrar productos del vendedor seleccionado -->
        <section class="contenedor">
            <div class="contenedor-items">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="item">
                        <img class="img-item" src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>">
                        <h3><?php echo $row['nombreProducto']; ?></h3>
                        <p class="descripcion"><?php echo $row['descripcion']; ?></p>
                        <p class="precio">$<?php echo $row['precio']; ?></p>

                        <form class="carProd" action="agregar_carrito.php" method="POST">
                            <input type="hidden" name="productoID" value="<?php echo $row['ID']; ?>">
                            <input type="number" name="cantidad" value="1" min="1">
                            <input type="hidden" name="vendedorID" value="<?php echo $vendedorID; ?>">  <!-- Añade esta línea -->
                            <button class="btnAgreCar" type="submit">Agregar al Carrito</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
