/*=============================================
EDITAR CAJA
=============================================*/
$(".tablas").on("click", ".btnEditarCaja", function() {

    var idCaja = $(this).attr("idCaja");
    var datos = new FormData();
    datos.append("idCaja", idCaja);
    $.ajax({
        url: "ajax/cajas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarCaja").val(respuesta["cajas"]);
            $("#idCaja").val(respuesta["id"]);
            $("#editarSucursal").val(respuesta["idSucursal"]);
        }
    })
})

/*=============================================
ELIMINAR CAJA
=============================================*/
$(".tablas").on("click", ".btnEliminarCaja", function() {
    var idCaja = $(this).attr("idCaja");
    swal({
        title: '¿Está seguro de borrar la caja?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar caja!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=cajas&idCaja=" + idCaja;
        }
    })
})