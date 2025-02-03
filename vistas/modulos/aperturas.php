<div class="content-wrapper">

  <section class="content-header">
	  <h1>Apertura de Cajas</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Apertura de caja</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAperturarCaja">
          Aperturar Caja
        </button>
      </div>

      <div class="box-body">        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Sucursal</th>
           <th>Caja</th>
           <th>Usuario Apertura</th>
           <th>Fecha Apertura</th>
           <th>Monto Apertura</th>
           <th>Fecha Cierre</th> 
           <th>Monto Cierre</th>
           <th>Estado</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $aperturas = ControladorAperturas::ctrMostrarAperturasUsuario();
          foreach ($aperturas as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["sucursal"].'</td>
                    <td>'.$value["cajas"].'</td>
                    <td>'.$value["usuario"].'</td>
                    <td>'.date("d-m-Y H:i:s", strtotime($value["fechaapertura"]) ).'</td>
                    <td> Gs. '.number_format($value["monto_apertura"], 2, '.', ',').'</td>
                    <td>'.date("d-m-Y H:i:s", strtotime($value["fechacierre"]) ).'</td>             
                    <td> Gs. '.number_format($value["monto_cierre"], 2, '.', ',').'</td>
                    <td>'.$value["estado"].'</td>
                    <td>
                      <div class="btn-group">  
                        <button class="btn btn-success btnCerrarCaja" data-toggle="modal" data-target="#modalCerrarCaja" idApertura="'.$value["id"].'"><i class="fa fa-lock"></i></button>';
                        if($_SESSION["perfil"] == "Administrador"){
                          echo '<button class="btn btn-danger btnEliminarCaja" idApertura="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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

<div id="modalAperturarCaja" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Aperturar Caja</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                    <select class="form-control input-lg" id="seleccionSucursal" name="seleccionSucursal">
                      <option value="0">--Seleccione Sucursal--</option>
                      <?php
                          $item = null;
                          $valor = null;
                          $grupos = ControladorAperturas::ctrMostrarSucursales();
                          foreach ($grupos as $key => $value) {
                            echo '<option value="'.$value["id"].'">'.$value["sucursal"].'</option>';
                            }
                      ?>
                    </select>
                </div>
              </div>
              
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                    <select class="form-control input-lg" id="caja" name="caja">
                        <option value="0">--Seleccione Caja--</option>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                  <input type="number" step="0.01" class="form-control input-lg" name="monto_caja" id="monto_caja" placeholder="Ingrese el monto de la caja"  required>
                </div>
              </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Aperturar</button>
        </div>
      </form>
      <?php
        $crearApertura = new ControladorAperturas();
        $crearApertura -> ctrAperturarCajaUsuario();
      ?>
    </div>
  </div>
</div>

<div id="modalCerrarCaja" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cerrar Caja</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                    <input type="text" class="form-control input-lg" name="nombreSucursal" id="nombreSucursal" placeholder="Ingrese Sucursal"  required>
                    <input type="hidden" id="idApertura" name="idApertura">
                </div>
              </div>
              
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                    <input type="text" class="form-control input-lg" name="nombreCaja" id="nombreCaja" placeholder="Ingrese Caja"  required>
                </div>
              </div>
              
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span> 
                  <input type="text" class="form-control input-lg" name="fechaApertura" id="fechaApertura" placeholder="Fecha Apertura"  required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                  <input type="number" step="0.01" class="form-control input-lg" name="montoApertura" id="montoApertura" placeholder="Ingrese el monto de la caja"  required>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                  <input type="number" step="0.01" class="form-control input-lg" name="montoCierre" id="montoCierre" placeholder="Ingrese el monto de cierre"  required>
                </div>
              </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" id="btnCerrar" name="btnCerrar" class="btn btn-primary">Cerrar Caja</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php
  $eliminarCajaAperturada = new ControladorAperturas();
  $eliminarCajaAperturada -> ctrEliminarCajaAperturada();
?>