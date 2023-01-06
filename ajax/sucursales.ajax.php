<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";

class AjaxSucursales{

	/*=============================================
	EDITAR SUCURSAL
	=============================================*/	
	public $idSucursal;
	public function ajaxEditarSucursal(){
		$item = "id";
		$valor = $this->idSucursal;
		$respuesta = ControladorSucursales::ctrMostrarSucursales($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR SUCURSAL
=============================================*/	
if(isset($_POST["idSucursal"])){
	$sucursal = new AjaxSucursales();
	$sucursal -> idSucursal = $_POST["idSucursal"];
	$sucursal -> ajaxEditarSucursal();
}