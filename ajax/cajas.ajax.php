<?php

require_once "../controladores/cajas.controlador.php";
require_once "../modelos/cajas.modelo.php";

class AjaxCajas{

	/*=============================================
	EDITAR CAJA
	=============================================*/	
	public $idCaja;
	public function ajaxEditarCaja(){
		$item = "id";
		$valor = $this->idCaja;
		$respuesta = ControladorCajas::ctrMostrarCajas($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CAJA
=============================================*/	
if(isset($_POST["idCaja"])){
	$caja = new AjaxCajas();
	$caja -> idCaja = $_POST["idCaja"];
	$caja -> ajaxEditarCaja();
}