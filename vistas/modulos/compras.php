<?php
  if($_SESSION["perfil"] == "Especial"){
    echo '<script>
      window.location = "inicio";
      </script>';
    return;
  }

  $xml = ControladorCompras::ctrDescargarXML();
  if($xml){
    rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");
    echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="compras">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';
  }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar Compras</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Compras</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-compra">
          <button class="btn btn-primary">Agregar Compra</button>
        </a>
        <button type="button" class="btn btn-default pull-right" id="daterange-btn3">   
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

      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%"> 
          <thead>
            <tr>
              <th>Código</th>
              <th>Proveedor</th>
              <th>Factura</th>
              <th>Tipo Compra</th>
              <th>Depósito</th>
              <th>Total</th> 
              <th>Fecha Compra</th> 
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
              $respuesta = ControladorCompras::ctrListarCompras($fechaInicial, $fechaFinal);
              foreach ($respuesta as $key => $value) {
                echo '<tr>
                  <td>'.$value["codigo"].'</td>
                  <td>'.$value["proveedor"].'</td>
                  <td>'.$value["nrofactura"].'</td>
                  <td>'.$value["tipocompra"].'</td>
                  <td>'.$value["deposito"].'</td>
                  
                  <td>Gs '.number_format($value["total"],0).'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-success" href="index.php?ruta=compras&xml='.$value["id"].'">xml</a>
                      <button class="btn btn-info btnImprimirFacturaCompra" codigoVentaCompra="'.$value["id"].'">
                        <i class="fa fa-print"></i>
                      </button>
                      <button class="btn btn-warning btnVerCompra" idCompra="'.$value["id"].'"><i class="fa fa-search"></i></button>';
                      if($_SESSION["perfil"] == "Administrador"){
                        echo '<button class="btn btn-danger btnEliminarCompra" idCompra="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                echo '</div>  
                  </td>
                </tr>';
            }
            ?>
          </tbody>
        </table> 
        <?php
          $eliminarCompra = new ControladorCompras();
          $eliminarCompra -> ctrEliminarCompra();
        ?>      
      </div>
    </div>
  </section>
</div>
