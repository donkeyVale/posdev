<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductosVentas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosVentas(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$productos = ControladorProductos::mdlMostrarProductosVentas($item, $valor, $orden);
 		
  		if(count($productos) == 0){

  			echo '{"data": []}';

		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($productos); $i++){
		      if($productos[$i]['product_id'] == '') {
                  /*=============================================
          TRAEMOS LA IMAGEN
          =============================================*/

                  $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

                  /*=============================================
                  STOCK
                  =============================================*/

                  if($productos[$i]["stock"] <= 10){

                      $stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

                  }else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){

                      $stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

                  }else{

                      $stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

                  }

                  /*=============================================
                  TRAEMOS LAS ACCIONES
                  =============================================*/

                  $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button></div>";

                  $datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "'.$stock.'",
			      "'.$botones.'"
			    ],';
              } else {
                  /*=============================================
        TRAEMOS LA IMAGEN
        =============================================*/

                  $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

                  /*=============================================
                  STOCK
                  =============================================*/

                  $producto = ControladorProductos::mdlMostrarProductosVentas('id', $productos[$i]['product_id']);

                  if($producto["stock"] <= 10){

                      $stock = "<button class='btn btn-danger'>".$producto["stock"]."</button>";

                  }else if($producto["stock"] > 11 && $producto["stock"] <= 15){

                      $stock = "<button class='btn btn-warning'>".$producto["stock"]."</button>";

                  }else{

                      $stock = "<button class='btn btn-success'>".$producto["stock"]."</button>";

                  }

                  /*=============================================
                  TRAEMOS LAS ACCIONES
                  =============================================*/

                  $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button></div>";

                  $datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "'.$stock.'",
			      "'.$botones.'"
			    ],';
              }
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
$activarProductosVentas = new TablaProductosVentas();
$activarProductosVentas -> mostrarTablaProductosVentas();
//$activarProductosVentas -> mostrarCuotas();

