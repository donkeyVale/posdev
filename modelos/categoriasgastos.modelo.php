<?php

require_once "conexion.php";

class ModeloCategoriasGastos{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/
	static public function mdlIngresarCategoriaGasto($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,usuariocreacion) VALUES (:nombre, :usuariocreacion)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
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
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function mdlMostrarCategoriasGastos($tabla, $item, $valor){
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
	EDITAR CATEGORIA
	=============================================*/
	static public function mdlEditarCategoriaGasto($tabla, $datos){
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
	BORRAR CATEGORIA
	=============================================*/
	static public function mdlBorrarCategoriaGasto($tabla, $datos){
		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
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