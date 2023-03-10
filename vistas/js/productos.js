/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/
/*$.ajax({
	url: "ajax/datatable-productos.ajax.php",
	success:function(respuesta){
		console.log("respuesta", respuesta);
	}
})*/

var perfilOculto = $("#perfilOculto").val();

/*$('.tablaProductos').DataTable({
    "ajax": "ajax/datatable-productos.ajax.php?perfilOculto=" + perfilOculto,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});*/

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function() {
    var idCategoria = $(this).val();
    var datos = new FormData();
    datos.append("idCategoria", idCategoria);
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            if (!respuesta) {
                var nuevoCodigo = idCategoria + "01";
                $("#nuevoCodigo").val(nuevoCodigo);
            } else {
                var nuevoCodigo = Number(respuesta["codigo"]) + 1;
                $("#nuevoCodigo").val(nuevoCodigo);
            }
        }
    })
})

/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function() {
    if ($(".porcentaje").prop("checked")) {
        var valorPorcentaje = $(".nuevoPorcentaje").val();
        var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());
        var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());
        $("#nuevoPrecioVenta").val(porcentaje);
        $("#nuevoPrecioVenta").prop("readonly", true);
        $("#editarPrecioVenta").val(editarPorcentaje);
        $("#editarPrecioVenta").prop("readonly", true);
    }
})

/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/
$(".nuevoPorcentaje").change(function() {
    if ($(".porcentaje").prop("checked")) {
        var valorPorcentaje = $(this).val();
        var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());
        var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());
        $("#nuevoPrecioVenta").val(porcentaje);
        $("#nuevoPrecioVenta").prop("readonly", true);
        $("#editarPrecioVenta").val(editarPorcentaje);
        $("#editarPrecioVenta").prop("readonly", true);
    }
})

$(".porcentaje").on("ifUnchecked", function() {
    $("#nuevoPrecioVenta").prop("readonly", false);
    $("#editarPrecioVenta").prop("readonly", false);
})

$(".porcentaje").on("ifChecked", function() {
    $("#nuevoPrecioVenta").prop("readonly", true);
    $("#editarPrecioVenta").prop("readonly", true);
})

/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/
$(".nuevaImagen").change(function() {
    var imagen = this.files[0];
    /*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/
    if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
        $(".nuevaImagen").val("");
        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen debe estar en formato JPG o PNG!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
    } else if (imagen["size"] > 2000000) {
        $(".nuevaImagen").val("");
        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen no debe pesar más de 2MB!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
    } else {
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);
        $(datosImagen).on("load", function(event) {
            var rutaImagen = event.target.result;
            $(".previsualizar").attr("src", rutaImagen);
        })
    }
})

/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablas tbody").on("click", "button.btnEditarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#idProducto").val(respuesta["id"]);
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarCategoria").val(respuesta["id_categoria"]);
            $("#editarMarca").val(respuesta["id_marca"]);
            $("#editarUnidad").val(respuesta["id_unidad"]);
            $("#editarPrecioCompra").val(respuesta["precio_compra"]);
            $("#editarPrecioVenta").val(respuesta["precio_venta"]);
            $("#editarStock").val(respuesta["stock"]);
            $("#editarFechaVencimiento").val(respuesta["fecha_vencimiento"]);
            $("#editarTipoProducto").val(respuesta["tipo_producto"]);
            $("#editarImpuesto").val(respuesta["tipo_impuesto"]);
            $("#editarCantidadAlerta").val(respuesta["stock_minimo_alerta"]);
            $("#editarStockCritico").val(respuesta["tipo_control"]);
            $("#editarCodigo").prop("disabled", true);
            if (respuesta["imagen"] != "") {
                $("#imagenActual").val(respuesta["imagen"]);
                $(".previsualizar").attr("src", respuesta["imagen"]);
            }
        }
    })
})

/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablas tbody").on("click", "button.btnEliminarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    swal({
        title: '¿Está seguro de borrar el producto?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar producto!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=productos&idProducto=" + idProducto;
        }
    })
})

/*BOTÓN PARA AGREGAR PRODUCTO HIJO*/
$(".tablas").on("click", ".btnAgregaProductorHijo", function() {
    var idProducto = $(this).attr("idProducto");
    window.location = "index.php?ruta=crear-producto&idProductoPadre=" + idProducto;
})


$(".tablas tbody").on("click", "button.btnEliminarProductoHijo", function() {
    var idProducto = $(this).attr("idProducto");
    var ProductoPadreId = $(this).attr("ProductoPadre");
    swal({
        title: '¿Está seguro de borrar el producto?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar producto!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=crear-producto&idProducto=" + idProducto + "&idProductoPadre=" + ProductoPadreId;
        }
    })
})

$("#cmbdepositoProducto").on('change', function() {
    var idDeposito = $(this).val();
    //alert("Depósito: " + idDeposito);
    window.location = "index.php?ruta=productos&cmbdepositoProducto=" + idDeposito;
});

$("#btnModalAgregarProducto").click(function(e) {
    var idCategoria = $("#nuevaCategoria").val();

    $("#nuevoTipoProducto").val(1);
    $("#nuevoImpuesto").val(2);
    $("#nuevoStockCritico").val(1);

    var datos = new FormData();
    datos.append("idCategoria", idCategoria);
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            if (!respuesta) {
                var nuevoCodigo = idCategoria + "01";
                $("#nuevoCodigo").val(nuevoCodigo);
            } else {
                var nuevoCodigo = Number(respuesta["codigo"]) + 1;
                $("#nuevoCodigo").val(nuevoCodigo);
            }
        }
    })
})
