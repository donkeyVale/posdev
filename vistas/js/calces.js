/*=============================================
EDITAR CALCE
=============================================*/
$(".tablas").on("click", ".btnEditarCalce", function() {

    var idCalce = $(this).attr("idCalce");
    var datos = new FormData();
    datos.append("idCalce", idCalce);
    $.ajax({
        url: "ajax/calces.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarCalce").val(respuesta["nombre"]);
            $("#idCalce").val(respuesta["id"]);
        }
    })
})

/*=============================================
ELIMINAR CALCE
=============================================*/
$(".tablas").on("click", ".btnEliminarCalce", function() {
    var idCalce = $(this).attr("idCalce");
    swal({
        title: '¿Está seguro de borrar el calce?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar calce!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=calces&idCalce=" + idCalce;
        }
    })
})