<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 07/11/2017
 * Time: 11:54 AM
 */

$operacion = \Illuminate\Support\Facades\Input::get('type');
?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <fieldset>
            <form role="form" action="{{url('inventario.productosguardar?type='.$operacion)}}" method="post"
                  id="formguardarinventarioproductos" novalidate>
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
                <input type="hidden" name="type" id="type" value="{{!empty($operacion)?$operacion:0}}">
                <div class="row">
                    <div class="col s12 m3 l3">
                        <label for="producto" class="active">Producto:</label>
                        <select class="required" name="producto" id="producto">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="col s12 m9 l9">
                        <label for="descripcion" class="active">Descripción:</label>
                        <input type="text" placeholder="Descripción..." name="descripcion" id="descripcion">
                    </div>
                    <div class="col s12 m3 l3">
                        <label for="medida" class="active">Medida:</label>
                        <select class="required" data-minimum-results-for-search="Infinity" name="medida" id="medida">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="col s12 m3 l3">
                        <label for="cantidad_peso" class="active">Cantidad/Peso:</label>
                        <input type="number" name="cantidad_peso" id="cantidad_peso" required>
                    </div>
                    <div class="col s12 m3 l3">
                        <label for="precio" class="active">Precio:</label>
                        <input type="number" name="precio" id="precio" required @if($operacion==1) readonly @endif>
                        @if($operacion==1)
                            <script>
                                $(document).ready(function () {
                                    $("#producto,#productoinventario").change(function () {
                                        producto = $("#producto").val();
                                        inventario = $("#productoinventario").val();
                                        if (producto != undefined && producto != "" && inventario != undefined && inventario != "") {
                                            $.post("/inventario.consultarprecio", {
                                                "producto": producto,
                                                "inventario": inventario,
                                                "_token": _to
                                            }, function (data) {
                                                if (data == false) {
                                                    Materialize.toast("No se pudo obtener el precio del producto e inventario seleccionado.");
                                                } else {
                                                    $("#precio").val(data).trigger('change');
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>
                        @endif
                    </div>
                    <div class="col s12 m3 l3">
                        <label for="importe" class="active">Importe:</label>
                        <input type="number" name="importe" id="importe" readonly required>
                    </div>
                    <div class="col s12 m3 l3" style="display: {{$operacion==1?'none':'block'}}">
                        <label for="fecha_ven" class="active">Fecha de vencimiento:</label>
                        <input type="date" class="datepicker" name="fecha_ven" id="fecha_ven" required>
                    </div>
                    <div class="col s12 m3 l3">
                        <label for="inventario" class="active">Inventario:</label>
                        <select class="required" name="inventario" id="productoinventario">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
                <div class="row facturacompra" style="display: {{$operacion==2?'block':'none'}} ">
                    <h5 class="blue white-text">Factura de compra</h5>
                    <hr>
                    <div class="col s12 m3 l3">
                        <label for="num_factura" class="active">Número de factura:</label>
                        <input type="text" name="num_factura" id="num_factura" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12 center">
                        <button type="submit" class="btn light light-blue"><span
                                    class="glyphicon glyphicon-floppy-disk"></span>Guardar
                        </button>
                    </div>
                </div>
            </form>

        </fieldset>
    </div>

@endsection
@section('script')
    <script src="{{asset('js/inventario.js')}}"></script>
@endsection