use postecnopadel_db;
CREATE TABLE `usuario_depositos` (
  `idUsuario` int(11) NOT NULL,
  `idDeposito` int(11) NOT NULL,
  `usuariocreacion` text DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuariomodificacion` text DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`,`idDeposito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
