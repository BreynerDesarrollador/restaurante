<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class homeprincipalController extends Controller
{
    //
    public function index()
    {
        return view('home.homeprincipal');
    }
}
