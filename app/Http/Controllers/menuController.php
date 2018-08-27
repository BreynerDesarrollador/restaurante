<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class menuController extends Controller
{
    //
    public function index(Request $request, $opcion = null)
    {
        $datos = [];
        $op = Input::get('op');
        $usuario = Auth::user()->id;
        switch ($opcion) {
            case "platos":
                $datos = DB::table("platos")->where('usuario', $usuario)->take(1000)->paginate(10);
                break;
            case "menu":
                $datos = DB::table('menu')->where('usuario', $usuario)->take(1000)->paginate(10);
                break;
            case "bebidas":
                $datos = DB::table('bebidas')->where('usuario', $usuario)->take(1000)->paginate(10);
                break;
            case "":
                $datos = DB::table('menu')->where('usuario', $usuario)->take(1000)->paginate(10);
                break;
        }

        return view('home.menu.menu')->with('datos', $datos)->with('opcion',$opcion);
    }

    public function guardarmenu(Request $request)
    {
        try {
            $nombre = Input::get('nombre');
            $descripcion = Input::get('descripcion');
            $mensaje = "";
            $usuario = Auth::user()->id;
            if (!empty($nombre)) {
                if (!empty($descripcion)) {
                    $respuesta = $this->guardarimagen($request, $usuario, "imgmenu");

                    if ($respuesta['msj'] == "OK") {
                        $img = $respuesta["ruta"];
                        $guardar = DB::select("call sp_guardarmenu('$nombre','$descripcion','$img',$usuario,0)");
                    }
                    $mensaje = $respuesta["msj"];
                } else {
                    $mensaje = "Debe ingresar una descripción del menú.";
                }
            } else {
                $mensaje = "Debe ingresar el nombre del menú.";
            }
            return Redirect::back()->with("mensaje", $mensaje)->withInput(Input::all());
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarimagen(Request $request, $usuario1, $carpeta)
    {
        $usuario = $usuario1;
        try {
            //if ($request->isAjax()) {
            $mensaje = "";
            if ($request->hasFile('imagen')) {
                //if ($request->file('imgpersona')->getSize() > 500) {
                if ($request->file('imagen')->isValid()) {
                    $extension = $request->imagen->extension();
                    if ($extension == "png" || $extension == "PNG" || $extension == "jpg" || $extension == "JPG" || $extension == "JPEG" || $extension == "jpeg" || $extension == "gif" || $extension == "GIF") {
                        if (!empty($usuario)) {
                            $ruta1 = "img/storage/" . $carpeta . "/" . $usuario;
                            $rutacompleta = "";
                            $file = Input::file('imagen');
                            //Creamos una instancia de la libreria instalada
                            $image = \Image::make(Input::file('imagen'));
                            if (!file_exists($ruta1))
                                $rutacompleta = Storage::makeDirectory($ruta1);
                            else
                                $rutacompleta = $ruta1;

                            $image->resize(240, 240);
                            $nombre = '/' . date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . $usuario . $this->generaridimagens() . '.' . $extension;
                            $image->save($ruta1 . $nombre);
                            return ["msj" => "OK", "ruta" => $ruta1 . $nombre];
                        } else {
                            $mensaje = "Debe seleccionar el usuario.";
                        }
                    } else {
                        $mensaje = "La extención de la imagen debe ser valida (png,jpg,gif)." . $extension;
                    }
                } else {
                    $mensaje = "El formato de la imagen no es valida.";
                }
                /*} else {
                    $mensaje = "La imagen debe tener un tamaño maximo de 500kb.";
                }*/
            } else {
                $mensaje = "Debe seleccionar la imagen.";
            }
            return ["msj" => $mensaje, "ruta" => ""];
            //}
        } catch
        (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarplato(Request $request)
    {
        try {
            $opcion = Input::get("opcion");
            $nombre = Input::get('nombre');
            $descripcion = Input::get('descripcion');
            $precio = Input::get('precio');
            $descuesto = !empty(Input::get('descuento')) ? Input::get('descuento') : 0;
            $usuario = Auth::user()->id;
            $fechadesde = Input::get('fechadesde');
            $fechahasta = Input::get('fechahasta');
            $estado = 0;
            $mensaje = "";
            $carpeta = $opcion == 'guardarplato' ? "imgplatos" : "imgbebidas";
            $this->validarplato($request);
            $ruta = $this->guardarimagen($request, $usuario, $carpeta);
            if (!empty($ruta["ruta"])) {
                $ruta = $ruta["ruta"];
                $guardar = DB::insert("call sp_guardarplato('$nombre','$descripcion',$precio,$descuesto,'$ruta',$usuario,$estado,0,'$opcion','$fechadesde','$fechahasta');");
                $mensaje = "Registro exitoso.";
            } else
                $mensaje = $ruta["msj"];

            return Redirect::back()->with("mensaje", $mensaje)->withInput(Input::all());
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function validarplato(Request $request)
    {
        $validar = $this->validate($request, ["nombre" => "required", "descripcion" => "required", "precio" => "required", "imagen" => "required"]);
    }

    public function actualizarmenu(Request $request, $opcion, $id)
    {
        try {
            $nombre = Input::get('nombre');
            $descripcion = Input::get('descripcion');
            $precio = Input::get('precio');
            $descuento = !empty(Input::get('descuento')) ? Input::get('descuento') : 0;
            $imagen = Input::get('imagen');
            $rutaanterior = Input::get('imagenanterior');
            $estado = Input::get('estado');
            $fechadesde = Input::get('fechadesde');
            $fechahasta = Input::get('fechahasta');
            $usuario = Auth::user()->id;
            $ruta = "";
            if ($opcion == "menu") {
                $val = $this->validate($request, ["nombre" => "required", "descripcion" => "required"]);
                if ($request->hasFile('imagen')) {
                    $this->eliminarimagen($rutaanterior);
                    $ruta = $this->guardarimagen($request, $usuario, "imgmenu")["ruta"];
                } else {
                    $ruta = $rutaanterior;
                }
                $gu = DB::select("call sp_guardarmenu('$nombre','$descripcion','$ruta',$usuario,$id);");
            } elseif ($opcion == "plato") {
                if ($request->hasFile('imagen')) {
                    $this->eliminarimagen($rutaanterior);
                    $ruta = $this->guardarimagen($request, $usuario, "imgplatos")["ruta"];
                } else {
                    $ruta = $rutaanterior;
                }
                $validar = $this->validate($request, ["nombre" => "required", "descripcion" => "required", "precio" => "required"]);
                $gua = DB::insert("call sp_guardarplato('$nombre','$descripcion',$precio,$descuento,'$ruta',$usuario,0,$id,'guardarplato','$fechadesde','$fechahasta');");

            } elseif ($opcion == "bebida") {
                if ($request->hasFile('imagen')) {
                    $this->eliminarimagen($rutaanterior);
                    $ruta = $this->guardarimagen($request, $usuario, "imgbebidas")["ruta"];
                } else {
                    $ruta = $rutaanterior;
                }
                $validar = $this->validate($request, ["nombre" => "required", "descripcion" => "required", "precio" => "required"]);
                $gua = DB::insert("call sp_guardarplato('$nombre','$descripcion',$precio,$descuento,'$ruta',$usuario,0,$id,'guardarbebida','$fechadesde','$fechahasta');");
            }
            return Redirect::back()->with("mensaje", "Los datos se han actualizado con exito.");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function eliminarimagen($ruta)
    {
        Storage::delete($ruta);
    }

    public function eliminar()
    {
        $opcion = Input::get('opcion');
        $id = Input::get('id');
        $usuario = Auth::user()->id;
        $imagen = Input::get('imagen');
        try {
            $eli = DB::delete("call sp_eliminarplatomenu('$opcion',$id,$usuario);");
            $this->eliminarimagen($imagen);
            return response()->json($id);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function estado()
    {
        $id = Input::get('id');
        $usuario = Auth::user()->id;
        $estado = Input::get('estado') == 0 ? 1 : 0;
        $opcion = Input::get('op');
        try {
            $eli = DB::update("call sp_estadoplato($id,$estado,$usuario,'$opcion');");
            return response()->json(["estado" => $estado, "id" => $id, "operacion" => $opcion]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function asociarplato()
    {
        try {
            $menu = Input::get('menu');
            $plato = Input::get('plato');
            $usuario = Auth::user()->id;
            $inse = DB::select("call sp_asociarplato($menu,$plato,$usuario);");
            return response()->json(["mensaje" => $inse[0]->mensaje, "id" => $menu]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function listadeplatosmenu()
    {
        try {
            $menu = Input::get('menu');
            $usuario = Auth::user()->id;
            $datos = DB::select("call sp_listadeplatosmenu($menu,$usuario,'');");
            return response()->json($datos);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function mesas()
    {
        try {
            $user = Auth::user()->id;
            $datos = DB::select("call sp_gestionar_mesas('listar','','',$user,0,0);");
            return view('home.mesas.mesas')->with("datos", $datos)->with('mensaje', 'OK');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function descargarqrcode()
    {
        $ruta = Input::get('file');
        $nombre = Input::get('nombre');
        return response()->download($ruta, $nombre.'.png');
    }

    public function mesaseliminar($id)
    {
        try {
            $user = Auth::user()->id;
            $datos = DB::select("call sp_gestionar_mesas('','','',$user,$id,0);");
            $ruta = explode('$$', $datos[0]->mensaje)[0];
            $eliminar = Storage::delete($ruta);
            return response()->json(explode('$$', $datos[0]->mensaje)[1]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function mesaguardar(Request $request)
    {
        try {
            $user = Auth::user()->id;
            $nombre = Input::get('nombre');
            $descricion = Input::get('descripcion');
            $mesero = Input::get('mesero');
            $validar = $this->validate($request, ["nombre" => "required", "descripcion" => "required", "mesero" => "required"]);
            $guardar = DB::select("call sp_gestionar_mesas('nueva','$nombre','$descricion',$user,0,$mesero);");
            //se optiene la utltima mesa ingresada
            $mesa = DB::select("select m.id from mesa m where m.usuario=$user group by m.id desc limit 1;");
            $codigo = $mesa[0]->id . '$$' . $user . '$$' . $mesero . '$$' . $nombre;
            $nombre = $this->generaridimagens() . '.png';
            if (!file_exists($nombre)) {
                $nombre = $this->generaridimagens() . '.png';
            }
            /*$existe = DB::select("select m.id from mesa m where m.imagennombre='$nombre' and m.usuario=$user");
            while (count($existe) > 0) {
                $nombre = $this->generaridimagens() . '.png';
                $existe = DB::select("select m.id from mesa m where m.imagennombre='$nombre' and m.usuario=$user");
            }*/
            $carpeta = 'img/storage/qrcodes/' . $user;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $id = $mesa[0]->id;
            $existe = DB::update("update mesa m set m.imagenurl='$carpeta/$nombre',m.imagennombre='$nombre' where m.id=$id and m.usuario=$user");
            //QrCode::size(700)->format('png')->encoding('UTF-8')->generate($codigo, public_path('img/storage/qrcodes/' . $nombre));

            QrCode::format('png')->size(399)->color(40, 40, 40)->generate($codigo, public_path($carpeta . '/' . $nombre));
            return Redirect::back()->with("mensaje", 'OK');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function mesaactualizar()
    {
        try {
            $user = Auth::user()->id;
            $mesero = Input::get('mesero');
            $mesa = Input::get("mesaid");
            $guar = DB::update("update mesa m set m.mesero='$mesero' WHERE m.id=$mesa AND m.usuario=$user");
            return response()->json(true);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    function generaridimagens()
    {
        try {
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
            $numerodeletras = 30; //numero de letras para generar el texto
            $cadena = ""; //variable para almacenar la cadena generada
            for ($i = 0; $i < $numerodeletras; $i++) {
                $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /*Extraemos 1 caracter de los caracteres
entre el rango 0 a Numero de letras que tiene la cadena */
            }
            return $cadena;
        } catch (Excepcion $es) {
            throw $es;
        }
    }
}
