<?php
  if($_SESSION["perfil"] == "Especial"){
    echo '<script>
      window.location = "inicio";
      </script>';
    return;
  }

  $xml = ControladorVentas::ctrDescargarXML();
  if($xml){
    rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");
    echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';
  }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar ventas</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar ventas</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-venta">
          <button class="btn btn-primary">Agregar venta</button>
        </a>
        <button type="button" class="btn btn-default pull-right" id="daterange-btn">   
          <span>
            <i class="fa fa-calendar"></i> 
              <?php
                if(isset($_GET["fechaInicial"])){
                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                }else{
                  echo 'Rango de fecha';
                }
              ?>
          </span>
          <i class="fa fa-caret-down"></i>
        </button>

        <?php if($_SESSION["perfil"] == "Administrador"){ ?> 
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalEstablecerCuotas">Establecer Cuotas</button>
        <?php } ?>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%"> 
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Código</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Forma de pago</th>
              <th>Neto</th>
              <th>Total</th> 
              <th>Fecha</th>
              <th>Acciones</th>
            </tr> 
          </thead>
          <tbody>
            <?php
              if(isset($_GET["fechaInicial"])){
                $fechaInicial = $_GET["fechaInicial"];
                $fechaFinal = $_GET["fechaFinal"];
              }else{
                $fechaInicial = null;
                $fechaFinal = null;
              }
              //$respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);
              $contador=1;
              $respuesta = ControladorVentas::ctrListarVentasUsuario($fechaInicial, $fechaFinal);
              foreach ($respuesta as $key => $value) {
                echo '<tr>
                  <td>'.$contador.'</td>
                  <td>'.$value["codigo"].'</td>
                  <td>'.$value["cliente"].'</td>
                  <td>'.$value["vendedor"].'</td>
                  <td>'.$value["forma_pago"].'</td>
                  <td>Gs '.number_format($value["neto"],0).'</td>
                  <td>Gs '.number_format($value["total"],0).'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-success" href="index.php?ruta=ventas&xml='.$value["id"].'">xml</a>
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["id"].'">
                        <i class="fa fa-print"></i>
                      </button>
                      <button class="btn btn-warning btnVerVenta" idVenta="'.$value["id"].'"><i class="fa fa-search"></i></button>';
                      if($_SESSION["perfil"] == "Administrador"){
                        echo '<button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                echo '</div>  
                  </td>
                </tr>';
                $contador = $contador + 1;
              }
            ?>
          </tbody>
        </table>
       <?php
          $eliminarVenta = new ControladorVentas();
          $eliminarVenta -> ctrEliminarVenta();
        ?>       
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL ESTABLECER CUOTAS
======================================-->
<div id="modalEstablecerCuotas" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <h4 class="modal-title">Establecer Cuotas</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA LA NUEVA CANTIDAD DE CUOTAS--> 
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="number" min="0" class="form-control input-lg" name="nuevoCuota" id="nuevoCuota" placeholder="Ingresar Cuota Maxima" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Nueva Cuota</button>
        </div>
        <?php
          $crearCuotas = new ControladorVentas();
          $crearCuotas -> ctrEstablecerCuotas();
        ?>
      </form>
    </div>
  </div>
</div>