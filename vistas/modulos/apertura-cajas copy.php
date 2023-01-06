<?php
if($_SESSION["perfil"] == "Admini"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
<?php $validaCaja = new ControladorVentas();
      $validarCaja=$validaCaja->consultaCajaAbierta();
      if($validarCaja['status']==1){
?>

<div class="alert alert-success alert-dismissible">
	<h4><i class="icon fa fa-success"></i> Alert!</h4>
	  La Caja se Encuentra Abierta.
</div>
  <section class="content-header">
    <div class="row">
    <div class="col-lg-2 col-md-2 col-xs-2"></div>
    	<div class="col-lg-8 col-md-8 col-xs-8">
	    	<h3>Apertura de Cajas</h3>
	    </div>
    </div>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Apertura de caja</li>
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
          <form role="form" method="post" class="formularioGuardarCaja">
            <div class="box-body">
              <div class="box">
                <!--=====================================
                ENTRADA DE LA APERTURA DE CAJA
                ======================================-->
                <div class="form-group">
                	<div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
	                    <select class="form-control" id="sucursal" name="sucursal" disabled="disabled">
	                    	<option value="">Seleccionar Sucursal</option>
                        	<option value="1">Central</option>
                        	<option value="2">PadelPy-Caaguazu</option>
	                    </select>
                  </div>
                </div>
                <div class="form-group">
                	<div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
	                    <select class="form-control" id="caja" name="caja" disabled="disabled">
	                    	<option value="">Seleccionar Caja</option>
                        	<option value="1">Caja1</option>
	                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                    <input type="text" class="form-control" id="monto_caja" value="" name="monto_caja" required="required" placeholder="Ingrese el monto de la caja" disabled="disabled">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right" disabled="disabled">Guardar</button>

          </div>
          <div class="col-lg-2 col-md-2 col-xs-2"></div>
        </form>

        <?php
          $guardarVenta = new ControladorVentas();
          $guardarVenta -> crtGuardarCaja();         
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
		La Caja no ha sido abierta el día de hoy
	</div>
  <section class="content-header">
    <div class="row">
    <div class="col-lg-2 col-md-2 col-xs-2"></div>
    	<div class="col-lg-8 col-md-8 col-xs-8">
	    	<h3>Apertura de Cajas</h3>
	    </div>
    </div>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Apertura de caja</li>
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
          <form role="form" method="post" class="formularioGuardarCaja">
            <div class="box-body">
              <div class="box">
                <!--=====================================
                ENTRADA DE LA APERTURA DE CAJA
                ======================================-->
                <div class="form-group">
                	<div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
	                    <select class="form-control" id="sucursal" name="sucursal">
	                    	<option value="">Seleccionar Sucursal</option>
                        	<option value="1">Central</option>
                        	<option value="2">PadelPy-Caaguazu</option>
	                    </select>
                  </div>
                </div>
                <div class="form-group">
                	<div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-building"></i></span> 
	                    <select class="form-control" id="caja" name="caja">
	                    	<option value="">Seleccionar Caja</option>
                        	<option value="1">Caja1</option>
	                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span> 
                    <input type="text" class="form-control" id="monto_caja" value="" name="monto_caja" required="required" placeholder="Ingrese el monto de la caja">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
          </div>
          <div class="col-lg-2 col-md-2 col-xs-2"></div>
        </form>
        <?php
          $guardarVenta = new ControladorVentas();
          $guardarVenta -> crtGuardarCaja();
        ?>
        </div>  
      </div>
    </div>
  </section>
</div>
<?php } ?>