/**
 * Created by windows 8.1 on 02/10/2017.
 */

$(document).ready(function () {
    var _to = $("meta [name=csrf-token]").val();
    $("#cargo").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/datoshome",
                dataType: "json",
                data: {
                    buscar: request.term,
                    _token:_to,
                    op:"autocompletado"

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
    $('#ciudad').select2({
        // Activamos la opcion "Tags" del plugin
        /*tags: true,
        tokenSeparators: [",", " "],*/
        ajax: {
            dataType: 'json',
            url: "/datoshome",
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    _token:_to,
                    op:"cargarciudad"
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        },
        language: "es",
        allowClear: false,
        width: '100%'
    });
});