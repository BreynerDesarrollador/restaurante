/**
 * Created by windows 8.1 on 14/11/2017.
 */
$(document).ready(function () {
    validarformulario("formguardarplato", {
        nombre: "required",
        descripcion: "required",
        precio: "required",
        imagen: "required"
    });
    validarformulario("formguardarbebida", {
        nombre: "required",
        descripcion: "required",
        precio: "required",
        imagen: "required"
    });
    $("#precio").keypress(function (event) {
        return solonumeros(event);
    });
    $("#descuento").keypress(function (event) {
        return solonumeros(event);
    });
    $("#descuento").blur(function () {
        if ($(this).val() != "") {
            $("#fechadesde").rules('add', "required");
            $("#fechahasta").rules('add', "required");
        } else {
            $("#fechadesde").rules('remove', "required");
            $("#fechahasta").rules('remove', "required");
        }
    });
    $(".lieditar").click(function () {
        valor = $(this).attr("value").split("$$")[0];
        opcion = $(this).attr("value").split("$$")[1];
        datos = JSON.parse($("#info" + valor).val());

        if (opcion == "platos") {
            $("#formguardarplato #imagen").rules("remove", "required");
            $("#formguardarplato #imagen").removeAttr("required");
            $("#formguardarplato #nombre").val(datos.nombre);
            $("#formguardarplato #descripcion").val(datos.descripcion);
            $("#formguardarplato #precio").val(datos.precio);
            $("#formguardarplato #descuento").val(datos.descuento);
            $("#formguardarplato #imagenanterior").val(datos.imagen);
            $("#formguardarplato #estado").val(datos.estado);
            $("#formguardarplato #fechadesde").val(datos.desc_desde);
            $("#formguardarplato #fechahasta").val(datos.desc_hasta);
            $("#operacion").val(valor);
            $("#formguardarplato").attr("action", '/menu.actualizarmenu/plato/' + datos.id);
            $('.agregarplato').click();
        }
        if (opcion == "menu") {
            $("#formguardarmenu #imagen").rules("remove", "required");
            $("#formguardarmenu #imagen").removeAttr("required");
            $("#formguardarmenu #nombre").val(datos.nombre);
            $("#formguardarmenu #descripcion").val(datos.descripcion);
            $("#formguardarmenu #imagenanterior").val(datos.imagen);
            $("#formguardarmenu").attr("action", '/menu.actualizarmenu/menu/' + datos.id);
            $('.agregarmenu').click();
        }
        if (opcion === "bebidas") {
            $("#formguardarbebida #imagen").rules("remove", "required");
            $("#formguardarbebida #imagen").removeAttr("required");
            $("#formguardarbebida #nombre").val(datos.nombre);
            $("#formguardarbebida #descripcion").val(datos.descripcion);
            $("#formguardarbebida #precio").val(datos.precio);
            $("#formguardarbebida #descuento").val(datos.descuento);
            $("#formguardarbebida #imagenanterior").val(datos.imagen);
            $("#formguardarbebida #estado").val(datos.estado);
            $("#formguardarbebida #fechadesde").val(datos.desc_desde);
            $("#formguardarbebida #fechahasta").val(datos.desc_hasta);
            $("#operacion").val(valor);
            $("#formguardarbebida").attr("action", '/menu.actualizarmenu/bebida/' + datos.id);
            $('.agregarbebida').click();
        }
    });
    var id, opciongeneral, imagen;
    $(".lieliminar").click(function () {
        id = $(this).attr("value").split("$$")[0];
        opciongeneral = $(this).attr("value").split("$$")[1];
        imagen = $(this).attr("value").split("$$")[2];
        if (opciongeneral == "eliminarplato") {
            $("#eliminarplatomenu #mensaje").html("Dese eliminar el plato seleccionado?");
        }
        if (opciongeneral == "eliminarmenu")
            $("#eliminarplatomenu #mensaje").html("Dese eliminar el menú seleccionado?");
        if (opciongeneral == "eliminarbebida")
            $("#eliminarplatomenu #mensaje").html("Dese eliminar la bebida seleccionada?");

        $(".botonaliminarplatomenu").click();
    });
    $("#botoneliminar").click(function () {
        $.post("/menu.eliminar", {"id": id, "opcion": opciongeneral,"imagen":imagen, "_token": _to}, function (data) {
            if (data) {
                $("#card" + data).remove();
                $(".btneliminarcancelar").click();
            }
        }).fail(function (error) {
            Materialize.toast("Error::.." + error.responseText, 4000);
        })
    });
    $(".cambiarestado").click(function () {
        estado = $(this).attr("value").split("$$")[0];
        id = $(this).attr("value").split("$$")[1];
        operacion = $(this).attr("value").split("$$")[2];
        $.post("/menu.estado", {"id": id, "estado": estado, "_token": _to, op: operacion}, function (data) {
            if (data) {
                $("#cambiarestado" + data["id"]).attr("value", data["estado"] + "$$" + data["id"] + '$$' + data['operacion']);
                if (data["estado"] == 0)
                    $("#cambiarestado" + data["id"]).html('<span class="glyphicon glyphicon-eye-open left"></span>');
                else
                    $("#cambiarestado" + data["id"]).html('<span class="glyphicon glyphicon-eye-close left"></span>');
            }
        }).fail(function (error) {
            Materialize.toast("Error::.." + error.responseText, 4000);
        });
    });
    $(".listadeplatos").click(function () {
        mostrarcargando();
        id = $(this).attr('value');
        idmenu = id;
        $.post("/menu.listadeplatosmenu", {"menu": id, "_token": _to}, function (data) {
            etiqueta = '<ul class="list-group">';
            $.each(data, function (pos, val) {
                etiqueta += '<li id="menuplato' + val.id + '" class="list-group-item d-flex justify-content-between align-items-center">'
                    + val.nombre
                    + '<a href="#!" class="right eliminarplatomenu1" value="' + val.id + '"><span class="glyphicon glyphicon-remove-circle red-text"></span></a>'
                    + '</li>';
            });
            etiqueta += '</ul>';
            $("#listadeplatos").find(".modal-body").html(etiqueta);
            $(".eliminarplatomenu1").click(function () {
                id = $(this).attr('value');
                $.post("/menu.eliminar", {"id": id, "opcion": "eliminarplatomenu", "_token": _to}, function (data) {
                    if (data) {
                        $("#menuplato" + data).remove();
                        etiqueta = $("#cantidadplatos" + idmenu);
                        cantida = parseInt($("#cantidadplatos" + idmenu).html()) - 1;
                        $(etiqueta).html(cantida);
                        Materialize.toast("Eliminación exitosa.", 4000);
                    }
                }).fail(function (error) {
                    Materialize.toast("Error::.." + error.responseText, 4000);
                })
            });
        }).fail(function (error) {
            Materialize.toast("Error::.." + error.responseText, 4000);
        });
        ocultarcargando();
        $(".botonlistadeplatos").click();
    });
});
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    idmenu = $("#" + ev.currentTarget.id).attr('value');
    idplato = $("#" + data).attr("value");
    if (idmenu != undefined && idmenu != "" && idplato != undefined && idplato != "") {
        $.post("/menu.asociarplato", {"menu": idmenu, "plato": idplato, "_token": _to}, function (data) {
            if (data["mensaje"] == "OK") {
                Materialize.toast("Se agrego correctamente el plato al menu.", 4000);
                cantida = parseInt($("#cantidadplatos" + data["id"]).html()) + 1;
                $("#cantidadplatos" + data["id"]).html(cantida);
            } else {
                Materialize.toast(data["mensaje"], 4000);
            }
        }).fail(function (error) {
            Materialize.toast("Error:..." + error.responseText, 4000);
        });
    }
    //ev.target.appendChild(document.getElementById(data));
}