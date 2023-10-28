<?php
$rol = $_GET['rol'] ?? ""; // Recupera el valor del parámetro "rol" de la URL

if ($rol === "2") {
    header("Location: vendedor.php"); // Redirige a vendedor.php si el rol es "2"
} elseif ($rol === "3") {
    header("Location: comprador.php"); // Redirige a comprador.php si el rol es "3"
} else {
    // Maneja otros casos o errores aquí, por ejemplo, redirigir a una página por defecto.
    header("Location: otra_pagina.php");
}

exit; // Asegúrate de salir después de la redirección.
?>
