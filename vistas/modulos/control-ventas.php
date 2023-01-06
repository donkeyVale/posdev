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
    
    <h1>
      
      Control de  ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th >Nombre del Cliente</th>
           <th>Metodo de Pago</th>
           <th>Neto</th>
           <th>Total</th>
           <th>Cuotas</th>
           <th>Monto Cancelado</th>
           <th>Monto a Pagar</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $respuesta = ControladorVentas::ctrControlVentas();


          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.$value["nombre"].'</td>

                  <td>'.$value["metodo_pago"].'</td>

                  <td>Gs '.number_format($value["neto"],0).'</td>

                  <td>Gs '.number_format($value["total"],0).'</td>';
                  
                  if(!empty($value["cuotas"])){
                    echo '<td> '.$value["cuotas"].'</td>';
                  }else{
                    echo '<td> Sin Credito </td>';
                  }

                  if(!empty($value["cuotas"])){
                    echo '<td>Gs '.number_format($value["monto_pagado"],0).'</td>';
                  }else{
                    echo '<td> Sin Credito </td>';
                  }

                  if(!empty($value["cuotas"])){
                    echo '<td>Gs '.number_format($value["monto_deudor"],0).'</td>';
                  }else{
                    echo '<td> Sin Credito </td>';
                  }

             echo '

                  <td>

                    <div class="btn-group">

                    <button data-toggle="modal" class="btn btn-primary" codigoVenta="'.$value["codigo"].'" data-target="#editarVenta">Actualizar</button>

                    </div>  

                  </td>

                </tr>';
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
MODAL EDITAR PRODUCTO
======================================-->

<div id="editarVenta" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          

          <h4 class="modal-title">Cuotas a Pagar de las Ventas</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- CLIENTE--> 
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="cliente" id="cliente" placeholder="Cliente" disabled="disabled">

              </div>

            </div>
            <!-- METODO DE PAGO--> 
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-cc-amex"></i></span> 

                <input type="text" class="form-control input-lg" name="metodo_pago" id="metodo_pago" placeholder="Metodo de Pago" disabled="disabled">

              </div>

            </div>
            <!-- NETO--> 
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-gg"></i></span> 

                <input type="text" class="form-control input-lg" name="neto" id="neto" placeholder="Neto" disabled="disabled">

              </div>

            </div>
            <!-- TOTAL--> 
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-gg"></i></span> 

                <input type="text" class="form-control input-lg" name="total" id="total" placeholder="Total" disabled="disabled">

              </div>

            </div>
            <!-- MONTO CANCELADO--> 
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-gg"></i></span> 

                <input type="text" class="form-control input-lg" name="monto_pagado" id="monto_pagado" placeholder="Monto Cancelado" disabled="disabled">

              </div>

            </div>
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-gg"></i></span> 

                <input type="text" class="form-control input-lg" name="monto_deudor" id="monto_deudor" placeholder="Monto por Pagar" disabled="disabled">

              </div>

            </div>
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-money"></i></span> 

                <input type="text" class="form-control input-lg" name="monto" id="monto" placeholder="Monto">

              </div>

            </div>
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Actualizar pago</button>

        </div>
     <?php
          $crearCuotas = new ControladorVentas();
          $crearCuotas -> ctrEstablecerCuotas();

        ?>
        </form>
</div>
</div>

</div>

<?php

  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();

?>      





