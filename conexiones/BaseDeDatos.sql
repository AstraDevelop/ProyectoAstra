-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2023 a las 06:30:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4


/*------Crea una base de datos de se llame "proveedores" con el siguinte comando: CREATE DATABASE proveedores;-------*/


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proveedores`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Usuario VARCHAR(255) NOT NULL,
    CorreoElectronico VARCHAR(255) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    FechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `codigoP` smallint(6) NOT NULL,
  `CodigoA` text NOT NULL,
  `Precio` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- insertar datos para la tabla `inventario`
--

INSERT INTO `inventario` (`codigoP`, `CodigoA`, `Precio`) VALUES
(1, '1.01.01', 70),
(2, '1.01.01', 80),
(3, '1.01.01', 75),
(2, '2.01.01', 50),
(1, '4.01.03', 450);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigoA` text NOT NULL,
  `descripcion` text NOT NULL,
  `unidad` text NOT NULL,
  `cantidad` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- insertar datos para la tabla `productos`
--

INSERT INTO `productos` (`codigoA`, `descripcion`, `unidad`, `cantidad`) VALUES
('1.01.01', 'CD-ROM', 'Unidad', 10),
('1.01.02', 'Disco ATA', 'Unidad', 20),
('2.01.01', 'Sonido de 16 bits', 'Unidad', 5),
('4.01.03', 'Pentium II 800 Mhz', 'Unidad', 9),
('1.02.01', 'Disco Flexible', 'Caja de 10', 20),
('3.01.01', 'Papel Carta para Impresora', 'Resma 100 Hojas', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codigo` smallint(6) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tnsertar datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codigo`, `nombre`, `telefono`, `direccion`) VALUES
(1, 'Inca Tel', '4923-4803', 'Av. La Plata 365'),
(2, 'Infocad', '4633-2520', 'Doblas 1578'),
(3, 'Herrera Campusistem', '4232-7711', 'Av. rivadavia 3558'),
(4, 'Julio', '6632567', 'Yo vivo Aqui'),
(5, 'Maria', '66328885', 'Yo vivo Allá');
COMMIT;