<div class="content-wrapper">
    <section class="content-header">
        <h1>Ver compra</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Ver compra</li>
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
                    <form role="form" method="post" class="formularioVenta">
                        <div class="box-body">
                            <div class="box">
                                <?php
                                $item = "id";
                                $valor = $_GET["idVenta"];
                                //$venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                                $venta = ControladorCompras::ctrMostrarCabeceraCompras($valor);
                                //$itemUsuario = "id";
                                //$valorUsuario = $venta["id_vendedor"];
                                //$vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                                //$itemCliente = "id";
                                //$valorCliente = $venta["id_cliente"];
                                //$cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                                //$porcentajeImpuesto = $venta["impuesto"] * 100 / $venta["neto"];
                                ?>
                                <!--=====================================
                                ENTRADA DEL VENDEDOR
                                ======================================-->
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <label for="vendedor">Comprador</label>
                                                <!-- <span class="input-group-addon"><i class="fa fa-user"></i></span>   -->
                                                <input type="text" class="form-control" id="vendedor" value="<?php echo $venta["vendedor"]; ?>" readonly>
                                                <input type="hidden" name="idVendedor" value="<?php echo $venta["id_vendedor"]; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <!--<span class="input-group-addon"><i class="fa fa-users"></i></span> -->
                                                <label for="cliente">Proveedor</label>
                                                <input type="text" class="form-control" id="cliente" value="<?php echo $venta["cliente"]; ?>" readonly>
                                                <input type="hidden" name="idCliente" value="<?php echo $venta["id_cliente"]; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <label for="metodo">Método Pago</label>
                                                <input type="text" class="form-control" id="metodo" value="<?php echo $venta["nombrePago"]; ?>" readonly>
                                                <input type="hidden" name="idMetodoPago" value="<?php echo $venta["metodo_pago"]; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <label for="metodo">Numero Factura</label>
                                                <input type="text" class="form-control" id="metodo" value="<?php echo $venta["nrofactura"]; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--=====================================
                                ENTRADA DEL CÓDIGO
                                ======================================-->
                                <!--<div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $venta["codigo"]; ?>" readonly>
                  </div>
                </div> -->
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
                                                            <th>Precio Unitario</th>
                                                            <th>Precio Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $listaProducto = json_decode($venta["productos"], true);
                                                        $contador=1;
                                                        foreach ($listaProducto as $key => $value) {
                                                            $item = "id";
                                                            $valor = $value["id"];
                                                            $orden = "id";
                                                            echo '<tr><td>'.$contador . '</td><td>'. $valor . '</td><td>'.$value["descripcion"].'</td>
                                    <td>' . $value["cantidad"] . '</td><td>' . $value["precio"] . '</td><td>' . $value["total"] . '</td></tr>';
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
                                <!--=====================================
                                BOTÓN PARA AGREGAR PRODUCTO
                                ======================================-->
                                <div class="row">
                                    <!--=====================================
                                    ENTRADA IMPUESTOS Y TOTAL
                                    ======================================-->
                                    <div class="col-xs-8 pull-right">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width: 50%">
                                                    <div class="input-group">

                                                    </div>
                                                </td>
                                                <td style="width: 50%">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                        <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta["neto"]; ?>"  value="<?php echo $venta["total"]; ?>" readonly required>
                                                        <input type="hidden" name="totalVenta" value="<?php echo $venta["total"]; ?>" id="totalVenta">
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <br>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a  href="ventas" class="btn btn-primary pull-right">Cerrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>