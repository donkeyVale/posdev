<?php

require_once "conexion.php";

class ModeloClientes{

	/*=============================================
	CREAR CLIENTE
	=============================================*/

	static public function mdlIngresarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, documento, email, telefono, direccion, fecha_nacimiento, grupocliente, limitecredito, usuariocreacion) VALUES (:nombre, :documento, :email, :telefono, :direccion, :fecha_nacimiento, :grupocliente, :limitecredito, :usuario)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":grupocliente", $datos["grupo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":limitecredito", $datos["limite_credito"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/* Registro cliente Venta */
	static public function mdlIngresarClienteVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, documento, email, telefono, direccion, fecha_nacimiento, grupocliente, limitecredito, usuariocreacion) VALUES (:nombre, :documento, :email, :telefono, :direccion, :fecha_nacimiento, :grupocliente, :limitecredito, :usuario)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":grupocliente",  $datos["grupo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":limitecredito", $datos["limite_credito"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function mdlMostrarClientes($tabla, $item, $valor){
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
	LISTAR GRUPOS DE CLIENTES
	=============================================*/
	static public function mdlMostrarGrupoClientes(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM grupo_cliente where estado=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarCliente($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, grupocliente = :grupocliente, limitecredito = :limitecredito, fechamodificacion=NOW(),usuariomodificacion = :usuario WHERE id = :id");
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":grupocliente", $datos["grupo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":limitecredito", $datos["limite_credito"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function mdlEliminarCliente($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/
	static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlMostrarCumpleanosMes(){
		$stmt = Conexion::conectar()->prepare("select nombre,telefono,email,Date_format(fecha_nacimiento,'%d/%m/%Y') as fecha_nacimiento from grupocreativodb.clientes where month(fecha_nacimiento)= month(now()) order by fecha_nacimiento desc ;");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
}