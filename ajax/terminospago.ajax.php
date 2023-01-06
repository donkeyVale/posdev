<?php

require_once "../controladores/terminospago.controlador.php";
require_once "../modelos/terminospago.modelo.php";

class AjaxTerminosPago{

	/*=============================================
	EDITAR TERMINO PAGO
	=============================================*/	
	public $idTermino;
	public function ajaxEditarTerminoPago(){
		$item = "id";
		$valor = $this->idTermino;
		$respuesta = ControladorTerminosPago::ctrMostrarTerminosPago($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR TERMINO PAGO
=============================================*/	
if(isset($_POST["idTermino"])){
	$termino = new AjaxTerminosPago();
	$termino -> idTermino = $_POST["idTermino"];
	$termino -> ajaxEditarTerminoPago();
}
