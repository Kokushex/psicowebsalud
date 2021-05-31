<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HorarioDia;
use App\Models\Horario;
use App\Models\Dia;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexHorario()
    {
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            if (auth()->user()) {
                $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;

                //Devuelve la vista de DashboardHorario al encontrarse en una sesion
                return view('horario');
            }else{
                //Si no se encuentra en una sesion es de vuelto al inicio
                return view('welcome');
            }

        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }

    }

    /*
    public function index()
    {
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            if (auth()->user()) {
                $id_psicologo = auth()->user()->id;

                //Devuelve la vista de DashboardHorario al encontrarse en una sesion
                return view('horario.dashboardHorario');

            }else{
                //Si no se encuentra en una sesion es de vuelto al inicio
                return view('welcome');
            }

        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }

    }
    */

    //Funcion para listar datos
    public function datos(){
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
            //Se realiza una consulta para buscar los datos pertinentes de las diferentes tablas para cargar el DATATABLE

            //Se llama la funcion mostrarDatosTabla() dentro del modelo HorarioDias
            $horarioDia = HorarioDia::mostrarDatosTabla($id_psicologo);
            //Se regresan los datos en forma de JSON para que la funcion en Ajax cargue los datos
            return datatables()->of($horarioDia)->toJson();

        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Obtener el id del psicologo de la sesion
        $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;

        //Se crean las variables
        $horario = new Horario();
        $horarioDia = new HorarioDia();
        //Se llama la funcion validarHorarioDuplicado() dentro del modelo HorarioDia
        $query = HorarioDia::validarHorarioDuplicado($request,$id_psicologo);
        //Si rescata algun id_horario_dia quiere decir que ya existen horarios con los dias marcados en el formAdd
        if(count($query)>0){
            //se retorna un json que tendra la variable mensaje con el valor 0 (0 == No agrega, existen horarios duplicados)
            return response()->json(['mensaje'=>'0']);
        }else{
            //Si la consulta retorna ningun id_horario_dia, entonces no hay dias en uso con el horario que se encuentra en el formAdd
            //Se obtienen los dias que va a trabajar
            $lunes      = $request->diaLun;
            $martes     = $request->diaMar;
            $miercoles  = $request->diaMie;
            $jueves     = $request->diaJue;
            $viernes    = $request->diaVie;
            $sabado     = $request->diaSab;
            $domingo    = $request->diaDom;
            //Se buscan los valores de los dias de la semana que trabaja el psicologo llamando la funcion recuperarSemanaLaboral
            //dentro del modelo Dia
            $dia = Dia::recuperarSemanaLaboral($lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
            
            //Se asignan los valores de Horario
            $horario->id_psicologo=$id_psicologo;
            $horario->hora_entrada_am=$request->horaEntAM;
            $horario->hora_salida_am=$request->horaSalAM;
            $horario->hora_entrada_pm=$request->horaEntPM;
            $horario->hora_salida_pm=$request->horaSalPM;

            //$data = horarioDia::all();
            //dd($data->toArray());
            //dd($horarioDia->toArray());
            
            //Se realiza el guardado de los datos horario
            //$horario->save();

            $dia->save();

            //Se realiza la union de las dos(tres) tablas (HorarioDia+Horario,HorarioDia+Dia)
            $horarioDia->id_horario = $horario->id_horario;
            //$horarioDia->id_dia     = $dia[0]->id_dia;
            $horarioDia->habilitado = 1;

            dd($horario, $horarioDia, $dia);

            //Se realiza el guardado de los datos horario (TEST)
            //$horario->save();

            //Se realiza el guardado de HorarioDia
            $horarioDia->save();

            //Se retorna un json que tendra la variable mensaje con el valor 1 (1 == Agrega, no existen horarios duplicados)
            return response()->json(['mensaje'=>'1']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
