<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

if (isset($_POST['cantidadAjuste']) && isset($_POST['idDeposito']) && isset($_POST['idProducto'])){
    $stock = ControladorProductos::ctrActualizarProductoStockAjust($_POST['idDeposito'], $_POST['idProducto'], $_POST['cantidadAjuste'], $_POST['usuario'], $_POST['txtNota']);
    echo json_encode($stock);
}
