<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class usuariosController extends Controller
{
    //
    public function index()
    {
        $usuario = Auth::user()->id;
        $datos = DB::select("call sp_usuarios($usuario);");
        return view('home.usuarios.usuarios', compact('datos'));
    }

    public function guardarusuario(Request $request)
    {
        session()->flash('op', 'si hay');
        $nombres = Input::get('nombres');
        $apellidos = Input::get('apellidos');
        $email = Input::get('email');
        $password = Input::get("password");
        $type = Input::get('type');
        try {
            $val = $this->validate($request,
                ["nombres" => "required", "apellidos" => "required", "type" => "required", "email" => "required|email|unique:users", "password" => 'required|min:8|max:100|alpha_num']);
            $user = new User();
            $user->nombres = $nombres;
            $user->apellidos = $apellidos;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->type = $type;
            $user->user = Auth::user()->id;
            $user->acceso = 0;
            $user->imagen = '/img/storage/default.PNG';
            $user->save();
            $usua = "";
            if ($type == 1)
                $usua = 3;
            elseif ($type == 2)
                $usua = 4;
            elseif ($type == 3)
                $usua = 2;

            $user->roles()->attach($usua); // id only
            session()->forget('op');
            return Redirect::to("/usuarios")->with("mensaje", "Registro exitoso.");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function eliminarusuario($id)
    {
        $usuario = Auth::user()->id;
        try {
            $user = User::where("type", "<>", 0)->where("id", $id)->where('user', $usuario)->first();
            $user->delete();
            return redirect("/usuarios");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function editarusuario(Request $request, $id)
    {
        session()->flash('op', 'si hay');
        $nombres = Input::get('nombres');
        $apellidos = Input::get('apellidos');
        $email = Input::get('email');
        $password = Input::get("password");
        $type = Input::get('type');
        try {
            $val = $this->validate($request,
                ["nombres" => "required", "apellidos" => "required", "type" => "required"]);
            $user = User::find($id);
            if (!empty($password)) {
                $user->nombres = $nombres;
                $user->apellidos = $apellidos;
                $user->type = $type;
                $user->password = Hash::make($password);
                $user->save();
            } else {
                $user->nombres = $nombres;
                $user->apellidos = $apellidos;
                $user->type = $type;
                $user->save();
            }
            session()->forget('op');
            return Redirect::to("/usuarios")->with("mensaje", "Registro exitoso.");
        } catch (Excepcion $es) {
            throw $es;
        }
    }
}
