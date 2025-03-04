-- Estructura de tabla para la tabla `users`
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,  -- Clave primaria única
    `identificacion` VARCHAR(50) NOT NULL UNIQUE,  -- Único, pero NO clave primaria
    `tipo_doc` ENUM('CC', 'TI', 'CE', 'PASAPORTE') NOT NULL,
    `nombres` VARCHAR(100) NOT NULL,
    `apellidos` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `telefono` VARCHAR(20) NOT NULL,
    `clave` VARCHAR(32) NOT NULL,
    `rol` ENUM('Cliente', 'Instructor', 'Administrador') NOT NULL,
    `estado` ENUM('Pendiente', 'Activo', 'Suspendido') NOT NULL DEFAULT 'Pendiente',
    `foto` VARCHAR(255) DEFAULT NULL,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Volcado de datos para la tabla `users`
INSERT INTO `users` (`identificacion`, `tipo_doc`, `nombres`, `apellidos`, `email`, `telefono`, `clave`, `rol`, `estado`, `foto`) VALUES
(123, 'CC', 'Miguel Angel', 'Gallego Restrepo', 'miguel@gmail.com', 3212334455, '202cb962ac59075b964b07152d234b70', 'Administrador', 'Activo', '');

COMMIT;

