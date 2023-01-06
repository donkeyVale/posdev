<?php

require_once "../controladores/aperturas.controlador.php";
require_once "../modelos/aperturas.modelo.php";

class AjaxAperturas{

	public $idSucursal;
	public function ajaxListarCajas(){
		$item = "idSucursal";
		$valor = $this->idSucursal;
		$respuesta = ControladorAperturas::ctrMostrarCajasSucursales($item, $valor);
		$sentencia ='';
		$sentencia = '<option value="0">--Seleccione Caja--</option>';
		foreach ($respuesta as $key => $value) {
			$sentencia .= '<option value="'.$value["id"].'">'.$value["cajas"].'</option>';
		}
		echo json_encode($sentencia);
	}
}

/*=============================================
EDITAR CAJA
=============================================*/	
if(isset($_POST["idSucursal"])){
	$sucursal = new AjaxAperturas();
	$sucursal -> idSucursal = $_POST["idSucursal"];
	$sucursal -> ajaxListarCajas();
}