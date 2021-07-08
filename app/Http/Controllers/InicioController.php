<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function nosotros(){
        return view('inicio.nosotros');
    }
}
