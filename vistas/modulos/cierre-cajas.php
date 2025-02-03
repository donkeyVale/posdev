<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}


?>

<div class="content-wrapper">
<?php $validaCaja = new ControladorVentas();
$validarCaja=$validaCaja->consultaCajaAbierta();

if($validarCaja['estado']==1){
?>

  <section class="content-header">
    <div class="row">
    <div class="col-lg-2 col-md-2 col-xs-2"></div>
    	<div class="col-lg-8 col-md-8 col-xs-8">
	    	<h3>
	      
	      	Resumen de las ventas totales del día de hoy <?php echo date('d-m-Y')?>
	    
	    	</h3>
	    </div>
    </div>
    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cierre de caja</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-2 col-md-2 col-xs-2"></div>
      <div class="col-lg-8 col-md-8 col-xs-8">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioCerrarCaja" >
              <?php $totalVentas = new ControladorVentas();
              $totalVentas=$totalVentas->totalVentasDias();
              $total_venta = 0;
              ?>

          <input type="hidden" value="1" name="cierre">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DE LA APERTURA DE CAJA
                ======================================-->

                  <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-green">
                      <h3>Ventas hasta el momento</h3>
                    </div>
                    <div class="box-footer no-padding">
                      <ul class="nav nav-stacked">
                      <li><a href="#"><strong>Métodos de Pagos</strong> <span class="pull-right badge bg-blue">Totales</span></a></li>
                      <?php if(isset($totalVentas)) { foreach ($totalVentas as $value) { ?>
                       
                        <li><a href="#"><?php echo $value['metodo']?> <span class="pull-right badge bg-blue">Gs. <?php  echo number_format($value['total_venta'],0); ?></span></a></li>
                        <?php $total_venta = $total_venta + $value['total_venta']; } } ?>

                        <li>&nbsp;</li>
                        <li style="background-color:rgb(9, 173, 138) !important"><a href="#"><strong>Total del Día</strong> <span class="pull-right badge bg-blue">Gs. <?php echo number_format($total_venta,0); ?></span></a></li>

                        <?php 
                        $ventas_productos = ModeloVentas::listadoTotalProductosCajaAperturada($validarCaja['id']);
                        ?>
                        <li>&nbsp;</li>
                        <li><a href="#"><strong>Descripción de Producto</strong> <span class="pull-right badge bg-blue">Cantidad</span></a></li>
                        <?php

                        $cantProd = 0;
                        foreach ($ventas_productos as $value) {
                          $cantProd =  $value['total'] + $cantProd;
                        ?>
                          <li><a href="#"><?php echo $value['descripcion']?> <span class="pull-right badge bg-blue"><?php  echo number_format($value['total'],0); ?></span></a></li>
                          
                        <?php
                        }
                        ?>
                        <li>&nbsp;</li>
                        <li style="background-color:rgb(9, 173, 138) !important"><a href="#"><strong>Total Productos</strong> <span class="pull-right badge bg-blue"><?php echo number_format($cantProd,0); ?></span></a></li>
                        <li>&nbsp;</li>
                        <li><a href="#"><strong>Vendedor</strong> <span class="pull-right badge bg-blue">Monto</span></a></li>
                        <li>&nbsp;</li>
                        <?php

                        $ventasCajaVendedor = ModeloVentas::obtenerVentaCajaUsuario($validarCaja['id']);
                        $montoCajaxVen= 0;
                        foreach ($ventasCajaVendedor as $value) {
                          $montoCajaxVen =  $value['neto'] + $montoCajaxVen;
                        ?>
                          <li><a href="#"><?php echo "(".$value['id_vendedor'].")"." ".$value['usuario'] ?> <span class="pull-right badge bg-blue">Gs. <?php  echo number_format($value['neto'],0); ?></span></a></li>
                          
                        <?php
                        }
                        ?>
                        <li>&nbsp;</li>
                        <li style="background-color:rgb(9, 173, 138) !important"><a href="#"><strong>Total Vendedores</strong> <span class="pull-right badge bg-blue">Gs. <?php echo number_format($montoCajaxVen,0); ?></span></a></li>
                        <li>&nbsp;</li>
                        <li style="background-color:rgb(9, 173, 138) !important"><a href="#"><strong>Monto de Apertura</strong> <span class="pull-right badge bg-blue">Gs. <?php echo number_format($validarCaja['monto_apertura'],0); ?></span></a></li>
                          <input type="hidden" value="<?php echo  $total_venta ?>" name="valor_cierre">
                          <input type="hidden" value="<?php echo  $validarCaja['id'] ?>" name="caja_id">
                      </ul>
                    </div>
                  </div>

                </div>

                
               
          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Cierre de Caja</button>

          </div>
          <div class="col-lg-2 col-md-2 col-xs-2"></div>
        </form>

        <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta -> crtCerrarCaja();
          
        ?>

        </div>
            
      </div>

    </div>
   
  </section>

</div>
<?php }else{ ?>
<div class="content-wrapper">
<div class="alert alert-danger alert-dismissible">
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    La Caja no ha sido abierta el día de hoy.
  </div>
  <section class="content-header">
    <div class="row">
    <div class="col-lg-2 col-md-2 col-xs-2"></div>
      <div class="col-lg-8 col-md-8 col-xs-8">
        <h3>
        
          Resumen de las ventas totales del día de hoy <?php echo date('d-m-Y')?>
      
        </h3>
      </div>
    </div>
    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cierre de caja</li>
    
    </ol>

  </section>

  
  <section class="content">

    <div class="row">

      <div class="col-lg-2 col-md-2 col-xs-2"></div>
      <div class="col-lg-8 col-md-8 col-xs-8">
        
        <div class="box box-danger">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioCerrarCaja">
          <input type="hidden" value="1" name="cierre">
            <div class="box-body">
  
              <div class="box">

                  <?php $totalVentas = new ControladorVentas();
                    $totalVentas=$totalVentas->totalVentasDias();
                  $total_venta = 0;
                  ?>
                  <div class="box box-widget widget-user-2">

                    <div class="widget-user-header bg-red">
                      <h3>Ventas hasta el momento</h3>
                    </div>
                    <div class="box-footer no-padding">
                      <ul class="nav nav-stacked">
                      <li><a href="#"><strong>Métodos de Pagos</strong> <span class="pull-right badge bg-blue">Totales</span></a></li>
                      <?php foreach ($totalVentas as $value) {?>
                       
                        <li><a href="#"><?php echo $value['metodo']?> <span class="pull-right badge bg-blue"><?php  echo number_format($value['total_venta'],0); ?></span></a></li>
                        <?php $total_venta=$total_venta+$value['total_venta']; } ?>
                      <li><a href="#"><strong>Total del Día</strong> <span class="pull-right badge bg-blue"><?php echo number_format($total_venta,0); ?></span></a></li>
                      </ul>
                    </div>
                  </div>

                </div>
               
          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right" disabled="disabled">Cierre de Caja</button>

          </div>
          <div class="col-lg-2 col-md-2 col-xs-2"></div>
        </form>

        <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta -> crtCerrarCaja();
          
        ?>

        </div>
            
      </div>

    </div>
   
  </section> 

</div>
<?php } ?>
