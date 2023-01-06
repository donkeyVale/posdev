<?php

require_once "conexion.php";

class ModeloMarcas{

	/*=============================================
	CREAR MARCA
	=============================================*/
	static public function mdlIngresarMarca($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombremarca,usuariocreacion) VALUES (:marca, :usuariocreacion)");
		$stmt->bindParam(":marca", $datos["nombreMarca"], PDO::PARAM_STR);
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
	MOSTRAR MARCAS
	=============================================*/
	static public function mdlMostrarMarcas($tabla, $item, $valor){
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
	EDITAR MARCAS
	=============================================*/
	static public function mdlEditarMarca($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombremarca = :marca ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
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
	BORRAR MARCAS
	=============================================*/
	static public function mdlBorrarMarca($tabla, $datos){
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