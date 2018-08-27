<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>


    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="restautante, bar, etc...">
    <meta name="description" content="Waiter Software para control de Ventas (Restaurantes , Bar , shopping ) numero 1 en
        innovación. Venta, Caja , Cocina e Inventario."/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:url" content="https://restaurante.willitad.com/home.html"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="WAITER"/>
    <meta property="og:description"
          content="Waiter Software para control de Ventas (Restaurantes , Bar , shopping ) numero 1 en innovación. Venta, Caja , Cocina e Inventario."/>
    <meta property="og:image" content="https://restaurante.willitad.com/img/WAITER.jpg"/>
    <title>WAITER.com.co</title>
    <!--Let browser know website is optimized for mobile-->

    <link rel="stylesheet" type="text/css" href="{{asset('css/jqueryui.css')}}" media="screen">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" media="screen">
    <link href="{{asset('css/otrosappall.css')}}" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" href="{{asset('css/bootstrapnotifications.min.css')}}" media="screen" type="text/css">
    <link href="{{asset('img/WAITER.ico')}}" rel="icon">
    <style>
        html {
            font-family: Helvetica Neue, Segoe UI, Helvetica, Arial, sans-serif;
            line-height: 1.28;
            overflow: auto;
            text-rendering: optimizeLegibility;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
        }

        .selectboton {
            width: 191px !important;
            top: 56px !important;
            opacity: 1 !important;
            display: none;

        }

        .iconos {
            stroke: rgb(0, 132, 255) !important;
            color: rgb(0, 132, 255) !important;
            width: 32px !important;
            height: 33px !important;
            cursor: pointer;
            transition: opacity .2s;
            font-size: 25px;
        }
        @media only screen and (max-width: 992px) {
            .hide-on-med-and-down {
                display: block!important;
            }
            .hide-on-med-and-down .licontainer{
                display: none;
            }
            .hide-on-med-and-down .notificaciones{
                display: block;
            }
            .dropdown-notifications>.dropdown-container, .dropdown-notifications>.dropdown-menu{
                width: 400px;
            }
            .dropdown-menu{
                height: 400px;
            }
            .brand-logo{
                left: 10%!important;
            }
        }
        @media only screen and (max-width: 600px) {
            .dropdown-notifications>.dropdown-container, .dropdown-notifications>.dropdown-menu{
                width: 220px;
            }
        }
    </style>
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
        window.appopcion = {
            op: 'mesas'
        }
    </script>

    <script src="{{asset('js/jquery.js')}}"></script>
    @if(url()->current()==url('estadisticas'))
        {!! Charts::assets() !!}
    @endif
</head>
<body>
<div id="app" v-cloak>
    <nav class="white" style="display: {{\Illuminate\Support\Facades\Auth::check()?'block':'none'}}">
        <div class="nav-wrapper">
            <a class="brand-logo"
               href="@if(\Illuminate\Support\Facades\Auth::check()){{\Illuminate\Support\Facades\Auth::user()->type==0?url('home'):url('otherhome')}}@else
                       / @endif"><img src="{{asset('img/WAITER50.png')}}"></a>
            <a href="#" data-activates="mobile-demo" class="button-collapse" style="display: none"><i class="material-icons">menu</i></a>

            <ul class="right hide-on-med-and-down">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(\Illuminate\Support\Facades\Auth::user()->type==0)
                        <li class="center">
                            <a class="dropdown-button waves-effect waves-light center grey-text" href="#!"
                               data-activates="botonproductos">
                                <i class="ion-ios-star-outline iconos"></i>
                                Productos
                                <i class="ion-android-arrow-dropdown right"></i>
                            </a>
                            <ul id="botonproductos" class="dropdown-content selectboton">
                                <li class="dropdown-header">Gestionar inventario</li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="{{url('productos')}}" class=" grey-text"><span
                                                class="ion-ios-eye-outline iconos left"></span>
                                        productos
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-button waves-effect waves-light  grey-text" href="#!"
                               data-activates="botoninventario"
                               beloworigin="true">
                                <i class="ion-ios-list-outline iconos "></i>
                                Inventario
                                <i class="ion-android-arrow-dropdown right"></i>
                            </a>
                            <ul id="botoninventario" class="dropdown-content selectboton">
                                <li class="dropdown-header">Gestionar inventario</li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('/inventario.verinventario')}}"><span
                                                class="ion-ios-eye-outline iconos left"></span>
                                        inventario
                                    </a>
                                </li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('/inventario')}}"><span
                                                class="ion-ios-plus-empty iconos left"></span>
                                        inventario</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('inventario.productos?type=1')}}"><span
                                                class="ion-ios-redo-outline iconos left "></span>
                                        Produtos
                                        salientes</a></li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('inventario.productos?type=2')}}"><span
                                                class="ion-ios-undo-outline iconos left"></span>
                                        Produtos
                                        entrantes</a></li>
                                <li role="presentation" class="divider"></li>
                                <li class="dropdown-header center"></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-button waves-effect waves-light left  grey-text" href="#!"
                               data-activates="botonmenu"
                               beloworigin="true">
                                <i class="ion-android-restaurant iconos"></i>
                                Menu
                                <i class="ion-android-arrow-dropdown right"></i>
                            </a>
                            <ul id="botonmenu" class="dropdown-content selectboton">
                                <li class="dropdown-header">Gestionar menú</li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('menu/menu')}}"><span
                                                class="ion-ios-eye-outline iconos left"></span>menú</a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('menu/platos')}}"><span
                                                class="ion-ios-eye-outline iconos left"></span>platos</a>
                                </li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('menu/bebidas')}}"><span
                                                class="ion-ios-eye-outline iconos left"></span>bebidas</a>
                                </li>
                                <li role="presentation"><a role="menuitem" class=" grey-text"
                                                           href="{{url('menu/asociarplato')}}"><span
                                                class="ion-ios-compose-outline iconos left"></span>Asociar plato</a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <li class="dropdown-header center"></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect waves-light  grey-text"
                               href="{{url('estadisticas?type=inventario')}}">
                                <i class="ion-ios-pulse iconos"></i>
                                Estadisticas
                            </a>
                        </li>
                        <li>
                            <a href="{{url('usuarios')}}" class="waves-effect waves-light  grey-text">
                                <i class="ion-ios-people-outline iconos"></i>
                                Usuarios
                            </a>
                        </li>
                        <li>
                            <a href="{{url('mesas')}}"
                               class="waves-effect waves-light  grey-text">
                                <i class="ion-ios-star-outline iconos"></i>
                                Mesas
                            </a>
                        </li>
                    @endif
                    <li class="licontainer">
                        <a href="#" style="display: block" data-activates="slide-out"
                            class="button-collapse grey-text">
                            <i aria-hidden="true" class="ion-ios-person-outline iconos" ></i>
                            {{Auth::user()->nombres.' '.Auth::user()->apellidos}}
                        </a>
                    </li>
                    <li id="notificaciones" class="notificaciones">
                        <notifications-dropdown class="grey-text notificaciones"></notifications-dropdown>
                    </li>
                    <li>
                        <a href="#" style="display: block" data-activates="slide-out"
                           class="button-collapse grey-text"><i
                                    class="ion-ios-gear-outline iconos" aria-hidden="true"></i>
                        </a>
                        <ul id="slide-out" class="side-nav">
                            <li>
                                <div class="userView">
                                    <div class="background">
                                        <img src="{{asset('img/banner01.jpg')}}"
                                             style="width:100%;heigth:100%;">
                                    </div>
                                    <a href="#!user"><img class="circle"
                                                          src="{{asset(\Illuminate\Support\Facades\Auth::user()->imagen)}}"></a>
                                    <a href="#!name"><span
                                                class="black-text name">{{\Illuminate\Support\Facades\Auth::user()->usuario}}</span></a>
                                    <a href="#!email"><span
                                                class="black-text email">{{\Illuminate\Support\Facades\Auth::user()->email}}</span></a>
                                </div>
                            </li>
                            <li><a href="#!"><i class="material-icons">add_alert</i>Notificaciones</a></li>
                            <li>
                                <notifications-demo></notifications-demo>
                            </li>
                            <li>
                                <div class="divider"></div>
                            </li>
                            <li><a class="subheader">Configuraciones</a></li>
                            <li>
                                <a href="{{url('logout')}}"
                                   class="waves-effect">Salir</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{route('login')}}" class="white-text"><span class="green"
                                                                              style="border-radius: 4px">Ingresar</span></a>
                    </li>
                    <li>
                        <a href="{{route('register',['type'=>0])}}" class="white-text"><span
                                    class="green"
                                    style="border-radius: 4px">Registrarme</span></a>
                    </li>
                @endif
            </ul>
            <ul class="side-nav" id="mobile-demo">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(\Illuminate\Support\Facades\Auth::user()->type==0)
                        <li>
                            <div class="dropdown">
                                <button class="btn btn-flat dropdown-toggle grey-text" type="button"
                                        id="productos"
                                        data-toggle="dropdown"><span
                                            class="glyphicon glyphicon-star"></span>
                                    Productos
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="productos" aria-labelledby="productos">
                                    <li class="dropdown-header">Gestionar productos</li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('productos')}}"><span
                                                    class="glyphicon glyphicon-eye-open"></span>Ver
                                            productos</a></li>
                                    <!-- <li role="presentation"><a role="menuitem" href="#">Editar productos</a></li> -->
                                    <li role="presentation" class="divider"></li>
                                    <li class="dropdown-header center"></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="btn btn-flat dropdown-toggle grey-text" type="button"
                                        id="inventario"
                                        data-toggle="dropdown"><span
                                            class="glyphicon glyphicon-list"></span>
                                    Inventario
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="inventario"
                                    aria-labelledby="inventario">
                                    <li class="dropdown-header">Gestionar inventario</li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('/inventario.verinventario')}}"><span
                                                    class="glyphicon glyphicon-eye-open"></span>Ver
                                            inventario</a></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('/inventario')}}"><span
                                                    class="glyphicon glyphicon-plus-sign"></span>Crear
                                            inventario</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('inventario.productos?type=1')}}"><span
                                                    class="glyphicon glyphicon-circle-arrow-left"></span>Inventario
                                            produtos
                                            salientes</a></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('inventario.productos?type=2')}}"><span
                                                    class="glyphicon glyphicon-circle-arrow-right"></span>Inventario
                                            produtos
                                            entrantes</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li class="dropdown-header center"></li>
                                </ul>
                            </div>

                        <li>
                            <div class="dropdown">
                                <button class="btn btn-flat dropdown-toggle grey-text" type="button"
                                        id="menu"
                                        data-toggle="dropdown"><span
                                            class="glyphicon glyphicon-cutlery"></span>Menú
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu">
                                    <li class="dropdown-header">Gestionar menú</li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('menu?op=menu')}}"><span
                                                    class="glyphicon glyphicon-plus-sign"></span>Ver
                                            menú</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('menu?op=platos')}}"><span
                                                    class="glyphicon glyphicon-plus-sign"></span>Ver
                                            platos</a></li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('menu?op=bebidas')}}"><span
                                                    class="glyphicon glyphicon-glass"></span>Ver bebidas</a>
                                    </li>
                                    <li role="presentation"><a role="menuitem"
                                                               href="{{url('menu?op=asociarplato')}}"><span
                                                    class="glyphicon glyphicon-edit"></span>Asociar
                                            plato</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li class="dropdown-header center"></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{url('estadisticas?type=inventario')}}" class="grey-text">
                                <label><span class="glyphicon glyphicon-stats"></span>
                                    Estadisticas</label>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('usuarios')}}" class="grey-text">
                                <label> <span class="glyphicon glyphicon-user"></span>Usuarios</label>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('mesas')}}" class="grey-text">
                                <label><span class="glyphicon glyphicon-star"></span>Mesas</label>
                            </a>
                        </li>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->type===3)
                    <!--  <li>
                                <a href="#!">
                                    Pedidos
                                </a>
                            </li>
                            <li>
                                <a href="#!">
                                    Pedidos pendientes
                                </a>
                            </li> -->
                    @endif
                    <li>
                        <a class="grey-text row centrarcontenido" href="#!">
                            <label class="truncate">
                                <span class="glyphicon glyphicon-user"></span>{{Auth::user()->nombres.' '.Auth::user()->apellidos}}
                            </label>
                        </a>
                    </li>
                    <li><a href="{{url('logout')}}"
                           class="waves-effect">Salir</a></li>
                    <li>
                        <notifications-dropdown></notifications-dropdown>
                    </li>
                @else
                    <li>
                        <a href="{{route('login')}}" class="white-text"><span class="green"
                                                                              style="border-radius: 4px">Ingresar</span></a>
                    </li>
                    <li>
                        <a href="{{route('register',['type'=>0])}}" class="white-text"><span
                                    class="green"
                                    style="border-radius: 4px">Registrarme</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
    @yield('content')
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
<!-- modal -->
<div id="eliminardato" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal">&times;</button>
                <h4 class="modal-title tituloeliminardato blue-text">Modal
                    Header</h4>
            </div>
            <div class="modal-body">
                <p class="textoelimardato red-text"></p>
            </div>
            <div class="modal-footer">

                <button type="button" id="cancelareliminar"
                        class="btn btn-default light-blue light-green"
                        data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button"
                        class="btn btn-default light-blue red botoneliminardato">
                    Eliminar
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Scripts -->


<!--<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>-->

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
                    <li class="left">Dirección: Carrera 10a #10-30 Centro Avenida Venezuela plazoleta telecom, edifio
                        Arnold
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

<script type="text/javascript" src="{{mix('js/appprincipalall.js')}}"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script src="{{mix('js/scriptgeneral.js')}}"></script>
<script src="{{mix('js/funcionesgeneralesall.js')}}"></script>
@if(url()->current()==url('inventario.verinventario') || url()->current()==url('doperacionesprincipal') || url()->current()==url('doperaciones.consultar'))
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js"></script>
@endif
@yield('script')
</body>
</html>
