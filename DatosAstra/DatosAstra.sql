CREATE DATABASE datosastra;

USE datosastra;

CREATE TABLE usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Usuario VARCHAR(255) NOT NULL,
    CorreoElectronico VARCHAR(255) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    Rol ENUM('1', '2', '3') NOT NULL,
    FechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
