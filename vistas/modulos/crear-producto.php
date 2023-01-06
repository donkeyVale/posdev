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
            <h1>Administrar productos hijos</h1>
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-barcode"></i> Inicio</a></li>
                <li class="active">Administrar productos hijos</li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
                        Agregar producto
                    </button>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Imagen</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $productos = ControladorProductos::ctrListarProductosHijos();
                        foreach ($productos as $key => $value) {
                            echo '<tr>
                      <td>'.($key+1).'</td>
                      <td><img src="'.$value["imagen"].'" style="width:30px; height:30px;" class="img-circle"></td>
                      <td>'.$value["codigo"].'</td>
                      <td>'.$value["descripcion"].'</td>
                      <td>'.$value["categoria"].'</td>
                      <td>'.$value["precio_compra"].'</td>
                      <td>'.$value["precio_venta"].'</td>             
                      <td>'.$value["stock"].'</td>
                      <td>'.$value["unidad"].'</td>
                      <td>'.$value["nombre"].'</td>
                      <td>
                        <div class="btn-group">  
                          <button class="btn btn-warning btnEditarProducto" data-toggle="modal" data-target="#modalEditarProducto" idProducto="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';
                            if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-danger btnEliminarProductoHijo" idProducto="'.$value["id"].'" ProductoPadre="'. $_GET['idProductoPadre'] .'"><i class="fa fa-times"></i></button>';
                            }
                            echo '</div>  
                      </td>
                    </tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
                </div>
            </div>
        </section>
    </div>

    <!--=====================================
    MODAL AGREGAR PRODUCTO
    ======================================-->
    <div id="modalAgregarProducto" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" enctype="multipart/form-data">
                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->
                    <div class="modal-header" style="background:#3c8dbc; color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar producto</h4>
                    </div>
                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
                            <div class="form-group row">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                    <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Nombre Producto" required>
                                    <input type="hidden" class="form-control input-lg" name="product_id" value="<?php echo $_GET['idProductoPadre']; ?>">
                                </div>
                            </div>

                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                        <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Código" readonly required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                                            foreach ($categorias as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevaMarca" name="nuevaMarca" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
                                            foreach ($marcas as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombremarca"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevaUnidad" name="nuevaUnidad" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor);
                                            foreach ($unidades as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["unidad"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                        <input type="number" step="0.01" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" step="any" min="0" placeholder="Precio de compra" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                        <input type="number" step="0.01" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <!--              <div class="col-xs-6">-->
                                <!--                <div class="input-group">-->
                                <!--                  <span class="input-group-addon"><i class="fa fa-check"></i></span> -->
                                <!--                  <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock" required>-->
                                <!--                </div>-->
                                <!--              </div>-->
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" class="form-control input-lg" name="nuevaFechaVencimiento" placeholder="Fecha Vencimiento"  required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevoTipoProducto" name="nuevoTipoProducto" required>
                                            <?php
                                            $tipoProductos = ControladorProductos::ctrMostrarTipoProductos();
                                            foreach ($tipoProductos as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevoImpuesto" name="nuevoImpuesto" required>
                                            <?php
                                            $tipoImpuestos = ControladorProductos::ctrMostrarTipoImpuestos();
                                            foreach ($tipoImpuestos as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                        <input type="number" class="form-control input-lg" name="nuevaCantidadAlerta" min="0" placeholder="Cantidad Alerta" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="nuevoStockCritico" name="nuevoStockCritico" required>
                                            <?php
                                            $stockCritico = ControladorProductos::ctrMostrarStockCritico();
                                            foreach ($stockCritico as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="nuevaImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                            </div>
                        </div>
                    </div>
                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Guardar producto</button>
                    </div>
                </form>
                <?php
                $crearProducto = new ControladorProductos();
                $crearProducto -> ctrCrearProductosHijos();
                ?>
            </div>
        </div>
    </div>

    <!--=====================================
    MODAL EDITAR PRODUCTO
    ======================================-->
    <div id="modalEditarProducto" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" enctype="multipart/form-data">
                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->
                    <div class="modal-header" style="background:#3c8dbc; color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar producto</h4>
                    </div>
                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="form-group row">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                    <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" placeholder="Nombre Producto" required>
                                    <input type="hidden" id="idProducto" name="idProducto">
                                    <input type="hidden" class="form-control input-lg" name="product_id" value="<?php echo $_GET['idProductoPadre']; ?>">
                                </div>
                            </div>

                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                        <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" placeholder="Código" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarCategoria" name="editarCategoria" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                                            foreach ($categorias as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarMarca" name="editarMarca" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
                                            foreach ($marcas as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombremarca"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarUnidad" name="editarUnidad" required>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor);
                                            foreach ($unidades as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["unidad"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                        <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" placeholder="Precio de compra" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                        <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <!--              <div class="col-xs-6">-->
                                <!--                <div class="input-group">-->
                                <!--                  <span class="input-group-addon"><i class="fa fa-check"></i></span> -->
                                <!--                  <input type="number" class="form-control input-lg" name="editarStock" id="editarStock" min="0" placeholder="Stock" required>-->
                                <!--                </div>-->
                                <!--              </div>-->
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" class="form-control input-lg" name="editarFechaVencimiento" id="editarFechaVencimiento" placeholder="Fecha Vencimiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarTipoProducto" name="editarTipoProducto" required>
                                            <?php
                                            $tipoProductos = ControladorProductos::ctrMostrarTipoProductos();
                                            foreach ($tipoProductos as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarImpuesto" name="editarImpuesto" required>
                                            <?php
                                            $tipoImpuestos = ControladorProductos::ctrMostrarTipoImpuestos();
                                            foreach ($tipoImpuestos as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                        <input type="number" class="form-control input-lg" name="editarCantidadAlerta" id="editarCantidadAlerta" min="0" placeholder="Cantidad Alerta" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        <select class="form-control input-lg" id="editarStockCritico" name="editarStockCritico" required>
                                            <?php
                                            $stockCritico = ControladorProductos::ctrMostrarStockCritico();
                                            foreach ($stockCritico as $key => $value) {
                                                echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="editarImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                                <input type="hidden" name="imagenActual" id="imagenActual">
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
                $editarProducto = new ControladorProductos();
                $editarProducto -> ctrEditarProductoHijo();
                ?>
            </div>
        </div>
    </div>
<?php
$eliminarProducto = new ControladorProductos();
$eliminarProducto->ctrEliminarProductoHijo();
?>