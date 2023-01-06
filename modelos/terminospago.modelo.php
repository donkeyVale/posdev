<?php

require_once "conexion.php";

class ModeloTerminosPago{

	/*=============================================
	CREAR TERMINO PAGO
	=============================================*/
	static public function mdlIngresarTerminoPAgo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(descripcion,dias,usuariocreacion) VALUES (:descripcion, :dias, :usuariocreacion)");
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":dias", $datos["dias"], PDO::PARAM_INT);
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
	MOSTRAR TÉRMINOS DE PAGO
	=============================================*/
	static public function mdlMostrarTerminosPago($tabla, $item, $valor){
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
	EDITAR TERMINOS DE PAGO
	=============================================*/
	static public function mdlEditarTerminoPago($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion = :descripcion , dias = :dias ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":dias", $datos["dias"], PDO::PARAM_STR);
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
	BORRAR TERMINO DE PAGO
	=============================================*/
	static public function mdlBorrarTerminoPago($tabla, $datos){
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