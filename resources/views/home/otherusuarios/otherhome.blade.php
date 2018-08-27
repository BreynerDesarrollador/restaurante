<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 16/11/2017
 * Time: 4:36 PM
 */
$opcion = \Illuminate\Support\Facades\Input::get('op');
$user = \Illuminate\Support\Facades\Auth::user()->type;
$mesas = [];
$menus = [];
$usuario = \Illuminate\Support\Facades\Auth::user()->user;
?>
@extends('layouts.app')
@section("content")
    <link href="{{asset('css/platos.css')}}" rel="stylesheet">
    @if($user==3)
        @php
            $mesas=DB::select("call sp_listarmesas($usuario);");
            $menus=DB::select("call sp_infoplatomenu('infomenu',$usuario,'');");
        @endphp
        <menu-platos :datosmenus1="{{collect($menus)}}" :datosmesas1="{{collect($mesas)}}"></menu-platos>
    @elseif($user==2)
        <cocina-home></cocina-home>
    @elseif($user==1)
        <caja></caja>
    @endif
@endsection
@section('script')

@endsection