<?php

require_once "../controladores/calces.controlador.php";
require_once "../modelos/calces.modelo.php";

class AjaxCalces{

	/*=============================================
	EDITAR CALCES
	=============================================*/	
	public $idCalce;
	public function ajaxEditarCalce(){
		$item = "id";
		$valor = $this->idCalce;
		$respuesta = ControladorCalces::ctrMostrarCalces($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CALCES
=============================================*/	
if(isset($_POST["idCalce"])){
	$color = new AjaxCalces();
	$color -> idCalce = $_POST["idCalce"];
	$color -> ajaxEditarCalce();
}