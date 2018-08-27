<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 23/01/2018
 * Time: 10:37 AM
 */
?>
@extends('layouts.app')
@section('content')
    <div class="jumbotron">
        <div class="row">
            <fieldset>
                <legend>Listado de mesas</legend>
                <button class="btn light light-blue right botonnuevamesa" type="button" data-toggle="modal"
                        data-target="#nuevamesa">Agregar mesa
                </button>
                <table class="table-responsive table-hover container responsive-table" style="max-width: 100%">
                    <thead>
                    <tr>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Descripción
                        </th>
                        <th>
                            Mesero
                        </th>
                        <th>
                            Qr Code
                        </th>
                        <th>
                            Gestionar
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos as $item)
                        <tr id="tr{{$item->mesaid}}">
                            <td>
                                {{$item->nombre}}
                            </td>
                            <td>
                                {{$item->descripcion}}
                            </td>
                            <td>
                                <select class="selectmesero" name="mesero{{$item->mesaid}}"
                                        id="mesero{{$item->mesaid}}">
                                    <option value="">Seleccione...</option>
                                    <option value="{{$item->id}}" selected>{{$item->text}}</option>
                                </select>
                            </td>
                            <td>
                                <a href="{{url('descargarqrcode').'?file='.$item->qrimagen.'&nombre='.$item->nombre}}">
                                    <img src="{{$item->qrimagen}}" width="50" height="50">
                                </a>

                            </td>
                            <td>
                                <a href="#!" onclick="abrirpopat('{{$item->mesaid}}')"><span
                                            class="glyphicon glyphicon-remove-circle red-text center"></span></a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="#!" onclick="actualizarmesa('{{$item->id}}','{{$item->mesaid}}')"><span
                                            class="glyphicon glyphicon-floppy-save red-text center"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </fieldset>
            <div id="nuevamesa" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"
                                    data-dismiss="modal">&times;</button>
                            <h4 class="modal-title blue-text">Nueva mesa</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="formnuevamesa" action="{{url('mesaguardar')}}" method="post" role="form"
                                      novalidate>
                                    {{csrf_field()}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="input-field col s12 m6 l6">
                                        <input type="text" name="nombre" value="{{old('nombre')}}" id="nombre"
                                               maxlength="100" required>
                                        <label class="active" for="nombre">Nombre de la mesa:</label>
                                    </div>
                                    <div class="col s12 m6 l6">
                                        <select name="mesero" id="mesero" class="required selectmesero" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m12 l12">
                                    <textarea class="materialize-textarea" name="descripcion" id="descripcion" required>
{{old('descripcion')}}
                                    </textarea>
                                        <label for="descripcion" class="active">Descripción de la mesa:</label>
                                    </div>
                                    <div class="col s12 m12 l12 center">
                                        <button type="submit"
                                                class="btn btn-default light-blue red">
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-default light-blue light-green cancelarnuevamesa"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <button type="button" id="eliminarmesa" style="display: none" class="btn btn-primary" data-toggle="modal"
                    data-target="#eliminardato">
                Launch demo modal
            </button>

        </div>
        <div class="row">

        </div>
        <div class="row">

        </div>
    </div>
@endsection
@section('script')

    <script type="text/javascript">
        var eliminarmesa = 0;
        $(document).ready(function () {
            validarformulario('formnuevamesa', {nombre: 'required', descripcion: 'required', mesero: 'required'});
            $(".botoneliminardato").click(function () {
                $.post('/mesaseliminar/' + eliminarmesa, {"_token": _to}, function (data) {
                    if (data == "OK") {
                        Materialize.toast('Mesa eliminada.', 4000);
                        $("#tr" + eliminarmesa).remove();
                    }
                    else
                        Materialize.toast(data, 4000);

                    $("#cancelareliminar").click();
                }).fail(function (error) {
                    Materialize.toast('Error::..' + error.responseText, 4000);
                });
            });
            $(".selectmesero").select2({
                // Activamos la opcion "Tags" del plugin
                /*tags: true,
                 tokenSeparators: [",", " "],*/
                ajax: {
                    dataType: 'json',
                    url: "/cargarcombos",
                    delay: 250,
                    data: function (params) {
                        return {
                            buscar: '{{\Illuminate\Support\Facades\Auth::user()->id}}',
                            _token: _to,
                            op: 'cargarmesero'
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
                allowClear: true,
                width: '100%'
            });
            if ('{{$errors->any()}}') {
                $(".botonnuevamesa").click();
            }
        });
        function abrirpopat(id) {
            eliminarmesa = id;
            var popat = $("#eliminardato");
            popat.find('.tituloeliminardato').html('Eliminar mesa');
            popat.find('.textoelimardato').html('Desea eliminar la mesa seleccionada?');
            $("#eliminarmesa").click();
        }
        function actualizarmesa(id, mesaid) {
            mesero = $("#mesero" + mesaid).select2("val");
            $.post('/mesaactualizar', {"_token": _to, 'mesero': mesero, "mesaid": mesaid}, function (data) {
                if (data) {
                    Materialize.toast('Mesa actualizada.', 4000);
                }
                else
                    Materialize.toast(data, 4000);
            }).fail(function (error) {
                Materialize.toast('Error::..' + error.responseText, 4000);
            })
        }
    </script>
@endsection
