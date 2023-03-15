<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/unidades.controlador.php";
require_once "controladores/gruposclientes.controlador.php";
require_once "controladores/terminospago.controlador.php";
require_once "controladores/cajas.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/sucursales.controlador.php";
require_once "controladores/aperturas.controlador.php";
require_once "controladores/categoriasgastos.controlador.php";
require_once "controladores/depositos.controlador.php";
require_once "controladores/colores.controlador.php";
require_once "controladores/calces.controlador.php";
require_once "controladores/compras.controlador.php";
require_once "controladores/transferencias.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/unidades.modelo.php";
require_once "modelos/gruposclientes.modelo.php";
require_once "modelos/terminospago.modelo.php";
require_once "modelos/cajas.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/sucursales.modelo.php";
require_once "modelos/aperturas.modelo.php";
require_once "modelos/categoriasgastos.modelo.php";
require_once "modelos/depositos.modelo.php";
require_once "modelos/colores.modelo.php";
require_once "modelos/calces.modelo.php";
require_once "modelos/compras.modelo.php";
require_once "modelos/transferencias.modelo.php";

require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
