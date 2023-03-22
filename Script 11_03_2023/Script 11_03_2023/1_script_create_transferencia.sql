CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_transferencia` int(11) DEFAULT NULL,
  `productos` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL,
  `id_usuario_aprobacion` int(11) DEFAULT NULL,
  `fecha_aprobacion` timestamp NULL DEFAULT NULL,
  `id_usuario_recepcion` int(11) DEFAULT NULL,
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `id_deposito_origen` int(11) DEFAULT NULL,
  `id_deposito_destino` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
