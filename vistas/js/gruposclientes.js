/*=============================================
EDITAR GRUPO CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarGrupo", function() {

    var idGrupo = $(this).attr("idGrupo");
    var datos = new FormData();
    datos.append("idGrupo", idGrupo);
    $.ajax({
        url: "ajax/gruposclientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarGrupo").val(respuesta["nombre"]);
            $("#idGrupo").val(respuesta["id"]);
            $("#editarPorcentajeGrupo").val(respuesta["porcentaje"]);
        }
    })
})

/*=============================================
ELIMINAR GRUPO CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarGrupo", function() {
    var idGrupo = $(this).attr("idGrupo");
    swal({
        title: '¿Está seguro de borrar el grupo de cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar grupo!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=gruposcliente&idGrupo=" + idGrupo;
        }
    })
})