<?php

require_once "conexion.php";

class ModeloGruposClientes{

	/*=============================================
	CREAR GRUPO CLIENTE
	=============================================*/
	static public function mdlIngresarGrupo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,porcentaje,usuariocreacion) VALUES (:nombre, :porcentaje, :usuariocreacion)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":porcentaje", $datos["porcentaje"], PDO::PARAM_STR);
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
	MOSTRAR GRUPOS CLIENTES
	=============================================*/
	static public function mdlMostrarGrupos($tabla, $item, $valor){
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
	EDITAR GRUPO
	=============================================*/
	static public function mdlEditarGrupo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre , porcentaje = :porcentaje ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentaje", $datos["porcentaje"], PDO::PARAM_STR);
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
	BORRAR GRUPO
	=============================================*/
	static public function mdlBorrarGrupo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla set estado=0, fechamodificacion=NOW() WHERE id = :id");
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