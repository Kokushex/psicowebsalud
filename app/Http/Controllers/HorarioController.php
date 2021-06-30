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
                //Se filtra el acceso solo a usuarios psicologos
                if(isset(auth()->user()->persona->psicologo->id_psicologo)) {
                    $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
                    //Devuelve la vista de DashboardHorario al encontrarse en una sesion
                    return view('horario');
                }else{
                return view('home');
                }
            }else{
                //Si no se encuentra en una sesion es devuelto al inicio
                return view('welcome');
            }
        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }

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
        $dia = new Dia();
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
            $dia->lunes      = $request->diaLun;
            $dia->martes     = $request->diaMar;
            $dia->miercoles  = $request->diaMie;
            $dia->jueves     = $request->diaJue;
            $dia->viernes    = $request->diaVie;
            $dia->sabado     = $request->diaSab;
            $dia->domingo    = $request->diaDom;
            $dia->save();
            
            //Se asignan los valores de Horario
            $horario->id_psicologo=$id_psicologo;
            $horario->hora_entrada_am=$request->horaEntAM;
            $horario->hora_salida_am=$request->horaSalAM;
            $horario->hora_entrada_pm=$request->horaEntPM;
            $horario->hora_salida_pm=$request->horaSalPM;
            
            //Se realiza el guardado de los datos horario
            $horario->save();

            //Se realiza la union de las dos tablas
            $horarioDia->id_horario = $horario->id_horario;
            $horarioDia->id_dia     = $dia->id_dia;
            $horarioDia->habilitado = 1;

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
    public function edit(Request $request){
        //Obtener el id del psicologo de la sesion
        $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;

        $query = HorarioDia::validarHorarioDuplicado($request,$id_psicologo);
            //Se inicializa un contador
            $contador = 0;
            //Se crea un bucle for en donde se recorre el query y dentro del mismo se hace un if
            //el cual realiza la condicion de que si request rescatando el idHorarioDia el si es distinto a query[i]
            //el cual contiene el id_horario_dia el contador aumenta
            for ($i=0; $i<count($query); $i++) {
                if($request->idHorarioDia != $query[$i]->id_horario_dia){
                    $contador++;
                }
            }
            //Luego se realiza un ifelse el cual pregunta si el contador es mayor a 0 no agrega un dia demostrando un conflicto de horario,
            //en cambio si el contador es 0 se da el pase a editar el horario
            if($contador>0) {
                //0 = NO agrega
                return response()->json(['mensaje'=> '0']);
            } else {
                //Se crea una variable que rescate el id del horario
                $id = $request->input('idHorario');
                //Se busca la fila a editar de Horario con el id
                $horarioEdit = Horario::findOrFail($id);
                //rescato los datos del formulario
                $horarioEdit->hora_entrada_am= $request->horaEntAMEdit;
                $horarioEdit->hora_salida_am= $request->horaSalAMEdit;
                $horarioEdit->hora_entrada_pm= $request->horaEntPMEdit;
                $horarioEdit->hora_salida_pm= $request->horaSalPMEdit;
                //Se envía a la base de datos
                $horarioEdit->save();
                
                //Se crea una variable que rescate el idDia
                $idDia = $request->input('idDia');
                //Se busca la fila a editar de Dia con el idDia
                $diaEdit = Dia::findOrFail($idDia);
                //se rescatan datos desde formulario
                $diaEdit->lunes      = $request->diaLunEdit;
                $diaEdit->martes     = $request->diaMarEdit;
                $diaEdit->miercoles  = $request->diaMieEdit;
                $diaEdit->jueves     = $request->diaJueEdit;
                $diaEdit->viernes    = $request->diaVieEdit;
                $diaEdit->sabado     = $request->diaSabEdit;
                $diaEdit->domingo    = $request->diaDomEdit;
                //Se actualizan los campos en tabla dia
                $diaEdit->save();

                //Se rescata el idHorarioDia desde el formulario
                $idHorarioDia = $request->input('idHorarioDia');
                //Se busca la fila que contenga el id ya rescatado y se guarda en una variable
                $horarioDiaEdit =  HorarioDia::findOrFail($idHorarioDia);
                //Se guardan los cambios en la bd
                $horarioDiaEdit->save();
                //se retorna un json que tendra la variable mensaje con el valor 1 (1 == Edita, no existen horarios duplicados)
                return response()->json(['mensaje'=> '1']);
            }
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

    public function cambiarEstadoHorario(Request $request){
        //Se crea un modelo con el id proveniente de la tabla para cambiar estado del horario
        $horarioCambio = HorarioDia::findOrFail($request->input('id_horario_dia'));
        //Obtener el id del psicologo de la sesion
        $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
        //Se llama la funcion validarHorarioDuplicado() dentro del modelo HorarioDias
        $query = HorarioDia::validarHorarioDuplicado($request,$id_psicologo);
         //si la consulta rescata algun id_horario_dia, quiere decir que ya existen horarios con los dias marcados de forma habilitada
        if(count($query)>0){
            //Si El Horario Esta Habilitado (Habilitado == 1) se puede cambiar a Deshabilitado, pero si se intenta cambiar de Deshabilitado (Habilitado==0) a Habilitado  No dejara
            //debido a que existe un horario en conflicto
            if ($horarioCambio->habilitado == 1) {
                $horarioCambio->habilitado = 0;
                $horarioCambio->save();
                //se retorma un json que tendra la variable mensaje con el valor 1 (1 == Se realizo la modificacion de estado)
                return response()->json(['mensaje'=>'1']);
            } else {
                //se retorma un json que tendra la variable mensaje con el valor 0 (0 == No se puede Realizar la Modificacion de Estado, existen horarios en conflicto)
                return response()->json(['mensaje'=>'0']);
            }
        }else{
            //Si no existe ningun horario en Query
            //Si El Horario Esta Habilitado (Habilitado == 1) se puede cambiar a Deshabilitado, pero si se intenta cambiar de Deshabilitado (Habilitado==0) a Habilitado  No dejara
            //debido a que existe un horario en conflicto
            if ($horarioCambio->habilitado == 1) {
                $horarioCambio->habilitado = 0;
                $horarioCambio->save();
                //se retorna un json que tendra la variable mensaje con el valor 1 (1 == Se realizo la modificacion de estado)
                return response()->json(['mensaje'=>'1']);
            } else {
                //Si el Horario Intenta Cambiar de Deshabilitado a Habilitado lo permite debido a que no existe un horario en conflicto
                $horarioCambio->habilitado = 1;
                $horarioCambio->save();
                //se retorna un json que tendra la variable mensaje con el valor 1 (1 == Se realizo la modificacion de estado
                return response()->json(['mensaje'=>'1']);
            }
        }
    }
}
