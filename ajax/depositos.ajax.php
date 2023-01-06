<?php

require_once "../controladores/depositos.controlador.php";
require_once "../modelos/depositos.modelo.php";

class AjaxDepositos{

	/*=============================================
	EDITAR DEPOSITO
	=============================================*/	
	public $idDeposito;
	public function ajaxEditarDeposito(){
		$item = "id";
		$valor = $this->idDeposito;
		$respuesta = ControladorDepositos::ctrMostrarDepositos($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR DEPOSITO
=============================================*/	
if(isset($_POST["idDeposito"])){
	$deposito = new AjaxDepositos();
	$deposito -> idDeposito = $_POST["idDeposito"];
	$deposito -> ajaxEditarDeposito();
}