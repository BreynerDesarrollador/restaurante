<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Charts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class estadisticasController extends Controller
{
    public function index()
    {
        $tipo = Input::get('type');
        $valor=Input::get('valor');
        $chart = [];
        $usuario = Auth::user()->id;
        return view('home.estadisticas.estadistica');
    }
    public function consultardatos(){
        $usuario = Auth::user()->id;
        $tipo=Input::get('tipo');
        $opcion=Input::get('opcion');
        $datos = DB::select("call sp_estadisticas($usuario,'$tipo','$opcion');");//sp_inventarioproductos
        return response()->json($datos);
    }
}
