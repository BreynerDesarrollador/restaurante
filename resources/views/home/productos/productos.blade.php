<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 03/11/2017
 * Time: 5:15 PM
 */
?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <fieldset>
            <h5><i class="material-icons">format_list_numbered</i>Lista de productos</h5>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoproducto">
                <span class="glyphicon glyphicon-star"></span>Nuevo producto
            </button>
            <div class="col s12 m12 l12 right">
                {{$datosproductos->links()}}
            </div>
            @if(count($datosproductos))
                <table class="table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Gestionar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datosproductos as $item)
                        <tr>
                            <td>
                                {{$item->nombre}}
                            </td>
                            <td>
                                {{$item->tipo}}
                            </td>
                            <td>
                                {{$item->precio}}
                            </td>
                            <td>
                                <a href="#!"> <span class="glyphicon glyphicon-remove red-text" data-toggle="popover"
                                                    data-trigger="hover" data-placement="top"
                                                    data-content="eliminar producto"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info center">
                    <strong>No hay productos agregados hasta el momento.</strong>
                </div>
            @endif
        </fieldset>
    </div>
    <div class="modal fade" id="nuevoproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="glyphicon glyphicon-star"></span> Nuevo producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formguardarproducto" role="form" novalidate>
                        {{csrf_field()}}
                        <input type="hidden" id="operacion" name="operacion" value="guardarproducto">
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input required data-toggle="popover" data-trigger="" data-placement="top"
                                       title="campo obligatorio"
                                       data-content="Corresponde al nombre del producto a ingresar, ej: tomate, cebolla, etc..."
                                       name="nombre" id="nombre" type="text"
                                       placeholder="Ej: Tomate, cebolla, vino, etc...">
                                <label class="active" for="nombre">Nombre:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input name="precio" id="precio" type="number" placeholder="1.000" data-toggle="popover"
                                       data-placement="top" data-trigger="" title="Precio"
                                       data-content="Corresponde al precio del producto, este campo no es obligatorio, pero se utiliza para referenciar el precio de los productos.">
                                <label class="active" for="precio">Precio:</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <label for="clasificacion" class="active">Clasificacion:</label>
                                <select data-minimum-results-for-search="Infinity" id="clasificacion"
                                        data-toggle="popover" data-placement="top" data-trigger="" title="Precio"
                                        data-content="Corresponde a la clasificación del producto, ej: Verduras, frutas, aceites, etc."
                                        name="clasificacion" aria-required="true"
                                        class="required">
                                </select>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <label for="tipo" class="active">Tipo:</label>
                                <select data-minimum-results-for-search="Infinity" aria-required="true"
                                        class="required" id="tipo" name="tipo">
                                    <option value="">Seleccione...</option>
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
@section('script')
    <script src="{{asset('js/productos.js')}}"></script>
@endsection
@endsection