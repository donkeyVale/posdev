-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2025 a las 20:28:11
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `posdev_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturas`
--

CREATE TABLE `aperturas` (
  `id` int(11) NOT NULL,
  `idcaja` int(11) DEFAULT NULL,
  `monto_apertura` decimal(10,2) DEFAULT NULL,
  `usuarioapertura` int(11) DEFAULT NULL,
  `fechaapertura` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) DEFAULT 1,
  `fechacierre` timestamp NULL DEFAULT NULL,
  `monto_cierre` decimal(10,2) DEFAULT NULL,
  `fechaeliminacion` timestamp NULL DEFAULT NULL,
  `usuarioeliminacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `aperturas`
--

INSERT INTO `aperturas` (`id`, `idcaja`, `monto_apertura`, `usuarioapertura`, `fechaapertura`, `estado`, `fechacierre`, `monto_cierre`, `fechaeliminacion`, `usuarioeliminacion`) VALUES
(1, 1, '250000.00', 1, '2025-02-03 18:17:40', 0, '2025-02-03 18:17:40', '250000.00', NULL, NULL),
(2, 1, '300000.00', 1, '2025-02-03 18:46:38', 0, '2025-02-03 18:46:38', '99999999.99', NULL, NULL),
(3, 1, '300000.00', 1, '2025-02-03 19:20:58', 0, '2025-02-03 19:20:58', '99999999.99', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL,
  `cajas` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariocreacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `cajas`, `estado`, `fecha_creacion`, `usuariocreacion`, `fechamodificacion`, `usuariomodificacion`, `idSucursal`) VALUES
(1, 'Caja Principal', 1, '2021-02-11 10:17:02', 'admin', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas_sucursales`
--

CREATE TABLE `cajas_sucursales` (
  `id_caja` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `monto_caja` double NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas_ventas`
--

CREATE TABLE `cajas_ventas` (
  `id_caja` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calces`
--

CREATE TABLE `calces` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `codcategoria` text DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`, `codcategoria`, `usuariocreacion`, `usuariomodificacion`, `fechamodificacion`, `estado`) VALUES
(18, 'PALAS', '2022-12-20 15:45:25', 'PALAS', 'anegrete', 'felidios', '2022-12-20 15:45:25', 1),
(19, 'ARTICULOS DEPORTIVOS', '2021-07-13 02:05:40', 'ART DEPORTIVOS', 'anegrete', NULL, NULL, 1),
(20, 'CALZADOS', '2022-12-20 15:45:47', 'CALZADOS', 'anegrete', 'felidios', '2022-12-20 15:45:47', 1),
(21, 'BOLSOS', '2022-12-20 15:45:58', 'BOLSOS', 'felidios', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_gastos`
--

CREATE TABLE `categorias_gastos` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `categorias_gastos`
--

INSERT INTO `categorias_gastos` (`id`, `nombre`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, 'Gasto 2020', 1, 'admin', '2021-11-24 17:17:17', 'admin', '2021-11-24 17:17:17'),
(2, 'Gasto 2', 0, 'admin', '2021-02-15 06:52:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `documento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) DEFAULT NULL,
  `ultima_compra` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariocreacion` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `grupocliente` int(11) DEFAULT NULL,
  `limitecredito` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`, `usuariocreacion`, `estado`, `usuariomodificacion`, `fechamodificacion`, `grupocliente`, `limitecredito`) VALUES
(14, 'Ruben Vazquez', '3673519', 'fmva2011@gmail.com', '0983902795', 'Carandayty 207', '1984-05-11', 264, '2025-02-03 14:17:14', '2025-02-03 19:17:14', 'admin', 1, NULL, NULL, 2, '0.00'),
(15, 'Mario Vazquez', '3673528-3', 'fmva2011@gmail.com', '0983902795', 'Carandayty 207', '1984-05-11', 79, '2025-02-02 17:37:28', '2025-02-02 22:37:28', 'admin', 1, NULL, NULL, 2, '300000.00'),
(16, 'Casual', '12345678', 'mfndene@gmail.com', '0983902794', 'Carandayty 297', '1984-05-20', 102, '2025-02-03 13:45:34', '2025-02-03 18:45:34', 'felidios', 1, NULL, NULL, 2, '200000.00'),
(17, 'Mario Arce', '3673518-4', 'f_m-v.a2011@gmail.com', '0983902794', 'Carandayty 297', '1984-05-11', 5, '2025-01-26 21:48:04', '2025-01-27 02:48:04', 'admin', 1, NULL, NULL, 2, '0.00'),
(18, 'Mario Arce', '3673518-3', 'f_m-v.a2011@gmail.com', '0983902794', 'Carandayty 297', '2023-01-04', NULL, NULL, '2023-01-05 01:09:40', 'admin', 1, NULL, NULL, 2, '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `nombre`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(3, 'Amarillo', 1, 'admin', '2021-05-31 03:54:16', NULL, NULL),
(4, 'Rojo Perlado', 0, 'admin', '2021-05-31 03:54:45', 'admin', '2021-05-31 03:54:39'),
(5, 'morado', 1, 'admin', '2021-05-31 03:54:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fechacompra` timestamp NULL DEFAULT NULL,
  `referencia` text DEFAULT NULL,
  `nrofactura` text DEFAULT NULL,
  `id_deposito` int(11) DEFAULT NULL,
  `id_tipo_compra` int(11) DEFAULT NULL,
  `productos` text DEFAULT NULL,
  `neto` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado_compra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_proveedor`, `fechacompra`, `referencia`, `nrofactura`, `id_deposito`, `id_tipo_compra`, `productos`, `neto`, `total`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`, `estado_compra`) VALUES
(22, 5, '2025-02-02 04:00:00', '62162', '6262', 1, 1, '[{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"49\",\"precio\":\"190000\",\"total\":9310000}]', 9310000, 9310000, '1', '2025-02-02 22:38:05', NULL, NULL, 1),
(23, 3, '2025-02-02 04:00:00', 'test', '0001', 1, 1, '[{\"id\":\"230\",\"descripcion\":\"PALA ADIDAS ADIPOWER 31\",\"cantidad\":\"50\",\"precio\":\"1880000\",\"total\":94000000}]', 94000000, 94000000, '1', '2025-02-02 23:21:52', NULL, NULL, 1),
(24, 3, '2025-02-03 03:00:00', 'compra', '00012', 1, 2, '[{\"id\":\"232\",\"descripcion\":\"PALA ADIDAS DRIVE\",\"cantidad\":\"20\",\"precio\":\"483000\",\"total\":9660000},{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"20\",\"precio\":\"190000\",\"total\":3800000}]', 13460000, 13460000, '1', '2025-02-03 18:28:26', NULL, NULL, 1),
(25, 3, '2025-02-03 03:00:00', 'seba', '00234', 1, 2, '[{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"100\",\"precio\":\"1880000\",\"total\":188000000}]', 188000000, 188000000, '1', '2025-02-03 18:33:42', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depositos`
--

CREATE TABLE `depositos` (
  `id` int(11) NOT NULL,
  `deposito` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariocreacion` text DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `depositos`
--

INSERT INTO `depositos` (`id`, `deposito`, `estado`, `fechacreacion`, `usuariocreacion`, `usuariomodificacion`, `fechamodificacion`, `codigo`, `telefono`, `email`, `direccion`) VALUES
(1, 'Depósito Principal 2021', 1, '2022-12-24 03:50:13', 'admin', 'admin', '2022-12-24 03:50:13', 'DP', '0983902795', 'fmva2011@gmail.com', 'FERNANDO DE LA MORA'),
(7, 'DEPOSITO UNION', 1, '2022-12-24 03:48:54', 'admin', NULL, NULL, 'DU', '0983902795', 'fmva2011@gmail.com', 'LUQUE'),
(8, 'DEPOSITO  TOP PADEL', 1, '2022-12-24 03:49:30', 'admin', NULL, NULL, 'DTP', '0983902795', 'fmva2011@gmail.com', 'LAMBARE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`, `total`, `fecha_creacion`) VALUES
(75, 22, 229, 49, 190000, 9310000, '2025-02-02 22:38:06'),
(76, 23, 230, 50, 1880000, 94000000, '2025-02-02 23:21:52'),
(77, 24, 232, 20, 483000, 9660000, '2025-02-03 18:28:26'),
(78, 24, 229, 20, 190000, 3800000, '2025-02-03 18:28:26'),
(79, 25, 231, 100, 1880000, 188000000, '2025-02-03 18:33:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_transferencia`
--

CREATE TABLE `detalle_transferencia` (
  `id` int(11) NOT NULL,
  `id_transferencia` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_usuario_transferencia` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  `id_deposito_origen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_transferencia`
--

INSERT INTO `detalle_transferencia` (`id`, `id_transferencia`, `id_producto`, `cantidad`, `id_usuario_transferencia`, `fecha_creacion`, `id_deposito_origen`) VALUES
(10, 5, 231, 51, 1, '2025-02-03 19:11:26', 1),
(11, 5, 229, 75, 1, '2025-02-03 19:11:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_vendedor` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  `id_deposito` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `total`, `id_vendedor`, `fecha_creacion`, `id_deposito`) VALUES
(27, 106, 229, 10, 200000, 200000, 1, '2025-02-02 22:37:28', NULL),
(28, 107, 230, 10, 2520000, 2520000, 1, '2025-02-02 23:22:45', NULL),
(29, 108, 230, 10, 2520000, 2520000, 1, '2025-02-03 18:26:11', NULL),
(30, 108, 229, 30, 200000, 200000, 1, '2025-02-03 18:26:11', NULL),
(31, 109, 231, 50, 2750000, 2750000, 1, '2025-02-03 18:45:34', NULL),
(32, 110, 229, 10, 200000, 200000, 1, '2025-02-03 19:17:14', NULL),
(33, 110, 231, 10, 2750000, 2750000, 1, '2025-02-03 19:17:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`codigo`, `nombre`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
('AC', 'A Crédito', 1, NULL, NULL, NULL, NULL),
('EFECTIVO', 'Efectivo', 1, NULL, NULL, NULL, NULL),
('TC', 'Tarjeta de Crédito', 1, NULL, NULL, NULL, NULL),
('TD', 'Tarjeta de Débito', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general`
--

CREATE TABLE `general` (
  `id` int(11) NOT NULL,
  `cuotas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `general`
--

INSERT INTO `general` (`id`, `cuotas`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_cliente`
--

CREATE TABLE `grupo_cliente` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `porcentaje` decimal(4,2) DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `grupo_cliente`
--

INSERT INTO `grupo_cliente` (`id`, `nombre`, `estado`, `porcentaje`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(2, 'General', 1, '0.00', 'admin', '2021-02-06 19:00:52', NULL, NULL),
(3, 'VIP', 1, '0.20', 'admin', '2021-02-06 19:33:01', 'admin', '2021-02-06 19:33:01'),
(4, 'Prueba', 0, '0.20', 'admin', '2021-02-06 19:32:30', NULL, '2021-02-06 19:32:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombremarca` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombremarca`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(5, 'ESTRELLA DAMM', 0, 'anegrete', '2022-12-20 15:30:36', NULL, NULL),
(6, 'AQUAFINA', 0, 'anegrete', '2022-12-20 15:30:41', NULL, NULL),
(7, 'LA COSTA', 0, 'anegrete', '2022-12-20 15:30:46', NULL, NULL),
(8, 'PILSEN', 0, 'anegrete', '2022-12-20 15:30:51', NULL, NULL),
(9, 'SKOL', 0, 'anegrete', '2022-12-20 15:30:57', NULL, NULL),
(10, 'PEPSI', 0, 'anegrete', '2022-12-20 15:31:02', NULL, NULL),
(11, 'WILSON', 0, 'anegrete', '2022-12-20 15:31:06', NULL, NULL),
(12, 'HEAD', 0, 'anegrete', '2022-12-20 15:31:18', NULL, NULL),
(13, 'PS', 0, 'anegrete', '2022-12-20 15:31:23', NULL, NULL),
(14, 'DARK DOG', 0, 'anegrete', '2022-12-20 15:31:28', NULL, NULL),
(15, 'GATORADE', 0, 'anegrete', '2022-12-20 15:31:33', NULL, NULL),
(16, 'Play Padel', 0, 'anegrete', '2022-12-20 15:31:37', NULL, NULL),
(17, 'MUNICH', 0, 'admin', '2022-12-20 15:31:42', NULL, NULL),
(18, 'STARVIE', 0, 'felidios', '2022-12-20 15:38:36', NULL, NULL),
(19, 'STARVIE', 1, 'felidios', '2022-12-20 15:43:22', NULL, NULL),
(20, 'SIUX', 1, 'felidios', '2022-12-20 15:43:33', NULL, NULL),
(21, 'DUNLOP', 1, 'felidios', '2022-12-20 15:43:42', NULL, NULL),
(22, 'ADIDAS', 1, 'felidios', '2022-12-20 15:43:49', NULL, NULL),
(23, 'BABOLAT', 1, 'felidios', '2022-12-20 15:43:58', NULL, NULL),
(24, 'ROYAL', 1, 'felidios', '2022-12-20 15:44:07', NULL, NULL),
(25, 'DROP SHOT', 1, 'felidios', '2022-12-20 15:44:18', NULL, NULL),
(26, 'ASICS', 1, 'felidios', '2022-12-20 15:44:29', NULL, NULL),
(27, 'LOTTO', 1, 'felidios', '2022-12-20 15:44:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`id`, `nombre`, `email`, `estado`) VALUES
(3, 'Mario Vazquez', 'fmva2011@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `hijo` tinyint(4) NOT NULL DEFAULT 0,
  `codigo` text DEFAULT NULL,
  `descripcion` text NOT NULL,
  `imagen` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `fechacreacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipo_producto` int(11) DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `stock_minimo_alerta` int(11) DEFAULT NULL,
  `tipo_impuesto` int(11) DEFAULT NULL,
  `tipo_control` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `product_id`, `hijo`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `fechacreacion`, `tipo_producto`, `usuariocreacion`, `usuariomodificacion`, `fechamodificacion`, `id_marca`, `id_unidad`, `fecha_vencimiento`, `stock_minimo_alerta`, `tipo_impuesto`, `tipo_control`, `estado`) VALUES
(197, 18, NULL, 0, '1801', 'Estrella Damm 660ml', 'vistas/img/productos/1801/735.jpg', 0, 11400, 15000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 5, 6, '2022-07-01', 10, 2, 2, 0),
(198, 18, NULL, 0, '1802', 'Estrella Damm Inedit 330ml', 'vistas/img/productos/1802/845.jpg', 0, 7917, 10000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 5, 6, '2022-07-01', 10, 2, 2, 0),
(199, 18, NULL, 0, '1803', 'Estrella Damm 330ml', 'vistas/img/productos//222.jpg', 0, 6580, 8000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 03:42:30', 5, 6, '2022-07-01', 10, 2, 2, 0),
(200, 18, NULL, 0, '1804', 'Skol 275ml', 'vistas/img/productos/1804/532.png', 0, 4238, 7000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 9, 6, '2022-07-01', 10, 2, 2, 0),
(201, 18, NULL, 0, '1805', 'Pilsen 340ml', 'vistas/img/productos//378.jpg', 0, 2063, 5000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 02:38:27', 8, 6, '2022-07-01', 10, 2, 2, 0),
(202, 18, NULL, 0, '1806', 'Gatorade Mandarina', 'vistas/img/productos/1806/165.png', 0, 6667, 10000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0),
(203, 18, NULL, 0, '1807', 'Gatorade Cool Blue', 'vistas/img/productos/1807/623.png', 0, 6667, 10000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0),
(204, 18, NULL, 0, '1808', 'Gatorade Frutos Rojos', 'vistas/img/productos/1808/121.png', 0, 6667, 10000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0),
(205, 18, NULL, 0, '1809', 'Dark Dog 250ml', 'vistas/img/productos/1809/546.png', 0, 9000, 11000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 14, 6, '2022-07-01', 10, 2, 2, 0),
(206, 19, NULL, 0, '1810', 'Tubo Head Pro S', 'vistas/img/productos/1901/140.jpg', 0, 35500, 55000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 12, 6, '2022-07-01', 10, 2, 2, 0),
(207, 18, NULL, 0, '1811', 'Agua mineral Aquafina 500ml sin gas', 'vistas/img/productos/1811/291.png', 0, 1950, 4000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 02:48:47', 6, 6, '2022-07-01', 10, 2, 2, 0),
(208, 18, NULL, 0, '1812', 'Agua mineral La Costa 500ml con gas', 'vistas/img/productos/1811/170.png', 0, 0, 4000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 03:51:05', 7, 6, '2022-07-01', 10, 2, 2, 0),
(209, 18, NULL, 0, '1813', 'Agua mineral Aquafina 2l sin gas', 'vistas/img/productos/1812/619.png', 0, 2625, 10000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 6, 6, '2022-07-01', 10, 2, 2, 0),
(210, 18, NULL, 0, '1814', 'Pepsi Cola 500ml', 'vistas/img/productos/1813/753.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 8, 6, '2022-07-01', 10, 2, 2, 0),
(211, 18, NULL, 0, '1815', 'Mirinda Guaraná 500ml', 'vistas/img/productos/1814/762.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(212, 18, NULL, 0, '1816', 'Mirinda Guaraná Free 500ml', 'vistas/img/productos/1814/578.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(213, 18, NULL, 0, '1817', 'Paso de los toros 500ml ', 'vistas/img/productos/1815/116.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(214, 18, NULL, 0, '1818', 'Agua tónica Paso de los toros 500ml', 'vistas/img/productos/1816/277.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(215, 18, NULL, 0, '1819', 'Seven Up 500ml', 'vistas/img/productos/1817/224.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(216, 18, NULL, 0, '1820', 'Mirinda naranja 500ml', 'vistas/img/productos/1817/638.jpg', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(217, 18, NULL, 0, '1821', 'Pepsi Cola Black 500ml', 'vistas/img/productos/1818/971.png', 0, 3600, 8000, '2025-02-01 20:09:50', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0),
(218, 19, NULL, 0, '1822', 'Muñequera Wilson blanca', 'vistas/img/productos/1819/402.jpg', 0, 25000, 40000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 03:47:47', 11, 6, '2022-07-01', 10, 2, 2, 0),
(219, 19, NULL, 0, '1823', 'Grip PS', 'vistas/img/productos/1819/839.png', 0, 8125, 15000, '2025-02-01 20:09:50', 1, 'anegrete', 'anegrete', '2021-07-13 03:48:20', 13, 6, '2022-07-01', 10, 2, 2, 0),
(220, 20, NULL, 0, '2001', 'Cancha 90', 'vistas/img/productos/2001/321.jpg', 0, 0, 90000, '2025-02-01 20:09:50', 2, 'anegrete', 'anegrete', '2021-07-13 03:50:32', 16, 6, '2022-07-01', 0, 2, 1, 0),
(221, 20, NULL, 0, '2002', 'Cancha 80', 'vistas/img/productos/2002/635.jpg', 0, 0, 80000, '2025-02-01 20:09:50', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0),
(222, 20, NULL, 0, '2003', 'Cancha clase 25', 'vistas/img/productos/2003/211.jpg', 0, 0, 25000, '2025-02-01 20:09:50', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0),
(223, 20, NULL, 0, '2004', 'Cancha clase 20', 'vistas/img/productos/2004/117.jpg', 0, 0, 20000, '2025-02-01 20:09:50', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0),
(224, 20, NULL, 0, '2005', 'Cancha clase 15', 'vistas/img/productos/2005/271.jpg', 0, 0, 15000, '2025-02-01 20:09:50', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0),
(225, 18, NULL, 0, '1822', 'CHOPP MUNICH', 'vistas/img/productos/default/anonymous.png', 0, 390000, 600000, '2025-02-01 20:09:50', 1, 'admin', NULL, NULL, 17, 8, '2025-05-11', 10, 3, 2, 0),
(226, 18, 225, 1, '1823', 'CHOPP MUNICH 1litro', 'vistas/img/productos/default/anonymous.png', 0, 2000, 5000, '2022-02-21 00:04:31', 1, 'admin', NULL, NULL, 17, 8, '2025-05-11', 10, 2, 2, 1),
(227, 19, NULL, 0, '1824', 'Producto de Prueba depostio Union', 'vistas/img/productos/1824/627.jpg', 0, 10000, 20000, '2025-02-01 20:09:50', 1, 'admin', 'admin', '2022-07-22 18:48:48', 11, 6, '2026-12-01', 5, 2, 2, 0),
(228, 18, NULL, 0, '1824', 'PALA STARVIE TRITON PRO', 'vistas/img/productos//482.jpg', 0, 1850000, 2250000, '2025-02-02 22:35:38', 1, 'felidios', 'felidios', '2022-12-20 16:10:31', 19, 6, '2022-12-20', 1, 2, 2, 1),
(229, 18, NULL, 0, '1825', 'PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN', 'vistas/img/productos//261.png', 195, 190000, 200000, '2025-02-03 19:12:37', 1, 'felidios', 'admin', '2025-01-27 16:14:47', 22, 6, '2022-12-20', 1, 2, 2, 1),
(230, 18, NULL, 0, '1826', 'PALA ADIDAS ADIPOWER 31', 'vistas/img/productos//589.jpg', 50, 1880000, 2520000, '2025-02-02 23:21:52', 1, 'felidios', 'admin', '2025-01-26 19:54:01', 22, 6, '2022-12-20', 1, 2, 2, 1),
(231, 18, NULL, 0, '1827', 'PALA ADIDAS ADIPOWER SEBA NERONE', 'vistas/img/productos//429.jpg', 150, 1880000, 2750000, '2025-02-03 19:12:48', 1, 'felidios', 'admin', '2025-01-30 19:54:51', 22, 6, '2022-12-20', 1, 2, 2, 1),
(232, 18, NULL, 0, '1828', 'PALA ADIDAS DRIVE', 'vistas/img/productos//889.jpg', 20, 483000, 750000, '2025-02-03 18:28:26', 1, 'felidios', 'admin', '2025-01-30 03:40:49', 22, 6, '2022-12-20', 1, 2, 2, 1),
(233, 18, NULL, 0, '1829', 'PALA STARVIE AQUILA SPACE', 'vistas/img/productos//257.jpg', 0, 1350000, 1700000, '2025-02-02 22:35:43', 1, 'felidios', 'felidios', '2022-12-20 16:04:43', 19, 6, '2022-12-20', 1, 2, 2, 1),
(234, 18, NULL, 0, '1830', 'PALA STARVIE ARCADIA', 'vistas/img/productos//777.jpg', 0, 750000, 900000, '2025-02-01 20:09:50', 1, 'felidios', 'felidios', '2022-12-20 16:05:25', 19, 6, '2022-12-20', 1, 2, 2, 1),
(235, 18, NULL, 0, '1831', 'PALA STARVIE ASTRUM 2022', 'vistas/img/productos//959.jpg', 0, 2050000, 2450000, '2025-02-01 20:09:50', 1, 'felidios', 'felidios', '2022-12-20 16:06:15', 19, 6, '2022-12-20', 1, 2, 2, 1),
(236, 18, NULL, 0, '1832', 'PALA STARVIE BASALTO OSIRIS', 'vistas/img/productos//871.jpg', 0, 1750000, 2100000, '2025-02-01 20:09:50', 1, 'felidios', 'felidios', '2022-12-20 16:07:02', 19, 6, '2022-12-20', 1, 2, 2, 1),
(237, 18, NULL, 0, '1833', 'PALA STARVIE METHEORA 2022', 'vistas/img/productos//151.jpg', 0, 2220000, 2750000, '2025-02-01 20:09:50', 1, 'felidios', 'felidios', '2022-12-20 16:08:03', 19, 6, '2022-12-20', 1, 2, 2, 1),
(238, 21, NULL, 0, '2101', 'Prueba/Prueba', 'vistas/img/productos/default/anonymous.png', 0, 10, 20, '2025-02-01 20:09:50', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0),
(239, 20, NULL, 0, '2006', 'prueba.', 'vistas/img/productos/default/anonymous.png', 0, 1, 2, '2025-02-01 20:09:50', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0),
(240, 20, NULL, 0, '2007', 'prueba,', 'vistas/img/productos/default/anonymous.png', 0, 1, 2, '2025-02-01 20:09:50', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0),
(241, 20, NULL, 0, '2008', 'prueba-_.,/', 'vistas/img/productos/default/anonymous.png', 0, 12, 2, '2025-02-02 22:35:47', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0),
(242, 19, NULL, 0, '1825', 'PRODUCTO DE PRUEBA.,/-_', 'vistas/img/productos/default/anonymous.png', 0, 12, 23, '2025-02-02 22:35:47', 2, 'admin', 'admin', '2023-01-04 23:24:01', 19, 6, '2023-01-04', 1, 1, 1, 0),
(243, 19, NULL, 0, '1826', 'PELOTA DE SOFTBOL', 'vistas/img/productos/default/anonymous.png', 0, 153000, 360000, '2025-02-02 22:35:49', 1, 'admin', NULL, NULL, 24, 6, '2030-01-28', 10, 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_deposito`
--

CREATE TABLE `producto_deposito` (
  `idProducto` int(11) NOT NULL,
  `idDeposito` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `ruc` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `nombrecontacto` text DEFAULT NULL,
  `telefonocontacto` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `ruc`, `direccion`, `telefono`, `email`, `nombrecontacto`, `telefonocontacto`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(3, 'Mario Vazquez', '3673518-3', 'carandayty 207', '0983902795', 'fmva2011@gmail.com', 'Mario Vazquez', '0983902795', 1, 'admin', '2021-12-20 01:20:15', NULL, NULL),
(5, 'Felix Arce', '3673518-9', 'Carandayty 297', '0983902794', 'f.mva2011@gmail.com', 'c', '0983902795', 1, 'admin', '2023-01-04 23:36:02', NULL, NULL),
(6, 'Felix Arce', '3673518-9', 'Carandayty 297', '0983902794', 'fmv-a2011@gmail.com', 'c', '0983902795', 1, 'admin', '2023-01-04 23:36:54', NULL, NULL),
(7, 'Felix Arce', '3673518-0', 'Carandayty 297', '0983902794', 'fmv-a2011@gmail.com', 'andrs', '0983902797', 1, 'admin', '2023-01-05 00:08:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_producto`
--

CREATE TABLE `stock_producto` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_deposito` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `stock_producto`
--

INSERT INTO `stock_producto` (`id`, `id_producto`, `id_deposito`, `stock`) VALUES
(1, 237, 1, 0),
(2, 236, 1, 0),
(3, 235, 1, 0),
(4, 234, 1, 0),
(5, 233, 1, 0),
(6, 232, 1, 20),
(7, 231, 1, 50),
(8, 230, 1, 30),
(9, 229, 1, 75),
(10, 228, 1, 0),
(11, 242, 1, 0),
(12, 241, 1, 0),
(13, 240, 1, 0),
(14, 239, 1, 0),
(15, 238, 1, 0),
(16, 201, 1, 0),
(17, 200, 1, 0),
(18, 199, 1, 0),
(19, 198, 1, 0),
(20, 197, 1, 0),
(22, 243, 1, 0),
(23, 231, 8, 40),
(24, 229, 8, 70);

--
-- Disparadores `stock_producto`
--
DELIMITER $$
CREATE TRIGGER `stock_producto_after_insert` AFTER INSERT ON `stock_producto` FOR EACH ROW BEGIN

/*
	if length(NEW.usuario)>0 OR length(NEW.usuario)>0 then
      INSERT INTO stock_prod_hist (cantidad, fecha, tipo, usuario, nota, id_stock_producto) VALUES (NEW.stock, CURRENT_TIMESTAMP(),'Ajuste', NEW.usuario, NEW.nota,  NEW.id);
   END if;
*/   
   /*UPDATE productos SET stock = NEW.stock WHERE id=NEW.id_producto;*/

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stock_producto_after_update` AFTER UPDATE ON `stock_producto` FOR EACH ROW BEGIN

/*
   if length(NEW.usuario)>0 OR length(NEW.usuario)>0 then
   
   		INSERT INTO stock_prod_hist (cantidad, fecha, tipo, usuario, nota, id_stock_producto) VALUES ((NEW.stock-OLD.stock), CURRENT_TIMESTAMP(),'Ajuste', OLD.usuario, NEW.nota,  NEW.id);
   
   end if;
*/
	/*UPDATE productos SET stock = NEW.stock WHERE id=NEW.id_producto;*/

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_prod_hist`
--

CREATE TABLE `stock_prod_hist` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('Nuevo','Ajuste') NOT NULL DEFAULT 'Ajuste',
  `nota` longtext DEFAULT NULL,
  `usuario` char(50) DEFAULT NULL,
  `id_stock_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `stock_prod_hist`
--

INSERT INTO `stock_prod_hist` (`id`, `cantidad`, `fecha`, `tipo`, `nota`, `usuario`, `id_stock_producto`) VALUES
(148, -9, '2025-02-02 18:40:07', 'Ajuste', 'regalías ', 'admin', 9),
(149, 30, '2025-02-03 15:27:09', 'Ajuste', 'control de stock', 'admin', 9),
(150, 51, '2025-02-03 15:46:18', 'Ajuste', 'ajuste inventario', 'admin', 7),
(151, 5, '2025-02-03 16:12:37', 'Ajuste', 'ajuste', 'admin', 24),
(152, -1, '2025-02-03 16:12:48', 'Ajuste', 'ajuste', 'admin', 23);

--
-- Disparadores `stock_prod_hist`
--
DELIMITER $$
CREATE TRIGGER `stock_prod_hist_after_insert` AFTER INSERT ON `stock_prod_hist` FOR EACH ROW BEGIN

	/*	UPDATE stock_producto SET usuario=null, nota=null WHERE id = NEW.id_stock_producto;¨*/

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `sucursal` text NOT NULL,
  `estado` int(11) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariocreacion` text DEFAULT NULL,
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `sucursal`, `estado`, `fecha_creacion`, `usuariocreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, 'Central', 1, '2019-01-26 11:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `termino_pago`
--

CREATE TABLE `termino_pago` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `dias` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `termino_pago`
--

INSERT INTO `termino_pago` (`id`, `descripcion`, `dias`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, '80 días', 80, 1, 'admin', '2021-02-10 06:58:51', NULL, NULL),
(2, '31 dias', 31, 0, 'admin', '2021-02-10 07:16:57', 'admin', '2021-02-10 07:16:50'),
(3, '60 dias', 60, 1, 'admin', '2021-02-10 07:17:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_compra`
--

CREATE TABLE `tipo_compra` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_compra`
--

INSERT INTO `tipo_compra` (`id`, `nombre`) VALUES
(1, 'Contado'),
(2, 'Crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_control`
--

CREATE TABLE `tipo_control` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_control`
--

INSERT INTO `tipo_control` (`id`, `nombre`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`, `orden`) VALUES
(1, 'No Controlar', 1, NULL, '2021-02-14 07:33:52', NULL, NULL, 1),
(2, 'Controlar', 1, NULL, '2021-02-14 07:33:52', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_impuesto`
--

CREATE TABLE `tipo_impuesto` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `valor_impuesto` decimal(18,2) DEFAULT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_impuesto`
--

INSERT INTO `tipo_impuesto` (`id`, `descripcion`, `estado`, `valor_impuesto`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, 'IVA 5', 1, '0.05', NULL, '2021-02-14 07:16:29', NULL, NULL),
(2, 'IVA 10', 1, '0.10', NULL, '2021-02-14 07:16:29', NULL, NULL),
(3, 'EXCENTA', 1, '0.00', NULL, '2021-02-14 07:16:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id`, `nombre`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, 'Estándar', 1, NULL, '2021-02-14 07:04:19', NULL, NULL),
(2, 'Servicio', 1, NULL, '2021-02-14 07:04:19', NULL, NULL),
(3, 'Prenda/Calzado', 1, NULL, '2021-02-14 07:04:19', NULL, NULL),
(4, 'Producción', 1, NULL, '2021-02-14 07:04:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencia`
--

CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL,
  `id_usuario_transferencia` int(11) DEFAULT NULL,
  `productos` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL,
  `id_usuario_aprobacion` int(11) DEFAULT NULL,
  `fecha_aprobacion` timestamp NULL DEFAULT NULL,
  `id_usuario_recepcion` int(11) DEFAULT NULL,
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `id_deposito_origen` int(11) DEFAULT NULL,
  `id_deposito_destino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transferencia`
--

INSERT INTO `transferencia` (`id`, `id_usuario_transferencia`, `productos`, `fecha_registro`, `estado`, `id_usuario_aprobacion`, `fecha_aprobacion`, `id_usuario_recepcion`, `fecha_recepcion`, `id_deposito_origen`, `id_deposito_destino`) VALUES
(5, 1, '[{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"51\",\"stock\":\"50\",\"iddeposito\":\"1\"},{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"75\",\"stock\":\"75\",\"iddeposito\":\"1\"}]', '2025-02-03 19:11:26', 3, 1, '2025-02-03 19:11:42', 1, '2025-02-03 19:12:01', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `codunidad` text DEFAULT NULL,
  `unidad` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `codunidad`, `unidad`, `estado`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(6, 'UNIDADES', 'UNID', 1, 'anegrete', '2021-07-13 02:09:31', NULL, NULL),
(7, 'TUBO', 'TUBO', 1, 'anegrete', '2021-07-13 02:09:48', NULL, NULL),
(8, 'LTS', 'LITROS', 1, 'admin', '2022-02-21 00:00:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Administrador', 'vistas/img/usuarios/admin/191.jpg', 1, '2025-02-03 13:56:07', '2025-02-03 18:56:07'),
(2, 'Especial', 'erincon', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Especial', '', 1, '2025-01-26 13:50:05', '2025-01-26 18:50:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_depositos`
--

CREATE TABLE `usuario_depositos` (
  `idUsuario` int(11) NOT NULL,
  `idDeposito` int(11) NOT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_depositos`
--

INSERT INTO `usuario_depositos` (`idUsuario`, `idDeposito`, `usuariocreacion`, `fechacreacion`, `usuariomodificacion`, `fechamodificacion`) VALUES
(1, 1, '1', '2025-02-03 18:56:24', NULL, NULL),
(1, 7, '1', '2025-02-03 18:56:24', NULL, NULL),
(1, 8, '1', '2025-02-03 18:56:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` varchar(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo_operacion` varchar(10) DEFAULT NULL,
  `nro_cuotas` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `fecha`, `fechamodificacion`, `codigo_operacion`, `nro_cuotas`, `estado`) VALUES
(106, 1, 15, 1, '[{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"10\",\"stock\":\"90\",\"precio\":\"200000\",\"total\":\"200000\",\"iddeposito\":\"1\"}]', 0, 2000000, 2000000, 'EFECTIVO', '2025-02-02 22:37:28', NULL, '', 0, 1),
(107, 1, 16, 1, '[{\"id\":\"230\",\"descripcion\":\"PALA ADIDAS ADIPOWER 31\",\"cantidad\":\"10\",\"stock\":\"40\",\"precio\":\"2520000\",\"total\":\"2520000\",\"iddeposito\":\"1\"}]', 0, 25200000, 25200000, 'EFECTIVO', '2025-02-02 23:22:45', NULL, '', 0, 1),
(108, 2, 14, 1, '[{\"id\":\"230\",\"descripcion\":\"PALA ADIDAS ADIPOWER 31\",\"cantidad\":\"10\",\"stock\":\"40\",\"precio\":\"2520000\",\"total\":\"2520000\",\"iddeposito\":\"1\"},{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"30\",\"stock\":\"110\",\"precio\":\"200000\",\"total\":\"200000\",\"iddeposito\":\"1\"}]', 0, 31200000, 31200000, 'EFECTIVO', '2025-02-03 18:26:11', NULL, '', 0, 1),
(109, 2, 16, 1, '[{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"50\",\"stock\":\"50\",\"precio\":\"2750000\",\"total\":\"2750000\",\"iddeposito\":\"1\"}]', 0, 137500000, 137500000, 'EFECTIVO', '2025-02-03 18:45:34', NULL, '', 0, 1),
(110, 3, 14, 1, '[{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30 - PRUEBA DE EDICIÓN\",\"cantidad\":\"10\",\"stock\":\"185\",\"precio\":\"200000\",\"total\":\"200000\",\"iddeposito\":\"8\"},{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"10\",\"stock\":\"140\",\"precio\":\"2750000\",\"total\":\"2750000\",\"iddeposito\":\"8\"}]', 0, 29500000, 29500000, 'EFECTIVO', '2025-02-03 19:17:14', NULL, '', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_creditos`
--

CREATE TABLE `ventas_creditos` (
  `id` int(11) NOT NULL,
  `id_ventas` int(11) NOT NULL,
  `monto_pagado` double DEFAULT NULL,
  `monto_deudor` double DEFAULT NULL,
  `cuotas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aperturas`
--
ALTER TABLE `aperturas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_CAJA_SUCURSAL_idx` (`idcaja`) USING BTREE;

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `calces`
--
ALTER TABLE `calces`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `categorias_gastos`
--
ALTER TABLE `categorias_gastos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_PROD_COMPRA_DET_idx` (`id_producto`) USING BTREE,
  ADD KEY `FK_COMPRA_DET_COM_idx` (`id_compra`) USING BTREE;

--
-- Indices de la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_TRANSFERENCIA` (`id_transferencia`),
  ADD KEY `FK_PRODUCTO` (`id_producto`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_PROD_VENTA_DET_idx` (`id_producto`) USING BTREE,
  ADD KEY `FK_VEND_VENTA_DET_idx` (`id_vendedor`) USING BTREE,
  ADD KEY `FK_VENT_DET_VEN_idx` (`id_venta`) USING BTREE;

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`codigo`) USING BTREE;

--
-- Indices de la tabla `general`
--
ALTER TABLE `general`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `grupo_cliente`
--
ALTER TABLE `grupo_cliente`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_TIPO_IMPUESTO_PRO_idx` (`tipo_impuesto`) USING BTREE,
  ADD KEY `FK_CATEGORIA_PRO_idx` (`id_categoria`) USING BTREE,
  ADD KEY `FK_TIPO_PRO_idx` (`tipo_producto`) USING BTREE,
  ADD KEY `FK_MARCA_PRO_idx` (`id_marca`) USING BTREE,
  ADD KEY `FK_UNIDAD_PRO_idx` (`id_unidad`) USING BTREE,
  ADD KEY `FK_TIPO_CONTROL_idx` (`tipo_control`) USING BTREE;

--
-- Indices de la tabla `producto_deposito`
--
ALTER TABLE `producto_deposito`
  ADD PRIMARY KEY (`idProducto`,`idDeposito`) USING BTREE;

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `stock_producto`
--
ALTER TABLE `stock_producto`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id_producto_id_deposito` (`id_producto`,`id_deposito`);

--
-- Indices de la tabla `stock_prod_hist`
--
ALTER TABLE `stock_prod_hist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_stock_prod_hist_stock_producto` (`id_stock_producto`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `termino_pago`
--
ALTER TABLE `termino_pago`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `tipo_control`
--
ALTER TABLE `tipo_control`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `tipo_impuesto`
--
ALTER TABLE `tipo_impuesto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `usuario_depositos`
--
ALTER TABLE `usuario_depositos`
  ADD PRIMARY KEY (`idUsuario`,`idDeposito`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `ventas_creditos`
--
ALTER TABLE `ventas_creditos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aperturas`
--
ALTER TABLE `aperturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calces`
--
ALTER TABLE `calces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `categorias_gastos`
--
ALTER TABLE `categorias_gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `depositos`
--
ALTER TABLE `depositos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `general`
--
ALTER TABLE `general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupo_cliente`
--
ALTER TABLE `grupo_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `stock_producto`
--
ALTER TABLE `stock_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `stock_prod_hist`
--
ALTER TABLE `stock_prod_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `termino_pago`
--
ALTER TABLE `termino_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_impuesto`
--
ALTER TABLE `tipo_impuesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `ventas_creditos`
--
ALTER TABLE `ventas_creditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aperturas`
--
ALTER TABLE `aperturas`
  ADD CONSTRAINT `FK_CAJA_SUCURSAL` FOREIGN KEY (`idcaja`) REFERENCES `cajas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `FK_COMPRA_DET_COM` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_PROD_COMPRA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  ADD CONSTRAINT `FK_PRODUCTO` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TRANSFERENCIA` FOREIGN KEY (`id_transferencia`) REFERENCES `transferencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `FK_PROD_VENTA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_VENT_DET_VEN` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_CATEGORIA_PRO` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_MARCA_PRO` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TIPO_CONTROL` FOREIGN KEY (`tipo_control`) REFERENCES `tipo_control` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TIPO_IMP` FOREIGN KEY (`tipo_impuesto`) REFERENCES `tipo_impuesto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TIPO_PRO` FOREIGN KEY (`tipo_producto`) REFERENCES `tipo_producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_UNIDAD_PRO` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stock_prod_hist`
--
ALTER TABLE `stock_prod_hist`
  ADD CONSTRAINT `FK_stock_prod_hist_stock_producto` FOREIGN KEY (`id_stock_producto`) REFERENCES `stock_producto` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
