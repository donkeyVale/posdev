<?php
  if($_SESSION["perfil"] == "Especial"){
    echo '<script>
      window.location = "inicio";
      </script>';
    return;
  }

?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar Transferencias</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Transferencias</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-transferencia">
          <button class="btn btn-primary">Agregar Transferencia</button>
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

      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablaTransferencias" width="100%"> 
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Código</th>
              <th>Fecha Registro</th>
              <th>Usuario Registro</th>
              <th>Depósito Origen</th>
              <th>Depósito Destino</th>
              <th>Estado</th> 
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
              $contador=1;
              $respuesta = ControladorTransferencias::ctrListarTransferencias($fechaInicial, $fechaFinal);
              foreach ($respuesta as $key => $value) {
                echo '<tr>
                  <td>'.$contador.'</td>
                  <td>'.$value["id"].'</td>
                  <td>'.date("d-m-Y H:i:s", strtotime($value["fecha_registro"]) ).'</td>
                  <td>'.$value["usuario_transferencia"].'</td>
                  <td>'.$value["deposito_origen"].'</td>
                  <td>'.$value["deposito_destino"].'</td>
                  <td>'.$value["nombre_estado"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnVerTransferencia" idTransferencia="'.$value["id"].'" title="Ver Transferencia"><i class="fa fa-search"></i></button>';
                      if($_SESSION["perfil"] == "Administrador" && $value["nombre_estado"]== "En Proceso"){
                        echo '<button class="btn btn-danger btnEliminarTransferencia" idTransferencia="'.$value["id"].'" title="Eliminar Transferencia"><i class="fa fa-times"></i></button>';
                      }
                      if($_SESSION["perfil"] == "Administrador" && $value["nombre_estado"]== "En Proceso"){
                        echo '<button class="btn btn-success btnAprobarTransferencia" idTransferencia="'.$value["id"].'" title="Aprobar Transferencia"><i class="fa fa-thumbs-up"></i></button>';
                      }
                      if($_SESSION["perfil"] == "Administrador" && $value["nombre_estado"]== "Aprobado"){
                        echo '<button class="btn btn-dark btnRecepcionarTransferencia" idTransferencia="'.$value["id"].'" title="Recepcionar Transferencia"><i class="fa fa-sign-in"></i></button>';
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