<?php
if($_SESSION["perfil"] == "Vendedor"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar Depósitos</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Depósitos</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDeposito">
          Agregar Depósito
        </button>
      </div>

      <div class="box-body">
      <!--<div class="table-responsive">-->
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Código</th>
              <th>Descripción</th>
              <th>Teléfono</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Acciones</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php
              $item = null;
              $valor = null;
              $depositos = ControladorDepositos::ctrMostrarDepositos($item, $valor);
              foreach ($depositos as $key => $value) {
                echo ' <tr>
                        <td>'.($key+1).'</td>
                        <td class="text-uppercase">'.$value["codigo"].'</td>
                        <td class="text-uppercase">'.$value["deposito"].'</td>
                        <td class="text-uppercase">'.$value["telefono"].'</td>
                        <td class="text-uppercase">'.$value["email"].'</td>
                        <td class="text-uppercase">'.$value["direccion"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarDeposito" idDeposito="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarDeposito"><i class="fa fa-pencil"></i></button>';
                              if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarDeposito" idDeposito="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                              }
                          echo '</div>  
                        </td>
                      </tr>';
              } ?>
          </tbody>
       </table>
      </div>
      <!--</div>-->
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR DEPOSITOS
======================================-->

<div id="modalAgregarDeposito" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Depósito</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span> 
                <input type="text" class="form-control input-lg" name="codNuevoDeposito" maxlength="50" placeholder="Código" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoDeposito" maxlength="50" placeholder="Nombre Depósito" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELEFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="telefonoNuevoDeposito" maxlength="50" placeholder="Teléfono" >
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-at"></i></span> 
                <input type="text" class="form-control input-lg" name="emailNuevoDeposito" maxlength="50" placeholder="Email" >
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCION -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span> 
                <input type="text" class="form-control input-lg" name="direccionNuevoDeposito" maxlength="50" placeholder="Dirección" required>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Depósito</button>
        </div>
        <?php
          $crearDeposito = new ControladorDepositos();
          $crearDeposito -> ctrCrearDeposito();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR DEPOSITO
======================================-->
<div id="modalEditarDeposito" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Depósito</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span> 
                <input type="text" class="form-control input-lg" name="codEditarDeposito" maxlength="50" placeholder="Código" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-industry"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDeposito" id="editarDeposito" maxlength="50" required>
                <input type="hidden"  name="idDeposito" id="idDeposito" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELEFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="telefonoEditarDeposito" maxlength="50" placeholder="Teléfono" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-at"></i></span> 
                <input type="text" class="form-control input-lg" name="emailEditarDeposito" maxlength="50" placeholder="Email" required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCION -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span> 
                <input type="text" class="form-control input-lg" name="direccionEditarDeposito" maxlength="50" placeholder="Dirección" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
        <?php
          $editarDeposito = new ControladorDepositos();
          $editarDeposito -> ctrEditarDeposito();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarDeposito = new ControladorDepositos();
  $borrarDeposito -> ctrBorrarDeposito();
?>