<?php

require_once "../controladores/unidades.controlador.php";
require_once "../modelos/unidades.modelo.php";

class AjaxUnidades{

	/*=============================================
	EDITAR UNIDAD
	=============================================*/	
	public $idUnidad;
	public function ajaxEditarUnidad(){
		$item = "id";
		$valor = $this->idUnidad;
		$respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR UNIDAD
=============================================*/	
if(isset($_POST["idUnidad"])){
	$unidad = new AjaxUnidades();
	$unidad -> idUnidad = $_POST["idUnidad"];
	$unidad -> ajaxEditarUnidad();
}
