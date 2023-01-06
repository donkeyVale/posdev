/*=============================================
EDITAR UNIDAD
=============================================*/
$(".tablas").on("click", ".btnEditarUnidad", function() {

    var idUnidad = $(this).attr("idUnidad");
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
        url: "ajax/unidades.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarUnidad").val(respuesta["unidad"]);
            $("#idUnidad").val(respuesta["id"]);
            $("#codUnidad").val(respuesta["codunidad"]);
        }
    })
})

/*=============================================
ELIMINAR UNIDAD
=============================================*/
$(".tablas").on("click", ".btnEliminarUnidad", function() {
    var idUnidad = $(this).attr("idUnidad");
    swal({
        title: '¿Está seguro de borrar la unidad?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar unidad!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=unidades&idUnidad=" + idUnidad;
        }
    })
})