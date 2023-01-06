<?php

require_once "conexion.php";

class ModeloSucursales{

	/*=============================================
	CREAR SUCURSAL
	=============================================*/
	static public function mdlIngresarSucursal($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(sucursal,usuariocreacion) VALUES (:sucursal, :usuariocreacion)");
		$stmt->bindParam(":sucursal", $datos["sucursal"], PDO::PARAM_STR);
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
	MOSTRAR SUCURSAL
	=============================================*/
	static public function mdlMostrarSucursales($tabla, $item, $valor){
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
	EDITAR SUCURSAL
	=============================================*/
	static public function mdlEditarSucursal($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET sucursal = :sucursal ,usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":sucursal", $datos["sucursal"], PDO::PARAM_STR);
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
	BORRAR SUCURSAL
	=============================================*/
	static public function mdlBorrarSucursal($tabla, $datos){
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