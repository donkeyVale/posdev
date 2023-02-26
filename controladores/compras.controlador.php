<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorCompras{

	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/
	static public function ctrMostrarCompras($item, $valor){
		$tabla = "compras";
		$respuesta = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrMostrarCabeceraCompras($idCompra){
		$respuesta = ModeloCompras::mdlMostrarCabeceraCompras($idCompra);
		return $respuesta;
	}

	/*=============================================
	CREAR COMPRA
	=============================================*/
	static public function ctrCrearCompra(){
		
		if(isset($_POST["nuevaCompra"])){
			
			/*=============================================
			ACTUALIZAR LAS COMPRAS
			=============================================*/
			if($_POST["listaProductos"] == ""){
					echo'<script>
				swal({
					  type: "error",
					  title: "La compra no se puede ejecutar porque no hay productos a ingresar",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "crear-compra";
								}
							})
				</script>';
				return;
			}
			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/				
			$tabla = "compras";
			//$fechaCompra = substr($_POST["fechaCompra"],6,4).'-'.substr($_POST["fechaCompra"],1,2).'-'.substr($_POST["fechaCompra"],3,2);
			$datos = array("id_proveedor"=>$_POST["seleccionarProveedor"],
						   "codigo"=>$_POST["nuevaCompra"],
						   "productos"=>$_POST["listaProductos"],
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "referencia"=>$_POST["referencia"],
						   "nroFactura"=>$_POST["nroFactura"],
						   "fechacompra"=>$_POST["fechaCompra"],
						   "id_deposito"=>$_POST["cmbdeposito"],
						   "id_tipo_compra"=>$_POST["cmbTipoCompra"],
						   "usuarioCreacion"=>$_SESSION["id"],
						   "estado_compra"=>"1");
			$respuesta = ModeloCompras::mdlIngresarCompra($tabla, $datos);
			/*************************************************** */
			/*Se obtiene ultimo Id de Compra*/ 
			$codigo= ModeloCompras::obtenerUltimaCompra();
			$codigoCompra = $codigo[0][0];

			$listaProductos = json_decode($_POST["listaProductos"], true);
			$totalProductosComprados = array();
			foreach ($listaProductos as $key => $value) {
			   	array_push($totalProductosComprados, $value["cantidad"]);

				$existe = ModeloCompras::verificarExisteProductoDeposito($_POST["cmbdeposito"],$value["id"]);
				$cantidadExiste = $existe[0][0];
				if($cantidadExiste=="0")
				{
					ModeloProductos::mdlInsertarProductoStock($_POST["cmbdeposito"],$value["id"],$value["cantidad"]);
				}
				else
				{
					ModeloProductos::mdlActualizarProductoStock($_POST["cmbdeposito"],$value["id"],$value["cantidad"]);
				}

				/*Se inserta detalle de ventas */
				$tabla = "detalle_compras";
				$datos = array("id_compra"=>$codigoCompra,
							"id_producto"=>$value["id"],
							"cantidad"=>$value["cantidad"],
							"precio_unitario"=>$value["precio"],
							"total"=>$value["total"]);
				$respuesta2 = ModeloCompras::mdlIngresarDetalleCompra($tabla, $datos);
			}
			/*$tablaClientes = "clientes";
			$item = "id";
			$valor = $_POST["seleccionarCliente"];
			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
			$item1a = "compras";
			$valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];
			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);
			$item1b = "ultima_compra";
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;
			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);
			*/
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La compra ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "compras";
								}
							})
				</script>';
			}
		}
	}
	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarVenta(){
		if(isset($_POST["editarVenta"])){
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";
			$item = "codigo";
			$valor = $_POST["editarVenta"];
			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if($_POST["listaProductos"] == ""){
				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;
			}else{
				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}
			if($cambioProducto){
				$productos =  json_decode($traerVenta["productos"], true);
				$totalProductosComprados = array();
				foreach ($productos as $key => $value) {
					array_push($totalProductosComprados, $value["cantidad"]);
					$tablaProductos = "productos";
					$item = "id";
					$valor = $value["id"];
					$orden = "id";
					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];
					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerProducto["stock"];
					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
				}
				$tablaClientes = "clientes";
				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];
				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);		
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/
				$listaProductos_2 = json_decode($listaProductos, true);
				$totalProductosComprados_2 = array();
				foreach ($listaProductos_2 as $key => $value) {
					array_push($totalProductosComprados_2, $value["cantidad"]);
					$tablaProductos_2 = "productos";
					$item_2 = "id";
					$valor_2 = $value["id"];
					$orden = "id";
					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);
					$item1a_2 = "ventas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];
					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
					$item1b_2 = "stock";
					$valor1b_2 = $value["stock"];
					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
				}
				$tablaClientes_2 = "clientes";
				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];
				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);
				$item1a_2 = "compras";
				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];
				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);
				$item1b_2 = "ultima_compra";
				date_default_timezone_set('America/Bogota');
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;
				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);
			}
			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	
			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$listaProductos,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);
			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
								window.location = "ventas";
								}
							})
				</script>';
			}
		}
	}
	/*=============================================
	ELIMINAR COMPRA
	=============================================*/
	static public function ctrEliminarCompra(){
		if(isset($_GET["idCompra"])){
			$tabla = "compras";
			$item = "id";
			$valor = $_GET["idCompra"];
			$traerVenta = ModeloCompras::mdlMostrarCabeceraCompras($valor);
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$productos =  json_decode($traerVenta["productos"], true);
			$totalProductosComprados = array();
			foreach ($productos as $key => $value) {
				$valor = (-1)*$value["cantidad"];
				ModeloProductos::mdlActualizarProductoStock($traerVenta["id_deposito"],$value["id"],$valor);
			}
			/*=============================================
			ELIMINAR COMPRA
			=============================================*/
			$respuesta = ModeloCompras::mdlEliminarCompra($tabla, $_GET["idCompra"]);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La compra ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "compras";
								}
							})
				</script>';
			}		
		}
	}

	/*Listado de Compras */	
	static public function ctrListarCompras($fechaInicial, $fechaFinal){
		$respuesta = ModeloCompras::mdlListarCompras($fechaInicial, $fechaFinal);
		return $respuesta;
	}

	static public function ctrListarDepositos(){
		$respuesta = ModeloCompras::mdlListarDepositos();
		return $respuesta;
	}

	static public function ctrListarTipoCompras(){
		$respuesta = ModeloCompras::mdlListarTipoCompras();
		return $respuesta;
	}

	static public function ctrMostrarProveedores($item, $valor){
		$tabla = "proveedores";
		$respuesta = ModeloCompras::mdlMostrarProveedores($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	
	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){
		$tabla = "ventas";
		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/
	public function ctrDescargarReporte(){
		if(isset($_GET["reporte"])){
			$tabla = "ventas";
			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){
				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			}else{
				$item = null;
				$valor = null;
				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			}
			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$Name = $_GET["reporte"].'.xls';
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'> 
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>APERTURA CAJA</td>		
					</tr>");
			$total_ventas='';
			foreach ($ventas as $row => $item){
				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");
			 	$productos =  json_decode($item["productos"], true);
			 	foreach ($productos as $key => $valueProductos) {
			 		echo utf8_decode($valueProductos["cantidad"]."<br>");
			 	}
			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	
		 		foreach ($productos as $key => $valueProductos) {
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		}
		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>Gs ".number_format($item["impuesto"],0)."</td>
					<td style='border:1px solid #eee;'>Gs ".number_format($item["neto"],0)."</td>	
					<td style='border:1px solid #eee;'>Gs ".number_format($item["total"],0)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>	
					<td style='border:1px solid #eee;'>Gs ".number_format($item["monto_caja"],0)."</td>		
		 			</tr>");
		 		$total_ventas=$total_ventas+$item["total"];
		 		$total_caja='';
		 		if($item['monto_caja']==$item['monto_caja']){
		 			$total_caja=$total_caja+$item['monto_caja'];
		 		}
			}
			echo utf8_decode("<tr><td colspan='7' align='right'><strong>Total de Ventas</strong></td><td><strong>Gs ".number_format($total_ventas,0)."</strong></td><!--<td colspan='2' align='right'><strong>Total Apertura de Cajas</strong></td><td><strong>Gs ".number_format($total_caja,0)."</strong></td></tr>-->");
			echo "</table>";
		}
	}

	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/
	public function ctrSumaTotalVentas(){
		$tabla = "ventas";
		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);
		return $respuesta;
	}
	/*=============================================
	DESCARGAR XML
	=============================================*/
	static public function ctrDescargarXML(){
		if(isset($_GET["xml"])){
			$tabla = "ventas";
			$item = "codigo";
			$valor = $_GET["xml"];
			$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			// PRODUCTOS
			$listaProductos = json_decode($ventas["productos"], true);
			// CLIENTE
			$tablaClientes = "clientes";
			$item = "id";
			$valor = $ventas["id_cliente"];
			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
			// VENDEDOR
			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $ventas["id_vendedor"];
			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
			//http://php.net/manual/es/book.xmlwriter.php
			$objetoXML = new XMLWriter();
			$objetoXML->openURI($_GET["xml"].".xml"); //Creación del archivo XML
			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.
			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación
			$objetoXML->startDocument('1.0', 'utf-8');// Inicio del documento
			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz
			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal
			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo
			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna
			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo
			// 	$objetoXML->endElement(); // Final del nodo hijo
			// $objetoXML->endElement(); // Final del nodo raíz
			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');
			$objetoXML->writeRaw('<ext:UBLExtensions>');
			foreach ($listaProductos as $key => $value) {
				$objetoXML->text($value["descripcion"].", ");
			}
			$objetoXML->writeRaw('</ext:UBLExtensions>');
			$objetoXML->writeRaw('</fe:Invoice>');
			$objetoXML->endDocument(); // Final del documento
			return true;	
		}
	}

	public function crtGuardarCaja(){
		if($_POST['monto_caja']){
			$caja=ModeloVentas::crtGuardarCaja($_POST['caja'],$_POST['sucursal'],$_POST['monto_caja']);
			if($caja=='ok'){
				echo'<script>
					localStorage.removeItem("rango");
					swal({
						  type: "success",
						  title: "La apertura de caja se ha realizado satisfactoriamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "apertura-cajas";
									}
								})
					</script>';
			}
		}
	}

	public function consultaCajaAbierta(){
		$usuario = $_SESSION["id"];
		//Verificamos si el usuario que desea registrar una venta, cuenta con una caja abierta
		$verificado= ModeloVentas::consultaCajaAbierta($usuario);
		$existe = $verificado[0][0];
		return $existe;
	}

	public function obtenerCajaAbiertaUsuario(){
		$usuario = $_SESSION["id"];
		$codigoCaja= ModeloVentas::obtenerCajaAbiertaUsuario($usuario);
		$caja = $codigoCaja[0][0];
		return $caja;
	}

	public function crtCerrarCaja(){
		if($_POST['cierre']==1){
			$caja= ModeloVentas::cerrarCaja();
			if($caja=='ok'){
					echo'<script>
						localStorage.removeItem("rango");
						swal({
							  type: "success",
							  title: "El cierre de caja se ha realizado",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "cierre-cajas";
										}
									})
						</script>';
			}
		}
	}

	public function totalVentasDias(){
		return ModeloVentas::totalVentasDias();
	}

	/*=============================================
	MOSTRAR CUOTAS
	=============================================*/
	static public function ctrMostrarCuotas(){
		$tabla = "general";
		$respuesta = ModeloVentas::mdlMostrarCuotas();
		return $respuesta;
	}

	static public function ctrMostrarFormasPago(){
		$tabla = "forma_pago";
		$respuesta = ModeloVentas::ctrMostrarFormasPago($tabla);
		return $respuesta;
	}

	static public function ctrEstablecerCuotas(){
		if(isset($_POST["nuevoCuota"])){
	 		$datos = array("cuotas" => $_POST["nuevoCuota"]);
			$tabla = "general";
			$respuesta = ModeloVentas::mdlEstablecerCuotas($datos);
			if($respuesta=='ok'){
				echo'<script>
					localStorage.removeItem("rango");
					swal({
						  type: "success",
						  title: "El número de cuota se ha guadado con exito",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "ventas";
									}
								})
					</script>';
			}
		}
	}

	static public function ctrControlVentas(){
		return ModeloVentas::ctrControlVentas();	
	}

	static public function actualizarPagoVentas(){
		if(isset($_POST["monto"])){
			if($_POST["monto"]<=$_POST['monto_deudor']){
				if($_POST['cuota']==1 && $_POST['monto']==$_POST['monto_deudor']){
					$respuesta = ModeloVentas::actualizarPagoVentas($_POST);	
					if($respuesta=='ok'){
							echo'<script>
								localStorage.removeItem("rango");
								swal({
									  type: "success",
									  title: "La actualización del pago se ha realizado exitosamente",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
												if (result.value) {
												window.location = "control-ventas";
												}
											})
								</script>';
					}
				}elseif($_POST['cuota']==1 && $_POST['monto']<=$_POST['monto_deudor']){
					echo'<script>
				swal({
					  type: "error",
					  title: "El monto ingresado es menor al monto por pagar y te queda una cuota por pagar",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "control-ventas";
								}
							})
				</script>';
				}else{
					$respuesta = ModeloVentas::actualizarPagoVentas($_POST);	
					if($respuesta=='ok'){
							echo'<script>
								localStorage.removeItem("rango");
								swal({
									  type: "success",
									  title: "La actualización del pago se ha realizado exitosamente",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
												if (result.value) {
												window.location = "control-ventas";
												}
											})
								</script>';
					}
				}
			}else{
				echo'<script>
				swal({
					  type: "error",
					  title: "El monto ingresado es mayor al monto por pagar",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "control-ventas";
								}
							})
				</script>';
			}
		}
	}
}
