CREATE DATABASE  IF NOT EXISTS `posdev_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `posdev_db`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: posdev_db
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aperturas`
--

DROP TABLE IF EXISTS `aperturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aperturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idcaja` int DEFAULT NULL,
  `monto_apertura` decimal(10,2) DEFAULT NULL,
  `usuarioapertura` int DEFAULT NULL,
  `fechaapertura` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  `fechacierre` timestamp NULL DEFAULT NULL,
  `monto_cierre` decimal(10,2) DEFAULT NULL,
  `fechaeliminacion` timestamp NULL DEFAULT NULL,
  `usuarioeliminacion` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_CAJA_SUCURSAL_idx` (`idcaja`) USING BTREE,
  CONSTRAINT `FK_CAJA_SUCURSAL` FOREIGN KEY (`idcaja`) REFERENCES `cajas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aperturas`
--

LOCK TABLES `aperturas` WRITE;
/*!40000 ALTER TABLE `aperturas` DISABLE KEYS */;
INSERT INTO `aperturas` VALUES (5,1,300000.00,1,'2024-09-20 18:51:38',0,'2024-09-20 14:51:38',300000.00,NULL,NULL),(6,1,200000.00,1,'2024-09-23 13:25:36',0,'2024-09-23 09:25:36',200000.00,NULL,NULL),(7,1,150000.00,1,'2024-09-23 14:09:24',0,'2024-09-23 10:09:24',150000.00,NULL,NULL),(8,1,100000.00,1,'2024-09-23 14:48:14',0,'2024-09-23 10:48:14',100000.00,NULL,NULL),(9,1,150000.00,1,'2024-09-23 15:05:40',0,'2024-09-23 11:05:40',150000.00,NULL,NULL),(10,1,300000.00,13,'2024-09-23 20:10:08',0,'2024-09-23 16:10:08',1880000.00,NULL,NULL),(11,1,350000.00,1,'2024-11-06 12:21:14',0,'2024-11-06 09:21:14',3785000.00,NULL,NULL);
/*!40000 ALTER TABLE `aperturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas`
--

DROP TABLE IF EXISTS `cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cajas` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `idSucursal` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas`
--

LOCK TABLES `cajas` WRITE;
/*!40000 ALTER TABLE `cajas` DISABLE KEYS */;
INSERT INTO `cajas` VALUES (1,'Caja Principal',1,'2021-02-11 06:17:02','admin',NULL,NULL,1);
/*!40000 ALTER TABLE `cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas_sucursales`
--

DROP TABLE IF EXISTS `cajas_sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas_sucursales` (
  `id_caja` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `monto_caja` double NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas_sucursales`
--

LOCK TABLES `cajas_sucursales` WRITE;
/*!40000 ALTER TABLE `cajas_sucursales` DISABLE KEYS */;
/*!40000 ALTER TABLE `cajas_sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas_ventas`
--

DROP TABLE IF EXISTS `cajas_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas_ventas` (
  `id_caja` int NOT NULL,
  `id_venta` int NOT NULL,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas_ventas`
--

LOCK TABLES `cajas_ventas` WRITE;
/*!40000 ALTER TABLE `cajas_ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `cajas_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calces`
--

DROP TABLE IF EXISTS `calces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calces`
--

LOCK TABLES `calces` WRITE;
/*!40000 ALTER TABLE `calces` DISABLE KEYS */;
/*!40000 ALTER TABLE `calces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codcategoria` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `usuariocreacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `usuariomodificacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (22,'BASICAS','2024-09-23 15:34:28','100','admin',NULL,NULL,1),(23,'POLO','2024-09-23 15:34:40','200','admin',NULL,NULL,1),(24,'CAMISAS','2024-09-23 15:34:50','300','admin',NULL,NULL,1),(25,'ACCESORIOS','2024-09-23 15:35:03','400','admin',NULL,NULL,1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_gastos`
--

DROP TABLE IF EXISTS `categorias_gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_gastos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_gastos`
--

LOCK TABLES `categorias_gastos` WRITE;
/*!40000 ALTER TABLE `categorias_gastos` DISABLE KEYS */;
INSERT INTO `categorias_gastos` VALUES (1,'Gasto 2020',1,'admin','2021-11-24 13:17:17','admin','2021-11-24 13:17:17'),(2,'Gasto 2',0,'admin','2021-02-15 02:52:50',NULL,NULL);
/*!40000 ALTER TABLE `categorias_gastos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `documento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `telefono` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int DEFAULT NULL,
  `ultima_compra` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `estado` int DEFAULT '1',
  `usuariomodificacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `grupocliente` int DEFAULT NULL,
  `limitecredito` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (19,'Mario Vazquez','3673518-3','fmva2011@gmail.com','0983902795','Valois Rivarola','1984-05-11',4,'2024-11-06 07:15:23','2024-11-06 12:15:23','mario',1,'mario','2024-09-23 19:52:58',2,0.00),(20,'Felix Arce','3654738','info@dg.com.py','502700','America Luque','1985-01-05',4,'2024-09-23 15:07:25','2024-09-23 20:07:25','mario',1,NULL,NULL,2,0.00),(21,'Ruben Vazquez','3546758','info@aquagroup.com.py','515500','Bernardino Caballero','1954-06-13',19,'2024-11-06 07:16:58','2024-11-06 12:16:58','mario',1,NULL,NULL,2,0.00),(22,'Ocasional','1111111','globaladmpy@gmail.com','0986754673','cualquiera','1984-01-01',22,'2024-11-06 07:17:30','2024-11-06 12:17:30','mario',1,NULL,NULL,2,0.00);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (3,'Amarillo',1,'admin','2021-05-30 23:54:16',NULL,NULL),(4,'Rojo Perlado',0,'admin','2021-05-30 23:54:45','admin','2021-05-30 23:54:39'),(5,'morado',1,'admin','2021-05-30 23:54:31',NULL,NULL),(6,'BLANCO',1,'admin','2024-09-23 15:35:57',NULL,NULL),(7,'NEGRO',1,'admin','2024-09-23 15:36:03',NULL,NULL);
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proveedor` int DEFAULT NULL,
  `fechacompra` timestamp NULL DEFAULT NULL,
  `referencia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nrofactura` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_deposito` int DEFAULT NULL,
  `id_tipo_compra` int DEFAULT NULL,
  `productos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `neto` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado_compra` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
INSERT INTO `compras` VALUES (9,8,'2024-09-23 00:00:00','COMPRA INICIAL','0001',1,2,'[{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"200\",\"precio\":\"60000\",\"total\":12000000}]',12000000,12000000,'13','2024-09-23 19:23:39',NULL,NULL,1),(10,8,'2024-09-23 00:00:00','COMPRA INICIAL','0002',1,1,'[{\"id\":\"253\",\"descripcion\":\"BOXER LACOSTE NEGRO G\",\"cantidad\":\"100\",\"precio\":\"40000\",\"total\":4000000},{\"id\":\"252\",\"descripcion\":\"OVERSIZE NIKE NEGRO G\",\"cantidad\":\"100\",\"precio\":\"50000\",\"total\":5000000},{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"100\",\"precio\":\"70000\",\"total\":7000000},{\"id\":\"250\",\"descripcion\":\"POLO LACOSTE NEGRA GG\",\"cantidad\":\"100\",\"precio\":\"70000\",\"total\":7000000},{\"id\":\"249\",\"descripcion\":\"POLO LACOSTE VERDE P\",\"cantidad\":\"100\",\"precio\":\"70000\",\"total\":7000000},{\"id\":\"248\",\"descripcion\":\"BASICA TOMMY AZUL  P\",\"cantidad\":\"100\",\"precio\":\"60000\",\"total\":6000000},{\"id\":\"247\",\"descripcion\":\"BASICA TOMMY AZUL MARINO GG\",\"cantidad\":\"100\",\"precio\":\"60000\",\"total\":6000000},{\"id\":\"246\",\"descripcion\":\"BASICA LACOSTE ROJO G\",\"cantidad\":\"100\",\"precio\":\"60000\",\"total\":6000000}]',48000000,48000000,'13','2024-09-23 19:42:10',NULL,NULL,1);
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depositos`
--

DROP TABLE IF EXISTS `depositos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `depositos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `deposito` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `telefono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depositos`
--

LOCK TABLES `depositos` WRITE;
/*!40000 ALTER TABLE `depositos` DISABLE KEYS */;
INSERT INTO `depositos` VALUES (1,'Depósito Principal 2021',1,'2022-12-23 23:50:13','admin','admin','2022-12-23 23:50:13','DP','0983902795','fmva2011@gmail.com','FERNANDO DE LA MORA'),(9,'DEPOSITO LUQUE',1,'2024-09-23 15:48:29','admin',NULL,NULL,'DL','502700','MVAZQUEZ@DG.COM.PY','AMERICA 1287');
/*!40000 ALTER TABLE `depositos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_compras`
--

DROP TABLE IF EXISTS `detalle_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compra` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_PROD_COMPRA_DET_idx` (`id_producto`) USING BTREE,
  KEY `FK_COMPRA_DET_COM_idx` (`id_compra`) USING BTREE,
  CONSTRAINT `FK_COMPRA_DET_COM` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`),
  CONSTRAINT `FK_PROD_COMPRA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_compras`
--

LOCK TABLES `detalle_compras` WRITE;
/*!40000 ALTER TABLE `detalle_compras` DISABLE KEYS */;
INSERT INTO `detalle_compras` VALUES (13,9,245,200,60000,12000000,'2024-09-23 19:23:39'),(14,10,253,100,40000,4000000,'2024-09-23 19:42:10'),(15,10,252,100,50000,5000000,'2024-09-23 19:42:10'),(16,10,251,100,70000,7000000,'2024-09-23 19:42:10'),(17,10,250,100,70000,7000000,'2024-09-23 19:42:10'),(18,10,249,100,70000,7000000,'2024-09-23 19:42:10'),(19,10,248,100,60000,6000000,'2024-09-23 19:42:10'),(20,10,247,100,60000,6000000,'2024-09-23 19:42:10'),(21,10,246,100,60000,6000000,'2024-09-23 19:42:10');
/*!40000 ALTER TABLE `detalle_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_transferencia`
--

DROP TABLE IF EXISTS `detalle_transferencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_transferencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_transferencia` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `id_usuario_transferencia` int DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_deposito_origen` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TRANSFERENCIA` (`id_transferencia`),
  KEY `FK_PRODUCTO` (`id_producto`),
  CONSTRAINT `FK_PRODUCTO` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  CONSTRAINT `FK_TRANSFERENCIA` FOREIGN KEY (`id_transferencia`) REFERENCES `transferencia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_transferencia`
--

LOCK TABLES `detalle_transferencia` WRITE;
/*!40000 ALTER TABLE `detalle_transferencia` DISABLE KEYS */;
INSERT INTO `detalle_transferencia` VALUES (12,6,245,20,13,'2024-09-23 19:43:09',1),(13,6,246,30,13,'2024-09-23 19:43:09',1),(14,6,248,50,13,'2024-09-23 19:43:09',1),(15,6,247,10,13,'2024-09-23 19:43:09',1),(16,6,253,60,13,'2024-09-23 19:43:09',1),(17,6,252,10,13,'2024-09-23 19:43:09',1),(18,6,250,45,13,'2024-09-23 19:43:09',1),(19,6,249,38,13,'2024-09-23 19:43:09',1),(20,6,251,60,13,'2024-09-23 19:43:09',1);
/*!40000 ALTER TABLE `detalle_transferencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_venta` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_vendedor` int DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_deposito` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_PROD_VENTA_DET_idx` (`id_producto`) USING BTREE,
  KEY `FK_VEND_VENTA_DET_idx` (`id_vendedor`) USING BTREE,
  KEY `FK_VENT_DET_VEN_idx` (`id_venta`) USING BTREE,
  CONSTRAINT `FK_PROD_VENTA_DET` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  CONSTRAINT `FK_VENT_DET_VEN` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
INSERT INTO `detalle_ventas` VALUES (8,87,244,1,95000,95000,13,'2024-09-23 20:03:38',1),(9,87,245,1,95000,95000,13,'2024-09-23 20:03:38',1),(10,88,246,1,95000,95000,13,'2024-09-23 20:04:37',1),(11,88,247,1,95000,95000,13,'2024-09-23 20:04:37',1),(12,88,250,1,110000,110000,13,'2024-09-23 20:04:37',1),(13,89,252,1,90000,90000,13,'2024-09-23 20:05:11',9),(14,89,247,1,95000,95000,13,'2024-09-23 20:05:11',9),(15,89,251,1,110000,110000,13,'2024-09-23 20:05:11',9),(16,89,249,1,105000,105000,13,'2024-09-23 20:05:11',9),(17,90,244,1,95000,95000,1,'2024-09-23 20:07:25',1),(18,90,245,3,95000,95000,1,'2024-09-23 20:07:25',1),(19,91,244,1,95000,95000,14,'2024-09-23 20:08:23',9),(20,91,251,1,110000,110000,14,'2024-09-23 20:08:23',9),(21,91,249,1,105000,105000,14,'2024-09-23 20:08:23',9),(22,92,244,1,95000,95000,1,'2024-11-06 12:15:23',1),(23,92,245,1,95000,95000,1,'2024-11-06 12:15:23',1),(24,93,245,3,95000,95000,1,'2024-11-06 12:16:58',1),(25,93,246,3,95000,95000,1,'2024-11-06 12:16:58',1),(26,93,251,10,110000,110000,1,'2024-11-06 12:16:58',1),(27,94,251,10,110000,110000,1,'2024-11-06 12:17:30',1),(28,94,247,5,95000,95000,1,'2024-11-06 12:17:30',1);
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pago`
--

DROP TABLE IF EXISTS `forma_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pago` (
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` int DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pago`
--

LOCK TABLES `forma_pago` WRITE;
/*!40000 ALTER TABLE `forma_pago` DISABLE KEYS */;
INSERT INTO `forma_pago` VALUES ('AC','A Crédito',1,NULL,NULL,NULL,NULL),('EFECTIVO','Efectivo',1,NULL,NULL,NULL,NULL),('TC','Tarjeta de Crédito',1,NULL,NULL,NULL,NULL),('TD','Tarjeta de Débito',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `forma_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general`
--

DROP TABLE IF EXISTS `general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cuotas` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general`
--

LOCK TABLES `general` WRITE;
/*!40000 ALTER TABLE `general` DISABLE KEYS */;
INSERT INTO `general` VALUES (1,2);
/*!40000 ALTER TABLE `general` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_cliente`
--

DROP TABLE IF EXISTS `grupo_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `porcentaje` decimal(4,2) DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_cliente`
--

LOCK TABLES `grupo_cliente` WRITE;
/*!40000 ALTER TABLE `grupo_cliente` DISABLE KEYS */;
INSERT INTO `grupo_cliente` VALUES (2,'General',1,0.00,'admin','2021-02-06 15:00:52',NULL,NULL),(3,'VIP',1,0.20,'admin','2021-02-06 15:33:01','admin','2021-02-06 15:33:01'),(4,'Prueba',0,0.20,'admin','2021-02-06 15:32:30',NULL,'2021-02-06 15:32:30');
/*!40000 ALTER TABLE `grupo_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombremarca` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (28,'LACOSTE',1,'admin','2024-09-23 15:35:19',NULL,NULL),(29,'TOMMY',1,'admin','2024-09-23 15:35:25',NULL,NULL),(30,'NIKE',1,'admin','2024-09-23 15:35:32',NULL,NULL);
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacion`
--

LOCK TABLES `notificacion` WRITE;
/*!40000 ALTER TABLE `notificacion` DISABLE KEYS */;
INSERT INTO `notificacion` VALUES (3,'Mario Vazquez','globaladmpy@gmail.com',1);
/*!40000 ALTER TABLE `notificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_deposito`
--

DROP TABLE IF EXISTS `producto_deposito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_deposito` (
  `idProducto` int NOT NULL,
  `idDeposito` int NOT NULL,
  `stock` int DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idProducto`,`idDeposito`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_deposito`
--

LOCK TABLES `producto_deposito` WRITE;
/*!40000 ALTER TABLE `producto_deposito` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_deposito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_categoria` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `hijo` tinyint NOT NULL DEFAULT '0',
  `codigo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `imagen` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `stock` int NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `fechacreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo_producto` int DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `usuariomodificacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `id_marca` int DEFAULT NULL,
  `id_unidad` int DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `stock_minimo_alerta` int DEFAULT NULL,
  `tipo_impuesto` int DEFAULT NULL,
  `tipo_control` int DEFAULT NULL,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_TIPO_IMPUESTO_PRO_idx` (`tipo_impuesto`) USING BTREE,
  KEY `FK_CATEGORIA_PRO_idx` (`id_categoria`) USING BTREE,
  KEY `FK_TIPO_PRO_idx` (`tipo_producto`) USING BTREE,
  KEY `FK_MARCA_PRO_idx` (`id_marca`) USING BTREE,
  KEY `FK_UNIDAD_PRO_idx` (`id_unidad`) USING BTREE,
  KEY `FK_TIPO_CONTROL_idx` (`tipo_control`) USING BTREE,
  CONSTRAINT `FK_CATEGORIA_PRO` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  CONSTRAINT `FK_MARCA_PRO` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`),
  CONSTRAINT `FK_TIPO_CONTROL` FOREIGN KEY (`tipo_control`) REFERENCES `tipo_control` (`id`),
  CONSTRAINT `FK_TIPO_IMP` FOREIGN KEY (`tipo_impuesto`) REFERENCES `tipo_impuesto` (`id`),
  CONSTRAINT `FK_TIPO_PRO` FOREIGN KEY (`tipo_producto`) REFERENCES `tipo_producto` (`id`),
  CONSTRAINT `FK_UNIDAD_PRO` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (244,22,NULL,0,'2202','BASICA LACOSTE BLANCO M','vistas/img/productos//815.jpg',100,60000,95000,'2024-11-06 12:09:16',1,'admin','admin','2024-11-06 12:09:16',28,6,'2025-09-23',10,2,2,1),(245,22,NULL,0,'2203','BASICA LACOSTE NEGRA M','vistas/img/productos/2203/758.jpg',200,60000,95000,'2024-09-23 19:23:39',1,'mario',NULL,NULL,28,6,NULL,10,2,2,1),(246,22,NULL,0,'2204','BASICA LACOSTE ROJO G','vistas/img/productos/2204/424.png',100,60000,95000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,28,6,NULL,10,2,2,1),(247,22,NULL,0,'2205','BASICA TOMMY AZUL MARINO GG','vistas/img/productos/2205/517.jpg',100,60000,95000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,29,6,NULL,10,2,2,1),(248,22,NULL,0,'2206','BASICA TOMMY AZUL  P','vistas/img/productos/2206/418.jpg',100,60000,95000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,29,6,NULL,10,2,2,1),(249,23,NULL,0,'2301','POLO LACOSTE VERDE P','vistas/img/productos/2301/894.jpg',100,70000,105000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,28,6,NULL,10,2,2,1),(250,23,NULL,0,'2302','POLO LACOSTE NEGRA GG','vistas/img/productos/2302/275.jpg',100,70000,110000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,28,6,NULL,10,2,2,1),(251,23,NULL,0,'2303','POLO TOMMY AZUL MARINO M','vistas/img/productos/2303/256.jpg',100,70000,110000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,29,6,NULL,10,2,2,1),(252,22,NULL,0,'2207','OVERSIZE NIKE NEGRO G','vistas/img/productos/default/anonymous.png',100,50000,90000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,30,6,NULL,10,2,2,1),(253,25,NULL,0,'2501','BOXER LACOSTE NEGRO G','vistas/img/productos/2501/930.jpg',100,40000,75000,'2024-09-23 19:42:10',1,'mario',NULL,NULL,28,6,NULL,10,2,2,1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ruc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `telefono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nombrecontacto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `telefonocontacto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (8,'TIENDAS PERU','3673518-3','Paraguari 1511','502700','FMVA2011@GMAIL.COM','MARIO VAZQUEZ','0983902795',1,'admin','2024-09-23 15:56:42',NULL,NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_producto`
--

DROP TABLE IF EXISTS `stock_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_producto` int DEFAULT NULL,
  `id_deposito` int DEFAULT NULL,
  `stock` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_producto`
--

LOCK TABLES `stock_producto` WRITE;
/*!40000 ALTER TABLE `stock_producto` DISABLE KEYS */;
INSERT INTO `stock_producto` VALUES (11,244,9,49),(12,243,9,50),(13,244,1,47),(14,243,1,50),(15,245,1,172),(16,253,1,40),(17,252,1,90),(18,251,1,20),(19,250,1,54),(20,249,1,62),(21,248,1,50),(22,247,1,84),(23,246,1,66),(24,245,9,20),(25,246,9,30),(26,248,9,50),(27,247,9,9),(28,253,9,60),(29,252,9,9),(30,250,9,45),(31,249,9,36),(32,251,9,58);
/*!40000 ALTER TABLE `stock_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sucursales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sucursal` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `estado` int DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariocreacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `usuariomodificacion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` VALUES (1,'Central',1,'2019-01-26 07:00:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `termino_pago`
--

DROP TABLE IF EXISTS `termino_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `termino_pago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `dias` int DEFAULT NULL,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `termino_pago`
--

LOCK TABLES `termino_pago` WRITE;
/*!40000 ALTER TABLE `termino_pago` DISABLE KEYS */;
INSERT INTO `termino_pago` VALUES (1,'80 días',80,1,'admin','2021-02-10 02:58:51',NULL,NULL),(2,'31 dias',31,0,'admin','2021-02-10 03:16:57','admin','2021-02-10 03:16:50'),(3,'60 dias',60,1,'admin','2021-02-10 03:17:13',NULL,NULL);
/*!40000 ALTER TABLE `termino_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_compra`
--

DROP TABLE IF EXISTS `tipo_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_compra` (
  `id` int NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_compra`
--

LOCK TABLES `tipo_compra` WRITE;
/*!40000 ALTER TABLE `tipo_compra` DISABLE KEYS */;
INSERT INTO `tipo_compra` VALUES (1,'Contado'),(2,'Crédito');
/*!40000 ALTER TABLE `tipo_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_control`
--

DROP TABLE IF EXISTS `tipo_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_control` (
  `id` int NOT NULL,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `orden` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_control`
--

LOCK TABLES `tipo_control` WRITE;
/*!40000 ALTER TABLE `tipo_control` DISABLE KEYS */;
INSERT INTO `tipo_control` VALUES (1,'No Controlar',1,NULL,'2021-02-14 03:33:52',NULL,NULL,1),(2,'Controlar',1,NULL,'2021-02-14 03:33:52',NULL,NULL,2);
/*!40000 ALTER TABLE `tipo_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_impuesto`
--

DROP TABLE IF EXISTS `tipo_impuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_impuesto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `valor_impuesto` decimal(18,2) DEFAULT NULL,
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_impuesto`
--

LOCK TABLES `tipo_impuesto` WRITE;
/*!40000 ALTER TABLE `tipo_impuesto` DISABLE KEYS */;
INSERT INTO `tipo_impuesto` VALUES (1,'IVA 5',1,0.05,NULL,'2021-02-14 03:16:29',NULL,NULL),(2,'IVA 10',1,0.10,NULL,'2021-02-14 03:16:29',NULL,NULL),(3,'EXCENTA',1,0.00,NULL,'2021-02-14 03:16:29',NULL,NULL);
/*!40000 ALTER TABLE `tipo_impuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_producto`
--

DROP TABLE IF EXISTS `tipo_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_producto`
--

LOCK TABLES `tipo_producto` WRITE;
/*!40000 ALTER TABLE `tipo_producto` DISABLE KEYS */;
INSERT INTO `tipo_producto` VALUES (1,'Estándar',1,NULL,'2021-02-14 03:04:19',NULL,NULL),(2,'Servicio',1,NULL,'2021-02-14 03:04:19',NULL,NULL),(3,'Prenda/Calzado',1,NULL,'2021-02-14 03:04:19',NULL,NULL),(4,'Producción',1,NULL,'2021-02-14 03:04:19',NULL,NULL);
/*!40000 ALTER TABLE `tipo_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transferencia`
--

DROP TABLE IF EXISTS `transferencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transferencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario_transferencia` int DEFAULT NULL,
  `productos` text,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int DEFAULT NULL,
  `id_usuario_aprobacion` int DEFAULT NULL,
  `fecha_aprobacion` timestamp NULL DEFAULT NULL,
  `id_usuario_recepcion` int DEFAULT NULL,
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `id_deposito_origen` int DEFAULT NULL,
  `id_deposito_destino` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transferencia`
--

LOCK TABLES `transferencia` WRITE;
/*!40000 ALTER TABLE `transferencia` DISABLE KEYS */;
INSERT INTO `transferencia` VALUES (5,13,'[{\"id\":\"244\",\"descripcion\":\"BASICA LACOSTE BLANCO M\",\"cantidad\":\"50\",\"stock\":\"50\",\"iddeposito\":\"9\"},{\"id\":\"243\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"50\",\"stock\":\"50\",\"iddeposito\":\"9\"}]','2024-09-23 19:05:09',3,13,'2024-09-23 19:05:36',13,'2024-09-23 19:06:23',9,1),(6,13,'[{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"20\",\"stock\":\"180\",\"iddeposito\":\"1\"},{\"id\":\"246\",\"descripcion\":\"BASICA LACOSTE ROJO G\",\"cantidad\":\"30\",\"stock\":\"70\",\"iddeposito\":\"1\"},{\"id\":\"248\",\"descripcion\":\"BASICA TOMMY AZUL  P\",\"cantidad\":\"50\",\"stock\":\"50\",\"iddeposito\":\"1\"},{\"id\":\"247\",\"descripcion\":\"BASICA TOMMY AZUL MARINO GG\",\"cantidad\":\"10\",\"stock\":\"90\",\"iddeposito\":\"1\"},{\"id\":\"253\",\"descripcion\":\"BOXER LACOSTE NEGRO G\",\"cantidad\":\"60\",\"stock\":\"40\",\"iddeposito\":\"1\"},{\"id\":\"252\",\"descripcion\":\"OVERSIZE NIKE NEGRO G\",\"cantidad\":\"10\",\"stock\":\"90\",\"iddeposito\":\"1\"},{\"id\":\"250\",\"descripcion\":\"POLO LACOSTE NEGRA GG\",\"cantidad\":\"45\",\"stock\":\"55\",\"iddeposito\":\"1\"},{\"id\":\"249\",\"descripcion\":\"POLO LACOSTE VERDE P\",\"cantidad\":\"38\",\"stock\":\"62\",\"iddeposito\":\"1\"},{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"60\",\"stock\":\"40\",\"iddeposito\":\"1\"}]','2024-09-23 19:43:09',3,13,'2024-09-23 19:43:15',13,'2024-09-23 19:43:20',1,9);
/*!40000 ALTER TABLE `transferencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codunidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `unidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado` int DEFAULT '1',
  `usuariocreacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (6,'UNIDADES','UNID',1,'anegrete','2021-07-12 22:09:31',NULL,NULL);
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_depositos`
--

DROP TABLE IF EXISTS `usuario_depositos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_depositos` (
  `idUsuario` int NOT NULL,
  `idDeposito` int NOT NULL,
  `usuariocreacion` text,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuariomodificacion` text,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`,`idDeposito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_depositos`
--

LOCK TABLES `usuario_depositos` WRITE;
/*!40000 ALTER TABLE `usuario_depositos` DISABLE KEYS */;
INSERT INTO `usuario_depositos` VALUES (1,1,'1','2024-09-23 20:06:43',NULL,NULL),(1,9,'1','2024-09-23 20:06:43',NULL,NULL),(13,1,'1','2024-09-23 16:02:14',NULL,NULL),(13,9,'1','2024-09-23 16:02:14',NULL,NULL),(14,9,'1','2024-09-23 16:02:21',NULL,NULL);
/*!40000 ALTER TABLE `usuario_depositos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `usuario` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `perfil` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `foto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `estado` int DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin','$2a$07$asxx54ahjppf45sd87a5auzLCDizCcjjNp1tyBOr6NFmWs7ykDGF2','Administrador','vistas/img/usuarios/admin/191.jpg',1,'2024-12-17 14:58:03','2024-12-17 19:58:03'),(13,'Mario Vazquez','mario','$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly','Administrador','',1,'2024-09-25 08:55:37','2024-09-25 13:55:37'),(14,'Vendedor','venta','$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly','Vendedor','',0,'2024-09-23 15:07:44','2024-09-25 13:55:07');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `productos` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `codigo_operacion` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nro_cuotas` int DEFAULT NULL,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (87,10,19,13,'[{\"id\":\"244\",\"descripcion\":\"BASICA LACOSTE BLANCO M\",\"cantidad\":\"1\",\"stock\":\"49\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"1\",\"stock\":\"179\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"}]',0,190000,190000,'EFECTIVO','2024-09-23 20:03:38',NULL,'',0,1),(88,10,21,13,'[{\"id\":\"246\",\"descripcion\":\"BASICA LACOSTE ROJO G\",\"cantidad\":\"1\",\"stock\":\"69\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"247\",\"descripcion\":\"BASICA TOMMY AZUL MARINO GG\",\"cantidad\":\"1\",\"stock\":\"89\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"250\",\"descripcion\":\"POLO LACOSTE NEGRA GG\",\"cantidad\":\"1\",\"stock\":\"54\",\"precio\":\"110000\",\"total\":\"110000\",\"iddeposito\":\"1\"}]',0,300000,300000,'TD','2024-09-23 20:04:37',NULL,'1234',0,1),(89,10,22,13,'[{\"id\":\"252\",\"descripcion\":\"OVERSIZE NIKE NEGRO G\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"90000\",\"total\":\"90000\",\"iddeposito\":\"9\"},{\"id\":\"247\",\"descripcion\":\"BASICA TOMMY AZUL MARINO GG\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"9\"},{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"1\",\"stock\":\"59\",\"precio\":\"110000\",\"total\":\"110000\",\"iddeposito\":\"9\"},{\"id\":\"249\",\"descripcion\":\"POLO LACOSTE VERDE P\",\"cantidad\":\"1\",\"stock\":\"37\",\"precio\":\"105000\",\"total\":\"105000\",\"iddeposito\":\"9\"}]',0,400000,400000,'TC','2024-09-23 20:05:11',NULL,'2341',0,1),(90,0,20,1,'[{\"id\":\"244\",\"descripcion\":\"BASICA LACOSTE BLANCO M\",\"cantidad\":\"1\",\"stock\":\"48\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"3\",\"stock\":\"176\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"}]',0,380000,380000,'EFECTIVO','2024-09-23 20:07:25',NULL,'',0,1),(91,0,22,14,'[{\"id\":\"244\",\"descripcion\":\"BASICA LACOSTE BLANCO M\",\"cantidad\":\"1\",\"stock\":\"49\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"9\"},{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"1\",\"stock\":\"58\",\"precio\":\"110000\",\"total\":\"110000\",\"iddeposito\":\"9\"},{\"id\":\"249\",\"descripcion\":\"POLO LACOSTE VERDE P\",\"cantidad\":\"1\",\"stock\":\"36\",\"precio\":\"105000\",\"total\":\"105000\",\"iddeposito\":\"9\"}]',0,310000,310000,'TC','2024-09-23 20:08:23',NULL,'3456',0,1),(92,0,19,1,'[{\"id\":\"244\",\"descripcion\":\"BASICA LACOSTE BLANCO M\",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"1\",\"stock\":\"175\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"}]',0,190000,190000,'EFECTIVO','2024-11-06 12:15:23',NULL,'',0,1),(93,0,21,1,'[{\"id\":\"245\",\"descripcion\":\"BASICA LACOSTE NEGRA M\",\"cantidad\":\"3\",\"stock\":\"172\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"246\",\"descripcion\":\"BASICA LACOSTE ROJO G\",\"cantidad\":\"3\",\"stock\":\"66\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"},{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"10\",\"stock\":\"30\",\"precio\":\"110000\",\"total\":\"110000\",\"iddeposito\":\"1\"}]',0,1670000,1670000,'TD','2024-11-06 12:16:58',NULL,'1234',0,1),(94,0,22,1,'[{\"id\":\"251\",\"descripcion\":\"POLO TOMMY AZUL MARINO M\",\"cantidad\":\"10\",\"stock\":\"20\",\"precio\":\"110000\",\"total\":\"110000\",\"iddeposito\":\"1\"},{\"id\":\"247\",\"descripcion\":\"BASICA TOMMY AZUL MARINO GG\",\"cantidad\":\"5\",\"stock\":\"84\",\"precio\":\"95000\",\"total\":\"95000\",\"iddeposito\":\"1\"}]',0,1575000,1575000,'TC','2024-11-06 12:17:30',NULL,'4321',0,1);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas_creditos`
--

DROP TABLE IF EXISTS `ventas_creditos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas_creditos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_ventas` int NOT NULL,
  `monto_pagado` double DEFAULT NULL,
  `monto_deudor` double DEFAULT NULL,
  `cuotas` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas_creditos`
--

LOCK TABLES `ventas_creditos` WRITE;
/*!40000 ALTER TABLE `ventas_creditos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas_creditos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'posdev_db'
--

--
-- Dumping routines for database 'posdev_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-23  9:40:42
