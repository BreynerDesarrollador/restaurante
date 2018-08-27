/**
 * Created by windows 8.1 on 07/11/2017.
 */
$(document).ready(function () {
    validarformulario('formguardarinventario', {nombre: "required"});
    validarformulario('formguardarinventarioproductos', {
        producto: "required",
        centidad: "required",
        medida: "required",
        precio: "required",
        importe: "required",
        fecha_ven: "required",
        inventario: "required",
        peso: "required"
    });
    cargarcomboselect('#producto', 'cargarcomboproducto');
    cargarcomboselect('#medida', 'cargarcombomedida');
    cargarcomboselect('#productoinventario', 'cargarcomboinventario');
    cargareventosinventario();
});
function cargareventosinventario() {
    $("#medida").change(function () {
        valor = $(this).val();
        peso = $(".peso");
        if (valor == 1) {
            $(peso).rules('add', 'required');
            peso.show();
        } else {
            peso.rules('remove', 'required');
            peso.hide();
        }
    });
    $("#cantidad_peso,#precio").blur(function () {
        cantidad = $("#cantidad_peso").val();
        precio = $("#precio").val();
        if (cantidad != undefined && cantidad != "" && precio != undefined && precio != "") {
            calcularimporte(cantidad, precio);
        }
    });
    $("#cantidad_peso").change(function () {
        cantidad = $("#cantidad_peso").val();
        precio = $("#precio").val();
        if (cantidad != undefined && cantidad != "" && precio != undefined && precio != "") {
            calcularimporte(cantidad, precio);
        }
    });
    $("#precio").change(function () {
        cantidad = $("#cantidad_peso").val();
        precio = $("#precio").val();
        if (cantidad != undefined && cantidad != "" && precio != undefined && precio != "") {
            calcularimporte(cantidad, precio);
        }
    });
}
function calcularimporte(cantidad_peso, precio) {
    $("#importe").val(precio*cantidad_peso);
}