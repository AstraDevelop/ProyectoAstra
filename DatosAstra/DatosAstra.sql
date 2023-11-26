-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2023 a las 21:21:48
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
(1, 1, 59, 1, 2500.00),
(2, 2, 59, 2, 2500.00),
(3, 3, 59, 1, 2500.00),
(4, 4, 59, 1, 2500.00),
(5, 5, 59, 3, 2500.00),
(6, 6, 59, 2, 2500.00),
(7, 6, 60, 1, 1500.00),
(8, 7, 59, 3, 2500.00),
(9, 7, 60, 2, 1500.00),
(10, 8, 59, 3, 2500.00),
(11, 8, 60, 1, 1500.00),
(12, 9, 59, 7, 2500.00),
(13, 9, 60, 1, 1500.00),
(14, 10, 59, 2, 2500.00),
(15, 10, 60, 2, 1500.00),
(16, 11, 59, 3, 2500.00),
(17, 12, 61, 1, 3500.00),
(18, 14, 59, 1, 2500.00),
(19, 14, 60, 1, 1500.00),
(20, 14, 61, 1, 3500.00),
(21, 15, 61, 1, 3500.00),
(22, 17, 60, 1, 1500.00),
(23, 18, 59, 9, 2500.00),
(24, 18, 60, 4, 1500.00),
(25, 19, 60, 1, 1500.00),
(26, 20, 59, 1, 2500.00);

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
(1, 'JuniorSierra', 'ACEPTADO', '2023-11-19 20:57:03'),
(2, 'JuniorSierra', 'ACEPTADO', '2023-11-19 20:57:46'),
(3, 'JuniorSierra', 'ACEPTADO', '2023-11-19 20:58:01'),
(4, 'JuniorSierra', 'RECHAZADO', '2023-11-19 20:59:17'),
(5, 'JuniorSierra', 'ACEPTADO', '2023-11-19 20:59:39'),
(6, 'JuniorSierra', 'RECHAZADO', '2023-11-19 21:00:49'),
(7, 'JuniorSierra', 'ACEPTADO', '2023-11-19 21:05:17'),
(8, 'JuniorSierra', 'RECHAZADO', '2023-11-19 21:13:14'),
(9, 'JuniorSierra', 'ACEPTADO', '2023-11-19 21:21:23'),
(10, 'JuniorSierra', 'ACEPTADO', '2023-11-19 21:51:28'),
(11, 'JuniorSierra', 'ACEPTADO', '2023-11-19 22:56:24'),
(12, 'JuniorSierra', 'ACEPTADO', '2023-11-19 22:59:50'),
(13, 'JuniorSierra', 'PENDIENTE', '2023-11-19 22:59:50'),
(14, 'JuniorSierra', 'ACEPTADO', '2023-11-19 23:00:24'),
(15, 'JuniorSierra', 'PENDIENTE', '2023-11-20 00:12:22'),
(16, 'JuniorSierra', 'PENDIENTE', '2023-11-20 00:18:46'),
(17, 'JuniorSierra', 'ACEPTADO', '2023-11-20 02:57:18'),
(18, 'JuniorSierra', 'ACEPTADO', '2023-11-21 16:18:20'),
(19, 'JuniorSierra', 'ACEPTADO', '2023-11-21 16:33:31'),
(20, 'JuniorSierra', 'ACEPTADO', '2023-11-21 16:39:32');

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
(0, 'Astra', 'fotosVendedor/sandwitch.jpg', 'mi empresa se dedica a nada');

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
  `imagenProducto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `vendedorID`, `nombreProducto`, `descripcion`, `precio`, `imagenProducto`) VALUES
(59, 25, 'Pan', 'a', 2500.00, 'uploads/Pan-casero-fácil.webp'),
(60, 25, 'CocaCola', 'a', 1500.00, 'uploads/gaseosa-coca-cola-15-lt.jpg'),
(61, 26, 'Pan De sal', 'h', 3500.00, 'uploads/sandwitch.jpg');

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
(23, 'cliente', 'cliente', 'cliente@gmail.com', '$2y$10$DzCKXGLPPljB9yy3xz2K7.tHKVM3srKr3HvieVyDwihWV98nF9Lxi', '3', '2023-10-28 21:16:36'),
(24, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(25, 'olimpica', 'JuniorSierraM', 'junior@gmail.com', '$2y$10$TrXEBYq74N4JOZMQ4eRBsOuqet9lkDPdlLU49TAmjCfzDhKchxls2', '2', '2023-11-19 20:34:51'),
(26, 'juni', 'b', '156@gmail.com', '$2y$10$RS/rOov74JblsjVEVD9shelC1bjU9FPe/kUSl.5MFX0yi51IpLx6e', '2', '2023-11-19 22:59:01'),
(27, 'ARA', 'Astra', 'astra@gmail.com', '$2y$10$0vr55r8.aZmu38Imvo.DF.pddABkWjMo4vZCsSfmwDsYLFDOisg2O', '2', '2023-11-26 18:18:19');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
