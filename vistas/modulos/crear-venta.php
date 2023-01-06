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
    <?php $validaCaja = new ControladorVentas();
    $validarCaja=$validaCaja->consultaCajaAbierta();
    if($validarCaja!="0"){
      $cajaAperturada=$validaCaja->obtenerCajaAbiertaUsuario();
    ?>
    <h1>Crear venta</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear venta</li>
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
            <form role="form" method="post" class="formularioVenta">
              <div class="box-body">
                <div class="box">
                  <!--=====================================
                  ENTRADA DEL VENDEDOR
                  ======================================-->
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="nuevaVenta" id="nuevaVenta" value="<?php echo $cajaAperturada; ?>">
                    </div>
                  </div> 
                  <!--=====================================
                  ENTRADA DEL CLIENTE
                  ======================================--> 
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                        <option value="0">Seleccionar cliente</option>
                          <?php
                            $item = null;
                            $valor = null;
                            $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);
                            foreach ($categorias as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["nombre"].' ('.$value["documento"] .')</option>';
                            }
                          ?>
                      </select>
                      <span class="input-group-addon">
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button>
                      </span>
                    </div>
                  </div>
                  <!--=====================================
                  ENTRADA PARA AGREGAR PRODUCTO
                  ======================================--> 
                  <div class="row" style="padding:5px 15px">
                    <div class="col-xs-5" style="padding-right:0px">Producto</div>
                    <div class="col-xs-2 ingresoPrecio" style="padding-left:0px">Precio</div>
                    <div class="col-xs-2">Cantidad</div>
                    <div class="col-xs-3">SubTotal</div>
                  </div>
                  <div class="form-group row nuevoProducto">
                  </div>
                  <input type="hidden" id="listaProductos" name="listaProductos">
                  <!--=====================================
                  BOTÓN PARA AGREGAR PRODUCTO
                  ======================================-->
                  <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
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
                                <input type="number" class="form-control input-lg" min="0" id="nuevoDescuento" name="nuevoDescuento" placeholder="0">
                              </div>
                            </td>
                            <td>
                              <div class="input-group">
                                <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0">
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
                    <div class="col-xs-6" style="padding-right:0px">
                      <div class="input-group">
                        <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                          <option value="0">Seleccione método de pago</option>
                          <?php
                            $formas = ControladorVentas::ctrMostrarFormasPago();
                            foreach ($formas as $key => $value) {
                              echo '<option value="'.$value["codigo"].'">'.$value["nombre"].'</option>';
                            }
                          ?>                 
                        </select>    
                      </div>
                    </div>
                    <div class="cajasMetodoPago"></div>
                    <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                  </div>
                  <br>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary pull-right">Guardar venta</button>
              </div>
              <?php
              $guardarVenta = new ControladorVentas();
              $guardarVenta -> ctrCrearVenta();
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
              <table class="table table-bordered table-striped dt-responsive tablaVentas">    
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Imagen</th>
                    <th>Código</th>
                    <th>Descripcion</th>
                    <th>Stock</th>
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
  MODAL AGREGAR CLIENTE
  ======================================-->
  <div id="modalAgregarCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar cliente</h4>
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
                  <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL DOCUMENTO ID -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                  <input type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar cédula o RUC" onKeyPress="if(this.value.length==11) return false;" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL EMAIL -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                  <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL TELÉFONO -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoTelefono" maxlength="10" placeholder="Ingresar teléfono" >
                </div>
              </div>
              <!-- ENTRADA PARA LA DIRECCIÓN -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección">
                </div>
              </div>
              <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento">
                </div>
              </div>  
            </div>
          </div>
          <!--=====================================
          PIE DEL MODAL
          ======================================-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar cliente</button>
          </div>
        </form>
        <?php
          $crearCliente = new ControladorClientes();
          $crearCliente -> ctrCrearClienteVenta();
        ?>
      </div>
    </div>
  </div>

  <?php }else{ ?>

  <div class="content-wrapper">
    <div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
      Usted no cuenta con una caja aperturada, por lo tanto no puede registrar una venta!
    </div>
    <section class="content-header">
      <h1>Crear venta</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Crear venta</li>
      </ol>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="ventas">
            <button class="btn btn-primary">Regresar</button>
          </a>
        </div>
      </div>
    </section>
  </div>
  <?php } ?>
  <script type="text/javascript">
    $('#seleccionarCliente').select2();
  </script>