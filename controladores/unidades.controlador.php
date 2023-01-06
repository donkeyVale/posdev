<?php

class ControladorUnidades{

	/*=============================================
	CREAR UNIDADES
	=============================================*/

	static public function ctrCrearUnidad(){
		if(isset($_POST["nuevaUnidad"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaUnidad"]) &&
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["codUnidad"]))
			{
				$tabla = "unidades";
				$datos = array("codUnidad" => $_POST["codUnidad"],
							   "nombreUnidad" => $_POST["nuevaUnidad"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloUnidades::mdlIngresarUnidad($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La unidad ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "unidades";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La unidad no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "unidades";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR UNIDADES
	=============================================*/
	static public function ctrMostrarUnidades($item, $valor){
		$tabla = "unidades";
		$respuesta = ModeloUnidades::mdlMostrarUnidades($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR UNIDAD
	=============================================*/

	static public function ctrEditarUnidad(){
		if(isset($_POST["editarUnidad"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarUnidad"]) &&
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["codUnidad"]))
			{
				$tabla = "unidades";
				$datos = array("unidad"=>$_POST["editarUnidad"],
							   "id"=>$_POST["idUnidad"],
							   "codUnidad"=>$_POST["codUnidad"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloUnidades::mdlEditarUnidad($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La unidad ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "unidades";
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
						  title: "¡La unidad no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "categorias";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR UNIDAD
	=============================================*/

	static public function ctrBorrarUnidad(){
		if(isset($_GET["idUnidad"])){
			$tabla ="unidades";
			$datos = $_GET["idUnidad"];
			$respuesta = ModeloUnidades::mdlBorrarUnidad($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La unidad ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "unidades";
									}
								})
					</script>';
			}
		}
	}
}