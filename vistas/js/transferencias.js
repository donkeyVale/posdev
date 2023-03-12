/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/


$('.tablaTransferencias').DataTable({
    //"ajax": "ajax/datatable-ventas.ajax.php",
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

$(".tablaTransferencias tbody").on("click", "button.agregarProducto", function() {
    var idProducto = $(this).attr("idProducto");
    var idDeposito = $(this).attr("idDeposito");
    var idUsuario = $("#idUsuario").val();
    $(this).removeClass("btn-primary agregarProducto");
    $(this).addClass("btn-default");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    datos.append("idDeposito", idDeposito);
    datos.append("idUsuario", idUsuario);
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
            var stock = respuesta["stock"];
            var precio = respuesta["precio_venta"];
            var permiso = respuesta["permiso"];
            if (permiso == 0) {
                swal({
                    title: "El usuario no tiene permiso al depósito",
                    type: "error",
                    confirmButtonText: "¡Cerrar!"
                });
                $("button[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");
                return;
            }
            /*=============================================
            EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
            =============================================*/
            if (stock == 0) {
                swal({
                    title: "No hay stock disponible para realizar la transferencia.",
                    type: "error",
                    confirmButtonText: "¡Cerrar!"
                });
                $("button[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");
                return;
            }
            $(".nuevoProducto").append(
                    '<div class="row" style="padding:5px 15px">' +
                    '<!-- Descripción del producto -->' +
                    '<div class="col-xs-5" style="padding-right:0px">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
                    '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" idDeposito="' + idDeposito + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +
                    '</div>' +
                    '</div>' +
                    '<!-- Cantidad del producto -->' +
                    '<div class="col-xs-2">' +
                    '<input type="number" class="form-control nuevaCantidadProducto" id ="cantidad" name="nuevaCantidadProducto" min="1" value="1" stock="' + stock + '" nuevoStock="' + Number(stock - 1) + '" required>' +
                    '</div>' +
                    '</div>')
                // AGRUPAR PRODUCTOS EN FORMATO JSON
            listarProductosVentasTransferencia()
            localStorage.removeItem("quitarProducto");
        }
    })
});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
$(".tablaTransferencias").on("draw.dt", function() {
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
$(".formularioTransferencia").on("click", "button.quitarProducto", function() {
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
    if ($(".nuevoProducto").children().length == 0) {} else {
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        listarProductosVentasTransferencia()
    }
})


/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioTransferencia").on("change", "select.nuevaDescripcionProducto", function() {
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
            listarProductosVentasTransferencia()
        }
    })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioTransferencia").on("change", "input.nuevaCantidadProducto", function() {
    //var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".subTotalPrecioProducto");

    var precioFinal = $(this).val() * precio.attr("precioReal");
    precio.val(precioFinal);
    var nuevoStock = Number($(this).attr("stock")) - $(this).val();
    $(this).attr("nuevoStock", nuevoStock);
    if (Number($(this).val()) > Number($(this).attr("stock"))) {
        /*=============================================
        SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
        =============================================*/
        $(this).val(0);
        $(this).attr("nuevoStock", $(this).attr("stock"));
        var precioFinal = $(this).val() * precio.attr("precioReal");
        precio.val(precioFinal);
        swal({
            title: "La cantidad supera el Stock",
            text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
        return;
    }
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductosVentasTransferencia()
})

$(".formularioTransferencia").on("change", "input.nuevoDescuento", function() {
    var montoDescuento = $(".montoDescuento");
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var cantidad = document.getElementById('cantidad');
    //var cantidad2= $(".nuevaCantidadProducto").val();
    //alert(cantidad2);
    console.log(cantidad);
    var precioFinal = precio.attr("precioReal") * cantidad.value - ($(this).val() * precio.attr("precioReal") * cantidad.value / 100);
    precio.val(precioFinal);
    $("#montoDescuento").val($(this).val() * precio.attr("precioReal") * cantidad / 100);
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductosVentasTransferencia()
})

$(".formularioTransferencia").on("change", "input.montoDescuento", function() {
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var cantidad = document.getElementById('cantidad');
    console.log(cantidad);
    var precioFinal = precio.attr("precioReal") * cantidad.value - $(this).val();
    precio.val(precioFinal);
    //document.getElementById('nuevoDescuento').prop("disabled", true);
    //$("#nuevoDescuento").val("0");
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductosVentasTransferencia()
})

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioTransferencia").on("change", "input#nuevoValorEfectivo", function() {
    var efectivo = $(this).val();
    var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());
    var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');
    nuevoCambioEfectivo.val(cambio);
})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioTransferencia").on("change", "input#nuevoCodigoTransaccion", function() {
    // Listar método en la entrada
    listarMetodos()
})

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductosVentasTransferencia() {
    var listaProductosTransferencia = [];
    var descripcion = $(".nuevaDescripcionProducto");
    var cantidad = $(".nuevaCantidadProducto");
    var precio = $(".nuevoPrecioProducto");
    var descuento = $(".nuevoDescuento");
    var montoDescuento = $(".montoDescuento");
    for (var i = 0; i < descripcion.length; i++) {
        listaProductosTransferencia.push({
            "id": $(descripcion[i]).attr("idProducto"),
            "descripcion": $(descripcion[i]).val(),
            "cantidad": $(cantidad[i]).val(),
            "stock": $(cantidad[i]).attr("nuevoStock"),
            //  "descuento" : $(cantidad[i]).attr("descuento"),
            "precio": $(precio[i]).attr("precioReal"),
            "total": $(precio[i]).val(),
            "iddeposito": $(descripcion[i]).attr("idDeposito")
        });
    }
    $("#listaProductosTransferencia").val(JSON.stringify(listaProductosTransferencia));
}

/*=============================================
BOTON EDITAR TRANSFERENCIA
=============================================*/
$(".tablaTransferencias").on("click", ".btnEditarTransferencia", function() {
    var idTransferencia = $(this).attr("idTransferencia");
    window.location = "index.php?ruta=editar-transferencia&idTransferencia=" + idTransferencia;
})

/*BOTÓN PARA VER TRANSFERENCIA*/
$(".tablaTransferencias").on("click", ".btnVerTransferencia", function() {
    var idTransferencia = $(this).attr("idTransferencia");
    window.location = "index.php?ruta=ver-transferencia&idTransferencia=" + idTransferencia;
})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
function quitarAgregarProductoTransferencia() {
    //Capturamos todos los id de productos que fueron elegidos en la venta
    var idProductos = $(".quitarProducto");
    //Capturamos todos los botones de agregar que aparecen en la tabla
    var botonesTabla = $(".tablaTransferencias tbody button.agregarProducto");
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
$('.tablaTransferencias').on('draw.dt', function() {
    quitarAgregarProductoTransferencia();
})

/*=============================================
BORRAR TRANSFERENCIA
=============================================*/
$(".tablaTransferencias").on("click", ".btnEliminarTransferencia", function() {
    var idTransferencia = $(this).attr("idTransferencia");
    swal({
        title: '¿Está seguro de borrar la transferencia?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar transferencia!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=transferencias&idTransferencia=" + idTransferencia;
        }
    })
})

$(".tablaTransferencias").on("click", ".btnAprobarTransferencia", function() {
    var idTransferencia = $(this).attr("idTransferencia");
    window.location = "index.php?ruta=aprobar-transferencia&idTransferencia=" + idTransferencia;
})

$(".tablaTransferencias").on("click", ".btnRecepcionarTransferencia", function() {
    var idTransferencia = $(this).attr("idTransferencia");
    window.location = "index.php?ruta=recepcionar-transferencia&idTransferencia=" + idTransferencia;
})


/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker({
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
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var capturarRango = $("#daterange-btn span").html();
        localStorage.setItem("capturarRango", capturarRango);
        window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function() {
    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "transferencias";
})

/*=============================================
CAPTURAR HOY
=============================================*/
$(".daterangepicker.opensleft .ranges li").on("click", function() {
    var textoHoy = $(this).attr("data-range-key");
    if (textoHoy == "Hoy") {
        var d = new Date();
        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var año = d.getFullYear();

        dia = ("0" + dia).slice(-2);
        mes = ("0" + mes).slice(-2);
        var fechaInicial = año + "-" + mes + "-" + dia;
        var fechaFinal = año + "-" + mes + "-" + dia;
        localStorage.setItem("capturarRango", "Hoy");
        window.location = "index.php?ruta=transferencias&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
})


$("#btnGuardar").click(function(e) {

    $valor = $("#listaProductosTransferencia").val()
    if ($valor == "") {
        e.preventDefault();
        swal({
            type: "error",
            title: "La transferencia no se puede registrar porque no hay productos.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {});
    }
})

$("#cmbdepositoTransferenciaOrigen").on('change', function() {
    var idDeposito = $(this).val();
    window.location = "index.php?ruta=crear-transferencia&cmbdepositoTransferenciaOrigen=" + idDeposito;
});