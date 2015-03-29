-- phpMyAdmin SQL Dump
-- version 4.4.0-alpha1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-03-2015 a las 14:44:28
-- Versión del servidor: 5.6.21-log
-- Versión de PHP: 5.6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sysdatabase`
--
DROP DATABASE `sysdatabase`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_areaconocimiento`
--

CREATE TABLE IF NOT EXISTS `tbl_areaconocimiento` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_areaconocimiento`
--

INSERT INTO `tbl_areaconocimiento` (`id`, `nombre`) VALUES
(1, 'Primera Área');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_configuracion_item`
--

CREATE TABLE IF NOT EXISTS `tbl_configuracion_item` (
  `configuracion_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `posicion` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_configuracion_item`
--

INSERT INTO `tbl_configuracion_item` (`configuracion_id`, `item_id`, `posicion`) VALUES
(3, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_configuraciones`
--

CREATE TABLE IF NOT EXISTS `tbl_configuraciones` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `publico` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 es no'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_configuraciones`
--

INSERT INTO `tbl_configuraciones` (`id`, `nombre`, `descripcion`, `publico`) VALUES
(3, 'Primera Configuración', 'Esta es una configuración muy linda!', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estudiantes`
--

CREATE TABLE IF NOT EXISTS `tbl_estudiantes` (
  `cedula` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `seccion` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_estudiantes`
--

INSERT INTO `tbl_estudiantes` (`cedula`, `nombre`, `seccion`) VALUES
('1-1111-1111', 'Testeo', 'A12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estudiantes_configuraciones`
--

CREATE TABLE IF NOT EXISTS `tbl_estudiantes_configuraciones` (
  `id` int(10) unsigned NOT NULL,
  `profesor_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `estudiantes_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `configuracion_id` int(10) unsigned NOT NULL,
  `posicion` int(10) NOT NULL,
  `finalizada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_estudiantes_configuraciones`
--

INSERT INTO `tbl_estudiantes_configuraciones` (`id`, `profesor_id`, `estudiantes_id`, `configuracion_id`, `posicion`, `finalizada`) VALUES
(1, '4-0197-0613', '1-1111-1111', 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_item`
--

CREATE TABLE IF NOT EXISTS `tbl_item` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dificultad` tinyint(1) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `clasificacion` tinyint(1) NOT NULL,
  `tipoenunciado` tinyint(1) NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `areaconocimiento_id` int(10) unsigned NOT NULL,
  `enunciado` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_item`
--

INSERT INTO `tbl_item` (`id`, `nombre`, `dificultad`, `tipo`, `clasificacion`, `tipoenunciado`, `descripcion`, `areaconocimiento_id`, `enunciado`) VALUES
(1, 'Item de Prueba', 2, 1, 2, 2, 'Esta es la descripción de una prueba', 1, 'Esta es una prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_profesores`
--

CREATE TABLE IF NOT EXISTS `tbl_profesores` (
  `cedula` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_profesores`
--

INSERT INTO `tbl_profesores` (`cedula`, `nombre`) VALUES
('4-0197-0613', 'Juan Pablo Araya Gonzalez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_profesores_configuraciones`
--

CREATE TABLE IF NOT EXISTS `tbl_profesores_configuraciones` (
  `profesor_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `configuracion_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_profesores_configuraciones`
--

INSERT INTO `tbl_profesores_configuraciones` (`profesor_id`, `configuracion_id`) VALUES
('4-0197-0613', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_profesores_estudiantes`
--

CREATE TABLE IF NOT EXISTS `tbl_profesores_estudiantes` (
  `profesor_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `estudiante_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_profesores_estudiantes`
--

INSERT INTO `tbl_profesores_estudiantes` (`profesor_id`, `estudiante_id`) VALUES
('4-0197-0613', '1-1111-1111');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_respuestas`
--

CREATE TABLE IF NOT EXISTS `tbl_respuestas` (
  `id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `acierto` tinyint(4) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_respuestas`
--

INSERT INTO `tbl_respuestas` (`id`, `item_id`, `acierto`, `tipo`, `descripcion`) VALUES
(1, 1, 0, 2, 'Esta no es la correcta'),
(2, 1, 1, 2, 'Esta sí es la correcta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_resultados`
--

CREATE TABLE IF NOT EXISTS `tbl_resultados` (
  `prueba_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `resultado` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_resultados`
--

INSERT INTO `tbl_resultados` (`prueba_id`, `item_id`, `resultado`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE IF NOT EXISTS `tbl_usuarios` (
  `id` int(10) unsigned NOT NULL,
  `cedula` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabla de Usuarios';

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `cedula`, `clave`, `tipo`) VALUES
(1, '4-0197-0613', '1234', 2),
(2, '1-1111-1111', 'Testeo', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_areaconocimiento`
--
ALTER TABLE `tbl_areaconocimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_configuracion_item`
--
ALTER TABLE `tbl_configuracion_item`
  ADD PRIMARY KEY (`configuracion_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `tbl_configuraciones`
--
ALTER TABLE `tbl_configuraciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_estudiantes`
--
ALTER TABLE `tbl_estudiantes`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `tbl_estudiantes_configuraciones`
--
ALTER TABLE `tbl_estudiantes_configuraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `estudiantes_id` (`estudiantes_id`) USING BTREE,
  ADD KEY `configuracion_id` (`configuracion_id`);

--
-- Indices de la tabla `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areaconocimiento_id` (`areaconocimiento_id`);

--
-- Indices de la tabla `tbl_profesores`
--
ALTER TABLE `tbl_profesores`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `tbl_profesores_configuraciones`
--
ALTER TABLE `tbl_profesores_configuraciones`
  ADD PRIMARY KEY (`profesor_id`,`configuracion_id`),
  ADD KEY `configuracion_id` (`configuracion_id`);

--
-- Indices de la tabla `tbl_profesores_estudiantes`
--
ALTER TABLE `tbl_profesores_estudiantes`
  ADD PRIMARY KEY (`profesor_id`,`estudiante_id`),
  ADD KEY `estudiante_id` (`estudiante_id`);

--
-- Indices de la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `tbl_resultados`
--
ALTER TABLE `tbl_resultados`
  ADD PRIMARY KEY (`prueba_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_areaconocimiento`
--
ALTER TABLE `tbl_areaconocimiento`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_configuraciones`
--
ALTER TABLE `tbl_configuraciones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tbl_estudiantes_configuraciones`
--
ALTER TABLE `tbl_estudiantes_configuraciones`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_configuracion_item`
--
ALTER TABLE `tbl_configuracion_item`
  ADD CONSTRAINT `Tbl_configuracion_item_ibfk_1` FOREIGN KEY (`configuracion_id`) REFERENCES `tbl_configuraciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tbl_configuracion_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_estudiantes_configuraciones`
--
ALTER TABLE `tbl_estudiantes_configuraciones`
  ADD CONSTRAINT `tbl_estudiantes_configuraciones_ibfk_1` FOREIGN KEY (`configuracion_id`) REFERENCES `tbl_configuraciones` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_estudiantes_configuraciones_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `tbl_profesores` (`cedula`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_estudiantes_configuraciones_ibfk_3` FOREIGN KEY (`estudiantes_id`) REFERENCES `tbl_estudiantes` (`cedula`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD CONSTRAINT `Tbl_item_ibfk_1` FOREIGN KEY (`areaconocimiento_id`) REFERENCES `tbl_areaconocimiento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_profesores_configuraciones`
--
ALTER TABLE `tbl_profesores_configuraciones`
  ADD CONSTRAINT `Tbl_profesores_configuraciones_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `tbl_profesores` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tbl_profesores_configuraciones_ibfk_2` FOREIGN KEY (`configuracion_id`) REFERENCES `tbl_configuraciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_profesores_estudiantes`
--
ALTER TABLE `tbl_profesores_estudiantes`
  ADD CONSTRAINT `Tbl_profesores_estudiantes_ibfk_3` FOREIGN KEY (`estudiante_id`) REFERENCES `tbl_estudiantes` (`cedula`),
  ADD CONSTRAINT `Tbl_profesores_estudiantes_ibfk_4` FOREIGN KEY (`profesor_id`) REFERENCES `tbl_profesores` (`cedula`);

--
-- Filtros para la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD CONSTRAINT `Tbl_respuestas_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_resultados`
--
ALTER TABLE `tbl_resultados`
  ADD CONSTRAINT `tbl_resultados_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_resultados_ibfk_3` FOREIGN KEY (`prueba_id`) REFERENCES `tbl_estudiantes_configuraciones` (`id`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
