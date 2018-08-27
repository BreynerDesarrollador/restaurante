<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 08/11/2017
 * Time: 2:21 PM
 */
?>
@extends('layouts.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.semanticui.min.css">
    <div class="container">
        <div class="col s12 m12 l12 right">
            {{$datos->links()}}
        </div>
        <table id="tableinventario" class="ui celled table table-responsive" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>
                    Producto
                </th>
                <th>
                    Precio
                </th>
                <th>
                    Importe
                </th>
                <th>
                    Medida
                </th>
                <th>
                    Inventario
                </th>
                <th>
                    Total
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>
                    Producto
                </th>
                <th>
                    Precio
                </th>
                <th>
                    Importe
                </th>
                <th>
                    Medida
                </th>
                <th>
                    Inventario
                </th>
                <th>
                    Total
                </th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($datos as $item)
                <tr data-toggle="popover" data-trigger="hover" data-placement="top"
                    title="Estado del producto"
                    data-content="@if($item->estado=='bajo') Actualmente este producto se encuentra en esta bajo, @elseif($item->estado=='medio') Actualmente este producto se encuentra en estado medio,  @else Actualmente se encuentra en estado normal, @endif recuerde mirar el inventario de sus productos."
                    class="@if($item->estado=='bajo') red white-text @endif "
                    style="@if($item->estado=='medio')background-color: yellow;color: black!important; @endif ">
                    <td>
                        {{$item->producto}}
                    </td>
                    <td>
                        {{$item->precio}}
                    </td>
                    <td>
                        {{$item->importe}}
                    </td>
                    <td>
                        {{$item->medida}}
                    </td>
                    <td>
                        {{$item->inventario}}
                    </td>
                    <td>
                        {{$item->total}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#tableinventario").DataTable({
                'language': {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
@endsection