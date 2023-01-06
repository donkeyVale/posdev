/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarCategoriaGasto", function() {

    var idCategoria = $(this).attr("idCategoriaGasto");
    var datos = new FormData();
    datos.append("idCategoriaGasto", idCategoria);
    $.ajax({
        url: "ajax/categoriasgasto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarCategoriaGasto").val(respuesta["nombre"]);
            $("#idCategoriaGasto").val(respuesta["id"]);
        }
    })
})

/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarCategoriaGasto", function() {
    var idCategoria = $(this).attr("idCategoriaGasto");
    swal({
        title: '¿Está seguro de borrar la categoría del gasto?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar categoría del gasto!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=categoriagastos&idCategoriaGasto=" + idCategoria;
        }
    })
})