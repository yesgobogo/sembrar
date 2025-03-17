-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2025 a las 18:04:49
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
  `disponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Disponible, 0 = Ocupado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`Id_ambiente`, `nombre_ambiente`, `disponible`) VALUES
(1, '101 Laboratorio Ambiental', 1),
(2, '102 Aula de Sistemas - TIC', 1),
(3, '103 Gestión Administrativa', 1),
(4, '104 Sala Instructores', 1),
(5, '105A Aula BOSH', 1),
(6, '105B Taller BOSH', 1),
(7, '106A Aula Festo', 1),
(8, '106B Taller Festo', 1),
(9, '107 Aula Sistemas', 1),
(10, '108 Laboratorio Físico Químico', 1),
(11, '109 Aula Sistemas', 1),
(12, '110 Aula Sistemas', 1),
(13, '111 Wimpy', 1),
(14, '112 Taller Cocina', 1),
(15, '113 Pastelería', 1),
(16, '114 Taller de Suelos', 1),
(17, '115 Aula', 1),
(18, '116 Taller Audiovisuales', 1),
(19, '117 Aula', 1),
(20, '118 Mecánica', 1),
(21, '119 Taller de Soldadura', 1),
(22, '120 Torre de Alturas', 1),
(23, '121 Laboratorio Alcoholes', 1),
(24, '122A Aula de Música', 1),
(25, '122B Emisora', 1),
(26, '123 Taller Automotriz', 1),
(27, '124 Hotel Práctico', 1)
(28, '125 Ajedrez', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `identificacion` varchar(50) NOT NULL,
  `tipo_doc` enum('CC','TI','CE','PASAPORTE') NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `rol` enum('Cliente','Instructor','Administrador') NOT NULL,
  `estado` enum('Pendiente','Activo','Suspendido') NOT NULL DEFAULT 'Pendiente',
  `tipo_formacion` enum('Bilingüismo','Transversales','Técnica','N/A') NOT NULL DEFAULT 'N/A',
  `foto` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`identificacion`, `tipo_doc`, `nombres`, `apellidos`, `email`, `telefono`, `clave`, `rol`, `estado`, `tipo_formacion`, `foto`, `fecha_registro`) VALUES
('123', 'CC', 'Miguel Angel', 'Gallego Restrepo', 'miguel@gmail.com', '3212334455', '202cb962ac59075b964b07152d234b70', 'Administrador', 'Activo', 'Técnica', '', '2025-03-07 16:50:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`Id_ambiente`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`identificacion`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `Id_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
