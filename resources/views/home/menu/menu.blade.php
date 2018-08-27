<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 08/11/2017
 * Time: 3:22 PM
 */
$op = $opcion;
?>
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="row">
            <button class="btn light light-blue right agregarmenu" data-toggle="modal" data-target="#nuevomenu"><span
                        class="glyphicon glyphicon-plus-sign"></span>Agregar menú
            </button>
            <button class="btn light light-green right agregarplato" data-toggle="modal" data-target="#nuevoplato"><span
                        class="glyphicon glyphicon-plus-sign"></span>Agregar plato
            </button>
            <button class="btn light light-orange right agregarbebida" data-toggle="modal"
                    data-target="#nuevabebida"><span
                        class="glyphicon glyphicon-plus-sign"></span>Agregar bebida
            </button>
            <button style="display: none" class="btn light light-green right botonaliminarplatomenu" data-toggle="modal"
                    data-target="#eliminarplatomenu"><span
                        class="glyphicon glyphicon-plus-sign"></span>Agregar plato
            </button>
            <button style="display: none" class="btn light light-green right botonlistadeplatos" data-toggle="modal"
                    data-target="#listadeplatos"><span
                        class="glyphicon glyphicon-plus-sign"></span>Agregar plato
            </button>
            <br>
        </div>
        @if(count($datos))
            <div class="col s12 m12 l12 center">
                {{$datos->links()}}
            </div>
        @endif
        @foreach($datos as $d)
            <div class="col s12 m3 l3" id="card{{$d->id}}">
                <div class="card">
                    <div class="card-image">
                        <img height="150" width="100" src="/{{$d->imagen}}">
                        <span class="card-title fondotransparente">{{$d->nombre}}</span>
                        @if($op=="platos" || $op=="bebidas") <a href="#!" id="cambiarestado{{$d->id}}"
                                                                class="cambiarestado"
                                                                value="{{$d->estado}}$${{$d->id}}$${{$op}}">@if($d->estado==0)
                                <span
                                        class="glyphicon glyphicon-eye-open left"></span> @else <span
                                        class="glyphicon glyphicon-eye-close left"></span> @endif</a> @endif
                        <input type="hidden" name="info{{$d->id}}" id="info{{$d->id}}" value="{{collect($d)}}">
                        <div class="dropdown right">
                            <i class="btn dropdown-toggle btnsinestilo" id="item{{$d->id}}"
                               data-toggle="dropdown"><i class="material-icons grey-text">more_vert</i></i>
                            <ul class="dropdown-menu" role="item{{$d->id}}" aria-labelledby="item{{$d->id}}">
                                <li class="dropdown-header">Gestionar</li>
                                <li role="presentation"
                                    value="{{$d->id}}$$@if($op=='platos'){{'platos'}}@elseif($op=='menu'){{'menu'}}@elseif($op=='bebidas'){{'bebidas'}}@endif"
                                    class="lieditar"><a value="{{$d->id}}" role="menuitem" href="#!"><span
                                                class="glyphicon glyphicon-edit blue-text"></span>Editar</a></li>
                                <li role="presentation" class="lieliminar"
                                    value="{{$d->id}}$$@if($op=='platos'){{'eliminarplato'}}@elseif($op=='menu'){{'eliminarmenu'}}@elseif($op=='bebidas'){{'eliminarbebida'}}@endif$${{$d->imagen}}">
                                    <a
                                            role="menuitem" value="{{$d->id}}"
                                            href="#!"><span
                                                class="glyphicon glyphicon-remove-circle red-text"></span>Eliminar</a>
                                </li>
                                <!-- <li role="presentation"><a role="menuitem" href="#">Editar productos</a></li> -->
                                <li role="presentation" class="divider"></li>
                                <li class="dropdown-header center"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="truncate">{{$d->descripcion}}</p>
                    </div>
                    @if($op!="platos")
                        <div class="card-action center">
                            <a href="#">Ver platos</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        @if($op=="asociarplato")
            <div class="col s12 m2 l2 card" id="divmenu">
                @php
                    $usuario=\Illuminate\Support\Facades\Auth::user()->id;
                    $datosmenu=\Illuminate\Support\Facades\DB::select("call sp_infoplatomenu('infomenu',$usuario,'');");
                @endphp
                @foreach($datosmenu as $d)
                    <div class="col s12 m12 l12" id="cardmenu{{$d->id}}" ondrop="drop(event)"
                         ondragover="allowDrop(event)" value="{{$d->id}}">
                        <div class="card">
                            <div class="card-image">
                                <img height="150" width="100" src="/{{$d->imagen}}">
                                <span class="card-title fondotransparente">{{$d->nombre}}</span>
                                <a href="#!" class="listadeplatos" value="{{$d->id}}"><span
                                            class="red badge white-text right" value="{{$d->id}}"
                                            id="cantidadplatos{{$d->id}}">{{$d->cantidadplatos}}</span></a>
                            </div>
                            <div class="card-content">
                                <p class="truncate">{{$d->descripcion}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col s12 m9 l9 card" id="divplatos">
                <div class="row">
                    @php
                        $usuario=\Illuminate\Support\Facades\Auth::user()->id;
                        $datosplato=\Illuminate\Support\Facades\DB::select("call sp_infoplatomenu('infoplatos',$usuario,'');");
                    @endphp
                    @foreach($datosplato as $d)
                        <div class="col s12 m3 l3" id="cardplato{{$d->id}}" draggable="true" ondragstart="drag(event)"
                             value="{{$d->id}}">
                            <div class="card">
                                <div class="card-image">
                                    <img height="150" width="100" src="/{{$d->imagen}}">
                                    <span class="card-title fondotransparente">{{$d->nombre}}</span>
                                </div>
                                <div class="card-content">
                                    <p class="truncate">{{$d->descripcion}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif
    </div>
    <div class="modal fade" id="nuevomenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center"><span class="glyphicon glyphicon-star"></span>MENÚ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{url('menu.guardarmenu')}}" method="post" id="formguardarmenu"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">

                            <div class="input-field col s12 m5 l5">
                                <input type="text" name="nombre" value="{{old('nombre')}}" id="nombre" required
                                       placeholder="Nombre del menu...">
                                <label class="active" for="nombre">Nombre:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="file" name="imagen" id="imagen" required>
                                <label class="active" for="nombre">Imagen:</label>
                                <input type="hidden" name="imagenanterior" id="imagenanterior">
                            </div>
                            <div class="input-field col s12 m12 l12">
                   <textarea class="materialize-textarea" placeholder="descripción del menú..."
                             value="{{old('descripcion')}}" id="descripcion"
                             name="descripcion">

                   </textarea>
                                <label class="active" for="descripcion">Descripción:</label>
                            </div>
                            <div class="col s12 m12 l12 center">
                                <button class="btn light light-blue"><span
                                            class="glyphicon glyphicon-floppy-disk"></span>
                                    Guardar
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green" data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="nuevoplato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center"><span class="glyphicon glyphicon-star"></span>PLATO</h5>
                    <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{url('menu.guardarplato?opcion=guardarplato')}}" method="post"
                          id="formguardarplato"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="operacion" id="operacion" value="">
                        <div class="row">

                            <div class="input-field col s12 m12 l12">
                                <input type="text" name="nombre" value="{{old('nombre')}}" id="nombre" required
                                       placeholder="Nombre del plato...">
                                <label class="active" for="nombre">Nombre:</label>
                            </div>
                            <div class="input-field col s12 m12 l12">
                   <textarea class="materialize-textarea" placeholder="descripción..." value="{{old('descripcion')}}"
                             id="descripcion"
                             name="descripcion" required>

                   </textarea>
                                <label class="active" for="descripcion">Descripción:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="number" name="precio" value="{{old('precio')}}" id="precio" required
                                       placeholder="precio...">
                                <label class="active" for="precio">Precio:</label>
                            </div>
                            <div class="col s12 m5 l5">
                                <div class="input-field  col s12 m4 l4">
                                    <input type="number" name="descuento" value="{{old('descuento')}}" id="descuento"
                                           placeholder="descuento...">
                                    <label class="active" for="descuento">Descuento:</label>
                                </div>

                                <div class="col s1 m1 l1">
                                    <span>%</span>
                                </div>

                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="date" class="datepicker" name="fechadesde" value="{{old('fechadesde')}}"
                                       id="fechadesde"
                                       placeholder="{{date('Y-m-d')}}...">
                                <label class="active" for="fechadesde">Fecha desde:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="date" class="datepicker" name="fechahasta" value="{{old('fechahasta')}}"
                                       id="fechahasta"
                                       placeholder="{{date('Y-m-d')}}...">
                                <label class="active" for="fechahasta">Fecha hasta:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="file" name="imagen" id="imagen" required>
                                <label class="active" for="nombre">Imagen:</label>
                                <input type="hidden" name="imagenanterior" id="imagenanterior">
                                <input type="hidden" name="estado" id="estado">
                            </div>
                            <div class="col s12 m12 l12 center">
                                <button class="btn light light-blue"><span
                                            class="glyphicon glyphicon-floppy-disk"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green" data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="nuevabebida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center">BEBIDAS</h5>
                    <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{url('menu.guardarplato?opcion=guardarbebida')}}" method="post"
                          id="formguardarbebida"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="operacion" id="operacion" value="">
                        <div class="row">

                            <div class="input-field col s12 m12 l12">
                                <input type="text" name="nombre" value="{{old('nombre')}}" id="nombre" required
                                       placeholder="Nombre del plato...">
                                <label class="active" for="nombre">Nombre:</label>
                            </div>
                            <div class="input-field col s12 m12 l12">
                   <textarea class="materialize-textarea" placeholder="descripción..." value="{{old('descripcion')}}"
                             id="descripcion"
                             name="descripcion" required>

                   </textarea>
                                <label class="active" for="descripcion">Descripción:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="number" name="precio" value="{{old('precio')}}" id="precio" required
                                       placeholder="precio...">
                                <label class="active" for="precio">Precio:</label>
                            </div>
                            <div class="col s12 m5 l5">
                                <div class="input-field  col s12 m4 l4">
                                    <input type="number" name="descuento"
                                           value="{{!empty(old('descuento'))?old('descuento'):0}}" id="descuento"
                                           required
                                           placeholder="descuento...">
                                    <label class="active" for="descuento">Descuento:</label>
                                </div>

                                <div class="col s1 m1 l1">
                                    <span>%</span>
                                </div>

                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="date" class="datepicker" name="fechadesde" value="{{old('fechadesde')}}"
                                       id="fechadesde"
                                       placeholder="{{date('Y-m-d')}}...">
                                <label class="active" for="fechadesde">Fecha desde:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="date" class="datepicker" name="fechahasta" value="{{old('fechahasta')}}"
                                       id="fechahasta"
                                       placeholder="{{date('Y-m-d')}}...">
                                <label class="active" for="fechahasta">Fecha hasta:</label>
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <input type="file" name="imagen" id="imagen" required>
                                <label class="active" for="nombre">Imagen:</label>
                                <input type="hidden" name="imagenanterior" id="imagenanterior">
                                <input type="hidden" name="estado" id="estado">
                            </div>
                            <div class="col s12 m12 l12 center">
                                <button class="btn light light-blue"><span
                                            class="glyphicon glyphicon-floppy-disk"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green" data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eliminarplatomenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center"><span class="glyphicon glyphicon-star"></span>Eliminar</h5>
                    <button type="button" class="close right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col s12 m12 l12 center">
                            <h5 id="mensaje" class="red-text">Desea eliminar el item seleccionado?</h5>
                        </div>
                        <div class="col s12 m12 l12 center">
                            <button type="button" id="botoneliminar" class="btn light light-blue">Eliminar</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green btneliminarcancelar"
                            data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="listadeplatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header center">
                    <h4 class="modal-title">Lista de platos</h4>
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Cras justo odio
                            <span class="badge badge-primary badge-pill">14</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Dapibus ac facilisis in
                            <span class="badge badge-primary badge-pill">2</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Morbi leo risus
                            <span class="badge badge-primary badge-pill">1</span>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary light light-green" data-dismiss="modal"><span
                                class="glyphicon glyphicon-eye-close"></span> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('script')
    <script src="{{asset('js/menu.js')}}"></script>
    <script>
        $(document).ready(function () {
            validarformulario('formguardarmenu', {nombre: "required", descripcion: "required", imagen: "required"});
            @if(\Illuminate\Support\Facades\Session::has('mensaje'))
            Materialize.toast("{{\Illuminate\Support\Facades\Session::get('mensaje')}}", 4000);
            @endif
        });
    </script>
    <script>
        function mostraformulario() {
            etiqueta = $("#fielguardarmenu");
            if ($(etiqueta).hasClass('MO')) {
                $(etiqueta).show();
                $(etiqueta).removeClass('MO');
                $(etiqueta).addClass('OC');
            } else {
                $(etiqueta).hide();
                $(etiqueta).removeClass('OC');
                $(etiqueta).addClass('MO');
            }
        }
    </script>
@endsection