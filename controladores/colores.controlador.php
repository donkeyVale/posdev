<?php

class ControladorColores{

	/*=============================================
	CREAR COLORES
	=============================================*/

	static public function ctrCrearColor(){
		if(isset($_POST["nuevoColor"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoColor"]))
			{
				$tabla = "colores";
				$datos = array("nombre" => $_POST["nuevoColor"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloColores::mdlIngresarColor($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El color ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "colores";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El color no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "colores";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR COLORES
	=============================================*/
	static public function ctrMostrarColores($item, $valor){
		$tabla = "colores";
		$respuesta = ModeloColores::mdlMostrarColores($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR COLOR
	=============================================*/

	static public function ctrEditarColor(){
		if(isset($_POST["editarColor"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarColor"]))
			{
				$tabla = "colores";
				$datos = array("nombre"=>$_POST["editarColor"],
							   "id"=>$_POST["idColor"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloColores::mdlEditarColor($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El color ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "colores";
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
						  title: "¡El color no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "colores";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR COLOR
	=============================================*/

	static public function ctrBorrarColor(){
		if(isset($_GET["idColor"])){
			$tabla ="colores";
			$datos = $_GET["idColor"];
			$respuesta = ModeloColores::mdlBorrarColor($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El color ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "colores";
									}
								})
					</script>';
			}
		}
	}
}