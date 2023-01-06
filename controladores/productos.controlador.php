<?php

class ControladorProductos{

	static public function ctrListarProductos(){
		$respuesta = ModeloProductos::mdlListarProductos();
		return $respuesta;
	}

    static public function ctrListarProductosHijos(){
        $respuesta = ModeloProductos::mdlListarProductosHijos();
        return $respuesta;
    }

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function ctrMostrarProductos($item, $valor){
		$tabla = "productos";
		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
		return $respuesta;
	}

    static public function mdlMostrarProductosVentas($item, $valor){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarProductosVentas($tabla, $item, $valor);
        return $respuesta;
    }

	static public function ctrMostrarTipoProductos(){
		$respuesta = ModeloProductos::mdlMostrarTipoProductos();
		return $respuesta;
	}

	static public function ctrMostrarTipoImpuestos(){
		$respuesta = ModeloProductos::mdlMostrarTipoImpuestos();
		return $respuesta;
	}

	static public function ctrMostrarStockCritico(){
		$respuesta = ModeloProductos::mdlMostrarStockCritico();
		return $respuesta;
	}

	/*=============================================
	CREAR PRODUCTO
	=============================================*/
	static public function ctrCrearProducto(){
		if(isset($_POST["nuevaDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\.\-\_\, ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCodigo"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevaCantidadAlerta"]) &&	
			   preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["nuevoPrecioCompra"]) &&
			   preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["nuevoPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	$ruta = "vistas/img/productos/default/anonymous.png";
			   	if(isset($_FILES["nuevaImagen"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];
					mkdir($directorio, 0755);
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["nuevaImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				$datos = array("descripcion" => $_POST["nuevaDescripcion"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "id_categoria" => $_POST["nuevaCategoria"],
							   "id_marca" => $_POST["nuevaMarca"],
							   "id_unidad" => $_POST["nuevaUnidad"],
							   "precio_compra" => $_POST["nuevoPrecioCompra"],
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   "product_id" => isset($_POST["product_id"]) ? $_POST["product_id"] : null,
							   "hijo" => isset($_POST["product_id"]) ? 1 : 0,
							   "stock" => 0,
							   "fecha_vencimiento" => $_POST["nuevaFechaVencimiento"],
							   "id_tipo_producto" => $_POST["nuevoTipoProducto"],
							   "id_impuesto" => $_POST["nuevoImpuesto"],
							   "cantidad_alerta" => $_POST["nuevaCantidadAlerta"],
							   "stock_critico" => $_POST["nuevoStockCritico"],
							   "usuario" => $_SESSION["usuario"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "productos";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productos";
							}
						})
			  	</script>';
			}
		}
	}


    /**
     *
     */
    static public function ctrCrearProductosHijos(){
        if(isset($_POST["nuevaDescripcion"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\.\-\_\, ]+$/', $_POST["nuevaDescripcion"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCodigo"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevaCantidadAlerta"]) &&
                preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["nuevoPrecioCompra"]) &&
                preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["nuevoPrecioVenta"])){
                /*=============================================
             VALIDAR IMAGEN
             =============================================*/
                $ruta = "vistas/img/productos/default/anonymous.png";
                if(isset($_FILES["nuevaImagen"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/
                    $directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];
                    mkdir($directorio, 0755);
                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/
                    if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["nuevaImagen"]["type"] == "image/png"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "productos";
                $datos = array("descripcion" => $_POST["nuevaDescripcion"],
                    "codigo" => $_POST["nuevoCodigo"],
                    "id_categoria" => $_POST["nuevaCategoria"],
                    "id_marca" => $_POST["nuevaMarca"],
                    "id_unidad" => $_POST["nuevaUnidad"],
                    "precio_compra" => $_POST["nuevoPrecioCompra"],
                    "precio_venta" => $_POST["nuevoPrecioVenta"],
                    "product_id" => isset($_POST["product_id"]) ? $_POST["product_id"] : null,
                    "hijo" => isset($_POST["product_id"]) ? 1 : 0,
                    "stock" => 0,
                    "fecha_vencimiento" => $_POST["nuevaFechaVencimiento"],
                    "id_tipo_producto" => $_POST["nuevoTipoProducto"],
                    "id_impuesto" => $_POST["nuevoImpuesto"],
                    "cantidad_alerta" => $_POST["nuevaCantidadAlerta"],
                    "stock_critico" => $_POST["nuevoStockCritico"],
                    "usuario" => $_SESSION["usuario"],
                    "imagen" => $ruta);
                $respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
                if($respuesta == "ok"){
                    echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										    window.location = "index.php?ruta=crear-producto&idProductoPadre='. $_POST["product_id"].'";
										}
									})
						</script>';
                }
            }else{
                echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "index.php?ruta=crear-producto&idProductoPadre='. $_POST["product_id"].'";
							}
						})
			  	</script>';
            }
        }
    }
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function ctrEditarProducto(){
		if(isset($_POST["editarDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\.\-\_\, ]+$/', $_POST["editarDescripcion"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarCantidadAlerta"]) &&	
				preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["editarPrecioCompra"]) &&
				preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["editarPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	$ruta = $_POST["imagenActual"];
			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$directorio = "vistas/img/productos/".$_POST["editarCodigo"];
					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
						unlink($_POST["imagenActual"]);
					}else{
						mkdir($directorio, 0755);	
					}
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["editarImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["editarImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				$datos = array("descripcion" => $_POST["editarDescripcion"],
							   "id" => $_POST["idProducto"],
							   "id_categoria" => $_POST["editarCategoria"],
							   "id_marca" => $_POST["editarMarca"],
							   "id_unidad" => $_POST["editarUnidad"],
							   "precio_compra" => $_POST["editarPrecioCompra"],
							   "precio_venta" => $_POST["editarPrecioVenta"],
							   "fecha_vencimiento" => $_POST["editarFechaVencimiento"],
							   "id_tipo_producto" => $_POST["editarTipoProducto"],
							   "id_impuesto" => $_POST["editarImpuesto"],
							   "cantidad_alerta" => $_POST["editarCantidadAlerta"],
							   "stock_critico" => $_POST["editarStockCritico"],
							   "usuario" => $_SESSION["usuario"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "productos";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productos";
							}
						})
			  	</script>';
			}
		}
	}


    static public function ctrEditarProductoHijo(){
        if(isset($_POST["editarDescripcion"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\.\-\_\, ]+$/', $_POST["editarDescripcion"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarCantidadAlerta"]) &&
                preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["editarPrecioCompra"]) &&
                preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["editarPrecioVenta"])){
                /*=============================================
             VALIDAR IMAGEN
             =============================================*/
                $ruta = $_POST["imagenActual"];
                if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/
                    $directorio = "vistas/img/productos/".$_POST["editarCodigo"];
                    /*=============================================
                    PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                    =============================================*/
                    if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
                        unlink($_POST["imagenActual"]);
                    }else{
                        mkdir($directorio, 0755);
                    }
                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/
                    if($_FILES["editarImagen"]["type"] == "image/jpeg"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["editarImagen"]["type"] == "image/png"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "productos";
                $datos = array("descripcion" => $_POST["editarDescripcion"],
                    "id" => $_POST["idProducto"],
                    "id_categoria" => $_POST["editarCategoria"],
                    "id_marca" => $_POST["editarMarca"],
                    "id_unidad" => $_POST["editarUnidad"],
                    "precio_compra" => $_POST["editarPrecioCompra"],
                    "precio_venta" => $_POST["editarPrecioVenta"],
                    "fecha_vencimiento" => $_POST["editarFechaVencimiento"],
                    "id_tipo_producto" => $_POST["editarTipoProducto"],
                    "id_impuesto" => $_POST["editarImpuesto"],
                    "cantidad_alerta" => $_POST["editarCantidadAlerta"],
                    "stock_critico" => $_POST["editarStockCritico"],
                    "usuario" => $_SESSION["usuario"],
                    "imagen" => $ruta);
                $respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
                if($respuesta == "ok"){
                    echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "index.php?ruta=crear-producto&idProductoPadre='. $_POST["product_id"].'";
										}
									})
						</script>';
                }
            }else{
                echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "index.php?ruta=crear-producto&idProductoPadre='. $_POST["product_id"].'";
							}
						})
			  	</script>';
            }
        }
    }
	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){

		if(isset($_GET["idProducto"])){
			$tabla ="productos";
			$datos = $_GET["idProducto"];
			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "productos";
								}
							})
				</script>';
			}		
		}
	}

    static public function ctrEliminarProductoHijo(){

        if(isset($_GET["idProducto"])){
            $tabla ="productos";
            $datos = $_GET["idProducto"];
            $ProductoPadreId= $_GET["idProductoPadre"];
            $respuesta = ModeloProductos::mdlEliminarProductoHijo($tabla, $datos);
            if($respuesta == "ok"){
                echo'<script>
				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								    window.location = "index.php?ruta=crear-producto&idProductoPadre='. $ProductoPadreId.'";
								}
							})
				</script>';
            }
        }
    }
	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/
	static public function ctrMostrarSumaVentas(){
		$tabla = "ventas";
		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);
		return $respuesta;
	}
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/
	public function ctrDescargarReporte(){
	$tabla = "productos";
	$productos = ModeloProductos::mdlMostrarProductosi($tabla);
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$Name = "reporte".'.xls';
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='1'> 
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CATEGORIA</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CODIGO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DESCRIPCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>STOCK</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO COMPRA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRECIO VENTA</td>
					</tr>");
			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["id_categoria"]."<br>");
		 		}
			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["codigo"]."<br>");
		 		}
				echo utf8_decode("</td><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		}
				echo utf8_decode("</td ><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["stock"]."<br>");
		 		}
		 		echo utf8_decode("</td ><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["precio_compra"]."<br>");
		 		}
		 		echo utf8_decode("</td ><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["precio_venta"]."<br>");
		 		}
			echo "</table>";
	}
}