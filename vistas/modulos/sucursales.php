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
    <h1>Administrar Sucursales</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Sucursales</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarSucursal">
          Agregar Sucursal
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
              $sucursales = ControladorSucursales::ctrMostrarSucursales($item, $valor);
              foreach ($sucursales as $key => $value) {
                echo ' <tr>
                        <td>'.($key+1).'</td>
                        <td class="text-uppercase">'.$value["sucursal"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarSucursal" idSucursal="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarSucursal"><i class="fa fa-pencil"></i></button>';
                              if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarSucursal" idSucursal="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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
MODAL AGREGAR SUCURSALES
======================================-->

<div id="modalAgregarSucursal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Sucursal</h4>
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
                <input type="text" class="form-control input-lg" name="nuevaSucursal" maxlength="50" placeholder="Nombre Sucursal" required>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
        </div>
        <?php
          $crearSucursal = new ControladorSucursales();
          $crearSucursal -> ctrCrearSucursal();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR SUCURSAL
======================================-->
<div id="modalEditarSucursal" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Sucursal</h4>
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
                <input type="text" class="form-control input-lg" name="editarSucursal" id="editarSucursal" maxlength="50" required>
                <input type="hidden"  name="idSucursal" id="idSucursal" required>
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
          $editarSucursal = new ControladorSucursales();
          $editarSucursal -> ctrEditarSucursal();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarSucursal = new ControladorSucursales();
  $borrarSucursal -> ctrBorrarSucursal();
?>