/**
 * Created by windows 8.1 on 13/10/2017.
 */
var _to = $("meta[name=csrf-token]").attr('content');
function cargarcomboselect(etiqueta, op) {
    $(etiqueta).select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/cargarcombos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: op
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        },
        maximumInputLength: 0,
        //minimumResultsForSearch: Infinity,
        theme: 'bootstrap',
        placeholder: 'Seleccione...',
        language: "es",
        allowClear: false,
        width: '100%'
    });
}
function cargarcomboselectnormal(etiqueta) {
    $(etiqueta).select2({
        //minimumResultsForSearch: Infinity,
        theme: 'bootstrap',
        placeholder: 'Seleccione...',
        language: "es",
        allowClear: false,
        width: '100%'
    });
}
function agregarchip(opcion, val, etiqueta1) {
    valor = val.val(); //opcion == "agregarconocimiento" ? $("#conocimientohabilidad").val() : $("#conocimientohabilidad");
    if (valor != "" && valor != undefined) {
        etiqueta = $("#chipclone").clone();
        etiqueta.show();
        etiqueta.find("span#textochip").html(valor);
        etiqueta.find("span#textochip").attr("value", valor);
        etiquetaglobal = etiqueta;
        $(etiqueta1).append(etiqueta);
        $.post("/guardarajax", {
            "_token": _to,
            "nivel": 0,
            "idioma": 0,
            "op": opcion,
            "nombre": valor
        }, function (data) {
            if (data['mensaje'] == "OK") {

            } else {
                etiquetaglobal.remove();
                Materialize.toast(data['mensaje'], 4000);
            }
        }).fail(function (error) {
            Materialize.toast("Error::.." + error.responseText, 4000);
        });
    } else {
        Materialize.toast("El campo no puede estar vacio.", 4000);
        $(valor).focus();
    }
    $(val).val('');
}
function combosgenerales() {
    $('#pais,.pais').select2({
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    $('#idioma,.idioma').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcomboidiomas"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    $('#ciudad,.ciudad').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcombociudad"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    cargarcomboarea();
    $('.departamento').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcombodepartamento"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    $("#cargo,.cargo").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/datoshome",
                dataType: "json",
                data: {
                    buscar: request.term,
                    _token: _to,
                    op: "autocompletado"

                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function (event, ui) {
            //log("Selected: " + ui.item.value + " aka " + ui.item.id);
        }
    });
    $('#nivelestudio,.nivelestudio').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcombonivelestudio"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    $('#nivelidioma,.nivelidioma').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcombonivelidioma"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
    $(".eliminaralerta").click(function () {
        $(".tituloeliminardato").html($(this).attr("value").split('$$')[1]);
        $(".textoelimardato").html($(this).attr("value").split('$$')[2]);
        ideliminar = $(this).attr("value").split('$$')[3];
        operacion = $(this).attr("value").split('$$')[0];
    });
    $(".botoneliminardato").click(function () {
        $.post("/eliminardato", {_token: _to, op: operacion, id: ideliminar}, function (data) {
            if (data) {
                $("#liexperiencia" + ideliminar).remove();
                $("#collectionoferta" + ideliminar).remove();
                $("#cancelareliminar").click();
                Materialize.toast("Registro eliminado con exito.", 4000);
                if (data == "eliminaralerta") {
                    location.reload();
                }
            }
        }).fail(function (error) {
            Materialize.toast("Error::.." + error.responseText);
        });
    });
}
function cargarcomboarea() {
    $('.areaexperiencia,.area').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
         tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/combos",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token: _to,
                    op: "cargarcomboarea"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        theme: 'default',
        placeholder: 'Seleccione',
        language: "es",
        allowClear: false,
        width: '100%'
    });
}
function validarformulario(form, roles) {
    $("#" + form).validate({
        errorElement: "em",
        rules: roles,
        errorPlacement: function (error, element) {
            error.remove();
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parent().find(".select2-selection,.select2-selection--single").addClass("has-error").removeClass('has-success');
            $(element).parent().find("label").addClass("has-error").removeClass('has-success');
            $(element).parents().find('input,select,textarea').addClass("has-error").removeClass("has-success");
            if (element.localName == "select") {
                $(this).addClass('select2-offscreen').show();
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent().find("label").addClass("has-success").removeClass('has-error');
            $(element).parent().find(".select2-selection,.select2-selection--single").removeClass("has-error");
            $(element).parents().find('input,select,textarea').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) { // for demo
            return true;
        }
    });
}
function solonumeros(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;

}
