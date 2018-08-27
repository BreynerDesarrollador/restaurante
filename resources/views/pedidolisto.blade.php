<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 08/02/2018
 * Time: 5:33 PM
 */
?>
@extends('layouts.cliente')
@section('content')
    <div class="container">
        <h1 class="center">Su pedido ya se encuentra listo!

        </h1>
        <div class="center">
            <img src="{{asset('img/megusta.gif')}}" width="200" height="200">

        </div>
        <div class="center">
            <a href="{{url('cliente')}}" class="btn light light-blue"><span class="glyphicon glyphicon-home"></span>Atras</a>
        </div>
    </div>
@endsection
