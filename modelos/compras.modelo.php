<?php

require_once "conexion.php";

class ModeloCompras{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarCompras($tabla, $item, $valor){
		if($item != null){
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja WHERE $item = :$item ORDER BY v.id ASC");
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
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

	static public function mdlMostrarCabeceraCompras($idCompra){
		if($idCompra != null){
			/*
			$stmt = Conexion::conectar()->prepare("SELECT v.id,v.neto,v.total,v.productos,v.nrofactura, v.id_proveedor,u.nombre as comprador,c.nombre as proveedor,v.id_tipo_compra,fp.nombre as nombrePago ,
					v.fechacompra,v.usuariocreacion, v.referencia, v.id_deposito, d.deposito FROM compras v 
					inner join usuarios u on u.id=v.usuariocreacion 
					inner join proveedores c on c.id=v.id_proveedor 
					left join pospruebas_db.depositos d on d.id=v.id_deposito
					inner join tipo_compra fp on fp.id=v.id_tipo_compra where v.id= :valor");
			$stmt -> bindParam(":valor", $idCompra, PDO::PARAM_INT);
			*/
			$stmt = Conexion::conectar()->prepare("SELECT v.id,v.neto,v.total,v.productos,v.nrofactura, v.id_proveedor,u.nombre as comprador,c.nombre as proveedor,v.id_tipo_compra,fp.nombre as nombrePago ,
			v.fechacompra as fechacompra,v.usuariocreacion, v.referencia, v.id_deposito,d.deposito FROM compras v 
			inner join usuarios u on u.id=v.usuariocreacion 
			inner join proveedores c on c.id=v.id_proveedor 
			inner join depositos d on d.id=v.id_deposito
			inner join tipo_compra fp on fp.id=v.id_tipo_compra where v.id= :valor");
			$stmt -> bindParam(":valor", $idCompra, PDO::PARAM_INT);

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
	REGISTRO DE COMPRA
	=============================================*/

	static public function mdlIngresarCompra($tabla, $datos){

        $listaProducto = json_decode($datos["productos"], true);

        foreach ($listaProducto as $key => $value) {
            $tablaProductos = "productos";
            $valor = $value['id'];
            $stmtProducto = Conexion::conectar()->prepare("SELECT * FROM productos WHERE id = :id_producto");
            $stmtProducto -> bindParam(":id_producto", $valor);
            $stmtProducto -> execute();
            $traerProducto = $stmtProducto -> fetch();
            $item1b = "stock";
            $valor1b = $value["cantidad"] + $traerProducto["stock"];
            ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
            $item2b = "precio_compra";
            $valor2b = $value["precio"];
            ModeloProductos::mdlActualizarProductoPrecio($tablaProductos, $item2b, $valor2b, $valor);
        }

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_proveedor, fechacompra,referencia,nrofactura,id_deposito,id_tipo_compra,productos,neto,total, estado_compra, usuariocreacion) VALUES (:id_proveedor, :fechacompra, :referencia, :nrofactura, :id_deposito, :id_tipo_compra, :productos, :neto, :total, :estado_compra, :usuariocreacion)");
		$stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":fechacompra", $datos["fechacompra"] , PDO::PARAM_STR);
		$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
		$stmt->bindParam(":nrofactura", $datos["nroFactura"], PDO::PARAM_STR);
		$stmt->bindParam(":id_deposito", $datos["id_deposito"], PDO::PARAM_STR);
		$stmt->bindParam(":id_tipo_compra", $datos["id_tipo_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_compra", $datos["estado_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":usuariocreacion", $datos["usuarioCreacion"], PDO::PARAM_STR);




		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	/*INGRESAR DETALLE DE COMPRA

	Luis Fernando Barrera Ortiz
luisb@cybitsoft.com.co
+57 3114177181
	*/
	static public function mdlIngresarDetalleCompra($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_compra, id_producto, cantidad, precio_unitario, total) VALUES (:id_compra, :id_producto, :cantidad, :precio_unitario, :total)");
		$stmt->bindParam(":id_compra", $datos["id_compra"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":precio_unitario", $datos["precio_unitario"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->execute();
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
	ELIMINAR COMPRA
	=============================================*/
	static public function mdlEliminarCompra($tabla, $datos){
		$stm_detalle=Conexion::conectar()->prepare("DELETE FROM detalle_compras WHERE id_compra = ". $datos . "");
		$stm_detalle -> execute();
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja ORDER BY v.id ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v INNER JOIN cajas_ventas cv ON cv.id_venta=v.id INNER JOIN cajas_sucursales cs ON cs.id=cv.id_caja WHERE DATE(fecha)='$fechaFinal'");
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
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla v LEFT JOIN cajas_ventas cv ON cv.id_venta=v.id LEFT JOIN cajas_sucursales cs ON cs.id=cv.id_caja WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	/*Listar Ventas  Fecha */
	static public function mdlListarCompras($fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("select c.id,  p.nombre as proveedor,DATE_FORMAT(c.fechacompra, '%d/%m/%Y')  as fecha , d.deposito,c.nrofactura,c.total,tc.nombre as tipocompra, CONCAT('C-',LPAD(c.id,8,'0')) AS codigo from compras c inner join proveedores p on p.id=c.id_proveedor inner join depositos d on d.id=c.id_deposito inner join tipo_compra tc on tc.id=c.id_tipo_compra  order by c.id asc");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("select c.id,  p.nombre as proveedor,DATE_FORMAT(c.fechacompra, '%d/%m/%Y')  as fecha , d.deposito,c.nrofactura,c.total,tc.nombre as tipocompra, CONCAT('C-',LPAD(c.id,8,'0')) AS codigo from compras c inner join proveedores p on p.id=c.id_proveedor inner join depositos d on d.id=c.id_deposito inner join tipo_compra tc on tc.id=c.id_tipo_compra  where DATE(c.fechacompra)='".$fechaInicial."' order by c.id asc");
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
				$stmt = Conexion::conectar()->prepare("select c.id,  p.nombre as proveedor,DATE_FORMAT(c.fechacompra, '%d/%m/%Y')  as fecha , d.deposito,c.nrofactura,c.total,tc.nombre as tipocompra, CONCAT('C-',LPAD(c.id,8,'0')) AS codigo from compras c inner join proveedores p on p.id=c.id_proveedor inner join depositos d on d.id=c.id_deposito inner join tipo_compra tc on tc.id=c.id_tipo_compra  where c.fechacompra between '".$fechaInicial."' and '".$fechaFinalMasUno."' order by c.id asc");
			}else{
				//$stmt = Conexion::conectar()->prepare("select c.id,  p.nombre as proveedor,". $fechaInicial ." as fecha , d.deposito,c.nrofactura,c.total,tc.nombre as tipocompra, CONCAT('C-',LPAD(c.id,8,'0')) AS codigo from compras c inner join proveedores p on p.id=c.id_proveedor inner join depositos d on d.id=c.id_deposito inner join tipo_compra tc on tc.id=c.id_tipo_compra  order by c.id asc");
				$stmt = Conexion::conectar()->prepare("select c.id,  p.nombre as proveedor,DATE_FORMAT(c.fechacompra, '%d/%m/%Y')  as fecha , d.deposito,c.nrofactura,c.total,tc.nombre as tipocompra, CONCAT('C-',LPAD(c.id,8,'0')) AS codigo from compras c inner join proveedores p on p.id=c.id_proveedor inner join depositos d on d.id=c.id_deposito inner join tipo_compra tc on tc.id=c.id_tipo_compra  where c.fechacompra between '".$fechaInicial."' and '".$fechaFinal."' order by c.id asc");
			}
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	static public function mdlListarDepositos(){
		$stmt = Conexion::conectar()->prepare("SELECT id,deposito FROM depositos where estado=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlListarTipoCompras(){
		$stmt = Conexion::conectar()->prepare("SELECT id,nombre FROM tipo_compra");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlMostrarProveedores($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
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
		$fecha=date('Y-m-d');
		//$stmt = Conexion::conectar()->prepare("SELECT id,monto_caja,status FROM cajas_sucursales WHERE DATE(fecha_creacion)='".$fecha."' and status=1");
		$stmt = Conexion::conectar()->prepare("select count(*) from aperturas where usuarioapertura=:usuario and estado=1");
		$stmt -> bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function obtenerUltimaCompra(){
		$stmt = Conexion::conectar()->prepare("select max(id) from compras");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function verificarExisteProductoDeposito($idDeposito, $idProducto){
		$stmt = Conexion::conectar()->prepare("select count(*) from stock_producto where id_producto=" . $idProducto . " and id_deposito=". $idDeposito);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function totalVentasDias(){
		$fecha=date('Y-m-d');
		$stmt=Conexion::conectar()->prepare("SELECT distinct(metodo_pago)as metodo ,sum(total)as total_venta FROM ventas where date(fecha)='".$fecha."' group by metodo_pago;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function cerrarCaja(){
		$fecha=date('Y-m-d');
		$stmt=Conexion::conectar()->prepare("UPDATE cajas_sucursales SET status=0 WHERE DATE(fecha_creacion)='".$fecha."'");
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
