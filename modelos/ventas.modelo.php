<?php

require_once "conexion.php";

class ModeloVentas{

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

	static public function mdlMostrarCabeceraVentas($idVenta){
		if($idVenta != null){
			$stmt = Conexion::conectar()->prepare("SELECT v.id,v.impuesto,v.neto,v.total,v.productos, v.id_vendedor,u.nombre as vendedor,v.id_cliente,c.nombre as cliente,v.metodo_pago,fp.nombre as nombrePago, CONCAT('V-',LPAD(v.id,8,'0')) AS codigo 
FROM ventas v 
    inner join usuarios u on u.id=v.id_vendedor 
    inner join clientes c on c.id=v.id_cliente 
    inner join forma_pago fp on fp.codigo=v.metodo_pago 
where v.id= :valor");
			$stmt -> bindParam(":valor", $idVenta, PDO::PARAM_STR);
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
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){
		//$pago_cuotas=$datos['total']/$datos['cuotas'];
		//
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, codigo_operacion, nro_cuotas) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :codigo_operacion, :nro_cuotas)");
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_operacion", $datos["codigo_operacion"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_cuotas", $datos["nro_cuotas"], PDO::PARAM_STR);
		/*if($datos["cuotas"]){
			$stmt->bindParam(":datos_cuotas", $datos["cuotas"], PDO::PARAM_STR);
		}*/
		if($stmt->execute()){
			if($datos["cuotas"]){
				$cuotas=$datos['cuotas'];
				$stmt1 = Conexion::conectar()->prepare("SELECT max(id) as max_id FROM $tabla");
				$stmt1->execute();
				$codigo=$stmt1->fetch();
				$codigo=$codigo['max_id'];
				$total=$datos["total"];
				$stmt2 = Conexion::conectar()->prepare("INSERT INTO ventas_creditos (id_ventas,cuotas,monto_deudor) VALUES ($codigo,$cuotas,$total)");
				$stmt2->execute();
			}
			/*$id_caja_sucursal=$datos['id_caja_sucursal'];
			$stmt3 = Conexion::conectar()->prepare("INSERT INTO cajas_ventas (id_venta,id_caja) VALUES ($codigo,$id_caja_sucursal)");
			$stmt3->execute();*/
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*INGRESAR DETALLE DE VENTA */
	static public function mdlIngresarDetalleVenta($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_venta, id_producto, cantidad, precio_unitario, total, id_vendedor) VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :total, :id_vendedor )");
		$stmt->bindParam(":id_venta", $datos["id_venta"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":precio_unitario", $datos["precio_unitario"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		//$stmt->bindParam(":id_deposito", $datos["id_deposito"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "INSERT INTO $tabla(id_venta, id_producto, cantidad, precio_unitario, total, id_vendedor,id_deposito) VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :total, :id_vendedor, :id_deposito )";
		}
		$stmt->close();
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

	/*Listar Ventas de Usuario - Fecha */
	static public function mdlListarVentasUsuario($usuario,$fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT v.id,c.nombre as cliente, u.nombre as vendedor ,fp.nombre as forma_pago,v.neto,v.total,DATE_FORMAT(v.fecha, '%d/%m/%Y')  as fecha, CONCAT('V-',LPAD(v.id,8,'0')) AS codigo 
FROM ventas v 
    INNER JOIN clientes c on v.id_cliente=c.id 
    INNER JOIN usuarios u on u.id=v.id_vendedor 
    INNER JOIN forma_pago fp on fp.codigo=v.metodo_pago 
order by v.id asc");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT v.id,c.nombre as cliente, u.nombre as vendedor ,fp.nombre as forma_pago,v.neto,v.total,DATE_FORMAT(v.fecha, '%d/%m/%Y')  as fecha, CONCAT('V-',LPAD(v.id,8,'0')) AS codigo FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id INNER JOIN usuarios u on u.id=v.id_vendedor INNER JOIN forma_pago fp on fp.codigo=v.metodo_pago where DATE(v.fecha)='".$fechaFinal."' order by v.id asc");
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
				$stmt = Conexion::conectar()->prepare("SELECT v.id,c.nombre as cliente, u.nombre as vendedor ,fp.nombre as forma_pago,v.neto,v.total,DATE_FORMAT(v.fecha, '%d/%m/%Y')  as fecha, CONCAT('V-',LPAD(v.id,8,'0')) AS codigo FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id INNER JOIN usuarios u on u.id=v.id_vendedor INNER JOIN forma_pago fp on fp.codigo=v.metodo_pago where v.fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinalMasUno."' order by v.id asc");
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT v.id,c.nombre as cliente, u.nombre as vendedor ,fp.nombre as forma_pago,v.neto,v.total,DATE_FORMAT(v.fecha, '%d/%m/%Y')  as fecha, CONCAT('V-',LPAD(v.id,8,'0')) AS codigo FROM ventas v INNER JOINclientes c on v.id_cliente=c.id INNER JOIN usuarios u on u.id=v.id_vendedor INNER JOIN forma_pago fp on fp.codigo=v.metodo_pago where  v.fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' order by v.id asc");
			}
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		//$stmt = Conexion::conectar()->prepare("SELECT v.id,c.nombre as cliente, u.nombre as vendedor ,fp.nombre as forma_pago,v.neto,v.total,DATE_FORMAT(v.fecha, '%d/%m/%Y')  as fecha FROMventas v INNER JOINclientes c on v.id_cliente=c.id INNER JOINusuarios u on u.id=v.id_vendedor INNER JOINforma_pago fp on fp.codigo=v.metodo_pago where v.id_vendedor=".$usuario);
		//$stmt -> execute();
		//return $stmt -> fetchAll();	
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
		//$stmt = Conexion::conectar()->prepare("select estado,id from aperturas where usuarioapertura=:usuario and estado=1");
		$stmt = Conexion::conectar()->prepare("select count(*) as estado,(select max(id) from aperturas where usuarioapertura=:usuario and estado=1) as id, monto_apertura from aperturas where usuarioapertura=:usuario and estado=1");
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

	static public function obtenerUltimaVentaUsuario($usuario){
		$stmt = Conexion::conectar()->prepare("select max(id) from ventas where id_vendedor=:usuario and estado=1");
		$stmt -> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function obtenerVentaCajaUsuario($cajaid){
		$stmt = Conexion::conectar()->prepare("select v.id_vendedor, sum(v.neto) as neto, u.usuario from ventas as v INNER JOIN usuarios as u ON v.id_vendedor=u.id where v.codigo=:codigo and v.estado=1 group by v.id_vendedor order by v.id_vendedor");
		$stmt -> bindParam(":codigo", $cajaid, PDO::PARAM_STR);
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
		//$stmt=Conexion::conectar()->prepare("SELECT distinct(metodo_pago)as metodo ,sum(total)as total_venta FROM ventas where fecha>=(select fechaapertura from aperturas where id=" . $cajaid . ") and id_vendedor=" . $usuario . " group by metodo_pago;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function totalVentasCaja($cajaid, $usuario){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/Asuncion'));
        $fecha = $Object->format("Y-m-d");
		//$stmt=Conexion::conectar()->prepare("SELECT distinct(metodo_pago)as metodo ,sum(total)as total_venta FROM ventas where date(fecha)='".$fecha."' group by metodo_pago;");
		$stmt=Conexion::conectar()->prepare("SELECT distinct(metodo_pago)as metodo ,sum(total)as total_venta FROM ventas where fecha>=(select fechaapertura from aperturas where id=" . $cajaid . ") and id_vendedor=" . $usuario . " group by metodo_pago;");
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
        $fecha = $Object->format("Y-m-d H:i:s");
		//$stmt = Conexion::conectar()->prepare("UPDATE aperturas SET estado=0, monto_cierre=$valor WHERE DATE(fechaapertura)='".$fecha."' and id ='".$idCaja."'");
		$stmt = Conexion::conectar()->prepare("UPDATE aperturas SET estado=0, monto_cierre= monto_apertura + ".$valor.",fechacierre='".$fecha."' WHERE id ='".$idCaja."'");
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
