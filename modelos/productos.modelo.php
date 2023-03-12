<?php

require_once "conexion.php";

class ModeloProductos{

	static public function mdlListarProductos(){
		$stmt = Conexion::conectar()->prepare("SELECT p.id,p.imagen,p.codigo,p.descripcion, c.categoria, p.precio_compra,p.precio_venta,p.stock,u.unidad,tp.nombre 
            FROM productos p 
            left join categorias c on c.id=p.id_categoria 
            left join unidades u on u.id=p.id_unidad 
            left join tipo_producto tp on tp.id=p.tipo_producto  
            where p.estado=1 and p.hijo = 0 order by p.descripcion asc");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	/* Se agrega método para listar los productos del depósito */
	static public function mdlListarProductosDepositos($valor){
		$stmt = Conexion::conectar()->prepare("SELECT p.id,p.imagen,p.codigo,p.descripcion, c.categoria, p.precio_compra,p.precio_venta,pd.stock,u.unidad,tp.nombre 
            FROM productos p 
            left join categorias c on c.id=p.id_categoria 
            left join unidades u on u.id=p.id_unidad 
            left join tipo_producto tp on tp.id=p.tipo_producto  
			inner join stock_producto pd on pd.id_producto=p.id and pd.id_deposito=" . $valor . " where p.estado=1 and p.hijo = 0 order by p.descripcion asc");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlListarProductosHijos(){
        $stmt = Conexion::conectar()->prepare("SELECT p.id,p.imagen,p.codigo,p.descripcion, c.categoria, p.precio_compra,p.precio_venta,p.stock,u.unidad,tp.nombre 
            FROM productos p 
            left join categorias c on c.id=p.id_categoria 
            left join unidades u on u.id=p.id_unidad 
            left join tipo_producto tp on tp.id=p.tipo_producto  
            where p.estado=1 and p.hijo = 1 order by p.descripcion asc");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function mdlMostrarProductos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  where estado!=2 and product_id IS NULL ORDER BY 1 DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	/*Productos en Depósitos*/ 
	static public function mdlMostrarProductosDepositos($tabla, $item, $valor,$deposito,$usuario){
		//if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT p.id,p.descripcion, pd.stock, p.precio_venta,(select count(*) from usuario_depositos where idUsuario=".$usuario." and idDeposito=".$deposito.") as permiso 
						FROM productos p
						inner join stock_producto pd on pd.id_producto=p.id and pd.id_deposito=".$deposito." where p.id=".$valor."");
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
			//$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetch();
		/*}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  where estado!=2 and product_id IS NULL ORDER BY 1 DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}*/
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlProductoDeposito($deposito,$producto){
		$stmt = Conexion::conectar()->prepare("SELECT p.id,p.descripcion, pd.stock, p.precio_venta 
					FROM productos p
					inner join stock_producto pd on pd.id_producto=p.id and pd.id_deposito=".$deposito." where p.id=".$producto."");
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlMostrarProductosVentas($tabla, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt -> execute();
            return $stmt -> fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  where estado=1 ORDER BY 1 DESC");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }

	static public function mdlMostrarTipoProductos(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tipo_producto where estado=1 ORDER BY nombre DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlMostrarTipoImpuestos(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tipo_impuesto where estado=1 ORDER BY descripcion DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlMostrarStockCritico(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tipo_control where estado=1 ORDER BY nombre DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
	static public function mdlIngresarProducto($tabla, $datos){
		if($datos["fecha_vencimiento"]==null)
		{
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, codigo, descripcion, imagen, stock,product_id, hijo, precio_compra, precio_venta, tipo_producto, usuariocreacion, id_marca, id_unidad, stock_minimo_alerta, tipo_impuesto, tipo_control) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :product_id, :hijo, :precio_compra, :precio_venta, :tipo_producto, :usuariocreacion, :id_marca, :id_unidad, :stock_minimo_alerta, :tipo_impuesto, :tipo_control)");
			$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
			$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
			$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
			$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
			$stmt->bindParam(":product_id", $datos["product_id"], PDO::PARAM_STR);
			$stmt->bindParam(":hijo", $datos["hijo"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_producto", $datos["id_tipo_producto"], PDO::PARAM_STR);
			$stmt->bindParam(":usuariocreacion", $datos["usuario"], PDO::PARAM_STR);
			$stmt->bindParam(":id_marca", $datos["id_marca"], PDO::PARAM_STR);
			$stmt->bindParam(":id_unidad", $datos["id_unidad"], PDO::PARAM_STR);
			$stmt->bindParam(":stock_minimo_alerta", $datos["cantidad_alerta"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_impuesto", $datos["id_impuesto"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_control", $datos["stock_critico"], PDO::PARAM_STR);
		}
		else
		{
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, codigo, descripcion, imagen, stock,product_id, hijo, precio_compra, precio_venta, tipo_producto, usuariocreacion, id_marca, id_unidad, fecha_vencimiento, stock_minimo_alerta, tipo_impuesto, tipo_control) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :product_id, :hijo, :precio_compra, :precio_venta, :tipo_producto, :usuariocreacion, :id_marca, :id_unidad, :fecha_vencimiento, :stock_minimo_alerta, :tipo_impuesto, :tipo_control)");
			$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
			$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
			$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
			$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
			$stmt->bindParam(":product_id", $datos["product_id"], PDO::PARAM_STR);
			$stmt->bindParam(":hijo", $datos["hijo"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
			$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_producto", $datos["id_tipo_producto"], PDO::PARAM_STR);
			$stmt->bindParam(":usuariocreacion", $datos["usuario"], PDO::PARAM_STR);
			$stmt->bindParam(":id_marca", $datos["id_marca"], PDO::PARAM_STR);
			$stmt->bindParam(":id_unidad", $datos["id_unidad"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
			$stmt->bindParam(":stock_minimo_alerta", $datos["cantidad_alerta"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_impuesto", $datos["id_impuesto"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_control", $datos["stock_critico"], PDO::PARAM_STR);
		}
		
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, descripcion = :descripcion, imagen = :imagen, precio_compra = :precio_compra, precio_venta = :precio_venta, fechamodificacion=NOW(), tipo_producto= :tipo_producto, usuariomodificacion= :usuario, id_marca = :id_marca, id_unidad = :id_unidad , fecha_vencimiento = :fecha_vencimiento , stock_minimo_alerta = :stock_minimo_alerta , tipo_impuesto = :tipo_impuesto , tipo_control = :tipo_control  WHERE id = :id");
		$stmt->bindParam(":id_categoria", $datos["id_categoria"]);
		$stmt->bindParam(":id", $datos["id"]);
		$stmt->bindParam(":descripcion", $datos["descripcion"]);
		$stmt->bindParam(":imagen", $datos["imagen"]);
//		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"]);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"]);
		$stmt->bindParam(":tipo_producto", $datos["id_tipo_producto"]);
		$stmt->bindParam(":usuario", $datos["usuario"]);
		$stmt->bindParam(":id_marca", $datos["id_marca"]);
		$stmt->bindParam(":id_unidad", $datos["id_unidad"]);
		$stmt->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"]);
		$stmt->bindParam(":stock_minimo_alerta", $datos["cantidad_alerta"]);
		$stmt->bindParam(":tipo_impuesto", $datos["id_impuesto"]);
		$stmt->bindParam(":tipo_control", $datos["stock_critico"]);

		if($stmt->execute()){

			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function mdlEliminarProducto($tabla, $datos){
		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla set estado=0 WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlEliminarProductoHijo($tabla, $datos){
        //$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla set estado=2 WHERE id = :id");
        $stmt -> bindParam(":id", $datos, PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt -> close();
        $stmt = null;
    }

	/*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/
	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

        //Si tiene Padre
        $producto = self::productoPadre($valor);

        if($producto['product_id'] == '') {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
            $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
            $stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
            if($stmt -> execute()){
                return "ok";
            }else{
                return "error";
            }
            $stmt -> close();
            $stmt = null;
        } else {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
            $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
            $stmt -> bindParam(":id", $producto['product_id'], PDO::PARAM_STR);
            if($stmt -> execute()){
                return "ok";
            }else{
                return "error";
            }
            $stmt -> close();
            $stmt = null;
        }
	}

	static public function mdlActualizarProductoDepositoVenta($producto, $deposito , $cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE stock_producto SET stock = stock - " . $cantidad . " WHERE id_producto=" . $producto . " and id_deposito=" . $deposito . "");
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt -> close();
		$stmt = null;
	}

    static public function productoPadre($productoHijo){
        $item = "id";
        $valor = $productoHijo;
        $producto = ControladorProductos::ctrMostrarProductos($item, $valor);
        return $producto;
    }

    static public function mdlActualizarProductoPrecio($tabla, $item1, $valor1, $valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt -> close();
        $stmt = null;
    }

	static public function mdlInsertarProductoStock($idDeposito, $idProducto, $cantidad){
		$stmt = Conexion::conectar()->prepare("insert into stock_producto(id_producto,id_deposito,stock) values (".$idProducto.",". $idDeposito .",". $cantidad .")");
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlActualizarProductoStock($idDeposito, $idProducto, $cantidad){
		$stmt = Conexion::conectar()->prepare("update stock_producto set stock = stock +". $cantidad ." where id_producto=".$idProducto . " and id_deposito=". $idDeposito);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/	
	static public function mdlMostrarSumaVentas($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}
	/*=============================================
	MOSTRAR PRODUCTOS Inventario
	=============================================*/
	static public function mdlMostrarProductosi($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
}
