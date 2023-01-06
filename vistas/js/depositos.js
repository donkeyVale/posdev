/*=============================================
EDITAR DEPOSITO
=============================================*/
$(".tablas").on("click", ".btnEditarDeposito", function() {

    var idDeposito = $(this).attr("idDeposito");
    var datos = new FormData();
    datos.append("idDeposito", idDeposito);
    $.ajax({
        url: "ajax/depositos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#editarDeposito").val(respuesta["deposito"]);
            $("#idDeposito").val(respuesta["id"]);
        }
    })
})

/*=============================================
ELIMINAR DEPOSITO
=============================================*/
$(".tablas").on("click", ".btnEliminarDeposito", function() {
    var idDeposito = $(this).attr("idDeposito");
    swal({
        title: '¿Está seguro de borrar el depósito?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar depósito!'
    }).then(function(result) {
        if (result.value) {
            window.location = "index.php?ruta=depositos&idDeposito=" + idDeposito;
        }
    })
})