-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2023 a las 22:04:03
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `datosastra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID` int(11) NOT NULL,
  `usuarioNombre` varchar(255) NOT NULL,
  `productoID` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fechaAgregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `ID` int(11) NOT NULL,
  `pedidoID` int(11) NOT NULL,
  `productoID` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`ID`, `pedidoID`, `productoID`, `cantidad`, `precio`) VALUES
(27, 21, 62, 1, 2500.00),
(28, 22, 62, 10, 2500.00),
(29, 23, 62, 1, 2500.00),
(30, 24, 62, 1, 2500.00),
(31, 25, 62, 10, 2500.00),
(32, 26, 62, 10, 2500.00),
(33, 26, 63, 3, 3500.00),
(34, 27, 62, 1, 2500.00),
(35, 28, 62, 2, 2500.00),
(36, 29, 62, 7, 2500.00),
(37, 30, 62, 8, 2500.00),
(38, 31, 62, 1, 2500.00),
(39, 32, 62, 6, 2500.00),
(40, 33, 63, 3, 3500.00),
(41, 34, 63, 3, 3500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID` int(11) NOT NULL,
  `usuarioNombre` varchar(255) NOT NULL,
  `estado` enum('PENDIENTE','ACEPTADO','RECHAZADO') NOT NULL,
  `fechaRealizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID`, `usuarioNombre`, `estado`, `fechaRealizado`) VALUES
(21, 'JuniorSierra', 'ACEPTADO', '2023-11-27 18:49:06'),
(22, 'JuniorSierra', 'RECHAZADO', '2023-11-27 19:53:45'),
(23, 'JuniorSierra', 'ACEPTADO', '2023-11-27 19:58:31'),
(24, 'JuniorSierra', 'RECHAZADO', '2023-11-27 19:58:46'),
(25, 'JuniorSierra', 'RECHAZADO', '2023-11-27 20:00:12'),
(26, 'JuniorSierra', 'RECHAZADO', '2023-11-27 20:01:06'),
(27, 'JuniorSierra', 'ACEPTADO', '2023-11-27 20:27:19'),
(28, 'JuniorSierra', 'ACEPTADO', '2023-11-27 20:28:33'),
(29, 'JuniorSierra', 'ACEPTADO', '2023-11-27 20:30:01'),
(30, 'JuniorSierra', 'RECHAZADO', '2023-11-27 20:32:04'),
(31, 'JuniorSierra', 'ACEPTADO', '2023-11-27 20:32:55'),
(32, 'JuniorSierra', 'ACEPTADO', '2023-11-27 20:33:35'),
(33, 'JuniorSierra', 'RECHAZADO', '2023-11-27 20:45:11'),
(34, 'JuniorSierra', 'PENDIENTE', '2023-11-27 20:51:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_vendedor`
--

CREATE TABLE `perfil_vendedor` (
  `ID` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `FotoPerfil` varchar(255) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil_vendedor`
--

INSERT INTO `perfil_vendedor` (`ID`, `Usuario`, `FotoPerfil`, `Descripcion`) VALUES
(1, 'Olimpica', 'fotosVendedor/Olimpica_512px-Olimpical.webp', 'Chars'),
(3, 'Merke+', 'fotosVendedor/Merke+_descarga (1).jpeg', 'merka mas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `vendedorID` int(11) DEFAULT NULL,
  `nombreProducto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagenProducto` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `vendedorID`, `nombreProducto`, `descripcion`, `precio`, `imagenProducto`, `stock`) VALUES
(62, 30, 'Pan', 'ad', 2500.00, 'uploads/Pan-casero-fácil.webp', 0),
(63, 30, 'CocaCola', 'asdsad', 3500.00, 'uploads/gaseosa-coca-cola-15-lt.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `CorreoElectronico` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Rol` enum('1','2','3') NOT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Usuario`, `CorreoElectronico`, `Contraseña`, `Rol`, `FechaRegistro`) VALUES
(0, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(30, 'Olimpica', 'Olimpica', 'olimpica@gmail.com', '$2y$10$VhjHGmnvcTCftp4L0Wx9n.xmAX4Iv5oVP7C4FNCrvE.BA.6snCgm2', '2', '2023-11-27 04:07:28'),
(31, 'Merke+', 'Merke+', 'merke+@gmail.com', '$2y$10$Wnr4fPP113gIII2G.Tl8aOSsTrfzdfL3AqCe064XLpId1iXbmo2Gi', '2', '2023-11-27 17:46:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `usuarioNombre` (`usuarioNombre`),
  ADD KEY `productoID` (`productoID`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `pedidoID` (`pedidoID`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `vendedorID` (`vendedorID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuarioNombre`) REFERENCES `usuarios` (`Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`productoID`) REFERENCES `productos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedidoID`) REFERENCES `pedidos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  ADD CONSTRAINT `perfil_vendedor_fk` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`vendedorID`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
