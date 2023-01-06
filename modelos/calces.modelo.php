<?php

require_once "conexion.php";

class ModeloCalces{

	/*=============================================
	CREAR CALCE
	=============================================*/
	static public function mdlIngresarCalce($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,usuariocreacion) VALUES (:calce, :usuariocreacion)");
		$stmt->bindParam(":calce", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuariocreacion", $datos["usuario"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CALCES
	=============================================*/
	static public function mdlMostrarCalces($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where estado=1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CALCE
	=============================================*/
	static public function mdlEditarCalce($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		if($stmt->execute())
		{
			return "ok";
		}
		else
		{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR CALCE
	=============================================*/
	static public function mdlBorrarCalce($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla set estado=0 WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute())
		{
			return "ok";
		}
		else
		{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}