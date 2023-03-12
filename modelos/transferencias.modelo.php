<?php

require_once "conexion.php";

class ModeloTransferencias{

	/*=============================================
	REGISTRO DE TRANSFERENCIA
	=============================================*/

	static public function mdlIngresarTransferencia($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_usuario_transferencia,productos,estado,id_deposito_origen,id_deposito_destino) VALUES (:id_usuario_transferencia, :productos, 1, :id_deposito_origen, :id_deposito_destino)");
		$stmt->bindParam(":id_usuario_transferencia", $datos["id_usuario_transferencia"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":id_deposito_origen", $datos["id_deposito_origen"], PDO::PARAM_INT);
		$stmt->bindParam(":id_deposito_destino", $datos["id_deposito_destino"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	static public function obtenerUltimaTransferencia(){
		$stmt = Conexion::conectar()->prepare("select max(id) from transferencia");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	/*INGRESAR DETALLE TRANSFERENCIA */
	static public function mdlIngresarDetalleTransferencia($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_transferencia,id_producto,cantidad,id_usuario_transferencia,id_deposito_origen) VALUES (:id_transferencia, :id_producto, :cantidad, :id_usuario_transferencia, :id_deposito_origen )");
		$stmt->bindParam(":id_transferencia", $datos["id_transferencia"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario_transferencia", $datos["id_usuario_transferencia"], PDO::PARAM_INT);
		$stmt->bindParam(":id_deposito_origen", $datos["id_deposito_origen"], PDO::PARAM_INT);
		$stmt->execute();
	}

	/*Listar Ventas de Usuario - Fecha */
	static public function mdlListarTransferencias($fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT t.id,DATE_FORMAT(t.fecha_registro, '%d/%m/%Y')  as fecha_registro, u.nombre as usuario_transferencia,
						d.deposito as deposito_origen, dd.deposito as deposito_destino,
						case t.estado when 1 then 'En Proceso'
									when 0 then 'Anulado'
									when 2 then 'Aprobado'
									when 3 then 'Recepcionado'
									end as nombre_estado,
						t.estado
				FROM transferencia t
				inner join usuarios u on u.id=t.id_usuario_transferencia
				inner join depositos d on d.id=t.id_deposito_origen
				inner join depositos dd on dd.id=t.id_deposito_destino order by t.id asc;");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT t.id,DATE_FORMAT(t.fecha_registro, '%d/%m/%Y')  as fecha_registro, u.nombre as usuario_transferencia,
						d.deposito as deposito_origen, dd.deposito as deposito_destino,
						case t.estado when 1 then 'En Proceso'
									when 0 then 'Anulado'
									when 2 then 'Aprobado'
									when 3 then 'Recepcionado'
									end as nombre_estado,
						t.estado
				FROM transferencia t
				inner join usuarios u on u.id=t.id_usuario_transferencia
				inner join depositos d on d.id=t.id_deposito_origen
				inner join depositos dd on dd.id=t.id_deposito_destino where DATE(t.fecha_registro)='".$fechaFinal."' order by t.id asc;");

			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
			if($fechaFinalMasUno == $fechaActualMasUno){
				
				$stmt = Conexion::conectar()->prepare("SELECT t.id,DATE_FORMAT(t.fecha_registro, '%d/%m/%Y')  as fecha_registro, u.nombre as usuario_transferencia,
						d.deposito as deposito_origen, dd.deposito as deposito_destino,
						case t.estado when 1 then 'En Proceso'
									when 0 then 'Anulado'
									when 2 then 'Aprobado'
									when 3 then 'Recepcionado'
									end as nombre_estado,
						t.estado
				FROM transferencia t
				inner join usuarios u on u.id=t.id_usuario_transferencia
				inner join depositos d on d.id=t.id_deposito_origen
				inner join depositos dd on dd.id=t.id_deposito_destino where t.fecha_registro BETWEEN '".$fechaInicial."' AND '".$fechaFinalMasUno."' order by t.id asc;");

			}else{

				$stmt = Conexion::conectar()->prepare("SELECT t.id,DATE_FORMAT(t.fecha_registro, '%d/%m/%Y')  as fecha_registro, u.nombre as usuario_transferencia,
						d.deposito as deposito_origen, dd.deposito as deposito_destino,
						case t.estado when 1 then 'En Proceso'
									when 0 then 'Anulado'
									when 2 then 'Aprobado'
									when 3 then 'Recepcionado'
									end as nombre_estado,
						t.estado
				FROM transferencia t
				inner join usuarios u on u.id=t.id_usuario_transferencia
				inner join depositos d on d.id=t.id_deposito_origen
				inner join depositos dd on dd.id=t.id_deposito_destino where t.fecha_registro BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' order by t.id asc;");
			}
			$stmt -> execute();
			return $stmt -> fetchAll();
		}	
	}

	static public function mdlMostrarCabeceraTransferencia($idTransferencia){
		if($idTransferencia != null){
			$stmt = Conexion::conectar()->prepare("SELECT t.id,DATE_FORMAT(t.fecha_registro, '%d/%m/%Y')  as fecha_registro, u.nombre as usuario_transferencia,
						d.deposito as deposito_origen, dd.deposito as deposito_destino,
						case t.estado when 1 then 'En Proceso'
									when 0 then 'Anulado'
									when 2 then 'Aprobado'
									when 3 then 'Recepcionado'
									end as nombre_estado,
						t.estado, t.productos
				FROM transferencia t
				inner join usuarios u on u.id=t.id_usuario_transferencia
				inner join depositos d on d.id=t.id_deposito_origen
				inner join depositos dd on dd.id=t.id_deposito_destino where t.id= :valor");
			$stmt -> bindParam(":valor", $idTransferencia, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlAprobarTransferencia($tabla, $datos, $usuario){
		$stmt = Conexion::conectar()->prepare("update $tabla set id_usuario_aprobacion= :id_usuario_aprobacion , fecha_aprobacion= now() , estado=2 where id= :id ");
		$stmt->bindParam(":id_usuario_aprobacion", $usuario, PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["codigoTransferencia"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	static public function mdlRecepcionarTransferencia($tabla, $datos, $usuario){
		$stmt = Conexion::conectar()->prepare("update $tabla set id_usuario_recepcion= :id_usuario_recepcion , fecha_recepcion= now() , estado=3 where id= :id ");
		$stmt->bindParam(":id_usuario_recepcion", $usuario, PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["codigoTransferencia"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	static public function mdlMostrarTransferencia($valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM transferencia WHERE id= :id");
		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}


	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarVentas($tabla, $item, $valor){
		if($item != null){
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja WHERE $item = :$item ORDER BY v.id ASC");
			$stmt = Conexion::conectar()->prepare("SELECT * FROM ventas WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja ORDER BY v.id ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	

	
	


	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function mdlEditarVenta($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function mdlEliminarVenta($tabla, $datos){
        $stmtDetalleVenta = Conexion::conectar()->prepare("DELETE FROM detalle_ventas WHERE id_venta = :id");
        $stmtDetalleVenta->bindParam(":id", $datos, PDO::PARAM_STR);
        if($stmtDetalleVenta -> execute()){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $datos, PDO::PARAM_STR);
            if($stmt -> execute()){
                return "ok";
            }else{
                return "error";
            }
            $stmt -> close();
            $stmt = null;
        }else{
            return "error";
        }


	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v ORDER BY v.id ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v WHERE DATE(fecha)='$fechaFinal'");
			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
			if($fechaFinalMasUno == $fechaActualMasUno){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	

	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/
	static public function mdlSumaTotalVentas($tabla){	
		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}

	static public function crtGuardarCaja($id_caja,$id_sucursal,$monto){
		$stmt = Conexion::conectar()->prepare("INSERT INTO cajas_sucursales(id_caja,id_sucursal,monto_caja,status) VALUES($id_caja,$id_sucursal,$monto,1)");
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	}

	static public function consultaCajaAbierta($usuario){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
        //$stmt = Conexion::conectar()->prepare("SELECT id,monto_caja,status FROM cajas_sucursales WHERE DATE(fecha_creacion)='".$fecha."' and status=1");
		//$stmt = Conexion::conectar()->prepare("select * from aperturas where estado = 1  AND DATE(fechaapertura)='$fecha'");
		//$stmt = Conexion::conectar()->prepare("select count(*) as estado from aperturas where usuarioapertura=:usuario and estado=1");
		$stmt = Conexion::conectar()->prepare("select estado,id from aperturas where usuarioapertura=:usuario and estado=1");
		$stmt -> bindParam(":usuario", $usuario);
        $stmt->execute();
		return $stmt->fetch();
		$stmt -> close();
		$stmt = null;
	}

	static public function obtenerCajaAbiertaUsuario($usuario){
		$stmt = Conexion::conectar()->prepare("select id from aperturas where usuarioapertura=:usuario and estado=1");
		$stmt -> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	

	static public function totalVentasDias(){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
		$stmt=Conexion::conectar()->prepare("SELECT distinct(metodo_pago)as metodo ,sum(total)as total_venta FROM ventas where date(fecha)='".$fecha."' group by metodo_pago;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function listadoVentasFormaPagoCajaAperturada($idApertura){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
		$stmt=Conexion::conectar()->prepare("select f.nombre,sum(total) as total from ventas v inner join forma_pago f on v.metodo_pago=f.codigo where v.codigo=" . $idApertura . " group by f.nombre order by f.nombre;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function listadoTotalProductosCajaAperturada($idApertura){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
		$stmt=Conexion::conectar()->prepare("select p.descripcion, sum(dv.cantidad) as total from detalle_ventas dv inner join productos p on dv.id_producto=p.id inner join ventas v on v.id=dv.id_venta where v.codigo=" . $idApertura ." group by p.descripcion order by p.descripcion;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function cerrarCaja($valor, $idCaja){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
		$stmt = Conexion::conectar()->prepare("UPDATE aperturas SET estado=0, monto_cierre=$valor WHERE DATE(fechaapertura)='".$fecha."' and id ='".$idCaja."'");
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	}

	/*=============================================
	MOSTRAR CUOTAS 
	=============================================*/
	static public function mdlMostrarCuotas(){
		$tabla = "general";
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
	}

	static public function mdlEstablecerCuotas($datos){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM general");
		$stmt->execute();
		if (empty($stmt->fetchAll())) {
			$stmt = Conexion::conectar()->prepare("INSERT INTO general (cuotas) values (:cuotas)");
			$stmt->bindParam(":cuotas", $datos["cuotas"], PDO::PARAM_INT);
			if($stmt->execute()){
				return "ok";	
			}else{
				return "error";
			}
			$stmt->close();
			$stmt = null;
		}else{
			$stmt = Conexion::conectar()->prepare("UPDATE general SET cuotas=:cuotas WHERE 1");
			$stmt->bindParam(":cuotas", $datos["cuotas"], PDO::PARAM_INT);
			if($stmt->execute()){
				return "ok";	
			}else{
				return "error";
			}
			$stmt->close();
			$stmt = null;
		}
	}

	static public function ctrControlVentas(){
		$stmt = Conexion::conectar()->prepare("SELECT v.id, v.codigo,c.nombre, v.metodo_pago, v.neto, v.total, vc.cuotas , vc.monto_pagado, vc.monto_deudor, vc.status 
			FROM ventas v 
			INNER JOIN ventas_creditos vc ON vc.id_ventas=v.id 
			INNER JOIN clientes c ON c.id=v.id_cliente");
		$stmt->execute();
		return $stmt -> fetchAll();
	}

	static public function actualizarPagoVentas($datos){
		$monto_deudor=$datos['monto_deudor']-$datos['monto'];
		$monto_pagado=$datos['monto_pagado']+$datos['monto'];
		$cuotas=$datos['cuota']-1;
		$id=$datos['id_venta'];
		//print_r($monto_deudor.'-'.$monto_pagado);exit;
		if($monto_deudor == $monto_pagado){
			$status=0;
			$cuotas=0;
		}else{
			$status=1;
		}
		$stmt = Conexion::conectar()->prepare("UPDATE ventas_creditos SET monto_deudor=$monto_deudor, monto_pagado=$monto_pagado, cuotas=$cuotas, status=$status WHERE id_ventas=$id");
		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}
	}

	static public function ctrMostrarFormasPago($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where estado=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
}