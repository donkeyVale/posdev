<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

					if($existe!="0") //Entonces  existen cajas abiertas para el usuario
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
							
							$usuarioApertura = $_SESSION["id"];
							$respuestaCaja = ModeloAperturas::mdlMostrarAperturaActivaUsuario($usuarioApertura);
							foreach ($respuestaCaja as $key => $value) {
								$nombreSucursal = $value["sucursal"];
								$nombreCaja = $value["cajas"];
								$nombreUsuarioApertura =  $value["usuario"];
							}
							
							$notificaciones = ModeloAperturas::mdlMostrarUsuariosNotificacion();
							foreach ($notificaciones as $key2 => $value2) {
								
								$mail = new PHPMailer();
								$mail->isSMTP();
								$mail->SMTPAuth = true;
								// Login
								$mail->Host = "mail.growerdev.com.py";
								$mail->Port = "465";
								$mail->Username = "info@growerdev.com.py";
								$mail->Password = "Donkey3673518";
								$mail->setFrom('info@growerdev.com.py', 'Sistema Facturación');

								$mail->addAddress($value2["email"], $value2["nombre"]);
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
								
								date_default_timezone_set('America/Asuncion');
								$fecha_actual = date("d-m-Y h:i:s A");

								$mail->CharSet = 'UTF-8';
								$mail->Encoding = 'base64';
								$mail->isHTML(true);
								$mail->Subject = 'Apertura de Caja';
								$body='<center>
										<td width="100%" height="100" align="center">
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" height="50"></td>
													</tr>
												</tbody>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" style="height:auto">
															<a href="#m_6302990995433631177_m_-2542727450602248528_" style="text-decoration:none"><img src="https://ci4.googleusercontent.com/proxy/pCJryLl6Ekyzi250cEoRTjFR-8Vg6I4OfKJt2FUh2W5nCLkzF-iOtvuyBufUKNyjzvUK=s0-d-e1-ft#http://appignis.com/img/logo.png" alt="" border="0" class="CToWUd" data-bit="iit"></a>
														</td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" object="drag-module-small">
												<tbody>
													<tr>
														<td width="100%" height="50"></td>
													</tr>
												</tbody>
											</table>
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" style="border-radius:6px">
												<tbody>
													<tr>
														<td width="100%" style="border-radius:6px" bgcolor="#ffffff">										
															<div>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border-top-right-radius:6px;border-top-left-radius:6px" id="m_6302990995433631177m_-2542727450602248528not1ChangeBG" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="100%" height="50"></td>
																						</tr>														
																						<tr>
																							<td width="100%" height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
																						</tr>
																						<tr>
																							<td width="100%" style="width:329px;height:auto">
																								<img src="https://drive.google.com/file/d/1qp3WkZiqXEQFEi6phMAkpsIwjxdrJoze/view" alt="illustration" border="0" class="CToWUd" data-bit="iit">
																							</td>
																						</tr>
																						<tr>
																							<td width="100%" height="50" style="font-size:1px;line-height:1px">&nbsp;</td>
																						</tr>	
																					</tbody>
																				</table>		
																			</td>
																		</tr>
																	</tbody>
																</table>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td valign="middle" width="100%" style="text-align:center;font-family:Lato,Helvetica,Arial,sans-serif;font-size:20px;line-height:40px;font-weight:400;color:rgb(53,53,53)">
																								Hola <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $value2["nombre"] . '</span>, 
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">												
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="100%" height="25" style="font-size:1px;line-height:1px">&nbsp;</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:16px;line-height:24px;font-weight:400;color:rgb(134,133,133)">
																								Le notificamos que el usuario <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreUsuarioApertura .'</span>, siendo el <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $fecha_actual . '</span> realizo la apertura de la caja <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreCaja . '</span> del módulo ventas de la sucursal <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $nombreSucursal . '</span> con un monto inicial de <span style="font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(214,54,27)">' . $_POST["monto_caja"] . '</span> Gs.
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
		
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="100%" height="15" style="font-size:1px;line-height:1px">&nbsp;</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td valign="middle" width="100%" style="text-align:left;font-family:Lato,Helvetica,Arial,sans-serif;font-size:16px;line-height:24px;font-weight:400;color:rgb(0,212,255)">
																								<a href="#m_6302990995433631177_m_-2542727450602248528_" style="text-decoration:none;font-family:Lato,Helvetica,Arial,sans-serif;color:rgb(134,133,133)">Saludos.</a>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small">
																	<tbody>
																		<tr>
																			<td width="100%" valign="middle" align="center">
																				<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="100%" height="30" style="font-size:1px;line-height:1px">&nbsp;</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
											
											<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" object="drag-module-small" style="border-bottom-right-radius:6px;border-bottom-left-radius:6px">
												<tbody>
													<tr>
														<td width="100%" valign="middle" align="center">
															<table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align:center;border-collapse:collapse">
																<tbody>
																	<tr>
																		<td width="100%" height="50" style="font-size:1px;line-height:1px">&nbsp;</td>
																	</tr>
																</tbody>
															</table>							
														</td>
													</tr>
												</tbody>
											</table>
										</td>
										</center>';

								$mail->Body = $body;
								//$mail->AltBody = 'El texto como elemento de texto simple';
								$mail->send();
							}

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
