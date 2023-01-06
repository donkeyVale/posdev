$('#seleccionSucursal').on('change', function() {
    var idSucursal = $(this).val();
    var datos = new FormData();
    datos.append("idSucursal", idSucursal);
    $.ajax({
        url: "ajax/aperturas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $('#caja').html(respuesta);
        }
    })
});

$(".tablas").on("click", ".btnCerrarCaja", function() {

    var idApertura = $(this).attr("idApertura");
    var datos = new FormData();
    datos.append("idApertura", idApertura);
    $.ajax({
        url: "ajax/veraperturas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#nombreSucursal").val(respuesta["sucursal"]);
            $("#idApertura").val(respuesta["id"]);
            $("#nombreCaja").val(respuesta["cajas"]);
            $("#fechaApertura").val(respuesta["fechaapertura"]);
            $("#montoApertura").val(respuesta["monto_apertura"]);
            $("#montoCierre").val(respuesta["monto_cierre"]);

            $("#nombreSucursal").prop("disabled", true);
            $("#nombreCaja").prop("disabled", true);
            $("#fechaApertura").prop("disabled", true);
            $("#montoApertura").prop("disabled", true);

            if (respuesta["estado"] == "1") //Si esta aperturado
            {
                $("#montoCierre").prop("disabled", false);
                $("#btnCerrar").show();
                $("#btnCerrar").prop("disabled", false);
            } else {
                $("#montoCierre").prop("disabled", true);
                //$("#btnCerrar").prop("disabled", true);
                $("#btnCerrar").hide();
            }
        }
    })
})

$(".tablas").on("click", ".btnEliminarCaja", function() {
    var idApertura = $(this).attr("idApertura");
    swal({
        title: '¿Está seguro de borrar la caja aperturada?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar caja aperturada!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=aperturas&idApertura=" + idApertura;
        }
    })
})