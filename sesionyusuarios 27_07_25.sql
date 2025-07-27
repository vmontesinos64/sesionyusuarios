-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2025 a las 12:46:23
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
-- Base de datos: `sesionyusuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol` enum('super-user','profesor','alumno') NOT NULL,
  `recurso` varchar(100) NOT NULL,
  `acceso` enum('permitido','denegado') DEFAULT 'denegado',
  `requiere_validacion` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol`, `recurso`, `acceso`, `requiere_validacion`) VALUES
(148, 'super-user', 'config/db.php', 'permitido', 0),
(149, 'profesor', 'config/db.php', 'permitido', 0),
(150, 'alumno', 'config/db.php', 'permitido', 0),
(151, 'super-user', 'config/session.php', 'permitido', 0),
(152, 'profesor', 'config/session.php', 'permitido', 0),
(153, 'alumno', 'config/session.php', 'permitido', 0),
(154, 'super-user', 'includes/auth.php', 'permitido', 0),
(155, 'profesor', 'includes/auth.php', 'permitido', 0),
(156, 'alumno', 'includes/auth.php', 'permitido', 0),
(157, 'super-user', 'includes/toast.php', 'permitido', 0),
(158, 'profesor', 'includes/toast.php', 'permitido', 0),
(159, 'alumno', 'includes/toast.php', 'permitido', 0),
(160, 'super-user', 'index.php', 'permitido', 0),
(161, 'profesor', 'index.php', 'permitido', 0),
(162, 'alumno', 'index.php', 'permitido', 0),
(163, 'super-user', 'login.php', 'permitido', 0),
(164, 'profesor', 'login.php', 'permitido', 0),
(165, 'alumno', 'login.php', 'permitido', 0),
(166, 'super-user', 'logout.php', 'permitido', 0),
(167, 'profesor', 'logout.php', 'permitido', 0),
(168, 'alumno', 'logout.php', 'permitido', 0),
(169, 'super-user', 'modules/permisos/admin-permisos.php', 'permitido', 0),
(170, 'profesor', 'modules/permisos/admin-permisos.php', 'permitido', 0),
(171, 'alumno', 'modules/permisos/admin-permisos.php', 'permitido', 0),
(172, 'super-user', 'modules/permisos/crear-permisos-faltantes.php', 'permitido', 0),
(173, 'profesor', 'modules/permisos/crear-permisos-faltantes.php', 'permitido', 0),
(174, 'alumno', 'modules/permisos/crear-permisos-faltantes.php', 'permitido', 0),
(175, 'super-user', 'modules/permisos/duplicar-permiso.php', 'permitido', 0),
(176, 'profesor', 'modules/permisos/duplicar-permiso.php', 'permitido', 0),
(177, 'alumno', 'modules/permisos/duplicar-permiso.php', 'permitido', 0),
(178, 'super-user', 'modules/permisos/editar-permiso-ajax.php', 'permitido', 0),
(179, 'profesor', 'modules/permisos/editar-permiso-ajax.php', 'permitido', 0),
(180, 'alumno', 'modules/permisos/editar-permiso-ajax.php', 'permitido', 0),
(181, 'super-user', 'modules/permisos/eliminar-permiso.php', 'permitido', 0),
(182, 'profesor', 'modules/permisos/eliminar-permiso.php', 'permitido', 0),
(183, 'alumno', 'modules/permisos/eliminar-permiso.php', 'permitido', 0),
(184, 'super-user', 'registro.php', 'permitido', 0),
(185, 'profesor', 'registro.php', 'permitido', 0),
(186, 'alumno', 'registro.php', 'permitido', 0),
(187, 'super-user', 'usuarios.php', 'permitido', 0),
(188, 'profesor', 'usuarios.php', 'permitido', 0),
(189, 'alumno', 'usuarios.php', 'permitido', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_usuario`
--

CREATE TABLE `tokens_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `codigo_token` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` tinytext NOT NULL,
  `apellidos` tinytext NOT NULL,
  `correo` varchar(100) NOT NULL,
  `presentacion` text DEFAULT NULL,
  `rol` enum('super-user','profesor','alumno') DEFAULT 'alumno',
  `etapa` enum('primaria','secundaria','universidad') DEFAULT NULL,
  `centro` varchar(100) DEFAULT NULL,
  `poblacion` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `aula` varchar(50) DEFAULT NULL,
  `grupo` varchar(50) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `token_id` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `validado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellidos`, `correo`, `presentacion`, `rol`, `etapa`, `centro`, `poblacion`, `pais`, `aula`, `grupo`, `profesor_id`, `token_id`, `fecha_registro`, `validado`) VALUES
(6, 'vicenteprofe', '$2y$10$cqXRqUsUerU8tpYreHrjc.jqvyLyjRS9Z9rAPSCb/JOFlLloH3Ks2', '', '', 'vicente.montesinos@educa.madrid.org', NULL, 'profesor', 'secundaria', 'centro Esperanza', 'Madrid', 'España', NULL, NULL, NULL, NULL, '2025-07-21 21:50:13', 0),
(7, 'vicenteprofe2', '$2y$10$5DC.oOd6W7sGH0AD6xWqUeBTq6HsAzzEr8W/eWVXKqO2c1xgDOpNO', 'Vicente', 'Montesinos agilo', '2@elguerrerodelantifaz.org', 'Estoy interesado en concer el funcioanmiento de esta plataforma', 'profesor', 'secundaria', 'centro de la esperanza', 'madrid', 'ESPAÑA', NULL, NULL, NULL, NULL, '2025-07-22 16:14:49', 1),
(8, 'admin', '$2y$10$p0Z6j87Wv2h9mdBtBpKNAuS/GpYbw1Az.vbEzzQkFOznKZhysesIq', 'vicente', 'montesinos aguilo', 'vmont@gmail.com', 'sasd', 'super-user', 'secundaria', 'centro esperanza', 'madrid', 'ESPAÑA', NULL, NULL, NULL, NULL, '2025-07-22 21:47:50', 0),
(9, 'admin2', '$2y$10$VuAExDQfkkILOQmdUAfdz.Evw9fJLOuYxu3H0ByjmysGHHhk/eRLK', 'vicente', 'montesinos aguilo', 'v@gmail.com', 'cvcvxz', 'super-user', 'secundaria', 'cvxv', 'xcvxz', 'xcvx', NULL, NULL, NULL, NULL, '2025-07-23 18:00:28', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_token` (`codigo_token`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `token_id` (`token_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  ADD CONSTRAINT `tokens_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`token_id`) REFERENCES `tokens_usuario` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
