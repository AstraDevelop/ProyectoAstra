<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.php');
    exit();
}

$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : "";

// Consulta SQL para obtener todos los vendedores y su último producto
$sql = "SELECT u.ID AS vendedorID, u.Nombre, p.imagenProducto, p.nombreProducto
        FROM usuarios u 
        LEFT JOIN (
            SELECT vendedorID, imagenProducto, nombreProducto 
            FROM productos 
            WHERE ID IN (
                SELECT MAX(ID) 
                FROM productos 
                GROUP BY vendedorID
            )
        ) p ON p.vendedorID = u.ID 
        WHERE u.Rol = '2' 
        AND u.Nombre LIKE '%$busqueda%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="css/comprador.css">
    <title>Comprador - ASTRA</title>
</head>
<body>
    <header>
        <a href="index.php">
            <h2 class="logo">ASTRA</h2>
        </a>
        
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
    <h1 class="titulo">Tiendas</h1>
    <section class="contenedor">
        <div class="contenedor-items">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="item-tienda">
                    <a href="catalogo.php?vendedorID=<?php echo $row['vendedorID'];?>">
                    <span class="titulo-item">
                        <?php echo $row['Nombre']; ?>
                    </span>
                    <?php if($row['imagenProducto']): ?>
                    <img class="img-item" src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>">              
                    <p>Ultimo producto agregado</p>
                    <?php else: ?>
                        <p>Este vendedor aún no tiene productos.</p>
                    <?php endif; ?>
                    <button class="boton-item">Ver Productos</button>
                    </a>
                    </div>
                <?php endwhile; ?>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>