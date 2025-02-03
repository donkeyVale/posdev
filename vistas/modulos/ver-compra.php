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
                                $valor = $_GET["idCompra"];
                                $compra = ControladorCompras::ctrMostrarCabeceraCompras($valor);
                                ?>
                                <!--=====================================
                                ENTRADA DEL VENDEDOR
                                ======================================-->
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="fechaCompra">Fecha Compra</label>
                                                <input type="text" class="form-control" id="fechaCompra" name="fechaCompra" value="<?php echo date("d-m-Y", strtotime($compra["fechacompra"]) ) ; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="proveedor">Proveedor</label>
                                                <input type="text" class="form-control" id="proveedor" value="<?php echo $compra["proveedor"]; ?>" readonly>
                                                <input type="hidden" name="idProveedor" value="<?php echo $compra["id_proveedor"]; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="comprador">Comprador</label>
                                                <input type="text" class="form-control" id="comprador" value="<?php echo $compra["comprador"]; ?>" readonly>
                                                <input type="hidden" name="idComprador" value="<?php echo $compra["usuariocreacion"]; ?>">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="factura">Numero Factura</label>
                                                <input type="text" class="form-control" id="factura" value="<?php echo $compra["nrofactura"]; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="metodo">Método Pago</label>
                                                <input type="text" class="form-control" id="metodo" value="<?php echo $compra["nombrePago"]; ?>" readonly>
                                                <input type="hidden" name="idTipoCompra" value="<?php echo $compra["id_tipo_compra"]; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="input-group">
                                            <label for="referencia">Referencia</label>
                                            <input type="text" class="form-control" id="referencia" value="<?php echo $compra["referencia"]; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <label for="deposito">Depósito</label>
                                                <input type="text" class="form-control" id="deposito" value="<?php echo $compra["deposito"]; ?>" readonly>
                                                <input type="hidden" name="idDeposito" value="<?php echo $compra["id_deposito"]; ?>">
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
                                                            <th>Precio Unitario</th>
                                                            <th>Precio Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $listaProducto = json_decode($compra["productos"], true);
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
                                                        <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $compra["neto"]; ?>"  value="<?php echo $compra["total"]; ?>" readonly>
                                                        <input type="hidden" name="totalVenta" value="<?php echo $compra["total"]; ?>" id="totalVenta">
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
                            <a  href="compras" class="btn btn-primary pull-right">Cerrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
