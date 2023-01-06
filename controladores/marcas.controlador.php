<?php

class ControladorMarcas{

	/*=============================================
	CREAR MARCAS
	=============================================*/

	static public function ctrCrearMarca(){
		if(isset($_POST["nombreMarca"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreMarca"]))
			{
				$tabla = "marcas";
				$datos = array("nombreMarca" => $_POST["nombreMarca"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloMarcas::mdlIngresarMarca($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "marcas";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La marca no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "marcas";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR MARCAS
	=============================================*/
	static public function ctrMostrarMarcas($item, $valor){
		$tabla = "marcas";
		$respuesta = ModeloMarcas::mdlMostrarMarcas($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR MARCA
	=============================================*/

	static public function ctrEditarMarca(){
		if(isset($_POST["editarMarca"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMarca"]))
			{
				$tabla = "marcas";
				$datos = array("marca"=>$_POST["editarMarca"],
							   "id"=>$_POST["idMarca"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloMarcas::mdlEditarMarca($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "marcas";
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
						  title: "¡La marca no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "marcas";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR MARCA
	=============================================*/

	static public function ctrBorrarMarca(){
		if(isset($_GET["idMarca"])){
			$tabla ="marcas";
			$datos = $_GET["idMarca"];
			$respuesta = ModeloMarcas::mdlBorrarMarca($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "marcas";
									}
								})
					</script>';
			}
		}
	}
}