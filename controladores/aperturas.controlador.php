<?php

class ControladorAperturas{

	static public function ctrMostrarSucursales(){
		$respuesta = ModeloAperturas::mdlMostrarSucursales();
		return $respuesta;
	}

    static public function ctrMostrarCajasSucursales($item, $valor){
		$tabla = "cajas";
		$respuesta = ModeloAperturas::mdlMostrarCajasSucursal($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrMostrarAperturasUsuario(){
		$usuario = $_SESSION["id"];
		$respuesta = ModeloAperturas::mdlMostrarAperturasUsuario($usuario);
		return $respuesta;
	}

	static public function ctrAperturarCajaUsuario(){
       if (isset($_POST["idApertura"])) {
           $tabla = "aperturas";
           $datos = array(
               "id" => $_POST["idApertura"],
               "monto_cierre" => $_POST["montoCierre"],
           );
           $respuesta = ModeloAperturas::mdlCerrarApertura($tabla, $datos);
           $respuesta = "ok";
           if ($respuesta == "ok") {
               echo '<script>
						swal({
							type: "success",
							title: "La apertura se ha realizado con éxito!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
										if (result.value) {
										window.location = "aperturas";
										}
									})
						</script>';
           }
       }
		if(isset($_POST["caja"])){
			if($_POST["caja"]!="0")
			{
				if(preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["monto_caja"])){
					$tabla = "aperturas";
					$datos = array("idcaja"=>$_POST["caja"],
								"monto_apertura"=>$_POST["monto_caja"],
								"usuarioapertura"=>$_SESSION["id"]);

					$verificado =ModeloAperturas::mdlVerificarAperturaUsuario($_SESSION["id"]);
					$existe = $verificado[0][0];

					if($existe!="0") //Entonces no existen cajas abiertas para el usuario
					{
						echo'<script>
						swal({
							type: "warning",
							title: "Usted ya cuenta con una caja aperturada!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
										if (result.value) {
										window.location = "aperturas";
										}
									})
						</script>';
					}
					else
					{

						$respuesta = ModeloAperturas::mdlIngresarApertura($tabla, $datos);
						$respuesta ="ok";
						if($respuesta == "ok"){
						echo'<script>
						swal({
							type: "success",
							title: "La apertura se ha realizado con éxito!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
										if (result.value) {
										window.location = "aperturas";
										}
									})
						</script>';
					}
				 }
				}else{
					echo'<script>
						swal({
							type: "error",
							title: "¡Revisar los parámetros de apertura de la caja!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
								if (result.value) {
								window.location = "aperturas";
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
							title: "¡No se pudo registrar la apertura, tiene que seleccionar una Caja!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
								if (result.value) {
								window.location = "aperturas";
								}
							})
					</script>';
			}
		}
	}

	static public function ctrMostrarApertura($item, $valor){
		$tabla = "aperturas";
		$respuesta = ModeloAperturas::mdlMostrarApertura($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrEliminarCajaAperturada(){
		if(isset($_GET["idApertura"])){
			$tabla ="aperturas";
			$datos = $_GET["idApertura"];
			$datos = array("idApertura"=>$_GET["idApertura"],
						   "usuario"=>$_SESSION["id"]);

			$respuesta = ModeloAperturas::mdlEliminarApertura($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La caja aperturada ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {
								window.location = "aperturas";
								}
							})
				</script>';
			}		
		}
	}

}