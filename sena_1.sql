-- Configuración inicial
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `sena` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sena`;

-- --------------------------------------------------------
-- Tabla: ambientes
-- --------------------------------------------------------
CREATE TABLE `ambientes` (
  `Id_ambiente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_ambiente` varchar(100) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id_ambiente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos en ambientes
INSERT INTO `ambientes` (`nombre_ambiente`, `disponible`) VALUES
('101 Laboratorio ambiental', 1),
('102 Aula de sistemas - TIC', 1),
('103 Gestión administrativa', 1),
('105A Aula Bosh - Taller', 1),
('106A Aula Festo - Taller', 1),
('107 Aula sistemas', 1),
('108 Laboratorio físico químico', 1),
('109 Aula sistemas', 1),
('110 Aula sistemas', 1),
('111 Wimpy', 1),
('112 Taller cocina', 1),
('113 Pastelería', 1),
('114 Taller de suelos', 1),
('115 Aula', 1),
('116 Taller audiovisuales', 1),
('117 Aula', 1),
('118 Mecánica', 1),
('119 Taller Soldadura', 1),
('120 Torre de alturas', 1),
('121 Laboratorio alcoholes', 1),
('122 A-B Aula de Música-Emisora', 1),
('123 Taller automotriz', 1),
('124 Hotel práctico', 1),
('125 Ajedrez', 1);

-- --------------------------------------------------------
-- Tabla: users
-- --------------------------------------------------------
CREATE TABLE `users` (
  `identificacion` varchar(50) NOT NULL,
  `tipo_doc` enum('CC','TI','CE','PASAPORTE') NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `telefono` varchar(20) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `rol` enum('Instructor','Administrador') NOT NULL,
  `estado` enum('Pendiente','Activo','Suspendido') NOT NULL DEFAULT 'Pendiente',
  `tipo_formacion` enum('Bilingüismo','Transversales','Técnica','N/A') NOT NULL DEFAULT 'N/A',
  `foto` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos en users
INSERT INTO `users` (`identificacion`, `tipo_doc`, `nombres`, `apellidos`, `email`, `telefono`, `clave`, `rol`, `estado`, `tipo_formacion`, `foto`) VALUES
('109', 'CE', 'Mariano', 'Agudelo', 'mari5911@gmail.com', '310323', '2723d092b63885e0d7c260cc007e8b9d', 'Administrador', 'Activo', 'N/A', NULL),
('123', 'CC', 'Miguel Angel', 'Gallego Restrepo', 'miguel@gmail.com', '3212334455', '202cb962ac59075b964b07152d234b70', 'Administrador', 'Activo', 'Técnica', ''),
('9906', 'CC', 'Norma', 'Escobar', 'norma34@gmail.com', '3452', 'c5383525e91474a4e5d7dcfee92c054f', 'Instructor', 'Pendiente', 'Bilingüismo', NULL);

-- --------------------------------------------------------
-- Tabla: inventario
-- --------------------------------------------------------
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ambiente` int(11) NOT NULL,
  `cedula_cuentadante` varchar(50) NOT NULL,
  `descripcion_elemento` text NOT NULL,
  `numero_placa` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_ambiente` (`id_ambiente`),
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`Id_ambiente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: registro_entrada
-- --------------------------------------------------------
CREATE TABLE `registro_entrada` (
  `id_registro` int AUTO_INCREMENT NOT NULL,
  `fecha_hora_entrada` datetime DEFAULT current_timestamp(),
  `nombre_completo_sale` varchar(200) DEFAULT NULL,
  `nombre_completo_entra` varchar(200) DEFAULT NULL,
  `jornada` ENUM('Mañana', 'Tarde', 'Noche') NOT NULL DEFAULT 'Mañana',
  `novedades` text DEFAULT NULL,
  `id_usuario` varchar(50) DEFAULT NULL,
  `id_ambiente` int DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_ambiente` (`id_ambiente`),
  CONSTRAINT `registro_entrada_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`identificacion`),
  CONSTRAINT `registro_entrada_ibfk_2` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`Id_ambiente`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: registro_salida
-- --------------------------------------------------------
CREATE TABLE `registro_salida` (
  `id_registro` int AUTO_INCREMENT NOT NULL,
  `fecha_hora_salida` datetime DEFAULT current_timestamp(),
  `nombre_completo_sale` varchar(200) DEFAULT NULL,
  `nombre_completo_entra` varchar(200) DEFAULT NULL,
  `jornada` ENUM('Mañana', 'Tarde', 'Noche') NOT NULL DEFAULT 'Mañana',
  `novedades` text DEFAULT NULL,
  `id_usuario` varchar(50) DEFAULT NULL,
  `id_ambiente` int DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_ambiente` (`id_ambiente`),
  CONSTRAINT `registro_salida_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`identificacion`),
  CONSTRAINT `registro_salida_ibfk_2` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`Id_ambiente`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
