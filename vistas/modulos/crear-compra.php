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
    <h1>Crear Compra</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Compra</li>
    </ol>

  <section class="content">
    <section class="content-header">
      <div class="row">
        <!--=====================================
        EL FORMULARIO
        ======================================-->
        <div class="col-lg-5 col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border"></div>
            <form role="form" method="post" class="formularioCompra">
              <div class="box-body">
                <div class="box">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="hidden" name="nuevaCompra" id="nuevaCompra" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div> 
                  <!--=====================================
                  ENTRADA DEL VENDEDOR
                  ======================================-->
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <div class="input-group">
                          <label for="fechaCompra">Fecha Compra</label>
                          <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" value="<?php echo date("m/d/Y"); ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group">
                          <label for="referencia">Referencia</label>
                          <input type="text" class="form-control" id="referencia" name="referencia" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <div class="input-group">
                          <label for="nroFactura">Nro.Factura</label>
                          <input type="text" class="form-control" id="nroFactura" name="nroFactura" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group">
                          <label for="cmbdeposito">Depósito</label>
                          <select class="form-control" id="cmbdeposito" name="cmbdeposito" required>
                              <?php
                                $depositos = ControladorCompras::ctrListarDepositos();
                                foreach ($depositos as $key => $value) {
                                  echo '<option value="'.$value["id"].'">'.$value["deposito"].'</option>';
                                }
                              ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                   
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <div class="input-group">
                          <label for="cmbTipoCompra">Tipo de Compra</label>
                          <select class="form-control" id="cmbTipoCompra" name="cmbTipoCompra" required>
                              <?php
                                $tiposCompras = ControladorCompras::ctrListarTipoCompras();
                                foreach ($tiposCompras as $key => $value) {
                                  echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                                }
                              ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <br/>
                  <div class="row">
                   <div class="form-group">
                     <div class="col-md-7">
                        <span class="input-group-addon">
                          <label for="seleccionarProveedor">Proveedores</label>
                          <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>
                            <option value="0">Seleccionar Proveedor</option>
                              <?php
                                $item = null;
                                $valor = null;
                                $proveedores = ControladorCompras::ctrMostrarProveedores($item, $valor);
                                foreach ($proveedores as $key => $value) {
                                  echo '<option value="'.$value["id"].'">'.$value["nombre"].' ('.$value["ruc"] .')</option>';
                                }
                              ?>
                          </select>
                          
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProveedor" data-dismiss="modal">Nuevo Proveedor</button>
                          
                        </span>
                     </div>

                   </div>
                  </div>
                  
                  <br/>
                  <!--=====================================
                  ENTRADA PARA AGREGAR PRODUCTO
                  ======================================--> 
                  <div class="row" style="padding:5px 15px">
                    <div class="col-xs-5" style="padding-right:0px">Producto</div>
                    <div class="col-xs-2 ingresoPrecio" style="padding-left:0px">Precio</div>
                    <div class="col-xs-2 ingresoCantidad">Cantidad</div>
                    <div class="col-xs-3">SubTotal</div>
                  </div>
                  <div class="form-group row nuevoProducto">
                  </div>
                  <input type="hidden" id="listaProductos" name="listaProductos">
                  <!--=====================================
                  BOTÓN PARA AGREGAR PRODUCTO
                  ======================================-->
                  <div class="row">
                    <!--=====================================
                    ENTRADA IMPUESTOS Y TOTAL
                    ======================================-->
                    <div class="col-xs-12 pull-right">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Descuento</th>
                            <th>Impuesto</th>
                            <th>Total</th>      
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="input-group">
                                <input type="text" class="form-control input-lg" min="0" id="nuevoDescuento" name="nuevoDescuento" placeholder="0">
                              </div>
                            </td>
                            <td>
                              <div class="input-group">
                                <input type="text" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0">
                                <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
                                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                              </div>
                            </td>
                            <td>  
                              <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>
                                <input type="hidden" name="totalVenta" id="totalVenta">
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <hr>
                  <!--=====================================
                  ENTRADA MÉTODO DE PAGO
                  ======================================-->
                  <div class="form-group row">
                    <div class="col-md-11" style="padding-right:0px">
                        <div class="form-group">
                          <label for="notaCompra">Notas</label>
                          <textarea class="form-control" name="notaCompra" id="notaCompra" rows="3"></textarea>
                        </div>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary pull-right">Guardar Compra</button>
              </div>
              <?php
              $guardarCompra = new ControladorCompras();
              $guardarCompra -> ctrCrearCompra();
              ?>
            </form>
          </div>      
        </div>
        <!--=====================================
        LA TABLA DE PRODUCTOS
        ======================================-->
        <div class="col-lg-7 hidden-md hidden-sm hidden-xs">    
          <div class="box box-warning">
            <div class="box-header with-border"></div>
            <div class="box-body">    
              <table class="table table-bordered table-striped dt-responsive tablaCompras">    
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Imagen</th>
                    <th>Código</th>
                    <th>Precio Compra</th>
                    <th>Descripcion</th>
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
                <input type="email" class="form-control input-lg" name="nuevoEmail" maxlength="50" placeholder="Ingresar email" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoTelefono" maxlength="10" placeholder="Ingresar teléfono" required>
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

  <script type="text/javascript">
    $('#seleccionarProveedor').select2();
    $("#nuevoPrecioProducto").number(true, 2);
    $("#nuevoImpuestoVenta").number(true, 2);

    //$("#fechaCompra").datepicker();
    //$("#fechaCompra").datepicker("option", "dateFormat", 'dd/mm/yy');
    //$( "#fechaCompra" ).datepicker({
    //  dateFormat: "dd/mm/yy"
    //});
  </script>