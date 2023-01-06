<?php

require_once "../controladores/aperturas.controlador.php";
require_once "../modelos/aperturas.modelo.php";

class AjaxVerAperturas{

	public $idApertura;
	public function ajaxListarApertura(){
		$item = "id";
		$valor = $this->idApertura;
		$respuesta = ControladorAperturas::ctrMostrarApertura($item, $valor);
		echo json_encode($respuesta);
	}
}

if(isset($_POST["idApertura"])){
	$apertura = new AjaxVerAperturas();
	$apertura -> idApertura = $_POST["idApertura"];
	$apertura -> ajaxListarApertura();
}