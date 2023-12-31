<?php
include("conexion.php");
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
    $rol = $_SESSION['rol'];
    if ($rol == 2) {
        header("location: vendedor.php");
        exit;
    } elseif ($rol == 3) {
        header("location: comprador.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/logo.jpg" />
    <link rel="stylesheet" href="style.css" />
    <title>ASTRA</title>
  </head>

  <body>
    <div class="inicio">
      <header>
        <a href="">
          <h2 class="logo">ASTRA</h2>
        </a>
        <nav class="navigation">
          <a href="login.php"
            ><button class="btnLogin">INICIAR SESION</button></a
          >
        </nav>
      </header>
      <section id="section-1">
        <h1>Quienes Somos</h1>
        <div class="parrafos">
            <p>
              En <span>ASTRA</span>, creemos en la transformación digital de la
              manera en que las personas y las empresas realizan pedidos. Fundada en
              2023, nuestra misión es simplificar y agilizar el proceso de toma de
              pedidos a través de soluciones tecnológicas innovadoras.
            </p>
            <br>
            <p>
              Somos un equipo apasionado de profesionales dedicados a brindar
              soluciones eficientes y prácticas para la gestión de pedidos en línea.
              En
              <span>ASTRA</span> hemos desarrollado una plataforma robusta y fácil
              de usar que se adapta a las necesidades de empresas de todos los
              tamaños, desde pequeñas startups hasta corporaciones multinacionales.
              Nuestra visión es ser líderes en el mercado de la toma de pedidos en
              línea, ofreciendo a nuestros clientes una ventaja competitiva al
              proporcionarles herramientas que les permitan optimizar sus
              operaciones y mejorar la experiencia de compra de sus clientes.
            </p>
            <br>
            <p>
              Estamos comprometidos con la innovación constante y la mejora continua
              de nuestra plataforma para garantizar que sigamos siendo un socio
              confiable para todas las empresas que buscan simplificar sus procesos
              de pedidos
            </p>
        </div>
      </section>
    </div>
  </body>
</html>
