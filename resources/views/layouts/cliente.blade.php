<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 24/01/2018
 * Time: 9:53 AM
 */

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
?>
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WAITER</title>
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <!--Import materialize.css-->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    @if(\Illuminate\Support\Facades\Auth::check())

        <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    @endif

    <link rel="stylesheet" href="{{mix('css/otrosall.css')}}">
    <link href="{{asset('img/WAITER.ico')}}" rel="icon">
    <style>
        html, body {
            font-size: 1rem;
        }
    </style>


    <!-- Styles -->
    <script>
        window.Laravel = {!! json_encode([
            'user' => Auth::user(),
            'csrfToken' => csrf_token(),
            'vapidPublicKey' => config('webpush.vapid.public_key'),
            'pusher' => [
                'key' => config('broadcasting.connections.pusher.key'),
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            ],
        ]) !!};
        window.datoscliente = {!! json_encode([
            'datos' => session()->get('cliente')
        ]) !!};
        window.appopcion = {
            op: 'mesas'
        }
        window.idbebidadplatos = [];
    </script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.12&appId=2020561304897900&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
<div id="app" v-cloak>
    @if(\Illuminate\Support\Facades\Auth::check())
        <nav class="navbar navbar-inverse" style="height: auto">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand " style="padding: 0%" href="#"><img height="50" width="50"
                                                                               src="{{ \Illuminate\Support\Facades\Auth::user()->imagen}}"
                                                                               class="img-circle "></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#!">
                                {{\Illuminate\Support\Facades\Auth::user()->nombres}}
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{url('clientesalir')}}">
                                <span style="display: inline-block" class="ion-ios-close-outline"></span>Salir
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    @elseif(!session()->get('cliente'))
        <div class="col s12 m12 l12 text-center p-2 text-primary">
                <span class="float-left">
                    <a href="{{url()->previous()}}" class="text-primary">
                        <span class="ion-chevron-left"></span>
                    </a>
                </span>
            <span>
                    <a href="#!" class="text-dark"><span class="">Escannee su codigo QR</span></a>

                </span>
            <span class="float-right">
                    <a tabindex="0" data-placement="top" class="example-popover right white-text float-right"
                       role="button" style="font-size: 19px"
                       data-toggle="popover" data-trigger="focus" title="Información"
                       data-content="Por favor escanee el codigo QR de la mesa, recuerde no mover mucho su celular,
                    para
                    una mayor lectura, recuerde permitir acceder a su camara para poder escanear el codigo QR.">
                        <span class="ion-help-circled"></span>
                    </a>

                </span>
        </div>
    @endif
    @yield('content')
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text"><img src="{{asset('img/WAITER140.png')}}"></h5>
                    <p class="grey-text text-lighten-4">Plataforma para todo tipo de negocios de comidas y manejo de
                        inventario de productos.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Datos de contacto</h5>
                    <ul class="left">
                        <li class="left">Teléfono: 6686457</li>
                        <li class="left">Celular: 3157311004</li>
                        <li class="left">E-mail: mercadeo@willitad.com</li>
                        <li class="left">E-mail: gerencia@willitad.com</li>
                        <li class="left">Dirección: Carrera 10a #10-30 Centro Avenida Venezuela plazoleta telecom,
                            edifio Arnold
                            Puello.
                        </li>
                        <li class="left">Cartagena, Bolívar</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            © Derechos reservados WILLITAD TICS S.A.S
            <div class="credits">
                Empresa de desarrollo <a href="http://willitad.com/" target="_blank">Willitad tics s.a.s</a>
            </div>
        </div>
    </footer>
</div>
<div class="preloader-background" id="cargando">
    <div class="preloader-wrapper big active" id="cuerpocargando">
        <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-red">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

        <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
{{-- Polyfill JS features via polyfill.io --}}
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>
<script src="{{asset('js/clientepedido.js')}}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@if(\Illuminate\Support\Facades\Auth::check())
    <!-- <script type="text/javascript">
        $(document).ready(function () {
            $(".button-collapse").sideNav();
        });
    </script> -->
@else
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
@endif

@yield('script')



</body>
</html>


