<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Reserva;

class AgendaController extends Controller
{
    public function indexAgenda()
    {
        return view('agenda');
    }


    /**
     * listarAgenda
     *
     * obtener datos de las reservas asociadas al psicólogo desplegadas en su agenda.
     *
     */
    public function listarAgenda(){

        foreach(Reserva::reservasPsicologoEnAgenda(auth()->user()->persona->id_persona) as $value){

            if($value->precio==null){
                $value->precio="Precio Previsión";
            }
            if($value->prevision==null){
                $value->prevision="Sin Previsión";
            }
            // color aplicable según modalidad en el calendario del psicólogo
            $valor_color = "#3664F5";
            if($value->modalidad=="Online"){
                $valor_color = "#1cc961";
            }
            if($value->modalidad =="Presencial"){
                $valor_color = "#d44f9f";
            }

            $nuevaAgenda[] = [

                "title"=>$value->nombre." ".$value->apellido_paterno,
                "start"=>$value->fecha." ".$value->hora_inicio,
                "end"=>$value->fecha." ".$value->hora_termino,
                "backgroundColor"=>$valor_color,
                "textColor"=>"#fff",
                "extendedProps"=>[
                    "nombre"=>$value->nombre." ".$value->apellido_paterno,
                    "fecha"=>$value->fecha,
                    "estado_pago"=>$value->estado_pago,
                    "modalidad"=>$value->modalidad,
                    "servicio"=>$value->servicio,
                    "prevision"=>$value->prevision,
                    "precio"=>$value->precio,
                    "telefono"=>$value->telefono,
                    "hora_inicio"=>$value->hora_inicio,
                    "hora_termino"=>$value->hora_termino,
                    "id_reserva"=>$value->id_reserva,
                ]
            ];
        }
        return response()->json($nuevaAgenda);
    }
}
