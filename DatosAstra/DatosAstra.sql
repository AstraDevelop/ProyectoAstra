-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
-- Tiempo de generación: 26-11-2023 a las 21:21:48
=======
-- Tiempo de generación: 27-10-2023 a las 05:02:07
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
-- Tiempo de generación: 21-11-2023 a las 17:55:35
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
-- Tiempo de generación: 26-11-2023 a las 21:21:48
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
=======
-- Tiempo de generación: 27-11-2023 a las 19:12:07
>>>>>>> 462dd7e (Foto del Vendedor)
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
<<<<<<< HEAD
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

-- --------------------------------------------------------

--
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
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
<<<<<<< HEAD
=======
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
(59, 25, 'Pan', 'a', 2500.00, 'uploads/Pan-casero-fácil.webp'),
(60, 25, 'CocaCola', 'a', 1500.00, 'uploads/gaseosa-coca-cola-15-lt.jpg'),
(61, 26, 'Pan De sal', 'h', 3500.00, 'uploads/sandwitch.jpg');
=======
(46, 6, 'Pan careverga', 'Yo ofrezco\r\ndesnudas, vírgenes, intactas y sencillas,\r\npara mis delicias y el placer de mis amigos,\r\nestas noches árabes vividas, soñadas y traducidas sobre su tierra natal y sobre el agua\r\nEllas me fueron dulces durante los ocios en remotos mares, bajo un cielo ahora lejano.\r\nPor eso las doy.\r\n\r\nSencillas, sonrientes y llenas de ingenuidad, como la musulmana Schehrazada, su madre suculenta que las dió a luz en el misterio; fermentando con emoción en los brazos de un príncipe sublime —lúbrico y feroz—, bajo la mirada enternecida de Alah, clemente y misericordioso.', 12000.00, 'uploads/Captura de pantalla 2023-10-25 185330.png'),
(47, 6, 'awebazo', 'awebito currambero', 1234.00, 'uploads/Captura de pantalla 2023-10-26 130340.png');
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
(59, 25, 'Pan', 'a', 2500.00, 'uploads/Pan-casero-fácil.webp'),
(60, 25, 'CocaCola', 'a', 1500.00, 'uploads/gaseosa-coca-cola-15-lt.jpg'),
(61, 26, 'Pan De sal', 'h', 3500.00, 'uploads/sandwitch.jpg');
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
(62, 30, 'Pan', 'ad', 2500.00, 'uploads/Pan-casero-fácil.webp');
>>>>>>> 462dd7e (Foto del Vendedor)

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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
(23, 'cliente', 'cliente', 'cliente@gmail.com', '$2y$10$DzCKXGLPPljB9yy3xz2K7.tHKVM3srKr3HvieVyDwihWV98nF9Lxi', '3', '2023-10-28 21:16:36'),
(24, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(25, 'olimpica', 'JuniorSierraM', 'junior@gmail.com', '$2y$10$TrXEBYq74N4JOZMQ4eRBsOuqet9lkDPdlLU49TAmjCfzDhKchxls2', '2', '2023-11-19 20:34:51'),
(26, 'juni', 'b', '156@gmail.com', '$2y$10$RS/rOov74JblsjVEVD9shelC1bjU9FPe/kUSl.5MFX0yi51IpLx6e', '2', '2023-11-19 22:59:01'),
(27, 'ARA', 'Astra', 'astra@gmail.com', '$2y$10$0vr55r8.aZmu38Imvo.DF.pddABkWjMo4vZCsSfmwDsYLFDOisg2O', '2', '2023-11-26 18:18:19');
=======
(6, 'Astra', 'Astra', 'Astra@gmail.com', '$2y$10$4HOsv/61ojXF81YywuM/R.c2W/V4flT1c9HWzguUp8BHy9l4Zes26', '2', '2023-10-26 22:26:04');
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
(22, 'Astra', 'Astra', 'Astra@gmail.com', '$2y$10$SXbNZExC0xnIe2uUWBJ6zOO1GSmhrm3EshF9PH1gcBZScCnxzpNlO', '2', '2023-10-28 21:15:32'),
(23, 'cliente', 'cliente', 'cliente@gmail.com', '$2y$10$DzCKXGLPPljB9yy3xz2K7.tHKVM3srKr3HvieVyDwihWV98nF9Lxi', '3', '2023-10-28 21:16:36'),
(24, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(25, 'olimpica', 'JuniorSierraM', 'junior@gmail.com', '$2y$10$TrXEBYq74N4JOZMQ4eRBsOuqet9lkDPdlLU49TAmjCfzDhKchxls2', '2', '2023-11-19 20:34:51'),
(26, 'juni', 'b', '156@gmail.com', '$2y$10$RS/rOov74JblsjVEVD9shelC1bjU9FPe/kUSl.5MFX0yi51IpLx6e', '2', '2023-11-19 22:59:01');
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
(23, 'cliente', 'cliente', 'cliente@gmail.com', '$2y$10$DzCKXGLPPljB9yy3xz2K7.tHKVM3srKr3HvieVyDwihWV98nF9Lxi', '3', '2023-10-28 21:16:36'),
(24, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(25, 'olimpica', 'JuniorSierraM', 'junior@gmail.com', '$2y$10$TrXEBYq74N4JOZMQ4eRBsOuqet9lkDPdlLU49TAmjCfzDhKchxls2', '2', '2023-11-19 20:34:51'),
(26, 'juni', 'b', '156@gmail.com', '$2y$10$RS/rOov74JblsjVEVD9shelC1bjU9FPe/kUSl.5MFX0yi51IpLx6e', '2', '2023-11-19 22:59:01'),
(27, 'ARA', 'Astra', 'astra@gmail.com', '$2y$10$0vr55r8.aZmu38Imvo.DF.pddABkWjMo4vZCsSfmwDsYLFDOisg2O', '2', '2023-11-26 18:18:19');
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
=======
(0, 'Junior', 'JuniorSierra', 'juniors@gmail.com', '$2y$10$EfEbjxlYR1fsF7l5Q0sDJOZ548eykiwHRG96EbZSTWt9bFe689.Wu', '3', '2023-11-19 20:34:20'),
(30, 'Olimpica', 'Olimpica', 'olimpica@gmail.com', '$2y$10$VhjHGmnvcTCftp4L0Wx9n.xmAX4Iv5oVP7C4FNCrvE.BA.6snCgm2', '2', '2023-11-27 04:07:28'),
(31, 'Merke+', 'Merke+', 'merke+@gmail.com', '$2y$10$Wnr4fPP113gIII2G.Tl8aOSsTrfzdfL3AqCe064XLpId1iXbmo2Gi', '2', '2023-11-27 17:46:56');
>>>>>>> 462dd7e (Foto del Vendedor)

--
-- Índices para tablas volcadas
--

--
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
-- Indices de la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
<<<<<<< HEAD
=======
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `vendedorID` (`vendedorID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
<<<<<<< HEAD
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);
=======
  ADD PRIMARY KEY (`ID`);
>>>>>>> 60d5df1 (Nuevas implementaciones)

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
<<<<<<< HEAD
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
-- AUTO_INCREMENT de la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
<<<<<<< HEAD
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
<<<<<<< HEAD
=======
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
>>>>>>> 462dd7e (Foto del Vendedor)

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
=======
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
=======
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
>>>>>>> 462dd7e (Foto del Vendedor)

--
-- Restricciones para tablas volcadas
--

--
<<<<<<< HEAD
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
-- Filtros para la tabla `perfil_vendedor`
--
ALTER TABLE `perfil_vendedor`
  ADD CONSTRAINT `perfil_vendedor_fk` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`) ON DELETE CASCADE;

--
<<<<<<< HEAD
=======
>>>>>>> 60d5df1 (Nuevas implementaciones)
=======
>>>>>>> b1833b6 (Cambio la interfas, la base de datos y agrege nuevas ventanas)
=======
>>>>>>> 27ea48f (agregue ventana para agregar foto de perfil (solo vendedor))
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`vendedorID`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
