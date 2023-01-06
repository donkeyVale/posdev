<?php

require_once "conexion.php";

class ModeloCajas{

	/*=============================================
	CREAR CAJA
	=============================================*/
	static public function mdlIngresarCaja($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cajas,usuariocreacion,idSucursal) VALUES (:cajas, :usuariocreacion , :idSucursal)");
		$stmt->bindParam(":cajas", $datos["cajas"], PDO::PARAM_STR);
		$stmt->bindParam(":usuariocreacion", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":idSucursal", $datos["idSucursal"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CAJAS
	=============================================*/
	static public function mdlMostrarCajas($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT t.*, s.sucursal FROM $tabla t JOIN sucursales s on s.id=t.idSucursal where t.estado=1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CAJA
	=============================================*/
	static public function mdlEditarCaja($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cajas = :cajas, idSucursal =:idSucursal , usuariomodificacion = :usuario , fechamodificacion=NOW() WHERE id = :id");
		$stmt -> bindParam(":cajas", $datos["cajas"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":idSucursal", $datos["idSucursal"], PDO::PARAM_INT);
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
	BORRAR CAJA
	=============================================*/
	static public function mdlBorrarCaja($tabla, $datos){
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

	/*=============================================
	LISTAR SUCURSALES
	=============================================*/
	static public function mdlMostrarSucursales(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM sucursales where estado=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
}