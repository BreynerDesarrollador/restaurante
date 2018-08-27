<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;

class inventarioController extends Controller
{
    public $usuario;

    //
    public function index()
    {
        return view('home.inventario.inventario')->with('datosinventario', $this->datosinventario());
    }

    public function productos()
    {
        return view('home.inventario.productos');
    }

    public function verinventario(Request $request)
    {
        $this->usuario=Auth::user()->id;
        $datosdb = DB::select("call sp_inventarioproductos($this->usuario);");
        $datos = $this->arrayPaginator($datosdb, $request);
        return view('home.inventario.verinventarios')->with('datos', $datos);
    }

    public function datosinventario()
    {
        try {
            $this->usuario = Auth::user()->id;
            return $datos = DB::table('inventario')->where('usuario', $this->usuario)->take(1000)->paginate(10);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarinventario(Request $request)
    {
        try {
            $nombre = Input::get('nombre');
            $descripcion = Input::get('descripcion');
            $usuario = Auth::user()->id;
            $validar = $this->validate($request, ["nombre" => "required"]);
            $gua = DB::insert("call sp_guardarinventario('$nombre','$descripcion',$usuario)");
            return Redirect::back()->with("mensaje", "registro exitoso!");
        } catch (Exception $es) {
            throw $es;
        }
    }

    public function guardarinventarioproductos(Request $request)
    {
        try {
            $producto = Input::get('producto');
            $descripcion = Input::get('descripcion');
            $cantidad_peso = Input::get('cantidad_peso');
            $precio = Input::get('precio');
            $importe = Input::get('importe');
            $medida = Input::get('medida');
            $entrada_salida = Input::get('type');
            $fecha_ven = Input::get('fecha_ven');
            $inventario = Input::get('inventario');
            $num_factura = Input::get('num_factura');
            $usuario = Auth::user()->id;

            $roles = [
                "producto" => "required",
                "medida" => "required",
                "cantidad_peso" => "required",
                "precio" => "required",
                "importe" => "required",
                "inventario" => "required"];
            $validar = $this->validate($request, $roles);
            $guardar = DB::insert("call sp_guardarentradasalida($producto,'$descripcion',$cantidad_peso,$precio,$importe,$medida,'$fecha_ven',$inventario,$usuario,'$num_factura',$entrada_salida);");
            return redirect("/home");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function consultarprecio()
    {
        try {
            $producto = Input::get('producto');
            $inventario = Input::get('inventario');
            $usuario = Auth::user()->id;
            $datos = DB::select("call sp_consultarprecio($producto,$inventario,$usuario);");
            if (count($datos)) {
                return response()->json($datos[0]->precio);
            } else {
                return response()->json(false);
            }
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }
}
