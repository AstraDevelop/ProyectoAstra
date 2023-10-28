<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];
$dontshow = 0;
$sqlVendedores = "SELECT * FROM `productos` ORDER BY `productos`.`ID` ASC ";
$resultSqlVendedores = $conn->query($sqlVendedores);
if(!$resultSqlVendedores){
	die("Error con la base de datos: " . $conn->error);
}
$index = 0;
$pics = array_fill(0, 5, null);
if($resultSqlVendedores->num_rows > 0) {
	while($fetchData = $resultSqlVendedores->fetch_assoc()){
		$vendedorPicPath = $fetchData['imagenProducto'];
		$pics[$index] = $vendedorPicPath;
		$index++;
	}
    
} else {
    $dontshow = 1;
}

// Si el usuario ha iniciado sesión, se ejecuta esto
if (isset($usuarioI) && ($rol == 3)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpg">
    <link rel="stylesheet" href="comprador.css">
    <title>ASTRA</title>
	
	<style>
	.vendedores {
		visibility: <?php if($dontshow==1){echo "Hidden";}else{echo "visible";} ?>
	}

	</style>
</head>

<body>
    <div class="inicio">
        <header>
            <a href="">
                <h2 class="logo">ASTRA</h2>
            </a>
            <nav class="navigation">
                <a href="perfil.php"><button class="btnLogin">Ver Perfil</button></a>
                <a href="cerrarSesion.php"><button class="btnLogin cerrarSesion">CERRAR SESION</button></a>
            </nav>
        </header>
        <Section id="fondo">
        <div class="slider">
	<input type="radio" name="vendedor" id="t-1">
	<input type="radio" name="vendedor" id="t-2">
	<input type="radio" name="vendedor" id="t-3" checked>
	<input type="radio" name="vendedor" id="t-4">
	<input type="radio" name="vendedor" id="t-5">
	<div class="vendedores" >
		<label class="item" for="t-1">
			<h1><img src="<?php echo $pics[0]; ?>"	 alt="" id="vendedor-1"></h2>
		</label>
		<label class="item" for="t-2">
			<h1><img src="<?php echo $pics[1]; ?>"	 alt="" id="vendedor-2" ></h2>
		</label>
		<label class="item" for="t-3">
			<h1><img src="<?php echo $pics[2]; ?>"	 alt="" id="vendedor-3"></h2>
		</label>
		<label class="item" for="t-4">
			<h1><img src="<?php echo $pics[3]; ?>"	 alt="" id="vendedor-4"></h2>
		</label>
		<label class="item" for="t-5">
			<h1><img src="<?php echo $pics[4]; ?>"	 alt="" id="vendedor-5"></h2>
		</label>
	</div>
	<br/>
	
</div>

        </Section>
        
    </div>
</body>



</html>
<?php
}else {
    header('location: index.html');
}
?>
