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

    <title>WAITER.com.co | Plataforma para gestion de restaurante, bares, negocios de comida, etc..</title>
    <link href="{{asset('img/WAITER.ico')}}" rel="icon">
    <!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="{{asset('css/bootstrap3.3.7.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
    <link href="{{asset('css/ionicons.min.css')}}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/styleapp.css')}}" media="screen" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="screen" type="text/css"> -->
    <link rel="stylesheet" href="{{mix('css/otrosappall.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
</head>
<body>
<div id="fb-root"></div>
<div class="content" id="divhome">
    <div class="container wow fadeInUp delay-03s">
        <div class="row">
            <div class="logo center">
                <img src="{{asset('img/WAITER140.png')}}">
                <h2 class="teal textoinformativo">Tu mejor elección al momento de gestionar tus inventarios y
                    mejorar tus servicios hacia los clientes.</h2>
                <div class="divgestionar">
                    <a href="#!" class="btn light teal btn-info btn-lg" onclick="mostrarocultar('registrar')"><span
                                class="glyphicon glyphicon-new-window"></span>Registrarme</a>
                    <a href="#!" class="btn light teal btn-info btn-lg" onclick="mostrarocultar('login')"><span
                                class="glyphicon glyphicon-user"></span>Ingresar</a>
                    <a href="/cliente" class="btn light teal btn-info btn-lg"><span
                                class="glyphicon glyphicon-qrcode"></span>Qr code cliente</a>
                </div>
                <div id="divregistrarme" style="display:@if(session('register'))  block @else none @endif"
                     class="row">
                    @include('auth.register')
                </div>
                <div id="divlogin" style="display:@if($errors->any())  block @else none @endif" class="row right">
                    @include('auth.login')
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row bort text-center">
                <div class="social">
                    <ul>
                        <li>
                            <a href=""><i class="ion-social-facebook"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="ion-social-twitter"></i></a>
                        </li>
                    </ul>
                    <div class="fb-like" data-href="https://restaurante.willitad.com/landing-page"
                         data-layout="standard" data-action="like" data-size="large" data-show-faces="true"
                         data-share="true"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <div class="about-title">
                        <h2>Sobre WAITER</h2>
                        <p>Restaurante es una plataforma que te ayudara a gestionar tus inventarios de manera facil,
                            eficaz y organizada.
                            </br>Te muestra todos los gastos, estadisticas y graficos de tus inventarios, semanal o
                            mensual, ademas cuenta con un novedoso sistema de mejoras en entregas de pedidos, para
                            tu negocio,
                            permitiendo tener mejor respuesta en la atención de los clientes.</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp delay-02s">
                        <div class="img">
                            <i class="ion-loop"></i>
                        </div>
                        <h3 class="abt-hd">PROCESOS</h3>
                        <p>Es una plataforma escalable, sencilla y eficiente</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp delay-04s">
                        <div class="img">
                            <i class="ion-wifi"></i>
                        </div>
                        <h3 class="abt-hd">FLEXIBLE</h3>
                        <p>Solo necesitas un computador o cualquier dispositivo movil con acceso a Internet para
                            utilizar el sistema, no necesitas
                            instalar nada.</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp delay-06s">
                        <div class="img">
                            <i class="ion-cloud"></i>
                        </div>
                        <h3 class="abt-hd">CONECTADO</h3>
                        <p>Lo puedes usar desde cualquier equipo en cualquier parte del mundo. Siempre tienes el
                            control de tu negocio.</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp delay-08s">
                        <div class="img">
                            <i class="ion-clipboard"></i>
                        </div>
                        <h3 class="abt-hd">Nuestro Objetivo</h3>
                        <p>Brindarle a los usuarios finales, control financiero de sus productos y estabilidad en
                            sus negocios y mejora en los servicios prestados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="contact-info">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-title">
                        <i class="ion-email"></i>
                        <h2>Porque tus opiniones o sugerencias nos importan.</h2>
                        <p>Escribenos o envianos tus sugerencias o inquietudes,<br>con mucho gusto estaremos atento.
                        </p>
                    </div>
                </div>
                <div class="contact col-md-6 wow fadeIn delay-08s">
                    <div class="col-md-10 col-md-offset-1">
                        <div id="note"></div>
                        <div id="sendmessage"
                             style="display: {{\Illuminate\Support\Facades\Session::has('mensaje')?'block':'none'}}">Su
                            mensaje se ha enviado con exito, gracias por sus sugerencias o
                            comentarios.
                            Si quiere ver nuestros servicios ingrese a <a href="http://willitad.com"
                                                                          target="_blank">WILLITAD TICS
                                S.A.S</a></div>
                        <div id="errormessage"></div>
                        <form action="{{url('enviarcorreosugerencia')}}" method="post" role="form"
                              class="contactForm">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" required
                                       placeholder="Nombre de contacto" data-rule="minlen:4"
                                       data-msg="Please enter at least 4 chars"/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="emailcontacto" id="emailcontacto"
                                       required
                                       placeholder="Email de contacto" data-rule="email"
                                       data-msg="Please enter a valid email"/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject" required
                                       placeholder="Asunto" data-rule="minlen:4"
                                       data-msg="Please enter at least 8 chars of subject"/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                    <textarea class="form-control" name="message" rows="5" data-rule="required" required
                                              data-msg="Please write something for us"
                                              placeholder="Digite su mensaje"></textarea>
                                <div class="validation"></div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="contact-submit"><span class="ion-paper-airplane"></span>Enviar
                                    mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text"><img src="{{asset('img/WAITER140.png')}}"></h5>
                <p class="grey-text text-lighten-4">Waiter Software para control de Ventas (Restaurantes , Bar ,
                    shopping ) numero 1 en
                    innovación. Venta, Caja , Cocina e Inventario.</p>
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
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.12&appId=2020561304897900';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">
    function mostrarcargando() {
        $('#cargando').fadeIn('slow');
        $('#cuerpocargando').fadeIn('slow');
    }
    function ocultarcargando() {
        $('#cargando').fadeOut('slow');
        $('#cuerpocargando').fadeOut('slow');
    }
    function mostrarocultar(etiqueta) {
        $(".divgestionar").hide();
        if (etiqueta == "login") {
            $("#divlogin").show('slow');
            $("#divregistrarme").hide('slow');
        }
        if (etiqueta == "registrar") {
            $("#divlogin").hide('slow');
            $("#divregistrarme").show('slow');
        }
        if (etiqueta == "cancelar") {
            $(".divgestionar").show();
            $("#divlogin").hide('slow');
            $("#divregistrarme").hide('slow');
        }
    }
</script>
</body>
</html>

