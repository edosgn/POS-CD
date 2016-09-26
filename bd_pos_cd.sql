-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2016 a las 17:02:51
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
-- Estructura de tabla para la tabla `abono`
--

CREATE TABLE `abono` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `fecha_pago` datetime NOT NULL,
  `valor_abono` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `saldo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `identificacion` bigint(20) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `preferencias` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `identificacion`, `tipo`, `empresa`, `nit`, `nombre`, `apellido`, `telefono`, `correo`, `fecha_nacimiento`, `preferencias`, `created_at`, `updated_at`) VALUES
(1, 1085262079, 'natural', '', '', 'Pepito', 'Perez', '7333333', 'info@@gmail.com', '2016-09-03', NULL, '2016-09-03 04:45:04', '2016-09-16 23:14:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `detalle_categoria_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `precio_base` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `detalle_categoria_id`, `nombre`, `descripcion`, `precio_base`) VALUES
(1, 1, 'Frutero', 'Frutero especial', 20000),
(2, 1, 'Arreglo de flores', 'Arreglo con rosas y gorasoles', 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_categoria`
--

CREATE TABLE `detalle_categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_categoria`
--

INSERT INTO `detalle_categoria` (`id`, `nombre`) VALUES
(1, 'Funebre'),
(2, 'Fruteros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `inicio` int(11) NOT NULL,
  `final` int(11) NOT NULL,
  `jornada` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `inicio`, `final`, `jornada`) VALUES
(1, 8, 10, 'AM'),
(2, 10, 12, 'AM'),
(3, 2, 4, 'PM'),
(4, 4, 6, 'PM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `mensaje_categoria_id` int(11) DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `mensaje_categoria_id`, `descripcion`) VALUES
(1, 1, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje_categoria`
--

CREATE TABLE `mensaje_categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mensaje_categoria`
--

INSERT INTO `mensaje_categoria` (`id`, `nombre`) VALUES
(1, 'Amor'),
(2, 'Amistad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_produccion`
--

CREATE TABLE `orden_produccion` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `zona_envio_id` int(11) DEFAULT NULL,
  `numero` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `direccion_entrega` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion_direccion` longtext COLLATE utf8_unicode_ci,
  `tipo_pago` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `novedad` longtext COLLATE utf8_unicode_ci,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `horario_id` int(11) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `prioridad_id` int(11) DEFAULT NULL,
  `destinatario_nombres` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `destinatario_apellidos` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `orden_produccion`
--

INSERT INTO `orden_produccion` (`id`, `pedido_id`, `zona_envio_id`, `numero`, `telefono`, `direccion_entrega`, `descripcion_direccion`, `tipo_pago`, `novedad`, `estado`, `created_at`, `updated_at`, `horario_id`, `fecha_entrega`, `prioridad_id`, `destinatario_nombres`, `destinatario_apellidos`) VALUES
(1, 1, 1, 'OP201620-001', '7333333', 'Calle 1 #15-07', 'Calle 1 #15-07', 'consignacion', NULL, 'Sin asignar', '2016-09-20 17:55:06', '2016-09-20 18:04:14', 1, '2016-09-20 00:00:00', 1, 'Pepito', 'Perez'),
(2, 1, 1, 'OP201620-002', '7333333', 'Calle 1 #15-07 Barrio', 'Calle 1 #15-07', 'consignacion', NULL, 'Sin asignar', '2016-09-20 22:36:53', '2016-09-20 22:44:17', 1, '2016-09-20 00:00:00', 4, 'Pepito', 'Perez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_produccion_detalle`
--

CREATE TABLE `orden_produccion_detalle` (
  `id` int(11) NOT NULL,
  `orden_produccion_id` int(11) DEFAULT NULL,
  `detalle_id` int(11) DEFAULT NULL,
  `mensaje_id` int(11) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `precio` bigint(20) NOT NULL,
  `valor_envio` int(11) DEFAULT NULL,
  `descripcion_mensaje` longtext COLLATE utf8_unicode_ci NOT NULL,
  `observacion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `firma` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_observacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_produccion_estado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `orden_produccion_detalle`
--

INSERT INTO `orden_produccion_detalle` (`id`, `orden_produccion_id`, `detalle_id`, `mensaje_id`, `responsable_id`, `precio`, `valor_envio`, `descripcion_mensaje`, `observacion`, `firma`, `foto_observacion`, `orden_produccion_estado_id`) VALUES
(1, 1, 1, 1, 5, 20000, 4000, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'm Ipsum, y más recientemen', 'Firma de prueba', NULL, 2),
(2, 1, 2, 1, 4, 10000, 4000, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'nte igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'Firma de prueba', NULL, 1),
(3, 2, 1, 1, 5, 20000, 4000, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'encialmente igual al original. Fue po', 'Firma de prueba', NULL, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_produccion_estado`
--

CREATE TABLE `orden_produccion_estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `orden_produccion_estado`
--

INSERT INTO `orden_produccion_estado` (`id`, `nombre`, `estado`) VALUES
(1, 'Asignada', 1),
(2, 'Produccion', 1),
(3, 'Terminada', 1),
(4, 'Despacho', 1),
(5, 'Entregada', 1);

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
(1, 'Esposa (o)'),
(2, 'Novia (o)'),
(3, 'Amigo (a)'),
(4, 'Madre'),
(5, 'Padre'),
(6, 'Hijo(a)'),
(7, 'Abuelo(a)'),
(8, 'Otro (a)');

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
(1, 6, 1, 'P201609-001', '2016-09-20 17:54:39', '2016-09-20 17:54:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE `prioridad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `rango` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`id`, `nombre`, `color`, `rango`) VALUES
(1, 'Normal', '#107ce0', '<60'),
(2, 'Media', '#06d65a', '61<120'),
(3, 'Alta', '#abfa46', '0<60'),
(4, 'Importante', '#ff9d0a', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `parentesco_id` int(11) DEFAULT NULL,
  `identificacion` bigint(20) NOT NULL,
  `correo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_especial` date NOT NULL,
  `descripcion_fecha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombres` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `intereses` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `referencia`
--

INSERT INTO `referencia` (`id`, `cliente_id`, `parentesco_id`, `identificacion`, `correo`, `telefono`, `direccion`, `fecha_especial`, `descripcion_fecha`, `nombres`, `apellidos`, `intereses`) VALUES
(1, 1, 1, 123213123, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";'),
(2, 1, 1, 321616, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";'),
(3, 1, 1, 123132, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";'),
(4, 1, 1, 123132, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";'),
(5, 1, 1, 123132, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";'),
(6, 1, 1, 213122, NULL, '7333333', NULL, '2016-09-13', 'aniversario', 'Pepito', 'Perez', 's:10:"hola,mundo";');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `identificacion`, `telefono`, `correo`, `estado`, `foto`, `created_at`, `updated_at`, `role`, `password`, `salt`) VALUES
(3, 'Jose', 'Luis', 12364598, '7894552', 'jh@prueba.com', '1', 'default.jpg', '2016-06-17 18:45:03', '2016-09-03 13:10:10', 'ROLE_ADMIN', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c'),
(4, 'Ana', 'Giraldo', 4568965, '8956446', 'ana@prueba.com', '1', 'default.jpg', '2016-06-29 23:34:51', '2016-07-27 22:25:58', 'ROLE_PRODUCTION', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c'),
(5, 'Laura', 'Ruiz', 43123, '897789', 'lau@prueba.com', '1', 'default.jpg', '2016-06-30 18:47:30', '2016-07-27 22:26:47', 'ROLE_PRODUCTION', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c'),
(6, 'Alvaro', 'Rosero', 985132, '2356645', 'alv@prueba.com', '1', 'default.jpg', '2016-07-01 01:06:34', '2016-09-15 22:42:35', 'ROLE_COMMERCIAL', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c'),
(7, 'Esteban', 'Jaramillo', 654743532, '7345432', 'est@prueba.com', '1', 'default.jpg', '2016-07-01 22:26:40', '2016-07-27 22:28:51', 'ROLE_SHIPPING', 'amG93ZYpm2PdPUQtAvApQygoazXxvyKQRlpUwiqIveslYna1/TMs3DD51FS9LmQMvxjnWxh1dLlc4E+j/LWEdw==', 'h44dwvg3hq804s8gggoo8o08g4s4w8c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_categoria`
--

CREATE TABLE `usuario_categoria` (
  `id` int(11) NOT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `detalle_categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_categoria`
--

INSERT INTO `usuario_categoria` (`id`, `responsable_id`, `detalle_categoria_id`) VALUES
(2, 4, 1),
(3, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `articulo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `valor` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_envio`
--

CREATE TABLE `zona_envio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `zona_envio`
--

INSERT INTO `zona_envio` (`id`, `nombre`, `descripcion`, `valor`) VALUES
(1, 'Norte', 'Norte', 4000),
(2, 'Sur', 'Sur', 5000),
(3, 'Periferico', 'Rural', 10000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abono`
--
ALTER TABLE `abono`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_96A720954854653A` (`pedido_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_80397C30FAD74F11` (`detalle_categoria_id`);

--
-- Indices de la tabla `detalle_categoria`
--
ALTER TABLE `detalle_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9B631D01D690A463` (`mensaje_categoria_id`);

--
-- Indices de la tabla `mensaje_categoria`
--
ALTER TABLE `mensaje_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A4EB83EEF55AE19E` (`numero`),
  ADD KEY `IDX_A4EB83EE4854653A` (`pedido_id`),
  ADD KEY `IDX_A4EB83EEB4EB6A7E` (`zona_envio_id`),
  ADD KEY `IDX_A4EB83EE4959F1BA` (`horario_id`),
  ADD KEY `IDX_A4EB83EEBDD13D7A` (`prioridad_id`);

--
-- Indices de la tabla `orden_produccion_detalle`
--
ALTER TABLE `orden_produccion_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_22F18866E24BC846` (`orden_produccion_id`),
  ADD KEY `IDX_22F188669EA59ED2` (`detalle_id`),
  ADD KEY `IDX_22F188664C54F362` (`mensaje_id`),
  ADD KEY `IDX_22F1886653C59D72` (`responsable_id`),
  ADD KEY `IDX_22F18866C96B2A14` (`orden_produccion_estado_id`);

--
-- Indices de la tabla `orden_produccion_estado`
--
ALTER TABLE `orden_produccion_estado`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `usuario_categoria`
--
ALTER TABLE `usuario_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C72BF83F53C59D72` (`responsable_id`),
  ADD KEY `IDX_C72BF83FFAD74F11` (`detalle_categoria_id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8FE7EE554854653A` (`pedido_id`);

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
-- AUTO_INCREMENT de la tabla `abono`
--
ALTER TABLE `abono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `detalle_categoria`
--
ALTER TABLE `detalle_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mensaje_categoria`
--
ALTER TABLE `mensaje_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `orden_produccion_detalle`
--
ALTER TABLE `orden_produccion_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `orden_produccion_estado`
--
ALTER TABLE `orden_produccion_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `parentesco`
--
ALTER TABLE `parentesco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `usuario_categoria`
--
ALTER TABLE `usuario_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `zona_envio`
--
ALTER TABLE `zona_envio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abono`
--
ALTER TABLE `abono`
  ADD CONSTRAINT `FK_96A720954854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`);

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `FK_80397C30FAD74F11` FOREIGN KEY (`detalle_categoria_id`) REFERENCES `detalle_categoria` (`id`);

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `FK_9B631D01D690A463` FOREIGN KEY (`mensaje_categoria_id`) REFERENCES `mensaje_categoria` (`id`);

--
-- Filtros para la tabla `orden_produccion`
--
ALTER TABLE `orden_produccion`
  ADD CONSTRAINT `FK_A4EB83EE4854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `FK_A4EB83EE4959F1BA` FOREIGN KEY (`horario_id`) REFERENCES `horario` (`id`),
  ADD CONSTRAINT `FK_A4EB83EEB4EB6A7E` FOREIGN KEY (`zona_envio_id`) REFERENCES `zona_envio` (`id`),
  ADD CONSTRAINT `FK_A4EB83EEBDD13D7A` FOREIGN KEY (`prioridad_id`) REFERENCES `prioridad` (`id`);

--
-- Filtros para la tabla `orden_produccion_detalle`
--
ALTER TABLE `orden_produccion_detalle`
  ADD CONSTRAINT `FK_22F188664C54F362` FOREIGN KEY (`mensaje_id`) REFERENCES `mensaje` (`id`),
  ADD CONSTRAINT `FK_22F1886653C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_22F188669EA59ED2` FOREIGN KEY (`detalle_id`) REFERENCES `detalle` (`id`),
  ADD CONSTRAINT `FK_22F18866C96B2A14` FOREIGN KEY (`orden_produccion_estado_id`) REFERENCES `orden_produccion_estado` (`id`),
  ADD CONSTRAINT `FK_22F18866E24BC846` FOREIGN KEY (`orden_produccion_id`) REFERENCES `orden_produccion` (`id`);

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

--
-- Filtros para la tabla `usuario_categoria`
--
ALTER TABLE `usuario_categoria`
  ADD CONSTRAINT `FK_C72BF83F53C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_C72BF83FFAD74F11` FOREIGN KEY (`detalle_categoria_id`) REFERENCES `detalle_categoria` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_8FE7EE554854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
