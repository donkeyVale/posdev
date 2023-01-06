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
    <h1>Administrar Términos de Pago</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Términos de Pago</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTerminoPago">
          Agregar Término Pago
        </button>
      </div>

      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Descripción</th>
              <th>Días</th>
              <th>Acciones</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php
              $item = null;
              $valor = null;
              $terminos = ControladorTerminosPago::ctrMostrarTerminosPago($item, $valor);
              foreach ($terminos as $key => $value) {
                echo ' <tr>
                        <td>'.($key+1).'</td>
                        <td class="text-uppercase">'.$value["descripcion"].'</td>
                        <td class="text-uppercase">'.$value["dias"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarTermino" idTermino="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarTerminoPago"><i class="fa fa-pencil"></i></button>';
                              if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarTermino" idTermino="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarTerminoPago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Términos de Pago</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTerminoPago" placeholder="Descripción" maxlength="20" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="number" class="form-control input-lg" name="nuevoDias" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" placeholder="Días" pattern="\d*" maxlength="2" required>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Término</button>
        </div>
        <?php
          $crearTermino = new ControladorTerminosPago();
          $crearTermino -> ctrCrearTerminoPago();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->
<div id="modalEditarTerminoPago" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Término de Pago</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" maxlength="20" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="number" class="form-control input-lg" name="editarDias" id="editarDias" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" required>
                <input type="hidden"  name="idTermino" id="idTermino" required>
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
          $editarTermino = new ControladorTerminosPago();
          $editarTermino -> ctrEditarTerminoPago();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarTermino = new ControladorTerminosPago();
  $borrarTermino -> ctrBorrarTerminoPago();
?>