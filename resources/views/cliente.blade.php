<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 23/01/2018
 * Time: 5:37 PM
 */
?>
@extends('layouts.cliente')
@section('content')
    <div class="col s12 m12 l12" style="background-color: #eae3ea;">
        @if(session()->get('cliente'))
            @if(!\Illuminate\Support\Facades\Auth::check())
                <div class="container">
                    <div class="card text-center">
                        <div class="card-header text-muted">
                            Conectate por medio de tus redes sociales
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><img class="img-responsive center-block" height="100" width="100"
                                                        src="{{asset('img/WAITER140.png')}}"
                                                        alt="WAITER.com.co"></h5>
                            <p class="card-text">
                                <br>
                                <a class="btn btn-block btn-social btn-facebook"
                                   href="{{ route('social.auth', 'facebook') }}">
                                    <span class="fa fa-facebook"></span>Iniciar sesión Facebook
                                </a><br>
                                <a class="btn btn-block btn-social btn-google"
                                   href="{{ route('social.auth', 'google') }}">
                                    <span class="fa fa-google"></span>Iniciar sesión con Google
                                </a><br>

                            <div class="fb-like" data-href="https://restaurante.willitad.com/landing-page"
                                 data-layout="button" data-action="like" data-size="large" data-show-faces="true"
                                 data-share="true"></div>


                            <h3 class="teal transparent">

                                Para ingresar es necesario registrarse o iniciar sesión mediante tus redes sociales,
                                gracias por utilizar nuestro portal web.
                            </h3>

                            <a class="btn btn-outline-primary btn-block  btn-social"
                               href="{{url('clientesalir')}}">
                                <span class="ion-close-circled"></span>Cancelar
                            </a>
                            </p>
                        </div>
                        <div class="card-footer text-muted">

                            Para mayor información ingresar a <a href="http://willitad.com"
                                                                 target="_blank">Willitad.com</a>
                        </div>
                    </div>

                </div>
    </div>
    @else
        @if(\Illuminate\Support\Facades\Auth::user()->type==6)
            @php
                $menus=[];
                $usuario=\Illuminate\Support\Facades\Auth::user()->user;
                $menus=DB::select("call sp_infoplatomenu('infomenu',$usuario,'');");
            @endphp
            @if(!\Illuminate\Support\Facades\Auth::check())
                <script type="text/javascript">
                    $(document).ready(function () {
                        location.href = '/';
                    });
                </script>
            @endif
            <cliente-pedido :datoscliente="{{collect(session()->get('cliente'))}}"
                            :datosmenus1="{{collect($menus)}}"></cliente-pedido>
        @endif
    @endif
    @else
        <div class="row">
            <div class="container center">
                <div class="col s12 m12 l12">
                    <video id="preview" style="width: 100%;"></video>
                </div>


            </div>
        </div>


        </div>
        <div class="col s12 m12 l12">
        </div>
        <div id="fb-root"></div>
@section('script')
    <script src="{{mix('js/instascanall.js')}}"></script>
    <script async src="{{asset('js/escaner.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var ancho = $("body").height();
            $("#preview").height(ancho - 56 - 56);
        });
        $(function () {
            $('.example-popover').popover({
                container: 'body'
            })
        })
    </script>
@endsection
@endif
@endsection