CREATE SCHEMA `proveedores` DEFAULT CHARACTER SET utf8mb4 ;

use proveedores;

CREATE TABLE usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Usuario VARCHAR(255) NOT NULL,
    CorreoElectronico VARCHAR(255) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    FechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `inventario` (
  `codigoP` smallint(6) NOT NULL,
  `CodigoA` text NOT NULL,
  `Precio` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE `productos` (
  `codigoA` text NOT NULL,
  `descripcion` text NOT NULL,
  `unidad` text NOT NULL,
  `cantidad` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `proveedor` (
  `codigo` smallint(6) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
