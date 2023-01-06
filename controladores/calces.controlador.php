<?php

class ControladorCalces{

	/*=============================================
	CREAR CALCES
	=============================================*/

	static public function ctrCrearCalce(){
		if(isset($_POST["nuevoCalce"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCalce"]))
			{
				$tabla = "calces";
				$datos = array("nombre" => $_POST["nuevoCalce"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloCalces::mdlIngresarCalce($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Calce ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "calces";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El calce no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "calces";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CALCES
	=============================================*/
	static public function ctrMostrarCalces($item, $valor){
		$tabla = "calces";
		$respuesta = ModeloCalces::mdlMostrarCalces($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR CALCE
	=============================================*/

	static public function ctrEditarCalce(){
		if(isset($_POST["editarCalce"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCalce"]))
			{
				$tabla = "calces";
				$datos = array("nombre"=>$_POST["editarCalce"],
							   "id"=>$_POST["idCalce"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloCalces::mdlEditarCalce($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El calce ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "calces";
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
						  title: "¡El calce no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "calces";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CALCE
	=============================================*/

	static public function ctrBorrarCalce(){
		if(isset($_GET["idCalce"])){
			$tabla ="calces";
			$datos = $_GET["idCalce"];
			$respuesta = ModeloCalces::mdlBorrarCalce($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El calce ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "calces";
									}
								})
					</script>';
			}
		}
	}
}