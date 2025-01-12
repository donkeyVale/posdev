/*
 Navicat Premium Data Transfer

 Source Server         : DigitalOcean
 Source Server Type    : MySQL
 Source Server Version : 50740
 Source Host           : 147.182.174.137:3306
 Source Schema         : pospruebas_db

 Target Server Type    : MySQL
 Target Server Version : 50740
 File Encoding         : 65001

 Date: 05/01/2023 22:15:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aperturas
-- ----------------------------
DROP TABLE IF EXISTS `aperturas`;
CREATE TABLE `aperturas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcaja` int(11) NULL DEFAULT NULL,
  `monto_apertura` decimal(10, 2) NULL DEFAULT NULL,
  `usuarioapertura` int(11) NULL DEFAULT NULL,
  `fechaapertura` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int(11) NULL DEFAULT 1,
  `fechacierre` timestamp NULL DEFAULT NULL,
  `monto_cierre` decimal(10, 2) NULL DEFAULT NULL,
  `fechaeliminacion` timestamp NULL DEFAULT NULL,
  `usuarioeliminacion` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_CAJA_SUCURSAL_idx`(`idcaja`) USING BTREE,
  CONSTRAINT `FK_CAJA_SUCURSAL` FOREIGN KEY (`idcaja`) REFERENCES `cajas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of aperturas
-- ----------------------------
INSERT INTO `aperturas` VALUES (1, 1, 200000.00, 11, '2022-12-20 12:34:28', 0, NULL, 13400000.00, NULL, NULL);
INSERT INTO `aperturas` VALUES (2, 1, 0.00, 11, '2022-12-21 23:02:56', 1, NULL, NULL, NULL, NULL);
INSERT INTO `aperturas` VALUES (3, 1, 200000.00, 1, '2023-01-04 20:59:22', 0, NULL, 250000.00, NULL, NULL);
INSERT INTO `aperturas` VALUES (4, 1, 300000.00, 1, '2023-01-04 20:59:51', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for cajas
-- ----------------------------
DROP TABLE IF EXISTS `cajas`;
CREATE TABLE `cajas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cajas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `idSucursal` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cajas
-- ----------------------------
INSERT INTO `cajas` VALUES (1, 'Caja Principal', 1, '2021-02-11 06:17:02', 'admin', NULL, NULL, 1);

-- ----------------------------
-- Table structure for cajas_sucursales
-- ----------------------------
DROP TABLE IF EXISTS `cajas_sucursales`;
CREATE TABLE `cajas_sucursales`  (
  `id_caja` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `monto_caja` double NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cajas_sucursales
-- ----------------------------

-- ----------------------------
-- Table structure for cajas_ventas
-- ----------------------------
DROP TABLE IF EXISTS `cajas_ventas`;
CREATE TABLE `cajas_ventas`  (
  `id_caja` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `fecha_creacion` date NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cajas_ventas
-- ----------------------------

-- ----------------------------
-- Table structure for calces
-- ----------------------------
DROP TABLE IF EXISTS `calces`;
CREATE TABLE `calces`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of calces
-- ----------------------------

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codcategoria` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `usuariocreacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `usuariomodificacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (18, 'PALAS', '2022-12-20 11:45:25', 'PALAS', 'anegrete', 'felidios', '2022-12-20 11:45:25', 1);
INSERT INTO `categorias` VALUES (19, 'ARTICULOS DEPORTIVOS', '2021-07-12 22:05:40', 'ART DEPORTIVOS', 'anegrete', NULL, NULL, 1);
INSERT INTO `categorias` VALUES (20, 'CALZADOS', '2022-12-20 11:45:47', 'CALZADOS', 'anegrete', 'felidios', '2022-12-20 11:45:47', 1);
INSERT INTO `categorias` VALUES (21, 'BOLSOS', '2022-12-20 11:45:58', 'BOLSOS', 'felidios', NULL, NULL, 1);

-- ----------------------------
-- Table structure for categorias_gastos
-- ----------------------------
DROP TABLE IF EXISTS `categorias_gastos`;
CREATE TABLE `categorias_gastos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias_gastos
-- ----------------------------
INSERT INTO `categorias_gastos` VALUES (1, 'Gasto 2020', 1, 'admin', '2021-11-24 13:17:17', 'admin', '2021-11-24 13:17:17');
INSERT INTO `categorias_gastos` VALUES (2, 'Gasto 2', 0, 'admin', '2021-02-15 02:52:50', NULL, NULL);

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NULL DEFAULT NULL,
  `ultima_compra` datetime NULL DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariomodificacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `grupocliente` int(11) NULL DEFAULT NULL,
  `limitecredito` decimal(18, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES (14, 'Ruben Vazquez', '3673519', 'fmva2011@gmail.com', '0983902795', 'Carandayty 207', '1984-05-11', 17, '2022-02-20 15:07:16', '2022-02-20 20:07:16', 'admin', 1, NULL, NULL, 2, 0.00);
INSERT INTO `clientes` VALUES (15, 'Mario Vazquez', '3673528-3', 'fmva2011@gmail.com', '0983902795', 'Carandayty 207', '1984-05-11', 26, '2022-12-20 07:33:43', '2022-12-20 12:33:43', 'admin', 1, NULL, NULL, 2, 300000.00);
INSERT INTO `clientes` VALUES (16, 'Casual', '12345678', 'mfndene@gmail.com', '0983902794', 'Carandayty 297', '1984-05-20', 4, '2022-12-20 07:33:02', '2022-12-20 12:33:02', 'felidios', 1, NULL, NULL, 2, 200000.00);
INSERT INTO `clientes` VALUES (17, 'Mario Arce', '3673518-4', 'f_m-v.a2011@gmail.com', '0983902794', 'Carandayty 297', '1984-05-11', NULL, NULL, '2023-01-04 20:58:50', 'admin', 1, NULL, NULL, 2, 0.00);
INSERT INTO `clientes` VALUES (18, 'Mario Arce', '3673518-3', 'f_m-v.a2011@gmail.com', '0983902794', 'Carandayty 297', '2023-01-04', NULL, NULL, '2023-01-04 21:09:40', 'admin', 1, NULL, NULL, 2, 0.00);

-- ----------------------------
-- Table structure for colores
-- ----------------------------
DROP TABLE IF EXISTS `colores`;
CREATE TABLE `colores`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of colores
-- ----------------------------
INSERT INTO `colores` VALUES (3, 'Amarillo', 1, 'admin', '2021-05-30 23:54:16', NULL, NULL);
INSERT INTO `colores` VALUES (4, 'Rojo Perlado', 0, 'admin', '2021-05-30 23:54:45', 'admin', '2021-05-30 23:54:39');
INSERT INTO `colores` VALUES (5, 'morado', 1, 'admin', '2021-05-30 23:54:31', NULL, NULL);

-- ----------------------------
-- Table structure for compras
-- ----------------------------
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NULL DEFAULT NULL,
  `fechacompra` timestamp NULL DEFAULT NULL,
  `referencia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nrofactura` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_deposito` int(11) NULL DEFAULT NULL,
  `id_tipo_compra` int(11) NULL DEFAULT NULL,
  `productos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `neto` float NULL DEFAULT NULL,
  `total` float NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado_compra` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of compras
-- ----------------------------
INSERT INTO `compras` VALUES (1, 1, '2021-11-24 05:00:00', '123', '12345678', 1, 2, '[{\"id\":\"219\",\"descripcion\":\"Grip PS\",\"cantidad\":\"10\",\"precio\":\"15000\",\"total\":150000},{\"id\":\"205\",\"descripcion\":\"Dark Dog 250ml\",\"cantidad\":\"10\",\"precio\":\"11000\",\"total\":110000}]', 260000, 260000, '1', '2021-11-24 13:51:28', NULL, NULL, 1);
INSERT INTO `compras` VALUES (2, 1, '2021-11-24 05:00:00', '123', '123', 1, 1, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"1\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"223\",\"descripcion\":\"Cancha clase 20\",\"cantidad\":\"1\",\"precio\":\"20000\",\"total\":20000}]', 35000, 35000, '1', '2021-11-24 15:11:52', NULL, NULL, 1);
INSERT INTO `compras` VALUES (3, 1, '2021-11-24 05:00:00', '1234', '1234', 1, 1, '[{\"id\":\"209\",\"descripcion\":\"Agua mineral Aquafina 2l sin gas\",\"cantidad\":\"1\",\"precio\":\"10000\",\"total\":10000}]', 10000, 10989, '1', '2021-11-24 15:16:08', NULL, NULL, 1);
INSERT INTO `compras` VALUES (4, 3, '2022-02-20 03:00:00', 'chopp', '123', 1, 1, '[{\"id\":\"225\",\"descripcion\":\"CHOPP MUNICH\",\"cantidad\":\"60\",\"precio\":\"390000\",\"total\":23400000}]', 23400000, 23400000, '1', '2022-02-20 20:06:07', NULL, NULL, 1);
INSERT INTO `compras` VALUES (5, 3, '2022-07-18 04:00:00', 'ñl,nkljn', '00000001', 1, 1, '[{\"id\":\"209\",\"descripcion\":\"Agua mineral Aquafina 2l sin gas\",\"cantidad\":\"20\",\"precio\":\"2625\",\"total\":52500}]', 52500, 52500, '1', '2022-07-19 00:55:01', NULL, NULL, 1);
INSERT INTO `compras` VALUES (6, 3, '2022-07-22 04:00:00', 'Prueba deposito', '00000001', 6, 1, '[{\"id\":\"227\",\"descripcion\":\"Producto de Prueba depostio Union\",\"cantidad\":\"100\",\"precio\":\"10000\",\"total\":1000000}]', 1000000, 1000000, '1', '2022-07-22 14:49:39', NULL, NULL, 1);
INSERT INTO `compras` VALUES (7, 3, '2022-12-20 00:00:00', 'STOCKINI', '000000001', 1, 1, '[{\"id\":\"237\",\"descripcion\":\"PALA STARVIE METHEORA 2022\",\"cantidad\":\"5\",\"precio\":\"2220000\",\"total\":11100000},{\"id\":\"236\",\"descripcion\":\"PALA STARVIE BASALTO OSIRIS\",\"cantidad\":\"1\",\"precio\":\"1750000\",\"total\":1750000},{\"id\":\"235\",\"descripcion\":\"PALA STARVIE ASTRUM 2022\",\"cantidad\":\"1\",\"precio\":\"2050000\",\"total\":2050000},{\"id\":\"234\",\"descripcion\":\"PALA STARVIE ARCADIA\",\"cantidad\":\"1\",\"precio\":\"750000\",\"total\":750000},{\"id\":\"233\",\"descripcion\":\"PALA STARVIE AQUILA SPACE\",\"cantidad\":\"1\",\"precio\":\"1350000\",\"total\":1350000},{\"id\":\"232\",\"descripcion\":\"PALA ADIDAS DRIVE\",\"cantidad\":\"1\",\"precio\":\"483000\",\"total\":483000},{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"1\",\"precio\":\"1880000\",\"total\":1880000},{\"id\":\"230\",\"descripcion\":\"PALA ADIDAS ADIPOWER 31\",\"cantidad\":\"1\",\"precio\":\"1880000\",\"total\":1880000},{\"id\":\"229\",\"descripcion\":\"PALA ADIDAS ADIPOWER 30\",\"cantidad\":\"1\",\"precio\":\"1880000\",\"total\":1880000},{\"id\":\"228\",\"descripcion\":\"PALA STARVIE TRITON PRO\",\"cantidad\":\"1\",\"precio\":\"1850000\",\"total\":1850000}]', 24973000, 24973000, '11', '2022-12-20 12:29:09', NULL, NULL, 1);

-- ----------------------------
-- Table structure for depositos
-- ----------------------------
DROP TABLE IF EXISTS `depositos`;
CREATE TABLE `depositos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deposito` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `telefono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of depositos
-- ----------------------------
INSERT INTO `depositos` VALUES (1, 'Depósito Principal 2021', 1, '2022-12-23 23:50:13', 'admin', 'admin', '2022-12-23 23:50:13', 'DP', '0983902795', 'fmva2011@gmail.com', 'FERNANDO DE LA MORA');
INSERT INTO `depositos` VALUES (7, 'DEPOSITO UNION', 1, '2022-12-23 23:48:54', 'admin', NULL, NULL, 'DU', '0983902795', 'fmva2011@gmail.com', 'LUQUE');
INSERT INTO `depositos` VALUES (8, 'DEPOSITO  TOP PADEL', 1, '2022-12-23 23:49:30', 'admin', NULL, NULL, 'DTP', '0983902795', 'fmva2011@gmail.com', 'LAMBARE');

-- ----------------------------
-- Table structure for detalle_compras
-- ----------------------------
DROP TABLE IF EXISTS `detalle_compras`;
CREATE TABLE `detalle_compras`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `cantidad` int(11) NULL DEFAULT NULL,
  `precio_unitario` float NULL DEFAULT NULL,
  `total` float NULL DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_PROD_COMPRA_DET_idx`(`id_producto`) USING BTREE,
  INDEX `FK_COMPRA_DET_COM_idx`(`id_compra`) USING BTREE,
  CONSTRAINT `FK_COMPRA_DET_COM` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_PROD_COMPRA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_compras
-- ----------------------------
INSERT INTO `detalle_compras` VALUES (1, 7, 237, 5, 2220000, 11100000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (2, 7, 236, 1, 1750000, 1750000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (3, 7, 235, 1, 2050000, 2050000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (4, 7, 234, 1, 750000, 750000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (5, 7, 233, 1, 1350000, 1350000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (6, 7, 232, 1, 483000, 483000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (7, 7, 231, 1, 1880000, 1880000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (8, 7, 230, 1, 1880000, 1880000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (9, 7, 229, 1, 1880000, 1880000, '2022-12-20 12:29:09');
INSERT INTO `detalle_compras` VALUES (10, 7, 228, 1, 1850000, 1850000, '2022-12-20 12:29:09');

-- ----------------------------
-- Table structure for detalle_ventas
-- ----------------------------
DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE `detalle_ventas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `cantidad` int(11) NULL DEFAULT NULL,
  `precio_unitario` float NULL DEFAULT NULL,
  `total` float NULL DEFAULT NULL,
  `id_vendedor` int(11) NULL DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_PROD_VENTA_DET_idx`(`id_producto`) USING BTREE,
  INDEX `FK_VEND_VENTA_DET_idx`(`id_vendedor`) USING BTREE,
  INDEX `FK_VENT_DET_VEN_idx`(`id_venta`) USING BTREE,
  CONSTRAINT `FK_PROD_VENTA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_VENT_DET_VEN` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_ventas
-- ----------------------------
INSERT INTO `detalle_ventas` VALUES (5, 86, 233, 1, 1700000, 1700000, 11, '2022-12-20 12:33:43');
INSERT INTO `detalle_ventas` VALUES (6, 86, 232, 1, 750000, 750000, 11, '2022-12-20 12:33:43');
INSERT INTO `detalle_ventas` VALUES (7, 86, 231, 1, 2750000, 2750000, 11, '2022-12-20 12:33:43');

-- ----------------------------
-- Table structure for forma_pago
-- ----------------------------
DROP TABLE IF EXISTS `forma_pago`;
CREATE TABLE `forma_pago`  (
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of forma_pago
-- ----------------------------
INSERT INTO `forma_pago` VALUES ('AC', 'A Crédito', 1, NULL, NULL, NULL, NULL);
INSERT INTO `forma_pago` VALUES ('EFECTIVO', 'Efectivo', 1, NULL, NULL, NULL, NULL);
INSERT INTO `forma_pago` VALUES ('TC', 'Tarjeta de Crédito', 1, NULL, NULL, NULL, NULL);
INSERT INTO `forma_pago` VALUES ('TD', 'Tarjeta de Débito', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for general
-- ----------------------------
DROP TABLE IF EXISTS `general`;
CREATE TABLE `general`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuotas` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of general
-- ----------------------------
INSERT INTO `general` VALUES (1, 2);

-- ----------------------------
-- Table structure for grupo_cliente
-- ----------------------------
DROP TABLE IF EXISTS `grupo_cliente`;
CREATE TABLE `grupo_cliente`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `porcentaje` decimal(4, 2) NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grupo_cliente
-- ----------------------------
INSERT INTO `grupo_cliente` VALUES (2, 'General', 1, 0.00, 'admin', '2021-02-06 15:00:52', NULL, NULL);
INSERT INTO `grupo_cliente` VALUES (3, 'VIP', 1, 0.20, 'admin', '2021-02-06 15:33:01', 'admin', '2021-02-06 15:33:01');
INSERT INTO `grupo_cliente` VALUES (4, 'Prueba', 0, 0.20, 'admin', '2021-02-06 15:32:30', NULL, '2021-02-06 15:32:30');

-- ----------------------------
-- Table structure for marcas
-- ----------------------------
DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombremarca` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of marcas
-- ----------------------------
INSERT INTO `marcas` VALUES (5, 'ESTRELLA DAMM', 0, 'anegrete', '2022-12-20 11:30:36', NULL, NULL);
INSERT INTO `marcas` VALUES (6, 'AQUAFINA', 0, 'anegrete', '2022-12-20 11:30:41', NULL, NULL);
INSERT INTO `marcas` VALUES (7, 'LA COSTA', 0, 'anegrete', '2022-12-20 11:30:46', NULL, NULL);
INSERT INTO `marcas` VALUES (8, 'PILSEN', 0, 'anegrete', '2022-12-20 11:30:51', NULL, NULL);
INSERT INTO `marcas` VALUES (9, 'SKOL', 0, 'anegrete', '2022-12-20 11:30:57', NULL, NULL);
INSERT INTO `marcas` VALUES (10, 'PEPSI', 0, 'anegrete', '2022-12-20 11:31:02', NULL, NULL);
INSERT INTO `marcas` VALUES (11, 'WILSON', 0, 'anegrete', '2022-12-20 11:31:06', NULL, NULL);
INSERT INTO `marcas` VALUES (12, 'HEAD', 0, 'anegrete', '2022-12-20 11:31:18', NULL, NULL);
INSERT INTO `marcas` VALUES (13, 'PS', 0, 'anegrete', '2022-12-20 11:31:23', NULL, NULL);
INSERT INTO `marcas` VALUES (14, 'DARK DOG', 0, 'anegrete', '2022-12-20 11:31:28', NULL, NULL);
INSERT INTO `marcas` VALUES (15, 'GATORADE', 0, 'anegrete', '2022-12-20 11:31:33', NULL, NULL);
INSERT INTO `marcas` VALUES (16, 'Play Padel', 0, 'anegrete', '2022-12-20 11:31:37', NULL, NULL);
INSERT INTO `marcas` VALUES (17, 'MUNICH', 0, 'admin', '2022-12-20 11:31:42', NULL, NULL);
INSERT INTO `marcas` VALUES (18, 'STARVIE', 0, 'felidios', '2022-12-20 11:38:36', NULL, NULL);
INSERT INTO `marcas` VALUES (19, 'STARVIE', 1, 'felidios', '2022-12-20 11:43:22', NULL, NULL);
INSERT INTO `marcas` VALUES (20, 'SIUX', 1, 'felidios', '2022-12-20 11:43:33', NULL, NULL);
INSERT INTO `marcas` VALUES (21, 'DUNLOP', 1, 'felidios', '2022-12-20 11:43:42', NULL, NULL);
INSERT INTO `marcas` VALUES (22, 'ADIDAS', 1, 'felidios', '2022-12-20 11:43:49', NULL, NULL);
INSERT INTO `marcas` VALUES (23, 'BABOLAT', 1, 'felidios', '2022-12-20 11:43:58', NULL, NULL);
INSERT INTO `marcas` VALUES (24, 'ROYAL', 1, 'felidios', '2022-12-20 11:44:07', NULL, NULL);
INSERT INTO `marcas` VALUES (25, 'DROP SHOT', 1, 'felidios', '2022-12-20 11:44:18', NULL, NULL);
INSERT INTO `marcas` VALUES (26, 'ASICS', 1, 'felidios', '2022-12-20 11:44:29', NULL, NULL);
INSERT INTO `marcas` VALUES (27, 'LOTTO', 1, 'felidios', '2022-12-20 11:44:44', NULL, NULL);

-- ----------------------------
-- Table structure for producto_deposito
-- ----------------------------
DROP TABLE IF EXISTS `producto_deposito`;
CREATE TABLE `producto_deposito`  (
  `idProducto` int(11) NOT NULL,
  `idDeposito` int(11) NOT NULL,
  `stock` int(11) NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idProducto`, `idDeposito`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of producto_deposito
-- ----------------------------

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `product_id` int(11) NULL DEFAULT NULL,
  `hijo` tinyint(4) NOT NULL DEFAULT 0,
  `codigo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `fechacreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo_producto` int(11) NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `usuariomodificacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `id_marca` int(11) NULL DEFAULT NULL,
  `id_unidad` int(11) NULL DEFAULT NULL,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `stock_minimo_alerta` int(11) NULL DEFAULT NULL,
  `tipo_impuesto` int(11) NULL DEFAULT NULL,
  `tipo_control` int(11) NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_TIPO_IMPUESTO_PRO_idx`(`tipo_impuesto`) USING BTREE,
  INDEX `FK_CATEGORIA_PRO_idx`(`id_categoria`) USING BTREE,
  INDEX `FK_TIPO_PRO_idx`(`tipo_producto`) USING BTREE,
  INDEX `FK_MARCA_PRO_idx`(`id_marca`) USING BTREE,
  INDEX `FK_UNIDAD_PRO_idx`(`id_unidad`) USING BTREE,
  INDEX `FK_TIPO_CONTROL_idx`(`tipo_control`) USING BTREE,
  CONSTRAINT `FK_CATEGORIA_PRO` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_MARCA_PRO` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TIPO_CONTROL` FOREIGN KEY (`tipo_control`) REFERENCES `tipo_control` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TIPO_IMP` FOREIGN KEY (`tipo_impuesto`) REFERENCES `tipo_impuesto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TIPO_PRO` FOREIGN KEY (`tipo_producto`) REFERENCES `tipo_producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_UNIDAD_PRO` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 243 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES (197, 18, NULL, 0, '1801', 'Estrella Damm 660ml', 'vistas/img/productos/1801/735.jpg', 92, 11400, 15000, '2022-12-16 14:15:26', 1, 'anegrete', NULL, NULL, 5, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (198, 18, NULL, 0, '1802', 'Estrella Damm Inedit 330ml', 'vistas/img/productos/1802/845.jpg', 46, 7917, 10000, '2022-12-16 14:15:31', 1, 'anegrete', NULL, NULL, 5, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (199, 18, NULL, 0, '1803', 'Estrella Damm 330ml', 'vistas/img/productos//222.jpg', 0, 6580, 8000, '2022-12-16 14:15:21', 1, 'anegrete', 'anegrete', '2021-07-12 23:42:30', 5, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (200, 18, NULL, 0, '1804', 'Skol 275ml', 'vistas/img/productos/1804/532.png', 46, 4238, 7000, '2022-12-16 14:16:42', 1, 'anegrete', NULL, NULL, 9, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (201, 18, NULL, 0, '1805', 'Pilsen 340ml', 'vistas/img/productos//378.jpg', 26, 2063, 5000, '2022-12-16 14:16:25', 1, 'anegrete', 'anegrete', '2021-07-12 22:38:27', 8, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (202, 18, NULL, 0, '1806', 'Gatorade Mandarina', 'vistas/img/productos/1806/165.png', 19, 6667, 10000, '2022-12-16 14:15:41', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (203, 18, NULL, 0, '1807', 'Gatorade Cool Blue', 'vistas/img/productos/1807/623.png', 15, 6667, 10000, '2022-12-16 14:14:44', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (204, 18, NULL, 0, '1808', 'Gatorade Frutos Rojos', 'vistas/img/productos/1808/121.png', 14, 6667, 10000, '2022-12-16 14:15:35', 1, 'anegrete', NULL, NULL, 15, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (205, 18, NULL, 0, '1809', 'Dark Dog 250ml', 'vistas/img/productos/1809/546.png', 23, 9000, 11000, '2022-12-16 14:15:16', 1, 'anegrete', NULL, NULL, 14, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (206, 19, NULL, 0, '1810', 'Tubo Head Pro S', 'vistas/img/productos/1901/140.jpg', 9, 35500, 55000, '2022-12-13 12:14:43', 1, 'anegrete', NULL, NULL, 12, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (207, 18, NULL, 0, '1811', 'Agua mineral Aquafina 500ml sin gas', 'vistas/img/productos/1811/291.png', 17, 1950, 4000, '2022-12-13 12:14:54', 1, 'anegrete', 'anegrete', '2021-07-12 22:48:47', 6, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (208, 18, NULL, 0, '1812', 'Agua mineral La Costa 500ml con gas', 'vistas/img/productos/1811/170.png', 14, 0, 4000, '2022-12-13 12:15:00', 1, 'anegrete', 'anegrete', '2021-07-12 23:51:05', 7, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (209, 18, NULL, 0, '1813', 'Agua mineral Aquafina 2l sin gas', 'vistas/img/productos/1812/619.png', 44, 2625, 10000, '2022-12-13 12:14:49', 1, 'anegrete', NULL, NULL, 6, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (210, 18, NULL, 0, '1814', 'Pepsi Cola 500ml', 'vistas/img/productos/1813/753.png', 67, 3600, 8000, '2022-12-16 14:16:14', 1, 'anegrete', NULL, NULL, 8, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (211, 18, NULL, 0, '1815', 'Mirinda Guaraná 500ml', 'vistas/img/productos/1814/762.png', 50, 3600, 8000, '2022-12-16 14:15:51', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (212, 18, NULL, 0, '1816', 'Mirinda Guaraná Free 500ml', 'vistas/img/productos/1814/578.png', 12, 3600, 8000, '2022-12-16 14:15:56', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (213, 18, NULL, 0, '1817', 'Paso de los toros 500ml ', 'vistas/img/productos/1815/116.png', 17, 3600, 8000, '2022-12-16 14:16:09', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (214, 18, NULL, 0, '1818', 'Agua tónica Paso de los toros 500ml', 'vistas/img/productos/1816/277.png', 12, 3600, 8000, '2022-12-13 12:15:05', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (215, 18, NULL, 0, '1819', 'Seven Up 500ml', 'vistas/img/productos/1817/224.png', 6, 3600, 8000, '2022-12-16 14:16:34', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (216, 18, NULL, 0, '1820', 'Mirinda naranja 500ml', 'vistas/img/productos/1817/638.jpg', 5, 3600, 8000, '2022-12-16 14:16:00', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (217, 18, NULL, 0, '1821', 'Pepsi Cola Black 500ml', 'vistas/img/productos/1818/971.png', 14, 3600, 8000, '2022-12-16 14:16:20', 1, 'anegrete', NULL, NULL, 10, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (218, 19, NULL, 0, '1822', 'Muñequera Wilson blanca', 'vistas/img/productos/1819/402.jpg', 9, 25000, 40000, '2022-12-16 14:16:04', 1, 'anegrete', 'anegrete', '2021-07-12 23:47:47', 11, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (219, 19, NULL, 0, '1823', 'Grip PS', 'vistas/img/productos/1819/839.png', 42, 8125, 15000, '2022-12-16 14:15:46', 1, 'anegrete', 'anegrete', '2021-07-12 23:48:20', 13, 6, '2022-07-01', 10, 2, 2, 0);
INSERT INTO `productos` VALUES (220, 20, NULL, 0, '2001', 'Cancha 90', 'vistas/img/productos/2001/321.jpg', 100001, 0, 90000, '2022-12-16 14:14:56', 2, 'anegrete', 'anegrete', '2021-07-12 23:50:32', 16, 6, '2022-07-01', 0, 2, 1, 0);
INSERT INTO `productos` VALUES (221, 20, NULL, 0, '2002', 'Cancha 80', 'vistas/img/productos/2002/635.jpg', 100025, 0, 80000, '2022-12-16 14:14:50', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0);
INSERT INTO `productos` VALUES (222, 20, NULL, 0, '2003', 'Cancha clase 25', 'vistas/img/productos/2003/211.jpg', 99998, 0, 25000, '2022-12-16 14:15:06', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0);
INSERT INTO `productos` VALUES (223, 20, NULL, 0, '2004', 'Cancha clase 20', 'vistas/img/productos/2004/117.jpg', 100005, 0, 20000, '2022-12-16 14:15:01', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0);
INSERT INTO `productos` VALUES (224, 20, NULL, 0, '2005', 'Cancha clase 15', 'vistas/img/productos/2005/271.jpg', 99975, 0, 15000, '2022-12-13 12:28:05', 2, 'anegrete', NULL, NULL, 16, 6, '2022-07-01', 0, 2, 1, 0);
INSERT INTO `productos` VALUES (225, 18, NULL, 0, '1822', 'CHOPP MUNICH', 'vistas/img/productos/default/anonymous.png', 60, 390000, 600000, '2022-12-16 14:15:11', 1, 'admin', NULL, NULL, 17, 8, '2025-05-11', 10, 3, 2, 0);
INSERT INTO `productos` VALUES (226, 18, 225, 1, '1823', 'CHOPP MUNICH 1litro', 'vistas/img/productos/default/anonymous.png', 0, 2000, 5000, '2022-02-20 20:04:31', 1, 'admin', NULL, NULL, 17, 8, '2025-05-11', 10, 2, 2, 1);
INSERT INTO `productos` VALUES (227, 19, NULL, 0, '1824', 'Producto de Prueba depostio Union', 'vistas/img/productos/1824/627.jpg', 100, 10000, 20000, '2022-12-16 14:16:29', 1, 'admin', 'admin', '2022-07-22 14:48:48', 11, 6, '2026-12-01', 5, 2, 2, 0);
INSERT INTO `productos` VALUES (228, 18, NULL, 0, '1824', 'PALA STARVIE TRITON PRO', 'vistas/img/productos//482.jpg', 1, 1850000, 2250000, '2022-12-20 12:29:08', 1, 'felidios', 'felidios', '2022-12-20 12:10:31', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (229, 18, NULL, 0, '1825', 'PALA ADIDAS ADIPOWER 30', 'vistas/img/productos//415.jpg', 1, 1880000, 2520000, '2022-12-20 12:29:08', 1, 'felidios', 'felidios', '2022-12-20 12:01:17', 22, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (230, 18, NULL, 0, '1826', 'PALA ADIDAS ADIPOWER 31', 'vistas/img/productos//589.jpg', 1, 1880000, 2520000, '2022-12-20 12:29:08', 1, 'felidios', 'felidios', '2022-12-20 12:02:04', 22, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (231, 18, NULL, 0, '1827', 'PALA ADIDAS ADIPOWER SEBA NERONE', 'vistas/img/productos//429.jpg', 1, 1880000, 2750000, '2023-01-03 20:13:29', 1, 'felidios', 'felidios', '2022-12-20 12:03:07', 22, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (232, 18, NULL, 0, '1828', 'PALA ADIDAS DRIVE', 'vistas/img/productos//889.jpg', 1, 483000, 750000, '2023-01-03 20:13:29', 1, 'felidios', 'felidios', '2022-12-20 12:03:59', 22, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (233, 18, NULL, 0, '1829', 'PALA STARVIE AQUILA SPACE', 'vistas/img/productos//257.jpg', 1, 1350000, 1700000, '2023-01-03 20:13:29', 1, 'felidios', 'felidios', '2022-12-20 12:04:43', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (234, 18, NULL, 0, '1830', 'PALA STARVIE ARCADIA', 'vistas/img/productos//777.jpg', 1, 750000, 900000, '2022-12-23 23:51:43', 1, 'felidios', 'felidios', '2022-12-20 12:05:25', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (235, 18, NULL, 0, '1831', 'PALA STARVIE ASTRUM 2022', 'vistas/img/productos//959.jpg', 1, 2050000, 2450000, '2022-12-23 23:51:43', 1, 'felidios', 'felidios', '2022-12-20 12:06:15', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (236, 18, NULL, 0, '1832', 'PALA STARVIE BASALTO OSIRIS', 'vistas/img/productos//871.jpg', 1, 1750000, 2100000, '2022-12-23 23:51:43', 1, 'felidios', 'felidios', '2022-12-20 12:07:02', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (237, 18, NULL, 0, '1833', 'PALA STARVIE METHEORA 2022', 'vistas/img/productos//151.jpg', 5, 2220000, 2750000, '2022-12-23 23:51:43', 1, 'felidios', 'felidios', '2022-12-20 12:08:03', 19, 6, '2022-12-20', 1, 2, 2, 1);
INSERT INTO `productos` VALUES (238, 21, NULL, 0, '2101', 'Prueba/Prueba', 'vistas/img/productos/default/anonymous.png', 0, 10, 20, '2023-01-04 19:16:47', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0);
INSERT INTO `productos` VALUES (239, 20, NULL, 0, '2006', 'prueba.', 'vistas/img/productos/default/anonymous.png', 0, 1, 2, '2023-01-04 19:18:45', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0);
INSERT INTO `productos` VALUES (240, 20, NULL, 0, '2007', 'prueba,', 'vistas/img/productos/default/anonymous.png', 0, 1, 2, '2023-01-04 19:19:14', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0);
INSERT INTO `productos` VALUES (241, 20, NULL, 0, '2008', 'prueba-_.,/', 'vistas/img/productos/default/anonymous.png', 0, 12, 2, '2023-01-04 19:20:06', 2, 'admin', NULL, NULL, 19, 6, '2023-01-04', 1, 1, 1, 0);
INSERT INTO `productos` VALUES (242, 19, NULL, 0, '1825', 'PRODUCTO DE PRUEBA.,/-_', 'vistas/img/productos/default/anonymous.png', 0, 12, 23, '2023-01-04 19:24:10', 2, 'admin', 'admin', '2023-01-04 19:24:01', 19, 6, '2023-01-04', 1, 1, 1, 0);

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ruc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `telefono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nombrecontacto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `telefonocontacto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proveedores
-- ----------------------------
INSERT INTO `proveedores` VALUES (3, 'Mario Vazquez', '3673518-3', 'carandayty 207', '0983902795', 'fmva2011@gmail.com', 'Mario Vazquez', '0983902795', 1, 'admin', '2021-12-19 21:20:15', NULL, NULL);
INSERT INTO `proveedores` VALUES (5, 'Felix Arce', '3673518-9', 'Carandayty 297', '0983902794', 'f.mva2011@gmail.com', 'c', '0983902795', 1, 'admin', '2023-01-04 19:36:02', NULL, NULL);
INSERT INTO `proveedores` VALUES (6, 'Felix Arce', '3673518-9', 'Carandayty 297', '0983902794', 'fmv-a2011@gmail.com', 'c', '0983902795', 1, 'admin', '2023-01-04 19:36:54', NULL, NULL);
INSERT INTO `proveedores` VALUES (7, 'Felix Arce', '3673518-0', 'Carandayty 297', '0983902794', 'fmv-a2011@gmail.com', 'andrs', '0983902797', 1, 'admin', '2023-01-04 20:08:26', NULL, NULL);

-- ----------------------------
-- Table structure for stock_producto
-- ----------------------------
DROP TABLE IF EXISTS `stock_producto`;
CREATE TABLE `stock_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NULL DEFAULT NULL,
  `id_deposito` int(11) NULL DEFAULT NULL,
  `stock` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stock_producto
-- ----------------------------
INSERT INTO `stock_producto` VALUES (1, 237, 1, 5);
INSERT INTO `stock_producto` VALUES (2, 236, 1, 1);
INSERT INTO `stock_producto` VALUES (3, 235, 1, 1);
INSERT INTO `stock_producto` VALUES (4, 234, 1, 1);
INSERT INTO `stock_producto` VALUES (5, 233, 1, 1);
INSERT INTO `stock_producto` VALUES (6, 232, 1, 1);
INSERT INTO `stock_producto` VALUES (7, 231, 1, 1);
INSERT INTO `stock_producto` VALUES (8, 230, 1, 1);
INSERT INTO `stock_producto` VALUES (9, 229, 1, 1);
INSERT INTO `stock_producto` VALUES (10, 228, 1, 1);

-- ----------------------------
-- Table structure for sucursales
-- ----------------------------
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `usuariomodificacion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sucursales
-- ----------------------------
INSERT INTO `sucursales` VALUES (1, 'Central', 1, '2019-01-26 07:00:00', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for termino_pago
-- ----------------------------
DROP TABLE IF EXISTS `termino_pago`;
CREATE TABLE `termino_pago`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dias` int(11) NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of termino_pago
-- ----------------------------
INSERT INTO `termino_pago` VALUES (1, '80 días', 80, 1, 'admin', '2021-02-10 02:58:51', NULL, NULL);
INSERT INTO `termino_pago` VALUES (2, '31 dias', 31, 0, 'admin', '2021-02-10 03:16:57', 'admin', '2021-02-10 03:16:50');
INSERT INTO `termino_pago` VALUES (3, '60 dias', 60, 1, 'admin', '2021-02-10 03:17:13', NULL, NULL);

-- ----------------------------
-- Table structure for tipo_compra
-- ----------------------------
DROP TABLE IF EXISTS `tipo_compra`;
CREATE TABLE `tipo_compra`  (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_compra
-- ----------------------------
INSERT INTO `tipo_compra` VALUES (1, 'Contado');
INSERT INTO `tipo_compra` VALUES (2, 'Crédito');

-- ----------------------------
-- Table structure for tipo_control
-- ----------------------------
DROP TABLE IF EXISTS `tipo_control`;
CREATE TABLE `tipo_control`  (
  `id` int(11) NOT NULL,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `orden` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_control
-- ----------------------------
INSERT INTO `tipo_control` VALUES (1, 'No Controlar', 1, NULL, '2021-02-14 03:33:52', NULL, NULL, 1);
INSERT INTO `tipo_control` VALUES (2, 'Controlar', 1, NULL, '2021-02-14 03:33:52', NULL, NULL, 2);

-- ----------------------------
-- Table structure for tipo_impuesto
-- ----------------------------
DROP TABLE IF EXISTS `tipo_impuesto`;
CREATE TABLE `tipo_impuesto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `valor_impuesto` decimal(18, 2) NULL DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_impuesto
-- ----------------------------
INSERT INTO `tipo_impuesto` VALUES (1, 'IVA 5', 1, 0.05, NULL, '2021-02-14 03:16:29', NULL, NULL);
INSERT INTO `tipo_impuesto` VALUES (2, 'IVA 10', 1, 0.10, NULL, '2021-02-14 03:16:29', NULL, NULL);
INSERT INTO `tipo_impuesto` VALUES (3, 'EXCENTA', 1, 0.00, NULL, '2021-02-14 03:16:29', NULL, NULL);

-- ----------------------------
-- Table structure for tipo_producto
-- ----------------------------
DROP TABLE IF EXISTS `tipo_producto`;
CREATE TABLE `tipo_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_producto
-- ----------------------------
INSERT INTO `tipo_producto` VALUES (1, 'Estándar', 1, NULL, '2021-02-14 03:04:19', NULL, NULL);
INSERT INTO `tipo_producto` VALUES (2, 'Servicio', 1, NULL, '2021-02-14 03:04:19', NULL, NULL);
INSERT INTO `tipo_producto` VALUES (3, 'Prenda/Calzado', 1, NULL, '2021-02-14 03:04:19', NULL, NULL);
INSERT INTO `tipo_producto` VALUES (4, 'Producción', 1, NULL, '2021-02-14 03:04:19', NULL, NULL);

-- ----------------------------
-- Table structure for unidades
-- ----------------------------
DROP TABLE IF EXISTS `unidades`;
CREATE TABLE `unidades`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codunidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `unidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int(11) NULL DEFAULT 1,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of unidades
-- ----------------------------
INSERT INTO `unidades` VALUES (6, 'UNIDADES', 'UNID', 1, 'anegrete', '2021-07-12 22:09:31', NULL, NULL);
INSERT INTO `unidades` VALUES (7, 'TUBO', 'TUBO', 1, 'anegrete', '2021-07-12 22:09:48', NULL, NULL);
INSERT INTO `unidades` VALUES (8, 'LTS', 'LITROS', 1, 'admin', '2022-02-20 20:00:43', NULL, NULL);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `foto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `estado` int(11) NULL DEFAULT NULL,
  `ultimo_login` datetime NULL DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auzLCDizCcjjNp1tyBOr6NFmWs7ykDGF2', 'Administrador', 'vistas/img/usuarios/admin/191.jpg', 1, '2023-01-04 15:57:30', '2023-01-04 20:57:30');
INSERT INTO `usuarios` VALUES (2, 'Mario Vazquez', 'mvazquez', '$2a$07$asxx54ahjppf45sd87a5auYN6pXgCCD9cClZ0bwGTsV1E2tmMfUEu', 'Especial', '', 1, '2022-12-24 09:53:36', '2022-12-24 14:53:36');

-- ----------------------------
-- Table structure for ventas
-- ----------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo_operacion` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nro_cuotas` int(11) NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ventas
-- ----------------------------
INSERT INTO `ventas` VALUES (51, 5, 7, 8, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"3\",\"stock\":\"99997\",\"precio\":\"15000\",\"total\":45000}]', 0, 45000, 45000, 'EFECTIVO', '2021-07-13 00:02:25', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (52, 5, 7, 8, '[{\"id\":\"223\",\"descripcion\":\"Cancha clase 20\",\"cantidad\":\"2\",\"stock\":\"99998\",\"precio\":\"20000\",\"total\":40000}]', 0, 40000, 40000, 'EFECTIVO', '2021-07-13 00:02:56', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (53, 5, 7, 8, '[{\"id\":\"222\",\"descripcion\":\"Cancha clase 25\",\"cantidad\":\"2\",\"stock\":\"99998\",\"precio\":\"25000\",\"total\":50000}]', 0, 50000, 50000, 'TD', '2021-07-13 00:07:26', NULL, '0042', 0, 1);
INSERT INTO `ventas` VALUES (54, 5, 7, 8, '[{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"3\",\"stock\":\"99997\",\"precio\":\"80000\",\"total\":240000},{\"id\":\"209\",\"descripcion\":\"Agua mineral Aquafina 2l sin gas\",\"cantidad\":\"1\",\"stock\":\"21\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"39\",\"precio\":\"7000\",\"total\":7000}]', 0, 257000, 52000, 'TD', '2021-07-13 00:16:02', NULL, '0043', 0, 1);
INSERT INTO `ventas` VALUES (55, 5, 7, 8, '[{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"4\",\"stock\":\"35\",\"precio\":\"7000\",\"total\":28000}]', 0, 28000, 28000, 'TD', '2021-07-13 00:19:23', NULL, '0041', 0, 1);
INSERT INTO `ventas` VALUES (56, 5, 7, 8, '[{\"id\":\"208\",\"descripcion\":\"Agua mineral La Costa 500ml con gas\",\"cantidad\":\"3\",\"stock\":\"5\",\"precio\":\"4000\",\"total\":12000},{\"id\":\"219\",\"descripcion\":\"Grip PS\",\"cantidad\":\"1\",\"stock\":\"40\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"3\",\"stock\":\"99994\",\"precio\":\"80000\",\"total\":240000}]', 0, 267000, 62000, 'EFECTIVO', '2021-07-13 00:20:59', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (57, 5, 7, 8, '[{\"id\":\"211\",\"descripcion\":\"Mirinda Guaraná 500ml\",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"3\",\"stock\":\"99991\",\"precio\":\"80000\",\"total\":240000}]', 0, 248000, 43000, 'EFECTIVO', '2021-07-13 00:24:07', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (58, 5, 7, 8, '[{\"id\":\"210\",\"descripcion\":\"Pepsi Cola 500ml\",\"cantidad\":\"1\",\"stock\":\"64\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"3\",\"stock\":\"99988\",\"precio\":\"80000\",\"total\":240000}]', 0, 248000, 43000, 'EFECTIVO', '2021-07-13 00:27:03', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (59, 6, 7, 1, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"30\",\"stock\":\"99967\",\"precio\":\"15000\",\"total\":450000}]', 0, 450000, 450000, 'EFECTIVO', '2021-10-29 19:36:46', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (60, 6, 8, 1, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"1\",\"stock\":\"99966\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"223\",\"descripcion\":\"Cancha clase 20\",\"cantidad\":\"1\",\"stock\":\"99997\",\"precio\":\"20000\",\"total\":20000},{\"id\":\"222\",\"descripcion\":\"Cancha clase 25\",\"cantidad\":\"1\",\"stock\":\"99997\",\"precio\":\"25000\",\"total\":25000},{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"1\",\"stock\":\"99987\",\"precio\":\"80000\",\"total\":80000},{\"id\":\"220\",\"descripcion\":\"Cancha 90\",\"cantidad\":\"1\",\"stock\":\"99999\",\"precio\":\"90000\",\"total\":90000},{\"id\":\"219\",\"descripcion\":\"Grip PS\",\"cantidad\":\"1\",\"stock\":\"39\",\"precio\":\"15000\",\"total\":15000}]', 0, 245000, 245000, 'EFECTIVO', '2021-11-24 15:41:16', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (61, 6, 7, 1, '[{\"id\":\"218\",\"descripcion\":\"Muñequera Wilson blanca\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"40000\",\"total\":40000}]', 0, 40000, 40000, 'EFECTIVO', '2021-11-24 15:42:14', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (62, 0, 8, 9, '[{\"id\":\"218\",\"descripcion\":\"Muñequera Wilson blanca\",\"cantidad\":\"1\",\"stock\":\"8\",\"precio\":\"40000\",\"total\":40000},{\"id\":\"217\",\"descripcion\":\"Pepsi Cola Black 500ml\",\"cantidad\":\"1\",\"stock\":\"15\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"216\",\"descripcion\":\"Mirinda naranja 500ml\",\"cantidad\":\"1\",\"stock\":\"5\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"215\",\"descripcion\":\"Seven Up 500ml\",\"cantidad\":\"1\",\"stock\":\"5\",\"precio\":\"8000\",\"total\":8000}]', 0, 64000, 64000, 'EFECTIVO', '2021-12-04 15:18:32', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (63, 0, 7, 1, '[{\"id\":\"216\",\"descripcion\":\"Mirinda naranja 500ml\",\"cantidad\":\"1\",\"stock\":\"4\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"217\",\"descripcion\":\"Pepsi Cola Black 500ml\",\"cantidad\":\"1\",\"stock\":\"14\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"99\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"49\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"122\",\"precio\":\"5000\",\"total\":5000},{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"1\",\"stock\":\"99974\",\"precio\":\"15000\",\"total\":15000}]', 0, 58000, 58000, 'EFECTIVO', '2021-12-07 19:24:54', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (64, 0, 8, 1, '[{\"id\":\"198\",\"descripcion\":\"Estrella Damm Inedit 330ml\",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"48\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"20\",\"stock\":\"102\",\"precio\":\"5000\",\"total\":100000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"21\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"203\",\"descripcion\":\"Gatorade Cool Blue\",\"cantidad\":\"1\",\"stock\":\"15\",\"precio\":\"10000\",\"total\":10000}]', 0, 137000, 137000, 'TD', '2021-12-07 19:25:41', NULL, '1234', 0, 1);
INSERT INTO `ventas` VALUES (65, 0, 11, 1, '[{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"24\",\"stock\":\"78\",\"precio\":\"5000\",\"total\":120000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"6\",\"stock\":\"93\",\"precio\":\"15000\",\"total\":90000}]', 0, 210000, 210000, 'EFECTIVO', '2021-12-19 22:04:30', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (66, 0, 11, 1, '[{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"50\",\"stock\":\"28\",\"precio\":\"5000\",\"total\":250000}]', 0, 250000, 250000, 'EFECTIVO', '2021-12-19 22:05:44', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (67, 0, 12, 9, '[{\"id\":\"218\",\"descripcion\":\"Muñequera Wilson blanca\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"40000\",\"total\":40000},{\"id\":\"217\",\"descripcion\":\"Pepsi Cola Black 500ml\",\"cantidad\":\"1\",\"stock\":\"13\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"20\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"27\",\"precio\":\"5000\",\"total\":5000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"198\",\"descripcion\":\"Estrella Damm Inedit 330ml\",\"cantidad\":\"1\",\"stock\":\"46\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"92\",\"precio\":\"15000\",\"total\":15000}]', 0, 95000, 95000, 'EFECTIVO', '2021-12-27 16:53:49', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (68, 0, 12, 9, '[{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"1\",\"stock\":\"100022\",\"precio\":\"80000\",\"total\":80000}]', 0, 80000, 60000, 'EFECTIVO', '2021-12-27 19:17:35', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (69, 0, 12, 9, '[{\"id\":\"220\",\"descripcion\":\"Cancha 90\",\"cantidad\":\"1\",\"stock\":\"99998\",\"precio\":\"90000\",\"total\":90000},{\"id\":\"219\",\"descripcion\":\"Grip PS\",\"cantidad\":\"1\",\"stock\":\"41\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"46\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"26\",\"precio\":\"5000\",\"total\":5000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"203\",\"descripcion\":\"Gatorade Cool Blue\",\"cantidad\":\"1\",\"stock\":\"14\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"204\",\"descripcion\":\"Gatorade Frutos Rojos\",\"cantidad\":\"1\",\"stock\":\"13\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"91\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"198\",\"descripcion\":\"Estrella Damm Inedit 330ml\",\"cantidad\":\"1\",\"stock\":\"45\",\"precio\":\"10000\",\"total\":10000}]', 0, 172000, 112000, 'EFECTIVO', '2021-12-27 19:21:42', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (70, 0, 12, 1, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"1\",\"stock\":\"99973\",\"precio\":\"15000\",\"total\":15000}]', 0, 15000, 15000, 'TD', '2021-12-27 19:29:18', NULL, '003914', 0, 1);
INSERT INTO `ventas` VALUES (71, 0, 12, 1, '[{\"id\":\"217\",\"descripcion\":\"Pepsi Cola Black 500ml\",\"cantidad\":\"1\",\"stock\":\"12\",\"precio\":\"8000\",\"total\":8000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"45\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"18\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"25\",\"precio\":\"5000\",\"total\":5000}]', 0, 30000, 30000, 'AC', '2021-12-27 19:30:20', NULL, '', 2, 1);
INSERT INTO `ventas` VALUES (72, 0, 12, 9, '[{\"id\":\"224\",\"descripcion\":\"Cancha clase 15\",\"cantidad\":\"1\",\"stock\":\"99972\",\"precio\":\"15000\",\"total\":15000}]', 0, 15000, 15000, 'EFECTIVO', '2022-01-08 17:16:52', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (73, 0, 13, 9, '[{\"id\":\"223\",\"descripcion\":\"Cancha clase 20\",\"cantidad\":\"1\",\"stock\":\"100002\",\"precio\":\"20000\",\"total\":20000},{\"id\":\"222\",\"descripcion\":\"Cancha clase 25\",\"cantidad\":\"1\",\"stock\":\"100002\",\"precio\":\"25000\",\"total\":25000},{\"id\":\"221\",\"descripcion\":\"Cancha 80\",\"cantidad\":\"1\",\"stock\":\"100021\",\"precio\":\"80000\",\"total\":80000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"90\",\"precio\":\"15000\",\"total\":15000}]', 0, 140000, 140000, 'EFECTIVO', '2022-01-14 13:54:02', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (75, 0, 13, 1, '[{\"id\":\"222\",\"descripcion\":\"Cancha clase 25\",\"cantidad\":\"7\",\"stock\":\"99994\",\"precio\":\"25000\",\"total\":175000},{\"id\":\"198\",\"descripcion\":\"Estrella Damm Inedit 330ml\",\"cantidad\":\"1\",\"stock\":\"44\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"89\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"44\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"24\",\"precio\":\"5000\",\"total\":5000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"17\",\"precio\":\"10000\",\"total\":10000}]', 0, 222000, 222000, 'EFECTIVO', '2022-01-16 01:42:41', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (77, 0, 13, 9, '[{\"id\":\"219\",\"descripcion\":\"Grip PS\",\"cantidad\":\"1\",\"stock\":\"40\",\"precio\":\"15000\",\"total\":15000}]', 0, 15000, 15000, 'EFECTIVO', '2022-01-16 01:44:47', NULL, '', 0, 1);
INSERT INTO `ventas` VALUES (82, 0, 14, 9, '[{\"id\":\"197\",\"descripcion\":\"Estrella Damm 660ml\",\"cantidad\":\"1\",\"stock\":\"87\",\"precio\":\"15000\",\"total\":15000},{\"id\":\"198\",\"descripcion\":\"Estrella Damm Inedit 330ml\",\"cantidad\":\"1\",\"stock\":\"41\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"200\",\"descripcion\":\"Skol 275ml\",\"cantidad\":\"1\",\"stock\":\"40\",\"precio\":\"7000\",\"total\":7000},{\"id\":\"201\",\"descripcion\":\"Pilsen 340ml\",\"cantidad\":\"1\",\"stock\":\"20\",\"precio\":\"5000\",\"total\":5000},{\"id\":\"202\",\"descripcion\":\"Gatorade Mandarina\",\"cantidad\":\"1\",\"stock\":\"14\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"203\",\"descripcion\":\"Gatorade Cool Blue\",\"cantidad\":\"1\",\"stock\":\"12\",\"precio\":\"10000\",\"total\":10000},{\"id\":\"204\",\"descripcion\":\"Gatorade Frutos Rojos\",\"cantidad\":\"1\",\"stock\":\"11\",\"precio\":\"10000\",\"total\":10000}]', 0, 67000, 67000, 'TC', '2022-02-13 20:04:48', NULL, '123', 0, 1);
INSERT INTO `ventas` VALUES (86, 0, 15, 11, '[{\"id\":\"233\",\"descripcion\":\"PALA STARVIE AQUILA SPACE\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"1700000\",\"total\":1700000},{\"id\":\"232\",\"descripcion\":\"PALA ADIDAS DRIVE\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"750000\",\"total\":750000},{\"id\":\"231\",\"descripcion\":\"PALA ADIDAS ADIPOWER SEBA NERONE\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"2750000\",\"total\":2750000}]', 0, 5200000, 5200000, 'TD', '2022-12-20 12:33:43', NULL, '1234', 0, 1);

-- ----------------------------
-- Table structure for ventas_creditos
-- ----------------------------
DROP TABLE IF EXISTS `ventas_creditos`;
CREATE TABLE `ventas_creditos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ventas` int(11) NOT NULL,
  `monto_pagado` double NULL DEFAULT NULL,
  `monto_deudor` double NULL DEFAULT NULL,
  `cuotas` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ventas_creditos
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
