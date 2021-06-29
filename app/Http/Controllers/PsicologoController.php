<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Psicologo;


class PsicologoController extends Controller
{

    public function index()
    {
        try {
            //Si es usuario psicologo, se redirige a home
            if(isset(auth()->user()->persona->psicologo->id_psicologo)) {
                return view('home');
            }else{                
                $listaPsicologos = Psicologo::getListaPsicologos();
                // COMPROBAR SERVICIOS Y MODALIDADES
                // HAY QUE RECORRER DESDE SERVICIOPSICOLOGOS PARA OBTENER MODALIDADES
                // foreach ($listaPsicologos as $profesional) {
                // foreach ($profesional->servicioPsicologos as $servicio)
                // dd($servicio->modalidadServicio);
                // }
                $modalidad = Psicologo::getModalidades($listaPsicologos);
                $filtro_texto = null;
                $especialidad = null;
                $fecha = null;
                // dd($modalidad);
                return view('reserva.list', compact('listaPsicologos', 'filtro_texto', 'modalidad', 'especialidad', 'fecha'));
            }
        }
        catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }
//    public function filtroPrincipal(Request $request)
//    {
//        //return view('reserva.list');
//
//            if ($request->datoFiltro != "") {
//                $psicologos = Psicologo::getListaDePsicologos($request->datoFiltro);
//                $filtro_texto = $request->datoFiltro;
//                $modalidad = "";
//                $fecha = "";
//                $especialidad = "";
//                return view('reserva.list', compact('psicologos', 'filtro_texto', 'modalidad', 'especialidad', 'fecha'));
//
//
//        }
//           // */
//    }
}
