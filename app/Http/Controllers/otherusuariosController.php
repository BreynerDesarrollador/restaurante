<?php

namespace App\Http\Controllers;

use App\Events\EnviarNotificacion;
use App\Notifications\Notificaciones;
use App\User;
use ConsoleTVs\Charts\Builder\Url;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;

class otherusuariosController extends Controller
{
    //
    public function index()
    {
        return view("home.otherusuarios.otherhome");
    }

    public function listarmenuplatos(Request $request)
    {
        try {
            $type = Auth::user()->type;
            $usuario = Auth::user()->user;
            $opcion = Input::get('op');
            $menu = Input::get('menu');
            $buscar = Input::get('buscar');
            $datos = [];
            if ($type == 3 || $type == 6) {
                if ($opcion == "menu")
                    $datos = DB::select("call sp_infoplatomenu('infomenu',$usuario,'$buscar');");
                elseif ($opcion == "platos") {
                    $datos = DB::select("call sp_listadeplatosmenu($menu,$usuario,'$buscar');");
                } elseif ($opcion == "mesas") {
                    $datos = DB::select("call sp_listarmesas($usuario);");
                } elseif ($opcion == "bebidas") {
                    $datos = DB::select("call sp_infoplatomenu('bebidas',$usuario,'$buscar');");
                }
            }
            $total = count($datos);
            $da = $this->arrayPaginator($datos, $request);
            return compact("da", "total");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarpedido(Request $request)
    {
        try {
            $operacion = Input::get('operacion');
            if (!empty($operacion)) {
                if ($operacion == "mesero") {
                    $datos = Input::get('datos');
                    $datos1 = array();
                    $usuario = Auth::user()->user;
                    $mesero = Auth::user()->id;
                    $xml = "";
                    $xml = "<?mxl version=\"1.0\" encoding=\"UTF-8\"?>";
                    $mesageneral = "";
                    foreach ($datos as $item) {
                        $plato = $item["plato"];
                        $bebida = $item["bebida"];
                        $mesa = $item["mesa"];
                        $mesanombre = $item["mesanombre"];
                        $mesageneral = $mesa;
                        $comentario = $item["comentario"];
                        $xml = $xml . "<datos><plato>$plato</plato>" .
                            "<bebida>$bebida</bebida>" .
                            "<mesa>$mesa</mesa> <comentario>$comentario</comentario></datos>";
                        //$datos1[] = array(["plato" => $item["plato"], "bebida" => $item["bebida"], "mesa" => $item["mesa"], "usuario" => $usuario]);
                    }
                    //$con = new convertixmlController();
                    //$xml = $con->array_to_xml($datos1, new \SimpleXMLElement('<datos/>'))->asXML();
                    $fecha = date('Y-m-d H:i:s');
                    $guardar = DB::insert("call sp_guardarpedidomesero('$xml',$usuario,$mesero,0,'$fecha')");
                    $usuario1 = User::where('type', 2)->where('user', $usuario)->get();
                    $noti = (["titulo" => 'Nuevo pedido', "mensaje" => "Pedido mesa: " . $mesanombre, "url" => "127.0.0.1"]);
                    Notification::send($usuario1, new Notificaciones($noti));
                    $respuesta = true;
                } elseif ($operacion == "cocina") {
                    $respuesta = $this->guardarpedidococina();
                }
            }
            return compact('respuesta');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarpedidococina()
    {
        try {
            $datos = Input::get('datos');
            $datos1 = array();
            $usuario = Auth::user()->user;
            $xml = "";
            $xml = "<?mxl version=\"1.0\" encoding=\"UTF-8\"?>";
            $mesageneral = array();
            $meseros = array();
            $nombres = "";
            $mesasid = array();
            $cliente = array();
            foreach ($datos as $i => $item) {
                $mesaid = $item["mesaid"];
                $mesa = $item["mesanombre"];
                array_push($meseros, $item["mesero"]);
                array_push($mesasid, $mesaid);
                $platos = [];
                if ($item['cliente'] != "null" && !empty($item['cliente'])) {
                    array_push($cliente, intval($item['cliente']));
                }
                foreach ($item["datos"] as $itemplatos) {
                    $pedido = $itemplatos['pedido'];
                    array_push($platos, empty($itemplatos["plato"]) || $itemplatos["plato"] == "null" ? $itemplatos['bebida'] : $itemplatos["plato"]);
                    $xml = $xml . "<datos><mesa>$mesaid</mesa><pedido>$pedido</pedido></datos>";
                }
                array_push($mesageneral, $mesa . ": " . implode(', ', $platos) . "\n");

            }
            $guardar = DB::insert("call sp_guardarpedidococina('$xml',$usuario)");
            if (count($cliente) > 0) {
                $usuario1 = User::where('users.user', $usuario)
                    ->whereIn("users.id", $meseros)
                    ->orwhereIn("users.id", $cliente)
                    ->union(User::where('type', 1)->where('user', $usuario))
                    ->get();
            } else {
                $usuario1 = User::where('type', 3)
                    ->where('users.user', $usuario)
                    ->whereIn("users.id", $meseros)
                    ->orWhere('users.type', 1)
                    ->get();
            }
            $noti = (["titulo" => 'Salida de cocina', "mensaje" => implode(', ', $mesageneral), "url" => "127.0.0.1"]);
            Notification::send($usuario1, new Notificaciones($noti));
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

    public function listarpedidos()
    {
        try {
            $user = Auth::user()->user;
            $datoscocina = DB::select("call sp_listarpedidos($user)");
            $total = count($datoscocina);
            return compact('datoscocina', 'total');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function listarpedidoscaja()
    {
        try {
            $user = Auth::user()->user;
            $datoscaja = DB::select("call sp_listarpedidoscaja($user)");
            $total = count($datoscaja);
            return compact('datoscaja', 'total');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarfactura()
    {
        try {
            $user = Auth::user()->user;
            $mesa = Input::get('mesa');
            $mesero = Input::get("mesero");
            $mesanombre = Input::get("mesanombre");
            $idpedido = Input::get('idpedido');
            $xml = "<?mxl version=\"1.0\" encoding=\"UTF-8\"?>";
            //return response()->json($idpedido);
            foreach ($idpedido as $i => $item) {
                $pedido = $item["id"];
                $precio = $item["precio"];
                $xml = $xml . "<datos><idpedido>$pedido</idpedido><precio>$precio</precio></datos>";
            }
            $guardar = DB::select("call sp_guardarfactura($user,$mesa,'$xml');");
            $respuesta = true;
            $usuario1 = User::where('type', 3)->where('user', $user)->where("id", $mesero)->get();
            $noti = (["titulo" => 'Generación de factura', "mensaje" => "Se ha generado la factura para la mesa " . $mesanombre, "url" => "127.0.0.1"]);
            Notification::send($usuario1, new Notificaciones($noti));
            return compact('respuesta');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function listapedidos()
    {
        try {
            $usuario = Auth::user()->user;
            $mesero=Auth::user()->id;
            $datos = DB::select("call sp_consultarpedidos($usuario,$mesero)");
            return response()->json(['datos' => $datos]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }
}
