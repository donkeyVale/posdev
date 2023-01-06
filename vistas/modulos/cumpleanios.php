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
    <h1>Cumpleañeros del Mes</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Cumpleañeros del Mes</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">

      <div class="box-body">        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Nombre Completo</th>
           <th>Teléfono</th>
           <th>Email</th>
           <th>Fecha de Cumpleaños</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $clientes = ControladorClientes::ctrMostrarCumpleaniosMes();
          foreach ($clientes as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["telefono"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.$value["fecha_nacimiento"].'</td>
                  </tr>';
            }
        ?>
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>