<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Metodo encargado de la redireccion a Facebook
    public function redirectToProvider($provider, Request $request)
    {
        try {
            //session(['cliente' => null]);
            return Socialite::driver($provider)->redirect();
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            if (!$request->has('code') || $request->has('denied')) {
                return redirect('/');
            }
            // Obtenemos los datos del usuario
            $social_user = Socialite::driver($provider)->user();
            // Comprobamos si el usuario ya existe
            $user = User::where('email', $social_user->email)->where('type', 6)->first();
            if ($user) {
                //if ($user["user"] == session('cliente')['user']) {
                $this->actualizarusuario($user, $social_user);
                //} else {
                // En caso de que no exista creamos un nuevo usuario con sus datos.
                //$this->agregarusuario($social_user);
                //}
                return $this->authAndRedirect($user); // Login y redirección
            } else {
                // En caso de que no exista creamos un nuevo usuario con sus datos.
                $this->agregarusuario($social_user);
                return $this->authAndRedirect($user); // Login y redirección
            }
            //session(['cliente' => ["email" => $social_user->email, "nombre" => $social_user->name, "imagen" => $social_user->avatar]]);
            //$inser = DB::update("call sp_gestionarcliente('$nombre','$email','','$imagen',1);");
            return redirect()->to('/cliente/app/menu');
            //return $social_user->email;
        } catch (Excepcion $es) {
            return redirect('/cliente');
        }
    }

    public function agregarusuario($social_user)
    {
        $user = User::create([
            'nombres' => $social_user->name,
            'apellidos' => $social_user->name,
            'email' => $social_user->email,
            'telefono' => '',
            'password' => bcrypt($social_user->email),
            'type' => 6,
            'user' => session('cliente')['user'],
            'acceso' => 0,
            'imagen' => $social_user->avatar,
        ]);
        $user->roles()->attach(5); // id only
    }

    public function actualizarusuario($user, $social_user)
    {
        $user->nombres = $social_user->name;
        $user->apellidos = $social_user->name;
        $user->email = $social_user->email;
        $user->telefono = '';
        $user->password = bcrypt($social_user->email);
        //$user->type = 6;
        $user->user = session('cliente')['user'];
        //$user->acceso = 0;
        $user->imagen = $social_user->avatar;
        $user->save();
    }

    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user, false);
        return redirect()->to('/cliente/app/menu');
    }

    public function clientesalir()
    {
        session()->forget('cliente');
        session()->flush();
        return redirect()->to('/');
    }
}
