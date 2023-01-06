<?php

require_once "conexion.php";

class ModeloDepositos{

	/*=============================================
	CREAR DEPOSITO
	=============================================*/
	static public function mdlIngresarDeposito($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(deposito,usuariocreacion,codigo,telefono,email,direccion) VALUES (:deposito, :usuariocreacion, :codigo, :telefono, :email, :direccion)");
		$stmt->bindParam(":deposito", $datos["deposito"], PDO::PARAM_STR);
		$stmt->bindParam(":usuariocreacion", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR DEPÓSITOS
	=============================================*/
	static public function mdlMostrarDepositos($tabla, $item, $valor){
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
	EDITAR DEPÓSITO
	=============================================*/
	static public function mdlEditarDeposito($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET deposito = :deposito ,usuariomodificacion = :usuario , fechamodificacion=NOW(), codigo = :codigo , telefono = :telefono , email = :email , direccion = :direccion WHERE id = :id");
		$stmt -> bindParam(":deposito", $datos["deposito"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
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
	BORRAR DEPOSITO
	=============================================*/
	static public function mdlBorrarDeposito($tabla, $datos){
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