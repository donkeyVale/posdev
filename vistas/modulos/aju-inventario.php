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
    <h1>Ajustes de Inventario</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-barcode"></i> Inicio</a></li>
      <li class="active">Ajustes de Inventario</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
      <!--=====================================
      SELECCIONAR DEPOSITO
      ======================================-->
      <div class="col-md-12" position=relative>
          <div class="input-group">
            <label for="cmbdeposito">Depósito</label>
            <select class="form-control" id="cmbdepositoProducto_aju" name="cmbdepositoProducto_aju" required>
                <?php

                  $depositos = ControladorCompras::ctrListarDepositos();
                  foreach ($depositos as $key => $value) {
                    $condicional="";
                    if($_GET["cmbdepositoProducto"]==$value["id"])
                    {
                      $condicional = "selected";
                    }
                    else  
                    {
                      $condicional="";
                    }
                    echo '<option value="'.$value["id"].'" ' . $condicional . '>'.$value["deposito"].'</option>';
                  }
                ?>
            </select>
          </div>
        </div>
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
              <th>Existencia</th>
              <th>Unidad</th>
              <th>Tipo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if(isset($_GET["cmbdepositoProducto"])){
              $idDeposito = $_GET["cmbdepositoProducto"];
            }else{
              $idDeposito = 1;
            }
            $productos = ControladorProductos::ctrListarProductosDepositos($idDeposito);
            //$productos = ControladorProductos::ctrListarProductos();
            foreach ($productos as $key => $value) {
              echo '<tr>
                      <td>'.($key+1).'</td>
                      <td><img src="'.$value["imagen"].'" style="width:30px; height:30px;" class="img-circle"></td>
                      <td>'.$value["codigo"].'</td>
                      <td>'.$value["descripcion"].'</td>
                      <td>'.$value["categoria"].'</td>
                      <td> Gs. '.number_format($value["precio_compra"], 2, '.', ',').'</td>
                      <td> Gs. '.number_format($value["precio_venta"], 2, '.', ',').'</td>             
                      <td>'.$value["stock"].'</td>
                      <td>'.$value["unidad"].'</td>
                      <td>'.$value["nombre"].'</td>
                      <td>
                        <div class="btn-group">  
                          <button class="btn btn-warning btnAjusteInv" data-toggle="modal" data-target="#modalAgregarExi" idDeposito="'.$idDeposito.'" idProducto="'.$value["id"].'"><i class="	fa fa-plus-square"></i></button>';

                            if($_SESSION["perfil"] == "Administrador"){
                                echo '<button class="btn btn-success btnAjusteInvHistorico" id_producto="'.$value["id"].'" id_stock="'.$value["id_stock"].'"><i class="fa fa-building"></i></button>';
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
MODAL AJUSTE DE INVENTARIO
======================================-->
<div id="modalAgregarExi" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ajustar Existencia de Producto</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">

          <div class="form-group row">  
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" placeholder="Nombre Producto" required readonly>
                <input type="hidden" id="idProducto" name="idProducto">
              </div>
            </div>
            
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                  <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" placeholder="Código" required readonly>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <select class="form-control input-lg" id="editarCategoria" name="editarCategoria" required disabled>
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
            
            <!-- ENTRADA PARA LA MARCA -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <select class="form-control input-lg" id="editarMarca" name="editarMarca" required disabled>
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
                  <select class="form-control input-lg" id="editarUnidad" name="editarUnidad" disabled required>
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
            
            <!-- ENTRADA PARA PRECIO DE COMPRA/VENTA -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                    <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" placeholder="Precio de compra" readonly required>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" step="0.01" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" placeholder="Precio de venta" readonly required>
                </div>
              </div>
            </div>

            <!-- ENTRADA PARA FECHA DE VENCIMIENTO -->
            <div class="form-group row">
              <!--
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <input type="number" class="form-control input-lg" name="editarStock" id="editarStock" min="0" placeholder="Stock" required>
                </div>
              </div>
              -->
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                  <input type="date" class="form-control input-lg" name="editarFechaVencimiento" id="editarFechaVencimiento" readonly placeholder="Fecha Vencimiento">
                </div>
              </div>
            </div>
            
            <!-- ENTRADA PARA TIPO DE PRODUCTO -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <select class="form-control input-lg" id="editarTipoProducto" name="editarTipoProducto" disabled required>
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
                  <select class="form-control input-lg" disabled id="editarImpuesto" name="editarImpuesto" disabled required>
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
            
            <!-- ENTRADA PARA CANTIDAD DE ALERTA -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <input title="Existencia Alerta" type="number" class="form-control input-lg" name="editarCantidadAlerta" id="editarCantidadAlerta" min="0" placeholder="Cantidad Alerta" readonly required>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <select class="form-control input-lg" id="editarStockCritico" name="editarStockCritico" disabled required>
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

            <!-- ENTRADA AJUSTE DE INVENTARIO -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <input title="Existencia Actual" type="number" class="form-control input-lg" name="editarStock" id="editarStock" min="0" placeholder="Cantidad Existencia" readonly required>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <input title="Cantidad a Ajustar" type="number" class="form-control input-lg" name="cantidadAjuste" id="cantidadAjuste" min="0" placeholder="Cantidad a Ajustar" required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <textarea name="txtNota" id="txtNota" class="form-control input-lg" rows="4" placeholder="Escriba una nota" required></textarea>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="button" class="btn btn-primary" name="btnAgregarStock" id="btnAgregarStock">Guardar cambios</button>
          <input type="hidden" name="idDeposito" id="idDeposito" value="<?php echo $idDeposito; ?>">
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario']; ?>">
        </div>
      </form>
      <?php

        //if (isset($_POST['cantidadAjuste']) && isset($_POST['idDeposito']) && isset($_POST['idProducto']) && $_SESSION["stock_update"]){
          //ControladorProductos::ctrActualizarProductoStock($_POST['idDeposito'], $_POST['idProducto'], $_POST['cantidadAjuste']);
          //$_SESSION["stock_update"] = true;
        //}

      ?>
    </div>
  </div>
</div>
