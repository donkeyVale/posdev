CREATE TABLE `detalle_transferencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transferencia` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_usuario_transferencia` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  `id_deposito_origen` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TRANSFERENCIA` (`id_transferencia`),
  KEY `FK_PRODUCTO` (`id_producto`),
  CONSTRAINT `FK_PRODUCTO` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TRANSFERENCIA` FOREIGN KEY (`id_transferencia`) REFERENCES `transferencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
