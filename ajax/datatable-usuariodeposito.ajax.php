<?php

require_once "../controladores/depositos.controlador.php";
require_once "../modelos/depositos.modelo.php";


class TablaUsuariosDepositos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE DEPOSITOS USUARIOS
  	=============================================*/ 

	public function mostrarTablaUsuariosDepositos(){
		$item = null;
    	$valor = null;
    	$orden = "id";
  		$depositos = ControladorDepositos::ctrMostrarDepositos($item, $valor, $orden);
  		if(count($depositos) == 0){
  			echo '{"data": []}';
		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($depositos); $i++){

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarDeposito recuperarBoton' idDeposito='".$depositos[$i]["id"]."'>Agregar</button></div>"; 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$depositos[$i]["deposito"].'",
			      "'.$botones.'"
			    ],';
		  }
		  $datosJson = substr($datosJson, 0, -1);
		 $datosJson .=   '] 
		 }';
		echo $datosJson;
	}
}

$activarUsuariosDepositos = new TablaUsuariosDepositos();
$activarUsuariosDepositos -> mostrarTablaUsuariosDepositos();