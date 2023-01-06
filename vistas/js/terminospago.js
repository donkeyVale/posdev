/*=============================================
EDITAR TERMINO PAGO
=============================================*/
$(".tablas").on("click", ".btnEditarTermino", function() {

    var idTermino = $(this).attr("idTermino");
    var datos = new FormData();
    datos.append("idTermino", idTermino);
    $.ajax({
        url: "ajax/terminospago.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#idTermino").val(respuesta["id"]);
            $("#editarDias").val(respuesta["dias"]);
        }
    })
})

/*=============================================
ELIMINAR TERMINO PAGO
=============================================*/
$(".tablas").on("click", ".btnEliminarTermino", function() {
    var idTermino = $(this).attr("idTermino");
    swal({
        title: '¿Está seguro de borrar el término de pago?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar término!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=terminos-pago&idTermino=" + idTermino;
        }
    })
})