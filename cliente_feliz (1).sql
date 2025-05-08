-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2025 a las 00:03:50
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
-- Base de datos: `cliente_feliz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedenteacademico`
--

CREATE TABLE `antecedenteacademico` (
  `id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `institucion` varchar(150) NOT NULL,
  `titulo_obtenido` varchar(150) NOT NULL,
  `anio_ingreso` year(4) DEFAULT NULL,
  `anio_egreso` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `antecedenteacademico`
--

INSERT INTO `antecedenteacademico` (`id`, `candidato_id`, `institucion`, `titulo_obtenido`, `anio_ingreso`, `anio_egreso`) VALUES
(1, 2, 'Universidad de Chile', 'Ingeniería en Computación', '2010', '2015'),
(2, 2, 'Duoc UC', 'Técnico en Informática', '2008', '2010'),
(3, 4, 'Universidad de colombia', 'Ingeniería en procesos', '2010', '2017'),
(5, 8, 'Universidad de Temuco', 'Ingeniería Civil Industrial', '2025', '2039');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentelaboral`
--

CREATE TABLE `antecedentelaboral` (
  `id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `funciones` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `antecedentelaboral`
--

INSERT INTO `antecedentelaboral` (`id`, `candidato_id`, `empresa`, `cargo`, `funciones`, `fecha_inicio`, `fecha_termino`) VALUES
(1, 3, 'SoftTech SPA postmannnnnn postman', 'Desarrollador Web postman postmannnn', 'Diseño e implementación de módulos postman.', '2016-03-01', '2020-12-25'),
(2, 2, 'TechQA Ltda', 'Analista QA', 'Ejecución de pruebas automatizadas.', '2021-01-10', '2024-03-30'),
(3, 9, 'tecnoyupi', 'Analista vibecoder', 'Ejecución de pruebas de vibe code.', '2021-01-11', '2024-03-29'),
(4, 9, 'tecnoyupi', 'Analista vibecoder', 'Ejecución de pruebas de vibe code.', '2021-01-11', '2024-03-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertalaboral`
--

CREATE TABLE `ofertalaboral` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `tipo_contrato` enum('Indefinido','Temporal','Honorarios','Práctica') DEFAULT 'Indefinido',
  `fecha_publicacion` date DEFAULT curdate(),
  `fecha_cierre` date DEFAULT NULL,
  `estado` enum('Vigente','Cerrada','Baja') DEFAULT 'Vigente',
  `reclutador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertalaboral`
--

INSERT INTO `ofertalaboral` (`id`, `titulo`, `descripcion`, `ubicacion`, `salario`, `tipo_contrato`, `fecha_publicacion`, `fecha_cierre`, `estado`, `reclutador_id`) VALUES
(1, 'Desarrollador Backend PHP NODEJS', 'Responsable del desarrollo de todo', 'Santiago poniente, Chile', 14000090.00, '', '2025-05-06', '2026-05-30', 'Cerrada', 1),
(2, 'Analista QA', 'Pruebas funcionales, automatizadas y documentación de bugs.', 'Viña del Mar, Chile', 1100000.00, 'Temporal', '2025-05-06', '2025-05-31', 'Cerrada', 1),
(3, 'Especialista en vibe coding', 'especialista no code.', 'Arica, Chile', 2900090.00, '', '2025-05-06', '2030-06-30', 'Vigente', 2),
(4, 'Ingeniero DevOps', 'Administración de infraestructura en la nube, CI/CD y seguridad de despliegues.', 'Santiago, Chile', 1900000.00, 'Indefinido', '2025-05-08', '2025-06-30', 'Vigente', 7),
(5, 'Ingeniero de Datos', 'Responsable del diseño e implementación de pipelines de datos en la nube.', 'Santiago, Chile', 1800000.00, 'Indefinido', '2025-05-08', '2025-06-15', 'Vigente', 1),
(6, 'Desarrollador Full Stack', 'Encargado del desarrollo y mantenimiento de aplicaciones web utilizando tecnologías frontend y backend modernas.', 'Valparaíso, Chile', 1600000.00, 'Temporal', '2025-05-08', '2025-06-10', '', 2),
(7, 'Especialista en vibe coding senior', 'especialista vibe coding.', 'Antartica, Chile', 20900000.00, '', '2025-05-08', '2030-06-20', 'Vigente', 2),
(8, 'Especialista en vibe coding senior', 'especialista vibe coding.', 'Antartica, Chile', 20900000.00, '', '2025-05-08', '2030-06-20', 'Vigente', 2),
(9, 'Desarrollador Full Stack', 'Encargado del desarrollo y mantenimiento de aplicaciones web utilizando tecnologías frontend y backend modernas.', 'Valparaíso, Chile', 1600000.00, 'Temporal', '2025-05-08', '2025-06-10', 'Vigente', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `oferta_laboral_id` int(11) NOT NULL,
  `estado_postulacion` enum('Postulando','Revisando','Entrevista Psicológica','Entrevista Personal','Seleccionado','Descartado') DEFAULT 'Postulando',
  `comentario` text DEFAULT NULL,
  `fecha_postulacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulacion`
--

INSERT INTO `postulacion` (`id`, `candidato_id`, `oferta_laboral_id`, `estado_postulacion`, `comentario`, `fecha_postulacion`, `fecha_actualizacion`) VALUES
(1, 2, 1, 'Descartado', 'no se presento', '2025-05-06 05:18:45', '2025-05-08 04:00:56'),
(2, 3, 2, 'Entrevista Personal', 'Candidato citado a entrevista por experiencia en QA.', '2025-05-06 05:18:45', '2025-05-08 02:58:15'),
(3, 4, 3, 'Postulando', 'comentario de postulacion', '2025-09-06 05:18:40', '2025-05-08 21:14:34'),
(5, 9, 4, 'Postulando', '.', '2025-05-08 04:22:53', '2025-05-08 04:22:53'),
(6, 6, 6, NULL, 'Postulación iniciada.', '2025-05-08 16:53:23', '2025-05-08 16:53:23'),
(7, 9, 6, 'Postulando', 'Postulación iniciada.', '2025-05-08 22:59:46', '2025-05-08 22:59:46'),
(9, 6, 4, 'Postulando', 'nueva postulacion postman', '2025-05-18 04:22:53', '2025-05-28 04:22:53'),
(10, 6, 4, 'Postulando', 'nueva postulacion postman', '2025-05-18 04:22:53', '2025-05-28 04:22:53'),
(11, 6, 4, 'Postulando', 'nueva postulacion postman', '2025-05-18 04:22:53', '2025-05-28 04:22:53'),
(12, 6, 4, 'Postulando', 'nueva postulacion postman', '2025-05-18 04:22:53', '2025-05-28 04:22:53'),
(13, 5, 9, 'Postulando', 'Postulación iniciada.', '2025-05-09 03:48:29', '2025-05-09 03:48:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `rol` enum('Reclutador','Candidato') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `contrasena`, `fecha_nacimiento`, `telefono`, `direccion`, `rol`, `fecha_registro`, `estado`) VALUES
(1, 'Laura', 'Ramíreza', 'laura.ramirez@empresa.cl', '$2y$10$6ZQVWLnzAjiRZmM3PygXH.jtmczXurtc/qKjQMT9kQul1nzD/ONM6', '1980-05-20', '987654321', 'Av. Apoquindo 1234, Las Condes', 'Reclutador', '2025-05-06 05:18:45', 'Activo'),
(2, 'Laura postman', 'Ramírez postman', 'laura.ramirez@postman.cl', '$2y$10$sfPgqJowjnpABagNFxWwY.naXL9n74ClnlchroJZvK4yw5OaNpGIa', '1989-05-20', '98765432999991', 'Postmanero, Las postman', 'Reclutador', '2025-05-06 05:18:45', 'Activo'),
(3, 'Ana', 'Rojas', 'chanchitodetierra@gmail.com', '$2y$10$kHrNvJnyCdYFMQAqDrIWFeDixYFmyI7OVxfuPo9luuXhGBWMn5Fwm', '1990-08-15', '987654321', 'Av. Providencia 1', 'Candidato', '2025-05-07 01:03:18', 'Activo'),
(4, 'Valentina', 'González', 'valentina.gonzalez@correo.com', '$2y$10$LWoqe6asBUuBEgEOmIs3vubhSGuO7sZmvmljrFOa3GXOUYhxyhxWC', '1988-04-12', '987654321', 'Calle Los Pensamientos 321', 'Candidato', '2025-05-07 01:48:02', 'Activo'),
(5, 'Marcelo', 'Fernández', 'mfernandez@example.com', '$2y$10$Bg5g8GzdvZhbt0AnKPVk.eaRBCq1YlRhTedWAyVeE0tUgfZQUfNyW', '1988-04-22', '912345678', 'Calle Falsa 123', 'Candidato', '2025-05-08 01:00:53', 'Activo'),
(6, 'Marcela', 'Vergara', 'marcela.vergara@example.com', '$2y$10$lg1/d4aFY1/mDNl/35mc/Os/2Poa6Wj8SANy8lqX72XqxRuTRRZA.', '1989-06-15', '987654321', 'Av. Providencia 1234', 'Candidato', '2025-05-08 02:54:21', 'Activo'),
(7, 'Rodrigo', 'Salazar', 'rodrigo.salazar@example.com', '$2y$10$RTBpe0a4AAax01J8hxUgUe5b9G7WZ1J5P0QBn2HjgHhYqDe.PPXSy', '1992-10-03', '981234567', 'Pasaje Las Rosas 456', 'Reclutador', '2025-05-08 02:55:17', 'Activo'),
(8, 'Valentina', 'Campos', 'valentina.campos@example.com', '$2y$10$QqsBwhiOuc3hbvWVvMTxsuWawMRWNzS0R2yjaU5r7pqGX7HpmCHly', '1994-03-28', '987112233', 'Calle Los Leones 110', 'Candidato', '2025-05-08 02:56:23', 'Activo'),
(9, 'Esteban', 'Moya', 'esteban.moya@example.com', '$2y$10$qb0ztZdokwI77kn2aRkCB.iIAqsnmwsH5Eo/g1/rpzAyOVktXLGQe', '1991-11-09', '989998877', 'Av. Santa María 820', 'Candidato', '2025-05-08 02:56:29', 'Activo'),
(10, 'andrekkkks', 'corbackkkkkho', 'chanchitoderra@gmail.com', '$2y$10$v8gfgMvmWk3UBo4HlRSgJO4payDEXNFRMXdrK9FFgR2kzsIG64xUu', '1990-08-15', '999056391', 'Av. Providencia 1', 'Candidato', '2025-05-08 18:10:32', 'Activo'),
(11, 'Juan Pérez', 'corbacho', 'juan@example.com', '$2y$10$Ke60uotIyv87wSoUa5o5SOvazKsXLYEGySxBTFgMsCgOGcGx/RvOS', NULL, NULL, NULL, 'Candidato', '2025-05-08 18:22:55', 'Activo'),
(12, 'test', 'postman', 'postman@postman', '$2y$10$TWXwjbulZLs.vuFLW02KH.xBKQEodU0igbBrKQG3RPu0wpFTVT.la', '1860-05-20', '123456789', 'El Salto, recoleta', 'Candidato', '2025-05-08 18:46:03', 'Inactivo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedenteacademico`
--
ALTER TABLE `antecedenteacademico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidato_id` (`candidato_id`);

--
-- Indices de la tabla `antecedentelaboral`
--
ALTER TABLE `antecedentelaboral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidato_id` (`candidato_id`);

--
-- Indices de la tabla `ofertalaboral`
--
ALTER TABLE `ofertalaboral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reclutador_id` (`reclutador_id`);

--
-- Indices de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidato_id` (`candidato_id`),
  ADD KEY `oferta_laboral_id` (`oferta_laboral_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedenteacademico`
--
ALTER TABLE `antecedenteacademico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `antecedentelaboral`
--
ALTER TABLE `antecedentelaboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ofertalaboral`
--
ALTER TABLE `ofertalaboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `antecedenteacademico`
--
ALTER TABLE `antecedenteacademico`
  ADD CONSTRAINT `antecedenteacademico_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `antecedentelaboral`
--
ALTER TABLE `antecedentelaboral`
  ADD CONSTRAINT `antecedentelaboral_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `ofertalaboral`
--
ALTER TABLE `ofertalaboral`
  ADD CONSTRAINT `ofertalaboral_ibfk_1` FOREIGN KEY (`reclutador_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD CONSTRAINT `postulacion_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `postulacion_ibfk_2` FOREIGN KEY (`oferta_laboral_id`) REFERENCES `ofertalaboral` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
