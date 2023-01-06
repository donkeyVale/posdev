<?php

class ControladorCategoriasGastos{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCategoriaGasto(){
		if(isset($_POST["nuevaCategoriaGasto"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoriaGasto"]))
			{
				$tabla = "categorias_gastos";
				$datos = array("nombre" => $_POST["nuevaCategoriaGasto"],
							"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloCategoriasGastos::mdlIngresarCategoriaGasto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La categoría de gasto ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "categoriagastos";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La categoría de gasto no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "categoriagastos";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarCategoriasGastos($item, $valor){
		$tabla = "categorias_gastos";
		$respuesta = ModeloCategoriasGastos::mdlMostrarCategoriasGastos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarCategoriaGasto(){
		if(isset($_POST["editarCategoriaGasto"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoriaGasto"]))
			{
				$tabla = "categorias_gastos";
				$datos = array("nombre"=>$_POST["editarCategoriaGasto"],
							   "id"=>$_POST["idCategoriaGasto"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloCategoriasGastos::mdlEditarCategoriaGasto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La categoría del gasto ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "categoriagastos";
									}
								})
					</script>';
				}
			}
			else
			{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La categoría del gasto no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "categoriagastos";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarCategoriaGasto(){
		if(isset($_GET["idCategoriaGasto"])){
			$tabla ="categorias_gastos";
			$datos = $_GET["idCategoriaGasto"];
			$respuesta = ModeloCategoriasGastos::mdlBorrarCategoriaGasto($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La categoría de gasto ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "categoriagastos";
									}
								})
					</script>';
			}
		}
	}
}