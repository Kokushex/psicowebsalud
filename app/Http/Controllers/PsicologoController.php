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

    public function filtrarPsico(Request $request){
        if($request->datoFiltro != ""){
            $listaPsicologos = Psicologo::getListaPsicologosFiltro($request->datoFiltro);
            $filtro_texto = $request->datoFiltro;
            $modalidad=Psicologo::getModalidades($listaPsicologos);
            $especialidad = null;
            $fecha = null;
            //dd($listaPsicologos);
            return view('reserva.filtroPsico',
                compact('listaPsicologos',
                    'filtro_texto',
                    'modalidad',
                    'especialidad',
                    'fecha'));

        }
    }


}
