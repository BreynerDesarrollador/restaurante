<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 07/11/2017
 * Time: 10:05 AM
 */
?>
@extends('layouts.app')
@section('content')
    <template>
        <div class="container">
            <fieldset>
                <form role="form" action="{{url('inventario.guardar')}}" method="post" id="formguardarinventario">
                    {{csrf_field()}}
                    <div class="row">
                        @if ($errors->any())
                            @php
                                $etiqueta=\Illuminate\Support\Facades\Input::get('etiqueta');
                            @endphp
                            @if(!empty($etiqueta))
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('.perfil').tab('show');
                                        $('.{{$etiqueta}}').tab('show');
                                        //location.href = $(".{{$etiqueta}}").attr('href');
                                    });
                                </script>
                            @endif
                        @endif
                        <div class="input-field col s12 m4 l4">
                            <input type="text" maxlength="200" placeholder="nombre del inventario..." name="nombre"
                                   id="nombre"
                                   required data-toggle="popover" data-trigger="" data-placement="top"
                                   title="campo obligatorio"
                                   data-content="Corresponde al nombre del inventario de la semana, el mes, etc... Ej: inventario mes 07 del 2017">
                            <label for="nombre" class="active">Nombre:</label>
                        </div>
                        <div class="input-field col s12 m8 l8">
                            <input type="text" maxlength="200" placeholder="descripción del inventario..."
                                   name="descripcion" id="descripcion"
                                   data-toggle="popover" data-trigger="" data-placement="top"
                                   title="campo obligatorio"
                                   data-content="Corresponde a la descripción del inventario o nota a resaltar. Este campo no es obligatorio.">
                            <label for="nombre" class="active">Descripción:</label>
                        </div>
                        <div class="col s12 m12 l12 center">
                            <button type="submit" class="btn light light-blue">Guardar</button>
                        </div>
                    </div>
                </form>
                @if(count($datosinventario))
                    <table class="table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Gestionar
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datosinventario as $item)
                            <tr>
                                <td>
                                    {{$item->nombre}}
                                </td>
                                <td>
                                    {{$item->created_at}}
                                </td>
                                <td>
                                    <a href="#!"><span class="glyphicon glyphicon-edit"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info center">
                        <strong>No hay inventarios hasta el momento.</strong>
                    </div>
                @endif
            </fieldset>

        </div>
    </template>
@endsection
@section('script')
    <script src="{{asset('js/inventario.js')}}"></script>
@endsection