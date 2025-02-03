<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class AjaxProductos{

  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public $idCategoria;

  public function ajaxCrearCodigoProducto(){
  	$item = "id_categoria";
  	$valor = $this->idCategoria;
    $orden = "id";
  	$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

  	echo json_encode($respuesta);
  }

  /*=============================================
  EDITAR PRODUCTO
  =============================================*/ 
  public $idProducto;
  public $idDeposito;
  public $idUsuario;
  public $idProductoHijo;
  public $traerProductos;
  public $nombreProducto;

  public $stock_disponible;
  
  public function ajaxEditarProducto(){
		if ($this->idProductoHijo == null){
            $item = "id";
            $valor = $this->idProducto;
            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
        } else {
            $item = "id";
            $valor = $this->idProducto;
            $productoPadre = ControladorProductos::ctrMostrarProductos($item, $valor);

            $valorPadre = $this->idProductoHijo;
            $productoHijo = $this->ajaxProductoPadre($valorPadre);
            $productoHijo['stock'] = $productoPadre['stock'];
            $respuesta = $productoHijo;
        }

		echo json_encode($respuesta);
  }

  public function ajaxEditarProductoDeposito(){
		if ($this->idProductoHijo == null){
            $item = "id";
            $valor = $this->idProducto;
            $deposito = $this->idDeposito;
            $usuario = $this->idUsuario;
            $respuesta = ControladorProductos::ctrMostrarProductosDepositos($item, $valor,$deposito,$usuario);
        } else {
            $item = "id";
            $valor = $this->idProducto;
            $deposito = $this->idDeposito;
            $usuario = $this->idUsuario;
            $productoPadre = ControladorProductos::ctrMostrarProductosDepositos($item, $valor,$deposito,$usuario);

            $valorPadre = $this->idProductoHijo;
            $productoHijo = $this->ajaxProductoPadre($valorPadre);
            $productoHijo['stock'] = $productoPadre['stock'];
            $respuesta = $productoHijo;
        }

		echo json_encode($respuesta);
  }

    public function ajaxProductoPadre($productoHijo){
        $item = "id";
        $valor = $productoHijo;
        $producto = ControladorProductos::ctrMostrarProductos($item, $valor);
        return $producto;
    }
}

/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/	
if(isset($_POST["idCategoria"])){
	$codigoProducto = new AjaxProductos();
	$codigoProducto -> idCategoria = $_POST["idCategoria"];
	$codigoProducto -> ajaxCrearCodigoProducto();
}

/*=============================================
EDITAR PRODUCTO
=============================================*/ 
if(isset($_POST["idProducto"])){
  $editarProducto = new AjaxProductos();

  $producto =  $editarProducto->ajaxProductoPadre($_POST["idProducto"]);
  if($producto['product_id'] == '') {
      $editarProducto->idProducto = $_POST["idProducto"];
      $editarProducto->idProductoHijo = null;
  } else {
      $editarProducto->idProducto =  $producto['product_id'];
      $editarProducto->idProductoHijo = $producto['id'];
  }
  
  if(isset($_POST["idDeposito"]))
  {
    $editarProducto->idDeposito = $_POST["idDeposito"];
    $editarProducto->idProducto = $_POST["idProducto"];
    //$editarProducto->idUsuario = $_POST["idUsuario"];
    $editarProducto -> ajaxEditarProductoDeposito();
  }
  else
  {  
    $editarProducto -> ajaxEditarProducto();
  }

}
/*=============================================
TRAER PRODUCTO
=============================================*/ 
if(isset($_POST["traerProductos"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> traerProductos = $_POST["traerProductos"];
  $traerProductos -> ajaxEditarProducto();
}

/*=============================================
TRAER PRODUCTO
=============================================*/ 
if(isset($_POST["nombreProducto"])){
  $traerProductos = new AjaxProductos();
  $traerProductos -> nombreProducto = $_POST["nombreProducto"];
  $traerProductos -> ajaxEditarProducto();
}