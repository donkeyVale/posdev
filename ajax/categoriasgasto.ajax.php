<?php

require_once "../controladores/categoriasgastos.controlador.php";
require_once "../modelos/categoriasgastos.modelo.php";

class AjaxCategoriasGasto{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idCategoriaGasto;
	public function ajaxEditarCategoriaGasto(){
		$item = "id";
		$valor = $this->idCategoriaGasto;
		$respuesta = ControladorCategoriasGastos::ctrMostrarCategoriasGastos($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idCategoriaGasto"])){
	$categoria = new AjaxCategoriasGasto();
	$categoria -> idCategoriaGasto = $_POST["idCategoriaGasto"];
	$categoria -> ajaxEditarCategoriaGasto();
}
