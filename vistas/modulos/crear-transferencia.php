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

    <h1>Crear Transferencia</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Transferencia</li>
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
            <form role="form" method="post" class="formularioTransferencia">
              <div class="box-body">
                <div class="box">
                  <!--=====================================
                  ENTRADA DEL USUARIO
                  ======================================-->
                  <div class="form-group">
                    <div class="input-group">
                      <label for="nuevoUsuario">Usuario Transferencia</label>
                      <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                      <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="nuevaTransferencia" id="nuevaTransferencia" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <div class="input-group">
                        <label for="cmbdepositoTransferenciaOrigen">Depósito Origen</label>
                        <select class="form-control" id="cmbdepositoTransferenciaOrigen" name="cmbdepositoTransferenciaOrigen" required>
                            <?php
                              $depositos = ControladorCompras::ctrListarDepositos();
                              foreach ($depositos as $key => $value) {
                                $condicional="";
                                if($_GET["cmbdepositoTransferenciaOrigen"]==$value["id"])
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
                  <!--=====================================
                  ENTRADA DEL DEPOSITO DESTINO
                  ======================================--> 
                  <div class="form-group">
                    <div class="input-group">
                    <label for="seleccionarDepositoDestino">Depósito Destino</label>
                      <select class="form-control" id="seleccionarDepositoDestino" name="seleccionarDepositoDestino" required>
                          <?php
                            $depositosDestino = ControladorCompras::ctrListarDepositos();
                            foreach ($depositosDestino as $key2 => $value2) {
                              $condicional2="";
                                if($_GET["seleccionarDepositoDestino"]==$value2["id"])
                                {
                                  $condicional2 = "selected";
                                }
                                else  
                                {
                                  $condicional2="";
                                }
                                echo '<option value="'.$value2["id"].'" ' . $condicional2 .'>'.$value2["deposito"].'</option>';
                            }
                          ?>
                      </select>

                    </div>
                  </div>
                  <!--=====================================
                  ENTRADA PARA AGREGAR PRODUCTO
                  ======================================--> 
                  <div class="row" style="padding:5px 15px">
                    <div class="col-xs-5" style="padding-right:0px">Producto</div>
                    <div class="col-xs-2">Cantidad</div>
                  </div>
                  <div class="form-group row nuevoProducto">
                    
                  </div>
                  <input type="hidden" id="listaProductosTransferencia" name="listaProductosTransferencia">
                  <!--=====================================
                  BOTÓN PARA AGREGAR PRODUCTO
                  ======================================-->
                  <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                  <hr>
                  <br>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary pull-right">Guardar Transferencia</button>
              </div>
              <?php
              $guardarTransferencia = new ControladorTransferencias();
              $guardarTransferencia -> ctrCrearTransferencia();
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
              <table class="table table-bordered table-striped dt-responsive tablaTransferencias">    
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 50px">Imagen</th>
                    <th>Código</th>
                    <th>Descripcion</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($_GET["cmbdepositoTransferenciaOrigen"])){
                      $idDeposito = $_GET["cmbdepositoTransferenciaOrigen"];
                    }else{
                      $idDeposito = 1;
                    }
                    $productos = ControladorProductos::ctrListarProductosDepositos($idDeposito);
                    foreach ($productos as $key => $value) {

                      if($value["stock"] <= 10){
                          $stock = "<button class='btn btn-danger'>".$value["stock"]."</button>";
                      }else if($value["stock"] > 11 && $value["stock"] <= 15){
                          $stock = "<button class='btn btn-warning'>".$value["stock"]."</button>";
                      }else{
                          $stock = "<button class='btn btn-success'>".$value["stock"]."</button>";
                      }
                      
                      $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$value["id"]."' idDeposito='".$idDeposito."'>Agregar</button></div>";

                      echo '<tr>
                              <td>'.($key+1).'</td>
                              <td><img src="'.$value["imagen"].'" style="width:30px; height:30px;" class="img-circle"></td>
                              <td>'.$value["codigo"].'</td>
                              <td>'.$value["descripcion"].'</td>          
                              <td>'.$stock.'</td>
                              <td>'.$botones.'</td>
                            </tr>';
                      }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> 
    </section>
  </section>