/**
 * Created by windows 8.1 on 01/02/2018.
 */
$(document).ready(function () {

    $('.modal').modal({
        keyboard: false
    });
    $(".timeago").timeago();
    $('.materialboxed').materialbox();
    $(".button-collapse").sideNav();
    $('.tooltipped').tooltip({delay: 50});
    $('ul.tabs').tabs();
    $('.chips').material_chip();
    $('[data-toggle="tooltip"]').tooltip();
    option = {
        delay: {"show": 500, "hide": 100}
    };
    //$('[data-toggle="popover"]').popover(option);
    // initialize materialize datepicker
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 20,
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        },
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd'
    });
    ocultarcargando();
});

function mostrarcargando() {
    $('#cargando').fadeIn('slow');
    $('#cuerpocargando').fadeIn('slow');
}
function ocultarcargando() {
    $('#cargando').fadeOut('slow');
    $('#cuerpocargando').fadeOut('slow');
}
function mostrarocultar(etiqueta) {
    $(".divgestionar").hide();
    if (etiqueta == "login") {
        $("#divlogin").show('slow');
        $("#divregistrarme").hide('slow');
    }
    if (etiqueta == "registrar") {
        $("#divlogin").hide('slow');
        $("#divregistrarme").show('slow');
    }
    if (etiqueta == "cancelar") {
        $(".divgestionar").show();
        $("#divlogin").hide('slow');
        $("#divregistrarme").hide('slow');
    }
}