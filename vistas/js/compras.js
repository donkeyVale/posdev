$('.tablaCompras').DataTable({
    "ajax": "ajax/datatable-compras.ajax.php",
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

});

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaCompras tbody").on("click", "button.agregarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    $(this).removeClass("btn-primary agregarProducto");
    $(this).addClass("btn-default");
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
            var descripcion = respuesta["descripcion"];
            var precio = respuesta["precio_compra"];
            $(".nuevoProducto").append(
                    '<div class="row" style="padding:5px 15px">' +
                    '<!-- Descripción del producto -->' +
                    '<div class="col-xs-5" style="padding-right:0px">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
                    '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +
                    '</div>' +
                    '</div>' +
                    '<!-- Precio del producto -->' +
                    // '<div class="col-xs-1 ingresoPrecio" style="padding-left:0px">' +
                    // '<div class="input-group">' +
                    // '<input type="text" class="form-control nuevoPrecioProducto" precioReal="' + precio + '" name="nuevoPrecioProducto" value="' + precio + '" required>' +
                    // '</div>' +
                    // '</div>' +
                    '<!-- Precio del producto -->' +
                    '<div class="col-xs-2 ingresoPrecio" style="padding-left:0px">' +
                    '<div class="input-group">' +
                    '<input type="text" class="form-control nuevoPrecioProducto" precioReal="' + precio + '" name="nuevoPrecioProducto" value="' + precio + '" required>' +
                    '</div>' +
                    '</div>' +
                    '<!-- Cantidad del producto -->' +
                    '<div class="col-xs-2 ingresoCantidad">' +
                    '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1"  required>' +
                    '</div>' +
                    '<!-- SubTotal del producto -->' +
                    '<div class="col-xs-3 subTotalItem" style="padding-left:0px">' +
                    '<div class="input-group">' +
                    '<input type="text" class="form-control subTotalPrecioProducto" name="subTotalPrecioProducto" value="' + precio + '" readonly required>' +
                    '</div>' +
                    '</div>' +
                    '</div>')
                // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios()
                // AGREGAR IMPUESTO
            agregarImpuesto()
                // AGRUPAR PRODUCTOS EN FORMATO JSON
            listarProductos()
                // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
                //$(".nuevoPrecioProducto").number(true, 2);
            $(".subTotalPrecioProducto").number(true, 2);

            $(".nuevoDescuento").number(true, 2);
            localStorage.removeItem("quitarProducto");
        }
    })
});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
$(".tablaCompras").on("draw.dt", function() {
    if (localStorage.getItem("quitarProducto") != null) {
        var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
        for (var i = 0; i < listaIdProductos.length; i++) {
            $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").removeClass('btn-default');
            $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").addClass('btn-primary agregarProducto');
        }
    }
})

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioCompra").on("click", "button.quitarProducto", function() {
    $(this).parent().parent().parent().parent().remove();
    var idProducto = $(this).attr("idProducto");
    /*=============================================
    ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
    =============================================*/
    if (localStorage.getItem("quitarProducto") == null) {
        idQuitarProducto = [];
    } else {
        idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
    }
    idQuitarProducto.push({ "idProducto": idProducto });
    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
    $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass('btn-default');
    $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');
    if ($(".nuevoProducto").children().length == 0) {
        $("#nuevoImpuestoVenta").val(0);
        $("#nuevoTotalVenta").val(0);
        $("#totalVenta").val(0);
        $("#nuevoTotalVenta").attr("total", 0);
    } else {
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios()
            // AGREGAR IMPUESTO
        agregarImpuesto()
            // AGRUPAR PRODUCTOS EN FORMATO JSON
        listarProductos()
    }
})

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0;
$(".btnAgregarProducto").click(function() {
    numProducto++;
    var datos = new FormData();
    datos.append("traerProductos", "ok");
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $(".nuevoProducto").append(
                '<div class="row" style="padding:5px 15px">' +
                '<!-- Descripción del producto -->' +
                '<div class="col-xs-6" style="padding-right:0px">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +
                '<select class="form-control nuevaDescripcionProducto" id="producto' + numProducto + '" idProducto name="nuevaDescripcionProducto" required>' +
                '<option>Seleccione el producto</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<!-- Cantidad del producto -->' +
                '<div class="col-xs-3 ingresoCantidad">' +
                'Cantidad<input type="number" class="form-control nuevaCantidadProducto" id=cantidad name="nuevaCantidadProducto" min="1" value="0" stock nuevoStock required>' +
                '</div>' +
                '<!-- Descuento del producto-->' +
                '<div class="col-xs-3 ingresoDescuento">' +
                'porcentaje % <input type="number" class="form-control nuevoDescuento" name="nuevoDescuento" id="nuevoDescuento" min="0" value="0"  stock nuevoStock required>' +
                '</div>' +
                '<div class="col-xs-3 montoDescuento">' +
                'Monto Descuento<input type="number" class="form-control montoDescuento" name="montoDescuento" id="montoDescuento" min="0" value="0"  stock nuevoStock required>' +
                '</div>' +
                '<!-- Precio del producto -->' +
                '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                'Total<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>' +
                '</div>' +
                '</div>' +
                '</div>');

            // AGREGAR LOS PRODUCTOS AL SELECT 
            respuesta.forEach(funcionForEach);

            function funcionForEach(item, index) {
                if (item.stock != 0) {
                    $("#producto" + numProducto).append(
                        '<option idProducto="' + item.id + '" value="' + item.descripcion + '">' + item.descripcion + '</option>'
                    )
                }
            }
            // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios()
                // AGREGAR IMPUESTO
            agregarImpuesto()
                // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
            $(".nuevoPrecioProducto").number(true, 2);
            $(".nuevoDescuento").number(true, 2);
        }
    })
})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioCompra").on("change", "select.nuevaDescripcionProducto", function() {
    var nombreProducto = $(this).val();
    var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");
    var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
    var nuevoDescuento = $(this).parent().parent().parent().children(".ingresoDescuento").children(".nuevaCantidadProducto");
    var montoDescuento = $(this).parent().parent().parent().children(".montoDescuento").children(".nuevaCantidadProducto");
    var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
            $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
            $(nuevoDescuento).attr("descuento", respuesta["descuento"]);
            $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"]) - 1);
            $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
            $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);
            // AGRUPAR PRODUCTOS EN FORMATO JSON
            listarProductos()
        }
    })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioCompra").on("change", "input.nuevaCantidadProducto", function() {
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var precioFinal = $(this).val() * precio.attr("precioReal");

    var subTotalItem = $(this).parent().parent().children(".subTotalItem").children().children(".subTotalPrecioProducto");
    subTotalItem.val(precioFinal);
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
        // AGREGAR IMPUESTO
    agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos()
})

$(".formularioCompra").on("change", "input.nuevoPrecioProducto", function() {
    var precioReal = $(this).val();
    $(this).attr("precioReal", precioReal);
    var cantidad = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
    var precioFinal = cantidad.val() * precioReal;
    var subTotalItem = $(this).parent().parent().parent().children(".subTotalItem").children().children(".subTotalPrecioProducto");
    subTotalItem.val(precioFinal);

    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
        // AGREGAR IMPUESTO
    agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos()
})

$(".formularioCompra").on("change", "input.nuevoDescuento", function() {
    var montoDescuento = $(".montoDescuento");
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var cantidad = document.getElementById('cantidad');
    console.log(cantidad);
    var precioFinal = precio.attr("precioReal") * cantidad.value - ($(this).val() * precio.attr("precioReal") * cantidad.value / 100);
    precio.val(precioFinal);
    $("#montoDescuento").val($(this).val() * precio.attr("precioReal") * cantidad / 100);
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
        // AGREGAR IMPUESTO
    agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos()
})

$(".formularioCompra").on("change", "input.montoDescuento", function() {
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

    var cantidad = document.getElementById('cantidad');
    console.log(cantidad);
    var precioFinal = precio.attr("precioReal") * cantidad.value - $(this).val();
    precio.val(precioFinal);
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
        // AGREGAR IMPUESTO
    agregarImpuesto()
        // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos()
})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios() {
    //var precioItem = $(".nuevoPrecioProducto");
    var precioItem = $(".subTotalPrecioProducto");

    var arraySumaPrecio = [];
    for (var i = 0; i < precioItem.length; i++) {
        arraySumaPrecio.push(Number($(precioItem[i]).val()));
    }

    function sumaArrayPrecios(total, numero) {
        return total + numero;
    }

    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
    $("#nuevoTotalVenta").val(sumaTotalPrecio);
    $("#totalVenta").val(sumaTotalPrecio);
    $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);
}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/
function agregarImpuesto() {
    var impuesto = $("#nuevoImpuestoVenta").val();
    var descuento = $("#nuevoDescuento").val();
    if (descuento == "") {
        descuento = 0;
    }
    var precioTotal = $("#nuevoTotalVenta").attr("total");
    var precioImpuesto = Number((precioTotal - descuento) * impuesto / 100);
    var totalConImpuesto = Number(precioImpuesto) + Number((precioTotal - descuento));
    $("#nuevoTotalVenta").val(totalConImpuesto);
    $("#totalVenta").val(totalConImpuesto);
    $("#nuevoPrecioImpuesto").val(precioImpuesto);
    $("#nuevoPrecioNeto").val(precioTotal);
}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/
$("#nuevoImpuestoVenta").change(function() {
    agregarImpuesto();
});

/*=============================================
CUANDO CAMBIA EL MONTO DESCUENTO
=============================================*/
$("#nuevoDescuento").change(function() {
    agregarImpuesto();
});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/
$("#nuevoTotalVenta").number(true, 2);
$("#nuevoDescuento").number(true, 2);
$("#cuotas").on('change', function() {
    alert(this);
});

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductos() {
    var listaProductos = [];
    var descripcion = $(".nuevaDescripcionProducto");
    var cantidad = $(".nuevaCantidadProducto");
    var precio = $(".nuevoPrecioProducto");
    var descuento = $(".nuevoDescuento");
    var montoDescuento = $(".montoDescuento");
    for (var i = 0; i < descripcion.length; i++) {
        listaProductos.push({
            "id": $(descripcion[i]).attr("idProducto"),
            "descripcion": $(descripcion[i]).val(),
            "cantidad": $(cantidad[i]).val(),
            "stock": $(cantidad[i]).attr("nuevoStock"),
            "precio": $(precio[i]).attr("precioReal"),
            "total": $(precio[i]).val() * $(cantidad[i]).val()
        })
    }
    $("#listaProductos").val(JSON.stringify(listaProductos));
}



/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function() {
    var idVenta = $(this).attr("idVenta");
    window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta;
})

/*BOTÓN PARA VER COMPRA*/
$(".tablas").on("click", ".btnVerCompra", function() {
    var idCompra = $(this).attr("idCompra");
    window.location = "index.php?ruta=ver-compra&idCompra=" + idCompra;
})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
function quitarAgregarProducto() {
    //Capturamos todos los id de productos que fueron elegidos en la venta
    var idProductos = $(".quitarProducto");
    //Capturamos todos los botones de agregar que aparecen en la tabla
    var botonesTabla = $(".tablaVentas tbody button.agregarProducto");
    //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
    for (var i = 0; i < idProductos.length; i++) {
        //Capturamos los Id de los productos agregados a la venta
        var boton = $(idProductos[i]).attr("idProducto");
        //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
        for (var j = 0; j < botonesTabla.length; j++) {
            if ($(botonesTabla[j]).attr("idProducto") == boton) {
                $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
                $(botonesTabla[j]).addClass("btn-default");
            }
        }
    }
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/
$('.tablaCompras').on('draw.dt', function() {
    quitarAgregarProducto();
})

/*=============================================
BORRAR COMPRA
=============================================*/
$(".tablas").on("click", ".btnEliminarCompra", function() {
    var idCompra = $(this).attr("idCompra");
    swal({
        title: '¿Está seguro de borrar la compra?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar compra!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=compras&idCompra=" + idCompra;
        }
    })
})

/*=============================================
IMPRIMIR FACTURA
=============================================*/
$(".tablas").on("click", ".btnImprimirFacturaCompra", function() {
    var codigoVenta = $(this).attr("codigoVenta");
    window.open("extensiones/tcpdf/pdf/factura-compra.php?codigo=" + codigoVenta, "_blank");
})

$("#btnGuardar").click(function(e) {
    $valor = $("#seleccionarProveedor").val();
    if ($valor == "0") {
        e.preventDefault();
        swal({
            type: "error",
            title: "Tiene que seleccionar un proveedor",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {});
    } else {
        $valor = $("#listaProductos").val()
        if ($valor == "") {
            e.preventDefault();
            swal({
                type: "error",
                title: "La venta no se ha ejecuta si no hay productos",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {});
        } else {
            $valor = $("#referencia").val();
            if ($valor == "") {
                e.preventDefault();
                swal({
                    type: "error",
                    title: "Tiene que ingresar una referencia.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {});
            } else {
                $valor = $("#nroFactura").val();
                if ($valor = "") {
                    e.preventDefault();
                    swal({
                        type: "error",
                        title: "Tiene que ingresar el número de factura",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {});
                }
            }
        }
    }
})

$('.tablaCompras').DataTable({
    "ajax": "ajax/datatable-compras.ajax.php",
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
});

$('#daterange-btn3').daterangepicker({
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment()
    },
    function(start, end) {
        $('#daterange-btn3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var capturarRango = $("#daterange-btn3 span").html();
        localStorage.setItem("capturarRango", capturarRango);
        window.location = "index.php?ruta=compras&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
)
