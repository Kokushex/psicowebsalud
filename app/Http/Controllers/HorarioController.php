<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
//PODRIAN FALTAR MODELOS: HORARIODIA

class HorarioController extends Controller
{
    public function indexHorario()
    {
        return view('horario');
    }
}
