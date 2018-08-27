<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 16/11/2017
 * Time: 11:25 AM
 */
$op = \Illuminate\Support\Facades\Session::get('op');
?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="right">
            <button class="btn light light-green nuevousuario" data-toggle="modal" data-target="#nuevousuario">
                <span class="glyphicon glyphicon-plus-sign"></span>Crear usuarios
            </button>
            <button style="display: none" class="btn light light-green nuevousuario1" data-toggle="modal"
                    data-target="#nuevousuario">
                <span class="glyphicon glyphicon-plus-sign"></span>Crear usuarios
            </button>
        </div>
        <table id="tableinventario" class="ui celled table table-responsive" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>
                    Nombres
                </th>
                <th>
                    Apellidos
                </th>
                <th>
                    E-mail
                </th>
                <th>
                    Tipo
                </th>
                <th>
                    Gestionar
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>
                    Nombres
                </th>
                <th>
                    Apellidos
                </th>
                <th>
                    E-mail
                </th>
                <th>
                    Tipo
                </th>
                <th>
                    Gestionar
                </th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($datos as $item)
                <tr>
                    <td>
                        {{$item->nombres}}
                    </td>
                    <td>
                        {{$item->apellidos}}
                    </td>
                    <td>
                        {{$item->email}}
                    </td>
                    <td>
                        {{$item->typenombre}}
                    </td>
                    <td>
                        <input type="hidden" id="datosusuarios{{$item->id}}" name="datosusuarios{{$item->id}}"
                               value="{{collect($item)}}">
                        <a href="#!" class="aeditarusuario" value="{{$item->id}}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                        <a href="#!" class="aeliminarusuario" value="{{$item->id}}"><span
                                    class="glyphicon glyphicon-remove-circle red-text"></span></a>
                        <form action="{{url('/usuarios.eliminarusuario/'.$item->id)}}" method="POST"
                              id="eliminarusuario{{$item->id}}">
                            {{method_field('DELETE')}}
                            {{ csrf_field()}}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="nuevousuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center">Gestionar usuarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url("usuarios.guardarusuario")}}" method="post" id="formguardarusuario" role="form"
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
                        <input type="hidden" id="operacion" name="operacion" value="guardarproducto">
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input required data-toggle="popover" data-trigger="" data-placement="top"
                                       title="campo obligatorio"
                                       data-content="Corresponde al nombre del usuario..."
                                       name="nombres" id="nombres" type="text" value="{{old('nombres')}}"
                                       placeholder="Ej: Andres">
                                <label class="active" for="nombres">Nombres:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input name="apellidos" id="apellidos" type="text" data-toggle="popover"
                                       data-placement="top" data-trigger="" title="Precio" required
                                       value="{{old('apellidos')}}" placeholder="apellidos"
                                       data-content="Corresponde al apellido del usuario...">
                                <label class="active" for="apellidos">Apellidos:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input name="email" id="email" type="email" placeholder="Ej: example@dominio.com"
                                       data-toggle="popover"
                                       data-placement="top" data-trigger="" title="Email" required
                                       value="{{old('email')}}"
                                       data-content="Corresponde al correo electronico del usuario...">
                                <label class="active" for="email">E-mail:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input name="password" id="password" type="password" data-toggle="popover"
                                       data-placement="top" data-trigger="" title="password" required
                                       data-content="La contraseña debe tener como minimo 8 caracteres, para mas seguridad se recomienda letras y números...">
                                <label class="active" for="password">Contraseña:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <label for="type" class="active">Tipo de usuario:</label>
                                <select data-minimum-results-for-search="Infinity" id="type"
                                        data-toggle="popover" data-placement="top" data-trigger="" title="Precio"
                                        data-content="Corresponde a la clasificación del producto, ej: Verduras, frutas, aceites, etc."
                                        name="type" aria-required="true"
                                        class="required">
                                    <option value="">Seleccione...</option>
                                    <option value="1">Caja</option>
                                    <option value="2">Cocina</option>
                                    <option value="3">Mesero</option>
                                </select>
                            </div>
                        </div>
                        <div class="row center">
                            <button type="submit" class="btn btn-primary light light-blue"><span
                                        class="glyphicon glyphicon-floppy-save guardarproducto"></span>Guardar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green" data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
        $(document).ready(function () {
            cargarcomboselectnormal("#type");
            validarformulario('formguardarusuario', {
                nombres: "required",
                apellidos: "required",
                email: "required",
                password: "required",
                type: "required"
            });
            $(".aeliminarusuario").click(function () {
                valor = $(this).attr('value');
                $("#eliminarusuario" + valor).submit();
            });
            $(".nuevousuario").click(function () {
                //location.href = "/usuarios?op=nuevousuario";
            });
            $(".aeditarusuario").click(function () {
                valor = $(this).attr("value");
                datos = JSON.parse($("#datosusuarios" + valor).val());
                form = $("#formguardarusuario");
                $(form).find("#nombres").val(datos.nombres);
                $(form).find("#apellidos").val(datos.apellidos);
                $(form).find("#email").val(datos.email);
                $(form).find("#type").val(datos.type).trigger("change");
                $(form).attr("action", '/usuarios.editarusuario/' + valor);
                $("#password").rules("remove");
                $("#password").removeAttr("required");
                $(".nuevousuario1").click();
            });
            @if(!empty(session('op')))
            $(".nuevousuario1").click();
            @endif
        });
    </script>
@endsection