<?php

class ControladorDepositos{

	/*=============================================
	CREAR DEPOSITOS
	=============================================*/

	static public function ctrCrearDeposito(){
		if(isset($_POST["nuevoDeposito"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDeposito"]))
			{
				$tabla = "depositos";
				$datos = array("deposito" => $_POST["nuevoDeposito"],
							   "codigo" => $_POST["codNuevoDeposito"],
							   "telefono" => $_POST["telefonoNuevoDeposito"],
							   "email" => $_POST["emailNuevoDeposito"],
							   "direccion" => $_POST["direccionNuevoDeposito"],
								"usuario" => $_SESSION["usuario"]);
				$respuesta = ModeloDepositos::mdlIngresarDeposito($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El depósito ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "depositos";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El depósito no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "depositos";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR DEPOSITOS
	=============================================*/
	static public function ctrMostrarDepositos($item, $valor){
		$tabla = "depositos";
		$respuesta = ModeloDepositos::mdlMostrarDepositos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR DEPOSITO
	=============================================*/

	static public function ctrEditarDeposito(){
		if(isset($_POST["editarDeposito"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDeposito"]))
			{
				$tabla = "depositos";
				$datos = array("deposito"=>$_POST["editarDeposito"],
							   "id"=>$_POST["idDeposito"],
							   "codigo"=>$_POST["codEditarDeposito"],
							   "telefono"=>$_POST["telefonoEditarDeposito"],
							   "email"=>$_POST["emailEditarDeposito"],
							   "direccion"=>$_POST["direccionEditarDeposito"],
							   "usuario"=>$_SESSION["usuario"]);
				$respuesta = ModeloDepositos::mdlEditarDeposito($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El depósito ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "depositos";
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
						  title: "¡El depósito no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "depositos";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR DEPÓSITO
	=============================================*/

	static public function ctrBorrarDeposito(){
		if(isset($_GET["idDeposito"])){
			$tabla ="depositos";
			$datos = $_GET["idDeposito"];
			$respuesta = ModeloDepositos::mdlBorrarDeposito($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El depósito ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "depositos";
									}
								})
					</script>';
			}
		}
	}

	/*=============================================
	CREAR ASIGNACION DEPOSITOS A USUARIO
	=============================================*/
	static public function ctrAsignarDepositosUsuario(){
		
		if(isset($_POST["nuevaAsignacion"])){
			
			/*=============================================
			ACTUALIZAR LAS COMPRAS
			=============================================*/
			if($_POST["listaDepositos"] == ""){
					echo'<script>
				swal({
					  type: "error",
					  title: "Deben existir depósitos para asignar al usuario",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "asignar-depositos-usuario";
								}
							})
				</script>';
				return;
			}
			/*=============================================
			GUARDAR LA ASIGNACION
			=============================================*/				
			$tabla = "usuario_depositos";
			$datos = array("id_usuario"=>$_POST["seleccionarUsuario"],
						   "depositos"=>$_POST["listaDepositos"],
						   "usuarioCreacion"=>$_SESSION["id"]);
			$respuesta = ModeloDepositos::mdlIngresarUsuariosDepositos($tabla, $datos);
			/*************************************************** */
			
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La asignación se realizó de manera correcta.",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "asignar-depositos-usuario";
								}
							})
				</script>';
			}
		}
	}

	static public function ctrListarDepositosUsuarios($valor){
		$respuesta = ModeloDepositos::mdlListarDepositosUsuario($valor);
		return $respuesta;
	}
}
