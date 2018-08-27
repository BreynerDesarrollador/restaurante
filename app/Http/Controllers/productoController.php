<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class productoController extends Controller
{
    private $usuario;

    //
    public function index()
    {
        $datospructos = $this->listarproductos()->paginate(10);
        return view('home.productos.productos')->with('datosproductos', $datospructos);
    }

    public function listarproductos()
    {
        $this->usuario = Auth::user()->id;
        return DB::table("productos")
            ->join('producto_clasificacion', 'producto_clasificacion.id', '=', 'productos.clasificacion')
            ->join('productos_tipo', 'productos_tipo.id', '=', 'productos.tipo')
            ->where('productos.usuario', $this->usuario)
            ->select('productos.id AS id', 'producto_clasificacion.nombre AS clasificacion', 'productos_tipo.nombre AS tipo', 'productos.nombre AS nombre', 'productos.precio');
    }

    function cargarcombos()
    {
        try {
            $this->usuario=Auth::user()->id;
            $op = Input::get('op');
            $buscar = Input::get('buscar');
            $datos = DB::select("call sp_cargarcombos('$op','$buscar',$this->usuario)");
            return response()->json($datos);
        } catch (Exception $es) {

        }
    }

    function guardarajax()
    {
        try {
            $op = Input::get('operacion');
            $mensaje = "";
            switch ($op) {
                case "guardarproducto":
                    $mensaje = $this->guardarproducto();
                    break;
            }
            return response()->json($mensaje);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    function guardarproducto()
    {
        try {
            $this->usuario = Auth::user()->id;
            $nombre = Input::get('nombre');
            $clasificacion = Input::get('clasificacion');
            $tipo = Input::get('tipo');
            $precio = Input::get('precio');
            $mensaje = "";
            if (!empty($nombre)) {
                if (!empty($clasificacion)) {
                    if (!empty($tipo)) {
                        $datos = DB::select("call sp_guardarproducto('$nombre',$clasificacion,$tipo,$precio,$this->usuario);");
                        $mensaje = "OK";
                    } else {
                        $mensaje = "Debe seleccionar la clasificación del producto.";
                    }
                } else {
                    $mensaje = "Debe seleccionar la clasificación del producto.";
                }
            } else {
                $mensaje = "Debe ingresar el nombre del producto.";
            }

            return $mensaje;
        } catch (Exception $es) {
            throw $es;
        }
    }
}
