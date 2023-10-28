<?php
include("conexion.php");
session_start();
$usuarioI = $_SESSION['username'];
$rol = $_SESSION['rol'];

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
	<div class="vendedores">
		<label class="item" for="t-1">
			<h1><img src="img/fondouno.png" alt=""></h2>
		</label>
		<label class="item" for="t-2">
			<h1>2</h2>
		</label>
		<label class="item" for="t-3">
			<h1>3</h2>
		</label>
		<label class="item" for="t-4">
			<h1>4</h2>
		</label>
		<label class="item" for="t-5">
			<h1>5</h2>
		</label>
	</div>
	<br/>
	<div class="dots">
		<label for="t-1"></label>
		<label for="t-2"></label>
		<label for="t-3"></label>
		<label for="t-4"></label>
		<label for="t-5"></label>
	</div>
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