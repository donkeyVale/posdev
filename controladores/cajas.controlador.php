<?php

class ControladorCajas{

	/*=============================================
	CREAR CAJAS
	=============================================*/

	static public function ctrCrearCaja(){
		if(isset($_POST["nuevaCaja"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCaja"]))
			{
				$tabla = "cajas";
				$datos = array("cajas" => $_POST["nuevaCaja"],
								"usuario" => $_SESSION["usuario"],
								"idSucursal" => $_POST["selectSucursal"]);

				$respuesta = ModeloCajas::mdlIngresarCaja($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La caja ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "cajas";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La caja no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "cajas";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CAJAS
	=============================================*/
	static public function ctrMostrarCajas($item, $valor){
		$tabla = "cajas";
		$respuesta = ModeloCajas::mdlMostrarCajas($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrMostrarSucursales(){
		$respuesta = ModeloCajas::mdlMostrarSucursales();
		return $respuesta;
	}

	/*=============================================
	EDITAR CAJA
	=============================================*/

	static public function ctrEditarCaja(){
		if(isset($_POST["editarCaja"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCaja"]))
			{
				$tabla = "cajas";
				$datos = array("cajas"=>$_POST["editarCaja"],
							   "id"=>$_POST["idCaja"],
							   "usuario"=>$_SESSION["usuario"],
							   "idSucursal"=>$_POST["editarSucursal"]);
				$respuesta = ModeloCajas::mdlEditarCaja($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La caja ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "cajas";
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
						  title: "¡La caja no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "cajas";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CAJA
	=============================================*/

	static public function ctrBorrarCaja(){
		if(isset($_GET["idCaja"])){
			$tabla ="cajas";
			$datos = $_GET["idCaja"];
			$respuesta = ModeloCajas::mdlBorrarCaja($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La caja ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "cajas";
									}
								})
					</script>';
			}
		}
	}
}