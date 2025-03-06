-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-03-2025 a las 18:00:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sembrar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `Id_ambiente` int(11) NOT NULL,
  `nombre_ambiente` varchar(100) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`Id_ambiente`, `nombre_ambiente`, `disponible`) VALUES
(1, '101 Laboratorio Ambiental', 1),
(2, '102 Aula de Sistemas - TIC', 1),
(3, '103 Gestion Administrativa', 1),
(4, '104 Sala Instructores', 1),
(5, '105A Aula BOSH', 1),
(6, '105B Taller BOSH', 1),
(7, '106A Aula Festo ', 1),
(8, '106B Taller Festo', 1),
(9, '107 Aula Sistemas', 1),
(10, '108 Laboratorio Fisico Quimico', 1),
(11, '109 Aula Sistemas', 1),
(12, '110 Aula sistemas', 1),
(13, '111 Wimpy', 1),
(14, '112 Taller Cocina', 1),
(15, '113 Pasteleria', 1),
(16, '114 Taller de Suelos', 1),
(17, '115 Aula', 1),
(18, '116 Taller Audiovisuales', 1),
(19, '117 Aula', 1),
(20, '118 Mecanica', 1),
(21, '119 Taller de Soldadura', 1),
(22, '120 Torre de Alturas', 1),
(23, '121 Laboratorio Alcoholes', 1),
(24, '122A Aula de Musica', 1),
(25, '122B Emisora', 1),
(26, '123 Taller Automotriz', 1),
(27, '124 Hotel Practivo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--
CREATE TABLE `users` (
    `identificacion` VARCHAR(50) NOT NULL PRIMARY KEY,  
    `tipo_doc` ENUM('CC', 'TI', 'CE', 'PASAPORTE') NOT NULL,
    `nombres` VARCHAR(100) NOT NULL,
    `apellidos` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `telefono` VARCHAR(20) NOT NULL,
    `clave` VARCHAR(32) NOT NULL,
    `rol` ENUM('Cliente', 'Instructor', 'Administrador') NOT NULL,
    `estado` ENUM('Pendiente', 'Activo', 'Suspendido') NOT NULL DEFAULT 'Pendiente',
    `tipo_formacion` ENUM('Bilingüismo', 'Transversales', 'Técnica', 'N/A') NOT NULL DEFAULT 'N/A',
    `foto` VARCHAR(255) DEFAULT NULL,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Volcado de datos para la tabla `users`
--
INSERT INTO `users` (`identificacion`, `tipo_doc`, `nombres`, `apellidos`, `email`, `telefono`, `clave`, `rol`, `estado`, `tipo_formacion`, `foto`) VALUES
('123', 'CC', 'Miguel Angel', 'Gallego Restrepo', 'miguel@gmail.com', '3212334455', '202cb962ac59075b964b07152d234b70', 'Administrador', 'Activo', 'Técnica', '');

-- --------------------------------------------------------

--
-- Índices para tablas volcadas
--

--
-- Índices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`Id_ambiente`);

-- No se agrega nuevamente la clave primaria a `users` porque ya está definida en la creación de la tabla

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
