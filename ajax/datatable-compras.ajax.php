<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductosCompras{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosCompras(){
		$item = null;
    	$valor = null;
    	$orden = "id";
  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
  		if(count($productos) == 0){
  			echo '{"data": []}';
		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($productos); $i++){
		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
		  	$imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button></div>"; 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["precio_compra"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "'.$botones.'"
			    ],';
		  }
		  $datosJson = substr($datosJson, 0, -1);
		 $datosJson .=   '] 
		 }';
		echo $datosJson;
	}

	public function mostrarCuotas(){
		$cuotas = ControladorVentas::ctrMostrarCuotas();	
  		if(count($cuotas) == 0){
  			echo '{"data": []}';
		  	return;
  		}
  		$datosJson = '{
		  "data": [';
		  	$cuotas = $cuotas[0]["cuotas"];
		  	$datosJson .='[
			           "'.$cuotas.'"
			      ],';
		  $datosJson = substr($datosJson, 0, -1);
		 $datosJson .=   '] 
		 }';
		 //print($datosJson);exit;
		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductosCompras = new TablaProductosCompras();
$activarProductosCompras -> mostrarTablaProductosCompras();