<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Psicologo;

class ReservaController extends Controller
{
    public function indexReserva()
    {
        return view('reserva');
    }

}
