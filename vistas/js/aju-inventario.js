/*=============================================
CAPTURAR PRODUCTO
=============================================*/
$(".tablas tbody").on("click", "button.btnAjusteInv", function() {
    var idProducto = $(this).attr("idProducto");
    var idDeposito = $(this).attr("idDeposito");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    datos.append("idDeposito", idDeposito);
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            console.log(respuesta);
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#idProducto").val(respuesta["id"]);
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarCategoria").val(respuesta["id_categoria"]);
            $("#editarMarca").val(respuesta["id_marca"]);
            $("#editarUnidad").val(respuesta["id_unidad"]);
            $("#editarPrecioCompra").val(respuesta["precio_compra"]);
            $("#editarPrecioVenta").val(respuesta["precio_venta"]);
            $("#editarStock").val(respuesta["stock"]);
            $("#editarFechaVencimiento").val(respuesta["fecha_vencimiento"]);
            $("#editarTipoProducto").val(respuesta["tipo_producto"]);
            $("#editarImpuesto").val(respuesta["tipo_impuesto"]);
            $("#editarCantidadAlerta").val(respuesta["stock_minimo_alerta"]);
            $("#editarStockCritico").val(respuesta["tipo_control"]);
            $("#editarCodigo").prop("disabled", true);
            if (respuesta["imagen"] != "") {
                $("#imagenActual").val(respuesta["imagen"]);
                $(".previsualizar").attr("src", respuesta["imagen"]);
            }
        }
    })
})

/*BOTÓN PARA MOSTRAR DATOS HISTÓRICOS DE STOCK EN EL PRODUCTO*/
$(".tablas").on("click", ".btnAjusteInvHistorico", function() {
    var idStock = $(this).attr("id_stock");
    var idProducto = $(this).attr("id_producto");
    window.location = "index.php?ruta=aju-inv-historico&idStock=" + idStock +  "&id_producto=" + idProducto;
})

$("#cmbdepositoProducto_aju").on('change', function() {
    var idDeposito = $(this).val();
    //alert("Depósito: " + idDeposito);
    window.location = "index.php?ruta=aju-inventario&cmbdepositoProducto=" + idDeposito;
});

$("#btnAgregarStock").click(function(e) {
    var cantidadAjuste = $("#cantidadAjuste").val();
    var idDeposito = $("#idDeposito").val();
    var idProducto = $("#idProducto").val();
    var txtNota = $("#txtNota").val();
    var usuario = $("#usuario").val();

    if (cantidadAjuste=="") {
        swal({
            type: "error",
            title: "Ingrese una cantidad",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {});
    }
    else if (txtNota=="") {
        swal({
            type: "error",
            title: "Ingrese una nota",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {});
    }
    else {

        var datos = new FormData();
        datos.append("cantidadAjuste", cantidadAjuste);
        datos.append("idDeposito", idDeposito);
        datos.append("idProducto", idProducto);
        datos.append("usuario", usuario);
        datos.append("txtNota", txtNota);
    
        $.ajax({
            url: "ajax/stock.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                console.log(respuesta);
                if (respuesta=="ok") {
                    swal({
                        type: "success",
                        title: "Stock de producto actualizado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        location.reload();
                    });
    
                } else {
                    swal({
                        type: "error",
                        title: "No se actualizo el stock del producto",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {});
                }
            }
        })
    }
})
