<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class ControladorTransferencias{


	/*=============================================
	CREAR TRANSFERENCIA
	=============================================*/
	static public function ctrCrearTransferencia(){
		
		if(isset($_POST["nuevaTransferencia"])){
			$tabla = "transferencia";
			$datos = array("id_usuario_transferencia"=>$_POST["idUsuario"],
							"id_deposito_destino"=>$_POST["seleccionarDepositoDestino"],
							"id_deposito_origen"=>$_POST["cmbdepositoTransferenciaOrigen"],
							"productos"=>$_POST["listaProductosTransferencia"]);
			$respuesta = ModeloTransferencias::mdlIngresarTransferencia($tabla, $datos);
			/*************************************************** */
			/*Se obtiene ultimo Id de la transferencia*/ 
			$usuario = $_SESSION["id"];
			$codigo= ModeloTransferencias::obtenerUltimaTransferencia();
			$codigoTransferencia = $codigo[0][0];

			$listaProductos = json_decode($_POST["listaProductosTransferencia"], true);
			$totalProductosTransferencia = array();
			foreach ($listaProductos as $key => $value) {
				array_push($totalProductosTransferencia, $value["cantidad"]);
				$tablaProductos = "productos";
				$item = "id";
				$valor = $value["id"];
				$orden = "id";
				$item1b = "stock";
				$valor1b = $value["stock"];
				$idDeposito = $value["iddeposito"];

				/*Se inserta detalle de transferencias */
				$tabla = "detalle_transferencia";
				$datos = array("id_transferencia"=>$codigoTransferencia,
							"id_producto"=>$value["id"],
							"cantidad"=>$value["cantidad"],
							"id_usuario_transferencia"=>$usuario,
							"id_deposito_origen"=>$value["iddeposito"]);
				$respuesta2 = ModeloTransferencias::mdlIngresarDetalleTransferencia($tabla, $datos);
			}

			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
						type: "success",
						title: "La transferencia ha sido guardada correctamente. Se encuentra en proceso",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
								if (result.value) {
								window.location = "transferencias";
								}
							})
				</script>';
			}
		}
	}

	/*Listado de Transferencias*/	
	static public function ctrListarTransferencias($fechaInicial, $fechaFinal){
		$respuesta = ModeloTransferencias::mdlListarTransferencias($fechaInicial, $fechaFinal);
		return $respuesta;
	}


	static public function ctrMostrarCabeceraTransferencia($idTransferencia){
		$respuesta = ModeloTransferencias::mdlMostrarCabeceraTransferencia($idTransferencia);
		return $respuesta;
	}


	static public function ctrAprobarTransferencia(){
		
		if(isset($_POST["codigoTransferencia"])){
			$tabla = "transferencia";
			$datos = array("codigoTransferencia"=>$_POST["codigoTransferencia"]);
			$respuesta = ModeloTransferencias::mdlAprobarTransferencia($tabla, $datos, $_SESSION["id"]);

			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
						type: "success",
						title: "Se realizó la aprobación de la transferencia con éxito.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
								if (result.value) {
								window.location = "transferencias";
								}
							})
				</script>';
			}
		}
		
	}

	static public function ctrRecepcionarTransferencia(){
		
		if(isset($_POST["codigoTransferencia"])){
			$tabla = "transferencia";
			$datos = array("codigoTransferencia"=>$_POST["codigoTransferencia"]);
			
			$valor = $_POST["codigoTransferencia"];
			$traerTransferencia = ModeloTransferencias::mdlMostrarTransferencia($valor);
			$depositoDestino = $traerTransferencia["id_deposito_destino"];
			$hayStock=0;
			/* Se verifica que aún exista stock para transferencia en el depósito origen */
			$productos =  json_decode($traerTransferencia["productos"], true);
			foreach ($productos as $key => $value) {
				$idProducto = $value["id"];
				$cantidad = $value["cantidad"];
				$depositoOrigen = $value["iddeposito"];
				$traerProducto = ModeloProductos::mdlProductoDeposito($depositoOrigen, $idProducto);

				if($hayStock==0)
				{
					if($traerProducto["stock"]<$cantidad)
					{
						/* Quiere decir que no hay stock disponible para ese producto, por lo tanto la transferencia no se podría realizar */
						$hayStock=1;
					}
				}
			}

			/* Si se podría realizar la transferencia */
			if($hayStock==0)
			{

				foreach ($productos as $key => $value) {
					$idProducto = $value["id"];
					$cantidad = $value["cantidad"];
					$depositoOrigen = $value["iddeposito"];
					$traerProducto = ModeloProductos::mdlProductoDeposito($depositoOrigen, $idProducto);
					
					/* Se realiza la actualización de la salida de stock del depósito origen */
					ModeloProductos::mdlActualizarProductoDepositoVenta($idProducto, $depositoOrigen, $cantidad);

					/* Se realiza el ingreso del stock en el almacén destino */
					$existe = ModeloCompras::verificarExisteProductoDeposito($depositoDestino,$idProducto);
					$cantidadExiste = $existe[0][0];
					if($cantidadExiste=="0")
					{
						ModeloProductos::mdlInsertarProductoStock($depositoDestino,$idProducto,$cantidad);
					}
					else
					{
						ModeloProductos::mdlActualizarProductoStock($depositoDestino,$idProducto,$cantidad);
					}

				}
				/* Se actualiza la cabecera de la Transferencia */
				$respuesta = ModeloTransferencias::mdlRecepcionarTransferencia($tabla, $datos, $_SESSION["id"]);
				if($respuesta == "ok"){
					echo'<script>
					localStorage.removeItem("rango");
					swal({
							type: "success",
							title: "Se realizó la recepción de la transferencia con éxito.",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
									if (result.value) {
									window.location = "transferencias";
									}
								})
					</script>';
				}
			}
			else
			{
				echo'<script>
				localStorage.removeItem("rango");
				swal({
						type: "error",
						title: "Algunos productos no tienen stock suficiente en el depósito origen para realizar la transferencia.",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
								if (result.value) {
								window.location = "transferencias";
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
	ELIMINAR VENTA
	=============================================*/
	static public function ctrEliminarVenta(){
		if(isset($_GET["idVenta"])){
			$tabla = "ventas";
			$item = "id";
			$valor = $_GET["idVenta"];
			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/
			$tablaClientes = "clientes";
			$itemVentas = null;
			$valorVentas = null;
			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);
			$guardarFechas = array();
			foreach ($traerVentas as $key => $value) {
				if($value["id_cliente"] == $traerVenta["id_cliente"]){
					array_push($guardarFechas, $value["fecha"]);
				}
			}
			if(count($guardarFechas) > 1){
				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){
					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerVenta["id_cliente"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
				}else{
					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerVenta["id_cliente"];
					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
				}
			}else{
				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerVenta["id_cliente"];
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);
			}
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$productos =  json_decode($traerVenta["productos"], true);
			$totalProductosComprados = array();
			foreach ($productos as $key => $value) {
				array_push($totalProductosComprados, $value["cantidad"]);
				$tablaProductos = "productos";
				$item = "id";
				$valor = $value["id"];
				$orden = "id";
				$traerProducto = ModeloProductos::mdlMostrarProductosVentas($tablaProductos, $item, $valor, $orden);

				if ($traerProducto['product_id'] == '') {
                    $valorP = $value["id"];
                    $valor1b = $value["cantidad"] + $traerProducto["stock"];
                } else {
                    $valorP = $traerProducto["product_id"];
                    $productoPadre = ModeloProductos::mdlMostrarProductosVentas($tablaProductos, $item, $valorP, $orden);
                    $valor1b = $value["cantidad"] + $productoPadre["stock"];
                }
				$item1a = "ventas";
				//$valor1a = $traerProducto["ventas"] - $value["cantidad"];
				//$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
				$item1b = "stock";

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valorP);
			}
//			$tablaClientes = "clientes";
//			$itemCliente = "id";
//			$valorCliente = $traerVenta["id_cliente"];
//			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
//			$item1a = "compras";
//			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
//			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
			/*=============================================
			ELIMINAR VENTA
			=============================================*/
			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La venta ha sido borrada correctamente",
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
          //  error_reporting(0);
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
				<!--	<td style='font-weight:bold; border:1px solid #eee;'>APERTURA CAJA</td>		-->
					</tr>");
			$total_ventas= 0;
            $total_caja= 0;
			foreach ($ventas as $row => $item){
				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> ");
             if(is_array($cliente)){
                 echo utf8_decode("<td style='border:1px solid #eee;'>".  $cliente["nombre"] ."</td>");
             } else {
                 echo utf8_decode("<td style='border:1px solid #eee;'></td>");
             }

                if(is_array($vendedor)){
                    echo utf8_decode("<td style='border:1px solid #eee;'>".  $vendedor["nombre"] ."</td>");
                } else {
                    echo utf8_decode("<td style='border:1px solid #eee;'></td>");
                }


			 			echo utf8_decode("
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
		 			</tr>");
		 		$total_ventas=$total_ventas+$item["total"];

//		 		if($item['monto_caja']==$item['monto_caja']){
//		 			$total_caja=$total_caja+$item['monto_caja'];
//		 		}
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
		$verificado = ModeloVentas::consultaCajaAbierta($usuario);

		return $verificado;
	}

	public function obtenerCajaAbiertaUsuario(){
		$usuario = $_SESSION["id"];
		return  ModeloVentas::obtenerCajaAbiertaUsuario($usuario);
	}

	public function crtCerrarCaja(){
		if(isset($_POST['cierre']) && $_POST['cierre']==1){

			/* Se obtiene los datos de la caja aún aperturada */ 
			$usuarioApertura = $_SESSION["id"];
			$respuestaCaja = ModeloAperturas::mdlMostrarAperturaActivaUsuario($usuarioApertura);
			foreach ($respuestaCaja as $key => $value) {
				$nombreSucursal = $value["sucursal"];
				$nombreCaja = $value["cajas"];
				$nombreUsuarioApertura =  $value["usuario"];
				$fechaApertura = $value["fechaapertura"];
				$montoApertura = $value["monto_apertura"];
			}
			/* Se cierra la caja */
			$caja= ModeloVentas::cerrarCaja($_POST['valor_cierre'], $_POST['caja_id']);
			if($caja=='ok'){

				$formaPagos = ModeloVentas::listadoVentasFormaPagoCajaAperturada($_POST['caja_id']);
				$seccionFormaPago = "";
				$totalVenta = $montoApertura;
				foreach ($formaPagos as $key3 => $value3) {
					$seccionFormaPago = $seccionFormaPago . '<tr>
											<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
												Pago ' . $value3["nombre"] . '
											</td>
											<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
												' . $value3["total"] . '
											</td>
										</tr>';
					$totalVenta = $totalVenta + $value3["total"];
				}

				$listadoProductos = ModeloVentas::listadoTotalProductosCajaAperturada($_POST['caja_id']);
				$seccionProductos = "";
				foreach ($listadoProductos as $key4 => $value4) {
					$seccionProductos = $seccionProductos . '<tr>
															<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">' . $value4["descripcion"] . '</td>
															<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">' . $value4["total"] . '</td>
														</tr>';
				}

				$notificaciones = ModeloAperturas::mdlMostrarUsuariosNotificacion();
				foreach ($notificaciones as $key2 => $value2) {
					
					$mail = new PHPMailer();
					$mail->isSMTP();
					$mail->SMTPAuth = true;
					// Login
					$mail->Host = "smtp.gmail.com";
					$mail->Port = "465";
					$mail->Username = "enviocorreoworkana@gmail.com";
					$mail->Password = "ftydwxdbycayzpbt";
					$mail->setFrom('enviocorreoworkana@gmail.com', 'Sistema Facturación');

					$mail->addAddress($value2["email"], $value2["nombre"]);
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
					
					date_default_timezone_set('America/Asuncion');
					$fecha_actual = date("d-m-Y h:i:s A");

					$mail->CharSet = 'UTF-8';
					$mail->Encoding = 'base64';
					$mail->isHTML(true);
					$mail->Subject = 'Cierre de Caja';

					

					$body='<center>
					<td width="100%" height="100" align="center">
										
						<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
							<tbody>
								<tr>
									<td width="100%" height="50"></td>
								</tr>
							</tbody>
						</table>
					
						<table border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
							<tbody>
								<tr>
									<td width="100%" style="height:auto">
										<a href="#m_3032233882618744908_m_4466486075483208078_" style="text-decoration:none"><img src="https://ci4.googleusercontent.com/proxy/pCJryLl6Ekyzi250cEoRTjFR-8Vg6I4OfKJt2FUh2W5nCLkzF-iOtvuyBufUKNyjzvUK=s0-d-e1-ft#http://appignis.com/img/logo.png" alt="" border="0" class="CToWUd" data-bit="iit"></a>
									</td>
								</tr>
							</tbody>
						</table>
						
						<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
							<tbody>
								<tr>
									<td width="100%" height="50"></td>
								</tr>
							</tbody>
						</table>
						
						<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" style="border-radius:6px">
							<tbody>
								<tr>
									<td width="100%" style="border-radius:6px" bgcolor="#ffffff">
										<div>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border-top-right-radius:6px;border-top-left-radius:6px" id="m_3032233882618744908m_4466486075483208078not1ChangeBG" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="50"></td>
																	</tr>
																	<tr>
																		<td width="100%" height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																	<tr>
																		<td width="100%" style="width:329px;height:auto">
																			<img src="https://ci5.googleusercontent.com/proxy/0dEf3h65rfdfp0Hj5lfEbH7YIOEN-VuD2n0vGNmbLkPEpD7lcgLMruhDrZCwuU7d57LwyGZD1Je4lgw=s0-d-e1-ft#http://appignis.com/img/illustration.png" alt="illustration" border="0" class="CToWUd" data-bit="iit">
																		</td>
																	</tr>
																	<tr>
																		<td width="100%" height="50" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:center;font-family:Lato,Helvetica,Arial,sans-serif;font-size:20px;line-height:40px;font-weight:400;color:rgb(53,53,53)">
																			Hola <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $value2["nombre"] . '</span>, 
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="25" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:16px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Le notificamos que el usuario <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreUsuarioApertura .'</span>, siendo las <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $fecha_actual . '</span> realizo el cierre de la caja <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreCaja . '</span> del módulo ventas de la sucursal <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreSucursal . '</span> a continuación el detalle del cierre.
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="15" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="1" cellpadding="5" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Apertura
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			' . $fechaApertura . '
																		</td>
																	</tr>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Cierre
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			' . $fecha_actual .'
																		</td>
																	</tr>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Efectivo de apertura
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			' . $montoApertura . '
																		</td>
																	</tr>' . $seccionFormaPago .'
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Total Pagos
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			' . $totalVenta . '
																		</td>
																	</tr>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Gastos
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			0
																		</td>
																	</tr>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Total del Cierre
																		</td>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(214,54,27)">
																			' . $totalVenta . '
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<br>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="1" cellpadding="5" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<thead>
																	<tr>
																		<th valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Producto
																		</th>
																		<th valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:12px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																			Cantidad
																		</th>
																	</tr>
																</thead>
																<tbody>' . $seccionProductos . '
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="15" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:16px;line-height:24px;font-weight:400;color:rgb(0,212,255)">
																			<a href="#m_3032233882618744908_m_4466486075483208078_" style="text-decoration:none;font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(134,133,133)">Saludos.</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="30" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>	
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small" style="border-bottom-right-radius:6px;border-bottom-left-radius:6px">
							<tbody>
								<tr>
									<td width="100%" valign="middle" align="center">
										<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
											<tbody>
												<tr>
													<td width="100%" height="50" style="font-size:1px;line-height:1px">&nbsp;</td>
												</tr>
											</tbody>
										</table>							
									</td>
								</tr>
							</tbody>
						</table>
					</td>
					</center>';

					$mail->Body = $body;
					//$mail->AltBody = 'El texto como elemento de texto simple';
					$mail->send();
				}

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