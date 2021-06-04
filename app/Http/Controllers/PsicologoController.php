<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Psicologo;


class PsicologoController extends Controller
{
    public function filtroPrincipal(Request $request)
    {
        //return view('reserva.list');

            if ($request->datoFiltro != "") {
                $psicologos = Psicologo::getListaDePsicologos($request->datoFiltro);
                $filtro_texto = $request->datoFiltro;
                $modalidad = "";
                $fecha = "";
                $especialidad = "";
                return view('reserva.list', compact('psicologos', 'filtro_texto', 'modalidad', 'especialidad', 'fecha'));


        }
           // */
    }
}
