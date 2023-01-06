<?php

class ControladorGruposClientes{

	/*=============================================
	CREAR GRUPOS CLIENTES
	=============================================*/

	static public function ctrCrearGrupo(){
		if(isset($_POST["nombreGrupo"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreGrupo"]) &&
			preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["porcentajeGrupo"]))
			{
				$tabla = "grupo_cliente";
				$datos = array("nombre" => $_POST["nombreGrupo"],
							   "porcentaje" => $_POST["porcentajeGrupo"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloGruposClientes::mdlIngresarGrupo($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El grupo ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "gruposcliente";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El grupo no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "gruposcliente";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR GRUPOS DE CLIENTES
	=============================================*/
	static public function ctrMostrarGrupos($item, $valor){
		$tabla = "grupo_cliente";
		$respuesta = ModeloGruposClientes::mdlMostrarGrupos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR GRUPO DE CLIENTES
	=============================================*/

	static public function ctrEditarGrupo(){
		if(isset($_POST["editarGrupo"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarGrupo"]) &&
			preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["editarPorcentajeGrupo"]))
			{
				$tabla = "grupo_cliente";
				$datos = array("nombre"=>$_POST["editarGrupo"],
							   "id"=>$_POST["idGrupo"],
							   "porcentaje"=>$_POST["editarPorcentajeGrupo"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloGruposClientes::mdlEditarGrupo($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El grupo ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "gruposcliente";
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
						  title: "¡El grupo no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "gruposcliente";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR GRUPO CLIENTES
	=============================================*/

	static public function ctrBorrarGrupo(){
		if(isset($_GET["idGrupo"])){
			$tabla ="grupo_cliente";
			$datos = $_GET["idGrupo"];
			$respuesta = ModeloGruposClientes::mdlBorrarGrupo($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El grupo ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "gruposcliente";
									}
								})
					</script>';
			}
		}
	}
}