<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class Tabla1Cuotas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

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
		
		echo json_encode($cuotas);


	}



}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarCuotas = new Tabla1Cuotas();
$activarCuotas -> mostrarCuotas();