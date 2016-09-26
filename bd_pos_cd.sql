-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2016 a las 18:15:22
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_pos_cd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'AGRADECIMIENTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `identificacion` bigint(20) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `preferencias` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `nombre_apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `identificacion`, `tipo`, `telefono`, `correo`, `fecha_nacimiento`, `preferencias`, `created_at`, `updated_at`, `nombre_apellido`) VALUES
(5, 1024536, 'natural', '7202020', 'messi@barca.com', '1987-06-23', NULL, '2016-06-29 18:42:14', '2016-06-29 18:42:14', 'Leonel Messi'),
(6, 798456123, 'natural', '561851', 'mara@boca.com', '1962-11-20', NULL, '2016-06-29 22:36:59', '2016-06-29 22:36:59', 'Maradona'),
(7, 7891521, 'natural', '31543', 'dani@prueba.com', '1992-09-12', NULL, '2016-06-30 18:50:05', '2016-06-30 18:50:05', 'Daniela Ospina'),
(8, 8795132, 'natural', '613232', 'james@rm.com', '1985-10-09', NULL, '2016-06-30 18:52:28', '2016-06-30 18:52:28', 'James');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `precio_base` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `nombre`, `descripcion`, `precio_base`) VALUES
(1, 'funebre', 'arreglo funebre', 60000),
(2, 'ramo de rosas', 'ramo de 24 rosas', 50000),
(3, 'frutero', 'frutas y rosas', 55000),
(4, 'arreglo  floral', 'rosay y cartuchos', 75000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `descripcion`, `categoria_id`) VALUES
(1, 'feliz dia mama', NULL),
(2, 'feliz dia papa', NULL),
(3, 'feliz dia mujer', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_produccion`
--

CREATE TABLE `orden_produccion` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `mensaje_id` int(11) DEFAULT NULL,
  `detalle_id` int(11) DEFAULT NULL,
  `zona_envio_id` int(11) DEFAULT NULL,
  `numero` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `destinatario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `direccion_entrega` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valor_envio` int(11) DEFAULT NULL,
  `descripcion_direccion` longtext COLLATE utf8_unicode_ci,
  `cantidad_detalle` int(11) DEFAULT NULL,
  `observacion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tipo_pago` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firma` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `responsable_produccion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prioridad` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `fecha_estimada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `orden_produccion`
--

INSERT INTO `orden_produccion` (`id`, `pedido_id`, `mensaje_id`, `detalle_id`, `zona_envio_id`, `numero`, `destinatario`, `telefono`, `fecha_entrega`, `direccion_entrega`, `valor_envio`, `descripcion_direccion`, `cantidad_detalle`, `observacion`, `tipo_pago`, `firma`, `responsable_produccion`, `prioridad`, `estado`, `created_at`, `updated_at`, `fecha_estimada`) VALUES
(18, 30, 1, 2, 2, 'OP2016-07-09', 'Mama Messi', '615', '2016-10-09 00:00:00', 'casa', NULL, NULL, 1, 'ninguna', 'contado', 'messi', 'Ana Giraldo', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 30, 2, 4, 1, 'OP2016-07-10', 'Papa Messi', '8465164', '2016-07-07 00:00:00', 'casa', NULL, NULL, 1, 'ninguna', 'contado', 'messi', 'Laura Ruiz', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 31, 3, 3, 3, 'OP2016-07-12', 'Mama', '34243543', '2016-11-04 00:00:00', 'casa', NULL, NULL, NULL, 'ninguna', 'contado', 'daniela', 'Ana Giraldo', 'normal', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 31, NULL, 4, 2, 'OP2016-07-13', 'Hijo', '342432', '2016-09-07 00:00:00', 'casa', NULL, NULL, 1, 'ninguno', 'contado', NULL, 'Ana Giraldo', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 32, 3, 2, 1, 'OP2016-07-24', 'Juana De Arco', '32123121', '2016-08-12 00:00:00', 'casa', NULL, NULL, 1, 'inguna', 'contado', 'james', 'Ana Giraldo', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 32, 2, 3, 2, 'OP2016-07-25', 'Papa', '321321', '2016-09-05 00:00:00', 'casa', NULL, NULL, 2, 'ninguna', 'contado', 'james', 'Laura Ruiz', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 32, 1, 4, 2, 'OP2016-07-26', 'Mama', '321321', '2016-10-07 00:00:00', 'Pasto', NULL, NULL, 1, 'ninguna', 'contado', 'james', 'Ana Giraldo', 'normal', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 31, 1, 3, 3, 'OP2016-07-35', 'Thiago Messi', '3105447568', '2016-11-06 00:00:00', 'casa', NULL, NULL, 1, 'ninguna', 'contado', 'daniela', 'Laura Ruiz', 'normal', 'Entregada', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 33, 3, 2, 3, 'OP201607-001', 'Asd', '2342', '2016-07-08 06:56:00', 'asda', 2, 'asdds', 1, 'ok', 'credito', 'adasdsa', 'camilo martinez', 'normal', 'Pendiente', '2016-07-08 06:58:24', '2016-07-08 06:58:24', '2016-07-08 06:56:00'),
(27, 34, NULL, NULL, 1, 'OP201607-002', 'Oiueworjwo', '77', '2016-07-12 07:55:00', 'Calle 1 #15-07', NULL, 'jhkjsdlksdfs', NULL, 'ok', 'contado', NULL, 'camilo martinez', 'normal', 'Pendiente', '2016-07-12 18:06:21', '2016-07-12 18:06:21', '2016-07-12 07:55:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentesco`
--

CREATE TABLE `parentesco` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `parentesco`
--

INSERT INTO `parentesco` (`id`, `nombre`) VALUES
(1, 'Madre'),
(2, 'Padre'),
(3, 'Esposa (o)'),
(4, 'Hijo(a)'),
(5, 'Hermano(a)'),
(6, 'Abuelo(a)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `numero` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `usuario_id`, `cliente_id`, `numero`, `created_at`, `updated_at`) VALUES
(30, 6, 5, 'P2016-07-08', '2016-07-01 01:08:45', '2016-07-01 01:08:45'),
(31, 6, 7, 'P2016-07-10', '2016-07-01 01:10:56', '2016-07-01 01:10:56'),
(32, 6, 8, 'P2016-07-23', '2016-07-01 18:23:23', '2016-07-01 18:23:23'),
(33, 3, 5, 'P201607-004', '2016-07-07 05:24:16', '2016-07-07 05:24:16'),
(34, 3, 5, 'P201607-005', '2016-07-12 17:57:47', '2016-07-12 17:57:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `nombre_apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_especial` date NOT NULL,
  `interes_persona` longtext COLLATE utf8_unicode_ci,
  `parentesco_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `referencia`
--

INSERT INTO `referencia` (`id`, `cliente_id`, `nombre_apellido`, `correo`, `direccion`, `fecha_especial`, `interes_persona`, `parentesco_id`) VALUES
(1, 5, 'Ref Uno', 'esposa@prueba.com', NULL, '2016-07-08', NULL, 2),
(2, 5, 'Ref Dos', 'esposa@prueba.com', NULL, '2016-07-08', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre_apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identificacion` bigint(20) NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_apellido`, `identificacion`, `telefono`, `correo`, `estado`, `foto`, `created_at`, `updated_at`, `role`, `password`, `salt`) VALUES
(2, 'camilo martinez', 121212, '7568945', 'cm@prueba.com', '1', 'default.jpg', '2016-06-03 23:23:49', '2016-06-03 23:23:49', 'ROLE_ADMIN', 'aWoMnpsMxBhldRq4nAkikuGaN3+RQublG5SmKCFY0D2MppSnwTg3LAzZ2PoEDpCLyAvydFMc3DVj5y7AgHktKQ==', '1swmerlfgobo0g80w0w8ow4go48gcck'),
(3, 'Jose', 12364598, '7894552', 'jh@prueba.com', '1', 'default.jpg', '2016-06-17 18:45:03', '2016-06-17 18:45:03', 'ROLE_ADMIN', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c'),
(4, 'Ana Giraldo', 4568965, '8956446', 'ana@prueba.com', '1', 'default.jpg', '2016-06-29 23:34:51', '2016-06-29 23:34:51', 'ROLE_PROD', 'LoifCSnDNAGiuNuXl/6ET6+qhz+tSkQT9Kd9j8meiq8sNidqbtfohDy3aSWQRgPXd6SIS14/2yyR43m9aXrGWw==', '69an0pkw8vk8c4wo0s88wgwcksggwkg'),
(5, 'Laura Ruiz', 43123, '897789', 'lau@prueba.com', '1', 'default.jpg', '2016-06-30 18:47:30', '2016-06-30 18:47:30', 'ROLE_PROD', 'QS23ebpiTwNpVLHW1zK1qX3iA7vzuHsWt/7iY+MCJnkDSPKrXtj1iQpLJWO2glLJFv6Kq1QkvUZihPYjXuxU1w==', '4hw7nxcg8b284s8ggk4g8g884ccsos4'),
(6, 'Alvaro Castillo', 985132, '2356645', 'alv@prueba.com', '1', 'default.jpg', '2016-07-01 01:06:34', '2016-07-01 01:06:34', 'ROLE_COM', 'T+IipHbNjpfzjf85ZiT3ShFLsWcOIsZ392IWG7s0Yo+KjGcrLzE0pgqj2YgzPlsrMIgVVvezJhKWOUUbqpZz6Q==', 'lx5zlw70htwgg4888sgg48cwooowko4'),
(7, 'Esteban Calpa', 654743532, '7345432', 'est@prueba.com', '1', 'default.jpg', '2016-07-01 22:26:40', '2016-07-01 22:26:40', 'ROLE_DESP', 'WMQQnol7EcXXkNaQXHvNpBx4N6lKgKxKz7SOHoziMV4QK8yRGxmRHmM+EYWG8LxaHki31v+LhzFZxhjvWI2DUQ==', 'p43lq07p0r48wooocso0o0k440occs8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_envio`
--

CREATE TABLE `zona_envio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `zona_envio`
--

INSERT INTO `zona_envio` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Sur', NULL),
(2, 'Norte', NULL),
(3, 'Occidente', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F41C9B2584291D2B` (`identificacion`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9B631D013397707A` (`categoria_id`);

--
-- Indices de la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A4EB83EEF55AE19E` (`numero`),
  ADD KEY `IDX_A4EB83EE4854653A` (`pedido_id`),
  ADD KEY `IDX_A4EB83EE4C54F362` (`mensaje_id`),
  ADD KEY `IDX_A4EB83EE9EA59ED2` (`detalle_id`),
  ADD KEY `IDX_A4EB83EEB4EB6A7E` (`zona_envio_id`);

--
-- Indices de la tabla `parentesco`
--
ALTER TABLE `parentesco`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C4EC16CEF55AE19E` (`numero`),
  ADD KEY `IDX_C4EC16CEDB38439E` (`usuario_id`),
  ADD KEY `IDX_C4EC16CEDE734E51` (`cliente_id`);

--
-- Indices de la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C01213D8DE734E51` (`cliente_id`),
  ADD KEY `IDX_C01213D85BA311FC` (`parentesco_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05D84291D2B` (`identificacion`);

--
-- Indices de la tabla `zona_envio`
--
ALTER TABLE `zona_envio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2726BC603A909126` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `parentesco`
--
ALTER TABLE `parentesco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `zona_envio`
--
ALTER TABLE `zona_envio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `FK_9B631D013397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  ADD CONSTRAINT `FK_A4EB83EE4854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `FK_A4EB83EE4C54F362` FOREIGN KEY (`mensaje_id`) REFERENCES `mensaje` (`id`),
  ADD CONSTRAINT `FK_A4EB83EE9EA59ED2` FOREIGN KEY (`detalle_id`) REFERENCES `detalle` (`id`),
  ADD CONSTRAINT `FK_A4EB83EEB4EB6A7E` FOREIGN KEY (`zona_envio_id`) REFERENCES `zona_envio` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_C4EC16CEDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_C4EC16CEDE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Filtros para la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD CONSTRAINT `FK_C01213D85BA311FC` FOREIGN KEY (`parentesco_id`) REFERENCES `parentesco` (`id`),
  ADD CONSTRAINT `FK_C01213D8DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
