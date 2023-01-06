<?php

class ControladorTerminosPago{

	/*=============================================
	CREAR TERMINOS PAGO
	=============================================*/

	static public function ctrCrearTerminoPago(){
		if(isset($_POST["nuevoTerminoPago"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoTerminoPago"]) &&
			preg_match('/^[1-9][0-9]*$/', $_POST["nuevoDias"]))
			{
				$tabla = "termino_pago";
				$datos = array("descripcion" => $_POST["nuevoTerminoPago"],
							   "dias" => $_POST["nuevoDias"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloTerminosPago::mdlIngresarTerminoPAgo($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El término de pago ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "terminos-pago";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El término de pago no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "terminos-pago";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR TERMINO PAGO
	=============================================*/
	static public function ctrMostrarTerminosPago($item, $valor){
		$tabla = "termino_pago";
		$respuesta = ModeloTerminosPago::mdlMostrarTerminosPago($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR TERMINO PAGO
	=============================================*/

	static public function ctrEditarTerminoPago(){
		if(isset($_POST["editarDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			preg_match('/^[1-9][0-9]*$/', $_POST["editarDias"]))
			{
				$tabla = "termino_pago";
				$datos = array("descripcion"=>$_POST["editarDescripcion"],
							   "id"=>$_POST["idTermino"],
							   "dias"=>$_POST["editarDias"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloTerminosPago::mdlEditarTerminoPago($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El término de pago ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "terminos-pago";
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
						  title: "¡El término de pago no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "terminos-pago";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR TERMINO DE PAGO
	=============================================*/

	static public function ctrBorrarTerminoPago(){
		if(isset($_GET["idTermino"])){
			$tabla ="termino_pago";
			$datos = $_GET["idTermino"];
			$respuesta = ModeloTerminosPago::mdlBorrarTerminoPago($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El término de pago ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "terminos-pago";
									}
								})
					</script>';
			}
		}
	}
}