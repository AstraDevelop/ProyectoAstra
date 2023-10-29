<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

if (!isset($usuarioI) || $rol != '3') {
    header('location: index.html');
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
    <link rel="stylesheet" href="styles-I-R.css">
    <title>Comprador - ASTRA</title>
</head>

<body id="body">
    <div class="container" id="compradorPage">
        <header>
            <a href="index.html">
                <h2 class="logo">ASTRA</h2>
            </a>
                <!-- Barra de búsqueda -->
                <form action="comprador.php" method="GET" id="comp-searchForm">
                    <input type="text" name="buscar" placeholder="Buscar">
                    <button class="btnBuscar" type="submit">Buscar</button>
                </form>
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
        
        <!-- Mostrar vendedores y su último producto -->
        <h1>Tiendas</h1>
        <div class="comp-vendedores">
            <?php while($row = $result->fetch_assoc()): ?>
                <a href="catalogo.php?vendedorID=<?php echo $row['vendedorID'];?>">
                    <div class="comp-vendedor">
                        <h3>
                            <?php echo $row['Nombre']; ?>
                        </h3>
                        <?php if($row['imagenProducto']): ?>
                        <img src="<?php echo $row['imagenProducto']; ?>" alt="<?php echo $row['nombreProducto']; ?>">              
                        <?php else: ?>
                            <p>Este vendedor aún no tiene productos.</p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
