<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, foto) VALUES (:nombre, :usuario, :password, :perfil, :foto)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmtUser = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");


        $stmtProductos = Conexion::conectar()->prepare("SELECT * FROM detalle_ventas WHERE id_vendedor = :id_vendedor");

        $stmtProductos -> bindParam(":id_vendedor", $datos, PDO::PARAM_STR);
        $stmtProductos -> execute();
        $productos = $stmtProductos -> fetchAll();
        $idVentas = array();

        /**
         * Actualizamos el stock
         */
        foreach ($productos as $key => $value) {
            $tablaProductos = "productos";
            $item = "id";
            $valor = $value['id_producto'];
            $orden = "id";
            $stmtProducto = Conexion::conectar()->prepare("SELECT * FROM productos WHERE id = :id_producto");
            $stmtProducto -> bindParam(":id_producto", $valor);
            $stmtProducto -> execute();
            $traerProducto = $stmtProducto -> fetch();
            $item1b = "stock";
            $valor1b = $value["cantidad"] + $traerProducto["stock"];
            $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
            $idVentas[] = $value['id_venta'];
        }
        /**
         * Eliminamos los detalles de las ventas
         */
//        $stmtVentas = Conexion::conectar()->prepare("DELETE FROM detalle_ventas WHERE id_vendedor = :id_vendedor");
//        $stmtVentas -> bindParam(":id_vendedor", $datos, PDO::PARAM_STR);
//        $stmtVentas -> execute();
        /**
         * Eliminamos las ventas
         * ALTER TABLE `detalle_ventas`
        DROP FOREIGN KEY `FK_VEND_VENTA_DET`;
         */
//        foreach ($idVentas as $idVenta) {
//            $id_venta = $idVenta;
//            /**
//             * Ventas
//             */
//            $stmtVentasDelete = Conexion::conectar()->prepare("DELETE FROM ventas WHERE id = :id");
//            $stmtVentasDelete -> bindParam(":id", $id_venta, PDO::PARAM_INT);
//            $stmtVentasDelete -> execute();
//        }

        $stmtUser -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmtUser -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

        $stmtUser -> close();

        $stmtUser = null;


	}

}