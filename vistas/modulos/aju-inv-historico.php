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
    <h1>Histórico Ajustes de Inventario</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-barcode"></i> Inicio</a></li>
      <li class="active">Histórico Ajustes de Inventario</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">

    <div class="col-md-12" position=relative>
          <div class="input-group">
            <?php 
                  if(isset($_GET["id_producto"])){
                    $idProducto = $_GET["id_producto"];
                  }else{
                    $idProducto = 0;
                  }
                  $producto = ControladorProductos::ctrMostrarProductos('id',$idProducto);
            ?>
            <h3><?php echo $producto['codigo']." / ".$producto['descripcion']; ?></h3>
          </div>
        </div>
      </div>

      <div class="box-body">  
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nota</th>
              <th>Cantidad</th>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Usuario</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if(isset($_GET["idStock"])){
              $idStock = $_GET["idStock"];
            }else{
              $idStock = 1;
            }
            $ajusteHistorico = ControladorProductos::ctrAjusteInventarioHistorico($idStock);
            foreach ($ajusteHistorico as $key => $value) {
              echo '<tr>
                      <td>'.$value["id"].'</td>
                      <td>'.$value["nota"].'</td>
                      <td>'.$value["cantidad"].'</td>
                      <td>'.date("d-m-Y H:i:s", strtotime($value["fecha"]) ).'</td>
                      <td>'.$value["tipo"].'</td>
                      <td>'.$value["usuario"].'</td>
                    </tr>';
              }

          ?>
          </tbody>   
       </table>
      </div>
    </div>
  </section>
</div>
