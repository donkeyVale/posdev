<?php

require_once "conexion.php";

class ModeloUnidades{

	/*=============================================
	CREAR UNIDAD
	=============================================*/
	static public function mdlIngresarUnidad($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codunidad,unidad,usuariocreacion) VALUES (:codunidad, :unidad, :usuariocreacion)");
		$stmt->bindParam(":codunidad", $datos["codUnidad"], PDO::PARAM_STR);
		$stmt->bindParam(":unidad", $datos["nombreUnidad"], PDO::PARAM_STR);
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
	MOSTRAR UNIDADES
	=============================================*/
	static public function mdlMostrarUnidades($tabla, $item, $valor){
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
	EDITAR UNIDAD
	=============================================*/
	static public function mdlEditarUnidad($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET unidad = :unidad , codunidad = :codunidad ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":unidad", $datos["unidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":codunidad", $datos["codUnidad"], PDO::PARAM_STR);
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
	BORRAR UNIDAD
	=============================================*/
	static public function mdlBorrarUnidad($tabla, $datos){
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