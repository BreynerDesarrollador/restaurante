<?php
/**
 * Created by PhpStorm.
 * User: windows 8.1
 * Date: 03/03/2018
 * Time: 10:27 AM
 */
?>
@extends('app')
@section('content')
    <table>
        <thead>
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Email
            </th>
            <th>
                Telefono
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($datos as $d)
            <tr>
                <td>
                    {{$d->nombre}}
                </td>
                <td>
                    {{$d->email}}
                </td>
                <td>
                    {{$d->telefono}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection