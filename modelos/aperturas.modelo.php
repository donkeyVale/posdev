<?php

require_once "conexion.php";

class ModeloAperturas{

	static public function mdlMostrarSucursales(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM sucursales where estado=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlMostrarCajasSucursal($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and estado=1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlMostrarAperturasUsuario($usuario)
	{
		$stmt = Conexion::conectar()->prepare("select a.id,s.sucursal,c.cajas,u.usuario,a.fechaapertura,a.monto_apertura, a.fechacierre,a.monto_cierre, 
       case a.estado when 1 then 'Aperturado' when 0 then 'Cerrado' end as estado 
from aperturas a inner join cajas c on c.id=a.idcaja 
    inner join sucursales s on s.id=c.idSucursal 
    inner join usuarios u on u.id=a.usuarioapertura 
where (a.estado=1 or a.estado=0) 
  and a.usuarioapertura= :usuario");
		$stmt -> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlIngresarApertura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcaja, monto_apertura, usuarioapertura) VALUES (:idcaja, :monto_apertura, :usuarioapertura)");
		$stmt->bindParam(":idcaja", $datos["idcaja"], PDO::PARAM_STR);
		$stmt->bindParam(":monto_apertura", $datos["monto_apertura"], PDO::PARAM_INT);
		$stmt->bindParam(":usuarioapertura", $datos["usuarioapertura"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

    static public function mdlCerrarApertura($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=0, monto_cierre=:monto_cierre WHERE id = :id");
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt->bindParam(":monto_cierre", $datos["monto_cierre"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

	static public function mdlVerificarAperturaUsuario($usuario)
	{
		$stmt = Conexion::conectar()->prepare("select count(*) from aperturas where usuarioapertura=:usuario and estado=1 ");
		$stmt -> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlMostrarApertura($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT a.estado, a.id,s.sucursal, c.cajas,a.monto_apertura,a.monto_cierre,a.fechaapertura,a.fechacierre FROM aperturas a inner join cajas c on c.id=a.idcaja inner join sucursales s on s.id=c.idSucursal where a.id = :idApertura");
		$stmt -> bindParam(":idApertura", $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlEliminarApertura($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=0, fechaeliminacion=NOW(), usuarioeliminacion=:usuario WHERE id = :id");
		$stmt -> bindParam(":id", $datos["idApertura"], PDO::PARAM_INT);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}