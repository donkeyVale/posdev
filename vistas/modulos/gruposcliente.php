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
    <h1>Administrar Grupo de Clientes</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Grupo de Clientes</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarGrupo">
          Agregar Grupo Cliente
        </button>
      </div>

      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre</th>
              <th>Porcentaje</th>
              <th>Acciones</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php
              $item = null;
              $valor = null;
              $grupos = ControladorGruposClientes::ctrMostrarGrupos($item, $valor);
              foreach ($grupos as $key => $value) {
                echo ' <tr>
                        <td>'.($key+1).'</td>
                        <td class="text-uppercase">'.$value["nombre"].'</td>
                        <td class="text-uppercase">'.$value["porcentaje"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarGrupo" idGrupo="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarGrupo"><i class="fa fa-pencil"></i></button>';
                              if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarGrupo" idGrupo="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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
MODAL AGREGAR GRUPO DE CLIENTE
======================================-->

<div id="modalAgregarGrupo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Grupo de Clientes</h4>
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
                <input type="text" class="form-control input-lg" name="nombreGrupo" placeholder="Nombre del Grupo" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="number" step='0.01' class="form-control input-lg" name="porcentajeGrupo" placeholder="Porcentaje" required>
              </div>
            </div>
          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Grupo</button>
        </div>
        <?php
          $crearGrupo = new ControladorGruposClientes();
          $crearGrupo -> ctrCrearGrupo();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR GRUPO
======================================-->
<div id="modalEditarGrupo" class="modal fade" role="dialog">  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Grupo de Cliente</h4>
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
                <input type="text" class="form-control input-lg" name="editarGrupo" id="editarGrupo" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="editarPorcentajeGrupo" id="editarPorcentajeGrupo" required>
                <input type="hidden"  name="idGrupo" id="idGrupo" required>
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
          $editarGrupo = new ControladorGruposClientes();
          $editarGrupo -> ctrEditarGrupo();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarGrupo = new ControladorGruposClientes();
  $borrarGrupo -> ctrBorrarGrupo();
?>