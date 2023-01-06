<?php

if($_SESSION["perfil"] == "Especial"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar Proveedores</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Proveedores</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">
          Agregar Proveedor
        </button>
      </div>

      <div class="box-body">        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>RUC</th>
           <th>Email</th>
           <th>Teléfono</th>
           <th>Dirección</th>
           <th>Nombre Contacto</th> 
           <th>Teléfono Contacto</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);
          foreach ($proveedores as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["ruc"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.$value["telefono"].'</td>
                    <td>'.$value["direccion"].'</td>
                    <td>'.$value["nombrecontacto"].'</td>             
                    <td>'.$value["telefonocontacto"].'</td>
                    <td>
                      <div class="btn-group">  
                        <button class="btn btn-warning btnEditarProveedor" data-toggle="modal" data-target="#modalEditarProveedor" idProveedor="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';
                      if($_SESSION["perfil"] == "Administrador"){
                          echo '<button class="btn btn-danger btnEliminarProveedor" idProveedor="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                      echo '</div>  
                    </td>
                  </tr>';
            }
        ?>
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR PROVEEDOR
======================================-->

<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoProveedor" maxlength="50" placeholder="Ingresar Proveedor" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" min="0" class="form-control input-lg" name="nuevoRUC" placeholder="Ingresar RUC" onKeyPress="if(this.value.length==11) return false;" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="nuevoEmail" maxlength="50" placeholder="Ingresar email">
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefono" maxlength="10" placeholder="Ingresar teléfono"  required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDireccion" maxlength="60" placeholder="Ingresar dirección" required>
              </div>
            </div>
             <!-- ENTRADA PARA EL NOMBRE DEL CONTACTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoContacto" maxlength="60" placeholder="Ingresar Contacto" required>
              </div>
            </div>

            </div>
            <!-- ENTRADA PARA EL TELÉFONO DEL CONTACTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefonoContacto" maxlength="10" placeholder="Ingresar teléfono Contacto" required>
              </div>
            </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        </div>
      </form>
      <?php
        $crearProveedor = new ControladorProveedores();
        $crearProveedor -> ctrCrearProveedor();
      ?>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR PROVEEDOR
======================================-->
<div id="modalEditarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="editarProveedor" maxlength="50" id="editarProveedor" required>
                <input type="hidden" id="idProveedor" name="idProveedor">
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" min="0" class="form-control input-lg" name="editarRUC" id="editarRUC" onKeyPress="if(this.value.length==11) return false;" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="editarEmail" maxlength="50" id="editarEmail" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="editarTelefono" maxlength="10" id="editarTelefono" required>
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDireccion" maxlength="60" id="editarDireccion"  required>
              </div>
            </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
             <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="editarContacto" id="editarContacto" maxlength="60" placeholder="Ingresar Contacto" required>
              </div>
            </div>

            </div>
            <!-- ENTRADA PARA EL TELÉFONO DEL CONTACTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="editarTelefonoContacto" id="editarTelefonoContacto" maxlength="10" placeholder="Ingresar teléfono Contacto" required>
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
      </form>
      <?php
        $editarProveedor = new ControladorProveedores();
        $editarProveedor -> ctrEditarProveedor();
      ?>
    </div>
  </div>
</div>

<?php
  $eliminarProveedor = new ControladorProveedores();
  $eliminarProveedor -> ctrEliminarProveedor();
?>