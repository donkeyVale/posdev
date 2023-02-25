$('.tablaDepositosAsignar').DataTable({
    "ajax": "ajax/datatable-usuariodeposito.ajax.php",
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
AGREGANDO DEPOSITOS A LOS USUARIOS DESDE LA TABLA
=============================================*/

$(".tablaDepositosAsignar tbody").on("click", "button.agregarDeposito", function() {
    var idDeposito = $(this).attr("idDeposito");
    $(this).removeClass("btn-primary agregarDeposito");
    $(this).addClass("btn-default");
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
            var descripcion = respuesta["deposito"];
            $(".nuevoDeposito").append(
                '<div class="row" style="padding:5px 15px">' +
                '<!-- Descripción del producto -->' +
                '<div class="col-xs-5" style="padding-right:0px">' +
                '<div class="input-group">' +
                '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarDeposito" idDeposito="' + idDeposito + '"><i class="fa fa-times"></i></button></span>' +
                '<input type="text" class="form-control nuevaDescripcionDeposito" idDeposito="' + idDeposito + '" name="agregarDeposito" value="' + descripcion + '" readonly required>' +
                '</div>' +
                '</div>' +
                '</div>')
            listarDepositos()
            localStorage.removeItem("quitarDeposito");
        }
    })
});

function listarDepositos() {
    var listaDepositos = [];
    var descripcion = $(".nuevaDescripcionDeposito");
    for (var i = 0; i < descripcion.length; i++) {
        listaDepositos.push({
            "id": $(descripcion[i]).attr("idDeposito"),
            "descripcion": $(descripcion[i]).val()
        })
    }
    $("#listaDepositos").val(JSON.stringify(listaDepositos));
}

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
$(".tablaDepositosAsignar").on("draw.dt", function() {
    if (localStorage.getItem("quitarDeposito") != null) {
        var listaIdDepositos = JSON.parse(localStorage.getItem("quitarDeposito"));
        for (var i = 0; i < listaIdDepositos.length; i++) {
            $("button.recuperarBoton[idDeposito='" + listaIdProductos[i]["idDeposito"] + "']").removeClass('btn-default');
            $("button.recuperarBoton[idDeposito='" + listaIdProductos[i]["idDeposito"] + "']").addClass('btn-primary agregarDeposito');
        }
    }
})

/*=============================================
QUITAR DEPOSITOS DE LA ASIGNACIÓN DEL USUARIO Y RECUPERAR BOTÓN
=============================================*/
var idQuitarDeposito = [];
localStorage.removeItem("quitarDeposito");
$(".formularioDeposito").on("click", "button.quitarDeposito", function() {
    $(this).parent().parent().parent().parent().remove();
    var idDeposito = $(this).attr("idDeposito");
    /*=============================================
    ALMACENAR EN EL LOCALSTORAGE EL ID DEL DEPOSITO A QUITAR
    =============================================*/
    if (localStorage.getItem("quitarDeposito") == null) {
        idQuitarDeposito = [];
    } else {
        idQuitarDeposito.concat(localStorage.getItem("quitarDeposito"))
    }
    idQuitarDeposito.push({ "idDeposito": idDeposito });
    localStorage.setItem("quitarDeposito", JSON.stringify(idQuitarDeposito));
    $("button.recuperarBoton[idDeposito='" + idDeposito + "']").removeClass('btn-default');
    $("button.recuperarBoton[idDeposito='" + idDeposito + "']").addClass('btn-primary agregarDeposito');
})

$("#btnGuardarAsignacion").click(function(e) {
    $valor = $("#seleccionarUsuario").val();
    if ($valor == "0") {
        e.preventDefault();
        swal({
            type: "error",
            title: "Tiene que seleccionar un usuario",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {});
    } else {
        $valor = $("#listaDepositos").val()
            //alert($valor);
        if ($valor == "") {
            e.preventDefault();
            swal({
                type: "error",
                title: "Tiene que asignar depósitos al usuario.",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {});
        }
    }
})

$("#seleccionarUsuario").on('change', function() {
    var idUsuario = $(this).val();
    window.location = "index.php?ruta=asignar-depositos-usuario&seleccionarUsuario=" + idUsuario;
});