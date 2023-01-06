<?php

require_once "../controladores/gruposclientes.controlador.php";
require_once "../modelos/gruposclientes.modelo.php";

class AjaxGruposClientes{

	/*=============================================
	EDITAR GRUPO CLIENTE
	=============================================*/	
	public $idGrupo;
	public function ajaxEditarGrupoCliente(){
		$item = "id";
		$valor = $this->idGrupo;
		$respuesta = ControladorGruposClientes::ctrMostrarGrupos($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR GRUPO CLIENTE
=============================================*/	
if(isset($_POST["idGrupo"])){
	$grupo = new AjaxGruposClientes();
	$grupo -> idGrupo = $_POST["idGrupo"];
	$grupo -> ajaxEditarGrupoCliente();
}
