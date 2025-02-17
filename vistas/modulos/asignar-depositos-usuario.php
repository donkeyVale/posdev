<?php
if($_SESSION["perfil"] == "Especial"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="content-wrapper">
    <h1>Asignar Depósito Usuario</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Asignar Depósito Usuario</li>
    </ol>

  <section class="content">
    <section class="content-header">
      <div class="row">
        <!--=====================================
        EL FORMULARIO
        ======================================-->
        <!--<div class="col-lg-6 col-xs-12">-->
        <div class="col-lg-6">
          <div class="box box-success">
            <div class="box-header with-border"></div>
            <form role="form" method="post" class="formularioDeposito">
              <div class="box-body">
                <div class="box">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="hidden" name="nuevaAsignacion" id="nuevaAsignacion" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div> 

                  <br/>
                  <div class="row">
                   <div class="form-group">
                     <div class="col-md-5">
                        <span class="input-group-addon">
                          <label for="seleccionarUsuario">Usuario</label>
                          <select class="form-control" id="seleccionarUsuario" name="seleccionarUsuario" required>
                            <option value="0">Seleccionar Usuario</option>
                              <?php
                                $item = null;
                                $valor = null;
                                $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                                foreach ($usuarios as $key => $value) {
                                  $condicional="";
                                  if($_GET["seleccionarUsuario"]==$value["id"])
                                  {
                                    $condicional = "selected";
                                  }
                                  else  
                                  {
                                    $condicional="";
                                  }
                                  echo '<option value="'.$value["id"].'" ' . $condicional . ' >'.$value["nombre"].' - ' .$value["usuario"].'</option>';
                                }
                              ?>
                          </select>
                        </span>
                     </div>

                   </div>
                  </div>
                  
                  <br/>
                  <!--=====================================
                  ENTRADA PARA AGREGAR DEPOSITO
                  ======================================--> 
                  <div class="row" style="padding:5px 15px">
                    <div class="col-xs-5" style="padding-right:0px">Depósito</div>
                  </div>
                  <div class="form-group row nuevoDeposito">
                    <?php
                        if(isset($_GET["seleccionarUsuario"])){
                          $idUsuario = $_GET["seleccionarUsuario"];
                        }else{
                          $idUsuario = 0;
                        }
                        $depositos = ControladorDepositos::ctrListarDepositosUsuarios($idUsuario);
                        foreach ($depositos as $key => $value) {
                          echo '<div class="row" style="padding:5px 15px">
                                  <div class="col-xs-5" style="padding-right:0px">
                                      <div class="input-group">
                                          <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarDeposito" idDeposito=' . $value["idDeposito"] . '><i class="fa fa-times"></i></button></span>
                                          <input type="text" class="form-control nuevaDescripcionDeposito" idDeposito=' . $value["idDeposito"] . ' name="agregarDeposito" value="' .  $value["deposito"] . '" readonly required>
                                      </div>
                                  </div>
                                </div>';
                          }
                          echo ' <script type="text/javascript">
                            function listarDepositos() {
                            var listaDepositos = [];
                            var descripcion = $(".nuevaDescripcionDeposito");
                            for (var i = 0; i < descripcion.length; i++) {
                                listaDepositos.push({
                                    "id": $(descripcion[i]).attr("idDeposito"),
                                    "descripcion": $(descripcion[i]).val()
                                })
                            }
                            $("#listaDepositos").val(JSON.stringify(listaDepositos));
                        }
                        </script>';
                      ?>
                  </div>
                  <input type="hidden" id="listaDepositos" name="listaDepositos">

                  <hr>
                  <br>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" id="btnGuardarAsignacion" name="btnGuardarAsignacion" class="btn btn-primary pull-right">Guardar Asignación</button>
              </div>
              <?php
              $guardarAsignacion = new ControladorDepositos();
              $guardarAsignacion -> ctrAsignarDepositosUsuario();
              ?>
            </form>
          </div>      
        </div>
      <!--=====================================
        LA TABLA DE PRODUCTOS
        ======================================-->
        <!--<div class="col-lg-7 hidden-md hidden-sm hidden-xs">    -->
        <div class="col-lg-6">
          <div class="box box-warning">
            <div class="box-header with-border"></div>
            <div class="box-body">    
              <table class="table table-bordered table-striped small tablaDepositosAsignar">    
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre Depósito</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div> 
    </section>
  </section>

  <script type="text/javascript">
    $('#seleccionarUsuario').select2();

  </script>