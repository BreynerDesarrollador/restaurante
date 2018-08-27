/**
 * Created by windows 8.1 on 04/11/2017.
 */
$(document).ready(function () {
    cargarcomboselect("#clasificacion", "cargarcomboclasificacion");
    cargarcomboselect("#tipo", "cargarcomboproducto_tipo");
    eventosproductos();
    validarformulario("formguardarproducto", {nombre: "required", clasificacion: "requited", tipo: "required"});
});
function eventosproductos() {
    $("#formguardarproducto").submit(function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            guardarproducto();
        }
    });
}
function guardarproducto() {
    $nombre = $("#nombre").val();
    $precion = $("#precio").val();
    $clasificacion = $("#clasificacion").val();
    $tipo = $("#tipo").val();

    if ($nombre != "" && $nombre != undefined) {
        if ($clasificacion != "" && $clasificacion != undefined) {
            if ($tipo != "" && $tipo != undefined) {
                $.ajax({
                    url: '/guardarajax', // url where to submit the request
                    type: "POST", // type of action POST || GET
                    dataType: 'json', // data type
                    data: $("#formguardarproducto").serialize(), // post data || get data
                    success: function (result) {
                        // you can see the result from the console
                        // tab of the developer tools
                        Materialize.toast("Registro exitoso.");
                    },
                    error: function (error) {
                        Materialize.toast("Error::.." + error.responseText, 4000);
                    }
                })
            } else {
                Materialize.toast("Debe seleccionar el tipo del producto.", 4000);
            }
        } else {
            Materialize.toast("Debe seleccionar la clasificación del producto.", 4000);
        }
    } else {
        Materialize.toast("Debe ingresar el nombre del producto.", 4000);
    }
}
