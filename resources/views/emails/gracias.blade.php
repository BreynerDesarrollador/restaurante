<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 05/03/2018
 * Time: 11:24 AM
 */
?>
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
    <style>
        :root {
            --blue: #007bff;
            --indigo: #6610f2;
            --purple: #6f42c1;
            --pink: #e83e8c;
            --red: #dc3545;
            --orange: #fd7e14;
            --yellow: #ffc107;
            --green: #28a745;
            --teal: #20c997;
            --cyan: #17a2b8;
            --white: #fff;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --breakpoint-xs: 0;
            --breakpoint-sm: 576px;
            --breakpoint-md: 768px;
            --breakpoint-lg: 992px;
            --breakpoint-xl: 1200px;
            --font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
            --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -ms-overflow-style: scrollbar;
            -webkit-tap-highlight-color: transparent;
        }
        .jumbotron {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
            border-radius: .3rem;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .display-3 {
            font-size: 4.5rem;
            font-weight: 300;
            line-height: 1.2;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .text-light {
            color: #f8f9fa !important;
        }

        .bg-dark {
            background-color: #343a40 !important;
        }

        .text-center {
            text-align: center !important;
        }

        .row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        .h5, h5 {
            font-size: 1.25rem;
        }

        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: .5rem;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: .5rem;
        }
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }

        .bg-dark {
            background-color: #343a40 !important;
        }
        .text-light {
            color: #f8f9fa !important;
        }
    </style>
</head>
<body>
<main role="main">
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h5 class="display-3">Gracias por inscribirte a WAITER!</h5>
            <p>Si necesitas una asesoria, llamanos o escribenos al 3157311004, con gusto lo atenderemos.<br>
                Recuerde!<br>
                <span class="badge badge-info">Interpretamos</span><span
                        class="badge badge-warning text-light">Implementamos</span><span
                        class="badge badge-success">Innovamos</span>.
            </p>
        </div>
    </div>

</main>
<footer class="page-footer bg-dark text-light" style="background-color:black">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text"><img src="https://restaurante.willitad.com/img/WAITER140.png"></h5>
                <p class="grey-text text-lighten-4">Waiter Software para control de Ventas (Restaurantes , Bar ,
                    shopping ) numero 1 en
                    innovación. Venta, Caja , Cocina e Inventario.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Datos de contacto</h5>
                <ul class="list-unstyled">
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
    <div class="copyright text-center">
        © Derechos reservados WILLITAD TICS S.A.S
        <div class="credits font-weight-bold">
            Empresa de desarrollo <a href="http://willitad.com/" target="_blank">Willitad tics s.a.s</a>
        </div>
    </div>
</footer>

</body>
</html>
