<div class="content-wrapper">
  <section class="content-header">
    <h1>Ver Transferencia</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Ver Transferencia</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-md-12 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioTransferencia">
            <div class="box-body">
              <div class="box">
                <?php
                    $item = "id";
                    $valor = $_GET["idTransferencia"];
                    $transferencia = ControladorTransferencias::ctrMostrarCabeceraTransferencia($valor);
                ?>
                <!--=====================================
                ENTRADA DE LA TRANSFERENCIA
                ======================================-->
                <div class="row">
                  <div class="form-group">
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="codigoTransferencia">Nro Transferencia</label>
                        <input type="text" class="form-control" id="codigoTransferencia" value="<?php echo $transferencia["id"]; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="fechaTransferencia">Fecha Transferencia</label>
                        <input type="text" class="form-control" id="fechaTransferencia" value="<?php echo $transferencia["fecha_registro"]; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="estadoTransferencia">Estado</label>
                        <input type="text" class="form-control" id="estadoTransferencia" value="<?php echo $transferencia["nombre_estado"]; ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group">
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="usuarioTransferencia">Usuario Transferencia</label>
                        <input type="text" class="form-control" id="usuarioTransferencia" value="<?php echo $transferencia["usuario_transferencia"]; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="depositoOrigen">Depósito Origen</label>
                        <input type="text" class="form-control" id="depositoOrigen" value="<?php echo $transferencia["deposito_origen"]; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <label for="depositoDestino">Depósito Destino</label>
                        <input type="text" class="form-control" id="depositoDestino" value="<?php echo $transferencia["deposito_destino"]; ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                </br>
                <div class="row">
                  <div class="form-group">
                    <div class="col-md-12">
                      <div class="box box-warning">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                          <table class="table table-bordered table-striped dt-responsive">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>Código</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                              $listaProducto = json_decode($transferencia["productos"], true);
                              $contador=1;
                              foreach ($listaProducto as $key => $value) {
                                $item = "id";
                                $valor = $value["id"];
                                $orden = "id";
                                echo '<tr><td>'.$contador . '</td><td>'. $valor . '</td><td>'.$value["descripcion"].'</td>
                                    <td>' . $value["cantidad"] . '</td></tr>';
                              }
                            ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
                
                <input type="hidden" id="listaProductos" name="listaProductos">

                <hr>
                <br>
              </div>
          </div>
          <div class="box-footer">
            <a  href="transferencias" class="btn btn-primary pull-right">Cerrar</a>
          </div>
        </form>
        </div>  
      </div>
    </div>
  </section>
</div>