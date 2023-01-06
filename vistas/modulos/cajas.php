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
    <h1>Administrar Cajas</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Cajas</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCaja">
          Agregar Caja
        </button>
      </div>

      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php
              $item = null;
              $valor = null;
              $cajas = ControladorCajas::ctrMostrarCajas($item, $valor);
              foreach ($cajas as $key => $value) {
                echo ' <tr>
                        <td>'.($key+1).'</td>
                        <td class="text-uppercase">'.$value["sucursal"].'</td>
                        <td class="text-uppercase">'.$value["cajas"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarCaja" idCaja="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCaja"><i class="fa fa-pencil"></i></button>';
                              if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarCaja" idCaja="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                              }
                          echo '</div>  
                        </td>
                      </tr>';
              } ?>
          </tbody>
       </table>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR CAJAS
======================================-->

<div id="modalAgregarCaja" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Caja</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span> 
                <select name="selectSucursal" id="selectSucursal" class="form-control input-lg">
                  <?php
                      $item = null;
                      $valor = null;
                      $sucursales = ControladorCajas::ctrMostrarSucursales();
                      foreach ($sucursales as $key => $value) {
                        echo '<option value="'.$value["id"].'">'.$value["sucursal"].'</option>';
                        }
                    ?>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaCaja" maxlength="30" placeholder="Nombre Caja" required>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Caja</button>
        </div>
        <?php
          $crearCaja = new ControladorCajas();
          $crearCaja -> ctrCrearCaja();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR CAJA
======================================-->
<div id="modalEditarCaja" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Caja</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span> 
                <select name="editarSucursal" id="editarSucursal" class="form-control input-lg">
                  <?php
                      $item = null;
                      $valor = null;
                      $sucursales = ControladorCajas::ctrMostrarSucursales();
                      foreach ($sucursales as $key => $value) {
                        echo '<option value="'.$value["id"].'">'.$value["sucursal"].'</option>';
                        }
                    ?>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="editarCaja" id="editarCaja" maxlength="30" required>
                <input type="hidden"  name="idCaja" id="idCaja" required>
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
          $editarCaja = new ControladorCajas();
          $editarCaja -> ctrEditarCaja();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarCaja = new ControladorCajas();
  $borrarCaja -> ctrBorrarCaja();
?>