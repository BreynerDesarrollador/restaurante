<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 15/11/2017
 * Time: 11:52 AM
 */
?>
@extends('layouts.app')
@section('content')
    <div class="row">
        <estadisticas></estadisticas>
        <!-- foreach(Charts::types($chart->library) as $type)
            <div class="col s12 m6 l16">
                $chart->Type($type)->render() !!}
            </div>
        endforeach-->
    </div>
@endsection
@section("script")
    <script>
        $(document).ready(function () {
            cargarcomboselectnormal("#estadisticatipo");
            cargarcomboselectnormal("#estadisticatipofiltro");
            /*$("#estadisticatipo,#estadisticatipofiltro").change(function () {
                valor = $("#estadisticatipo").val();
                valor1 = $("#estadisticatipofiltro").val();
                if (valor != undefined && valor != "" && valor1 != undefined && valor1 != "") {
                    location.href = "/estadisticas?type=" + valor + "&valor=" + valor1;
                }

            });*/
        });
    </script>
@endsection