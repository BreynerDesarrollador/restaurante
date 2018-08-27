<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 20/02/2018
 * Time: 9:43 AM
 */
?>
        <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Waiter Software para control de Ventas (Restaurantes , Bar , shopping ) numero 1 en
        innovación. Venta, Caja , Cocina e Inventario."/>
    <meta name="keyword" content="plataforma, restaurante, bar, cocina, mesero, caja, servicio al cliente,
escaner QR, tecnología, inventario, mesas, calidad en servicio, en tiempo real, tecnologia de punta"/>
    <meta name="pageName" content="plataforma para resturante, bar, cocina, negocios de comida."/>
    <!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link href="{{asset('css/ionicons.min.css')}}" type="text/css" rel="stylesheet"> -->
    <link href="{{asset('css/toastr.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/landingpage.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('img/WAITER.ico')}}" rel="icon">
    <title>WAITER.com.co | Plataforma para gestion de restaurante, bares, negocios de comida, etc..</title>
    <style>
        body {
            background-image: url("{{asset('img/fondopage.jpg')}}");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .form-signin {
            width: 100%;
            max-width: 420px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .paner {
            background-color: rgba(125, 125, 125, 0.5);
            border-radius: 4px;
            color: white;
        }

        .has-error input {
            border-color: red;
        }

        .has-error select {
            border-color: red;
        }

        .has-error textarea {
            border-color: red;
        }

        .requerido {
            color: red;
        }

        .logowaiter {
            margin: auto;
            display: block;
            height: 150px;
            width: 150px;
        }

        .alinearizquierda {
            margin: auto;
            display: block;
            float: right;
            text-align: right;
        }

        .enviarlogin {
            padding-bottom: 3%;
            padding-top: 3%;
        }

        @media only screen and (max-width: 430px) {
            #conteo {
                font-size: 35px !important;

            }

            .badge {
                white-space: inherit !important;
            }
        }

        @media only screen and (max-width: 768px) {
            #conteo {
                font-size: 35px !important;
            }

            .badge {
                white-space: inherit !important;
            }
        }
    </style>
</head>
<body>
<div class="w-10 rounded" style="background-color: 	#007994">
    <div class="col col-12 col-md-12 col-xl-12 float-center textt-center">
        <img src="{{asset('img/WAITER.png')}}" class="logowaiter">
    </div>

</div>
<div class="container">
    <br>
    <div class="row">
        <div class="col col-12 col-md-12 col-xl-12">
            <div class="text-center enviarlogin ">
                <h3 class="text-light">
                    <h2 class="text-light"><strong>Tiempo restante para la promoción</strong></h2>
                    <h1 class="lead text-light btn btn-danger btn-large enviarlogin"
                        style="font-size: 55px"
                        id="conteo"></h1>
                </h3>
                <div class="enviarlogin">
                    <a href="https://api.whatsapp.com/send?phone=+573157311004&text=Hola%20WAITER%20quisiera%20tener%20mas%20información%20de%20la%20de%20plataforma%20WAITER"
                       target="_blank" class="btn btn-success"><strong><span class="ion-social-whatsapp-outline"></span>
                            3157311004 - HAZ CLICK AQUÍ</strong></a>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-7 col-xl-7 text-center">
            <br>
            <div class="card paner">
                <div class="card-body">
                    <img src="{{asset('img/farmtotable.png')}}" width="100%" height="675">
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-5 col-xl-5 form-signin">
            <br>
            <div class="paner">
                <div class="card-body">
                    <form class="form-horizontal" id="formpruebagratis" role="form" action="{{url('postprueba')}}"
                          method="post">
                        {{csrf_field()}}

                        <div class="text-center mb-4">
                            <h4>WAITER</h4><br>
                            <p class="badge badge-primary p-2">Quieres obtener una prueba <code>gratis</code> diligencia
                                tus datos.</p>
                        </div>
                        @if(\Illuminate\Support\Facades\Session::has('mensaje'))
                            <div class="alert alert-info">
                                <span>Gracias por registrarse en nuestro portal.</span>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-auto {{ $errors->has('inputcorreo') ? ' has-error' : '' }}">
                            <label class="sr-only" for="inputcorreo">Correo</label>
                            <div class="input-group mb-2 ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="ion-email"></span></div>
                                </div>
                                <input type="email" required value="{{old('inputcorreo')}}" class="form-control"
                                       name="inputcorreo" id="inputcorreo"
                                       placeholder="Correo"><span class="requerido">*</span>
                            </div>
                        </div>

                        <div class="col-auto {{ $errors->has('inputtelefono') ? ' has-error' : '' }}">
                            <label class="sr-only" for="inputtelefono">Teléfono</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="ion-ios-telephone-outline"></span></div>
                                </div>
                                <input type="number" required value="{{old('inputtelefono')}}" class="form-control"
                                       name="inputtelefono" id="inputtelefono"
                                       placeholder="Teléfono"><span class="requerido">*</span>
                            </div>
                        </div>
                        <div class="col-auto {{ $errors->has('inputnombre') ? ' has-error' : '' }}">
                            <label class="sr-only" for="inputnombre">Nombre completo</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="ion-person"></span></div>
                                </div>
                                <input type="text" required value="{{old('inputnombre')}}" class="form-control"
                                       name="inputnombre" id="inputnombre"
                                       placeholder="Nombre completo"><span class="requerido">*</span>
                            </div>
                        </div>
                        <div class="col-auto {{ $errors->has('inputrazonsocial') ? ' has-error' : '' }}">
                            <label class="sr-only" for="inputrazonsocial">Razón social de su negocio</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="ion-earth"></span></div>
                                </div>
                                <input type="text" required value="{{old('inputrazonsocial')}}"
                                       class="form-control text-uppercase" name="inputrazonsocial"
                                       id="inputrazonsocial"
                                       placeholder="Razón social de su negocio"><span class="requerido">*</span>
                            </div>
                        </div>
                        <div class="col-auto {{ $errors->has('selectsucursales') ? ' has-error' : '' }}">
                            <label class="sr-only" for="selectsucursales">Número de sucursales</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="ion-pricetags"></span></div>
                                </div>
                                <select class="custom-select required" name="selectsucursales" id="selectsucursales"
                                        required>
                                    <option value="">Seleccione las sucursales...</option>
                                    @for($i=1;$i<11;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                    <option value="10+">10+</option>
                                </select><span class="requerido">*</span>
                            </div>
                        </div>
                        <div class="col-auto {{ $errors->has('textareanegocio') ? ' has-error' : '' }}">
                            <label for="textareanegocio" class="badge badge-primary">Cuentenos sobre su negocio:<span
                                        class="requerido">*</span></label>
                            <textarea class="form-control" id="textareanegocio" required name="textareanegocio" rows="3"
                                      placeholder="Cuentenos sobre su negocio"></textarea>
                        </div>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block text-center btnenviar" type="submit">
                            <img src="{{asset('img/cargando.gif')}}" class="imgenviarajax" style="display: none">
                            <i class="ion-ios-paperplane-outline enviarajax" style="font-size:29px;"></i>
                            <span class="enviarajax">Registrarme</span>
                        </button>
                        <p class="mt-5 mb-3 text-light text-center"><a class="text-light" href="http://willitad.com"
                                                                       target="_blank">
                                <code>WILLITAD
                                    TICS S.A.S </code></a>© 2017-{{date('Y')}}</p>
                        <span id="clock"></span>
                    </form>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-12 col-xl-12 text-center">
            <br>
            <div class="card paner">
                <div class="card-body">
                    <!-- <p class="font-weight-bold text-left text-lingh">
                        WAITER es una novedosa plataforma para el control de ventas (restaurante, bar, shopping)
                        numero 1 en innovación. <br>
                        Cuenta con modulo de ventas, caja, cocina, mesero e inventario.
                        <br>
                        Ademas cuenta con un sistema de pedidos automatizados, moderno, flexible y
                        fácil de usar.
                        <br>
                        Obten el control desde cualquier dispositivo movil o PC, desde cualquier parte,
                        no tienes excusas, <strong class="text-warning">!PRUEBALA YA!</strong>
                    </p>
                    <BR>-->
                    <img src="{{asset('img/WAITERpublicidad.jpg')}}" width="80%">
                    <br><br>
                    Condiciones del servicio.
                    <a href="#!" class="text-warning enviarlogin"><strong>Ver
                            condiciones.</strong></a>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-12 col-xs-12 text-center">
            <div class="enviarlogin">
                <a href="https://api.whatsapp.com/send?phone=+573157311004&text=Hola%20WAITER%20quisiera%20tener%20mas%20información%20de%20la%20de%20plataforma%20WAITER"
                   target="_blank" class="btn btn-success"><strong><span class="ion-social-whatsapp-outline"></span>
                        3157311004 - HAZ CLICK AQUÍ</strong></a>
            </div>
            <h3 class="text-light"><strong>Qué dicen nuestros clientes</strong></h3>
            <br>
        </div>
        <div class="col col-12 col-md-6 col-xs-6">

            <div class="media border dorder-primary rounded paner">
                <img class="align-self-center rounded-circle" width="100" height="100"
                     src="{{asset('img/storage/default.PNG')}}">
                <div class="media-body text-light">
                    <h5 class="mt-0 text-light">Andres Perez <span class="text-muted"> Cartagena-Bolívar</span></h5>
                    <p class="text-left font-italic">
                        “Para nosotros la plataforma es una herramienta fundamental para el control diario de nuestro
                        negocio, nos permite estar conectados en todo momento y desde donde estemos, de esa forma no se
                        nos escapa nada. Es cómodo para los clientes y para nosotros, ademas solo necesitas una
                        conexión de internet y listo, se tiene todo el control de nuestro negocio.”
                        <a href="#!" class="btn btn-link text-warning enviarlogin"><strong>Ver
                                testimonio.</strong></a>
                    </p>

                </div>
            </div>

        </div>
        <div class="col col-12 col-md-6 col-xs-6">
            <div class="media border dorder-primary rounded paner text-left">
                <img class="align-self-center rounded-circle" width="100" height="100"
                     src="{{asset('img/storage/default.PNG')}}">

                <div class="media-body text-light">
                    <h5 class="mt-0 text-light">Geraldine Betancourt<span class="text-muted"> Cartagena-Bolívar</span>
                    </h5>
                    <p class="text-left font-italic">
                        “WAITER nos ha servido para controlar las ventas y estar al día con los inventarios de
                        productos críticos, además nos permite independizarnos más de nuestro negocio y tener control
                        del mismo y que los clientes pueden hacer sus pedidos directamente a cocina sin que los atienda
                        un mesero.”
                        <a href="#!" class="btn btn-link text-warning enviarlogin"
                        ><strong>Ver testimonio.</strong></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-12 col-xs-12 text-center">
            <div class="enviarlogin">
                <a href="https://api.whatsapp.com/send?phone=+573157311004&text=Hola%20WAITER%20quisiera%20tener%20mas%20información%20de%20la%20de%20plataforma%20WAITER"
                   target="_blank" class="btn btn-success"><strong><span class="ion-social-whatsapp-outline"></span>
                        3157311004 - HAZ CLICK AQUÍ</strong></a>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.countdown.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function () {
        @if(\Illuminate\Support\Facades\Session::has('mensaje'))
        // Override global options
        toastr.success('Gracias por registrarse en nuestro portal, nosotros nos estaremos comunicando con usted', 'WAITER plataforma de servicio', {timeOut: 5000});
        @endif
$('.carousel').carousel();
        $('#conteo').countdown('2018/03/31', function (event) {
            $(this).text(event.strftime('%D días %H:%M:%S'));
        });
        $("#formpruebagratis").submit(function (e) {
            e.preventDefault();
            $(".enviarajax").hide();
            $(".imgenviarajax").show();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                if (data.msj == "OK") {
                    $(".imgenviarajax").hide();
                    $(".enviarajax").show();
                    toastr.success('Gracias por registrarse en nuestro portal, nosotros nos estaremos comunicando con usted', 'WAITER plataforma de servicio', {timeOut: 5000});
                    $("#formpruebagratis").find('input,select,textarea').val('');
                    $("#formpruebagratis").find('select').val('');
                    location.reload();
                } else {
                    toastr.info('Debe rellenar los campos obligatorios', 'Datos incompletos');
                }
            }).fail(function (error) {
                toastr.warning(error.responseText, "Error");
            });
        });
        $('.enviarlogin').click(function () {
            $('#inputcorreo').focus();
        });
    });

</script>
</body>
</html>