<?php

namespace App\Models;

use DateTime;
use DateInterval;
use DatePeriod;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_horario_dia
 * @property int $id_dia
 * @property int $id_horario
 * @property boolean $habilitado
 * @property string $created_at
 * @property string $updated_at
 * @property Dia $dia
 * @property Horario $horario
 */
class HorarioDia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'horario_dia';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_horario_dia';

    /**
     * @var array
     */
    protected $fillable = ['id_dia', 'id_horario', 'habilitado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dia()
    {
        return $this->belongsTo('App\Models\Dia', 'id_dia', 'id_dia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horario()
    {
        return $this->belongsTo('App\Models\Horario', 'id_horario', 'id_horario');
    }

    public static function validarHorarioDuplicado($request,$id_psicologo){
        //Se valida que no exista un horario que contenga un dia ya en uso en la DB
        //Se realiza una consulta que rescate el id_horario_dia
        //donde el id_psicologo sea el que esta iniciado sesion
        //y donde el dia lunes sea igual a lo que esta activado en el formAdd
        //y donde dia lunes sea igual a 1 (1=dia que trabajara, 0=dia que no trabajara)
        //y donde el horario este habilitado o se repite la consulta para cada dia de la semana
        $query = HorarioDia::select('id_horario_dia')
        ->join('dia','dia.id_dia','=','horario_dia.id_dia')
        ->join('horario','horario.id_horario','=','horario_dia.id_horario')
        ->where('horario.id_psicologo',$id_psicologo)
        //se encierra entre parentesis cada dia junto a ello utilizando la variable request, para recuperar datos del formAdd
        ->where(function($query) use($request) {
            $query->where('dia.lunes','=',$request->diaLun)
            ->where('dia.lunes','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.martes','=',$request->diaMar)
            ->where('dia.martes','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.miercoles','=',$request->diaMie)
            ->where('dia.miercoles','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.jueves','=',$request->diaJue)
            ->where('dia.jueves','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.viernes','=',$request->diaVie)
            ->where('dia.viernes','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.sabado','=',$request->diaSab)
            ->where('dia.sabado','like',1)
            ->where('habilitado',1);
        })
        ->orWhere(function($query) use($request) {
            $query->where('dia.domingo','=',$request->diaDom)
            ->where('dia.domingo','like',1)
            ->where('habilitado',1);
        })
        ->get();
        return $query;
    }

    /**
     * mostrarDatosTabla
     * Funcion para listar el horario del psicologo
     * @param mixed $id_psicologo
     * @return $horarioDia
     */
    public static function mostrarDatosTabla($id_psicologo){
        $horarioDia = HorarioDia::select('horario_dia.id_horario_dia','horario_dia.id_horario','horario_dia.id_dia'
            ,'dia.lunes','dia.martes','dia.miercoles','dia.jueves','dia.viernes','dia.sabado','dia.domingo',
            'horario.hora_entrada_am','horario.hora_salida_am','horario.hora_entrada_pm','horario.hora_salida_pm','horario_dia.habilitado')
            ->join('dia','dia.id_dia','=','horario_dia.id_dia')
            ->join('horario','horario.id_horario','=','horario_dia.id_horario')
            ->where('horario.id_psicologo',$id_psicologo)
            ->get();
        return $horarioDia;
    }

    public static function getDiasHabiles($id_psicologo){
        $query= HorarioDia::select('id_horario_dia','dia.lunes','dia.martes','dia.miercoles','dia.jueves','dia.viernes','dia.sabado','dia.domingo')
            ->join('dia','dia.id_dia','=','horario_dia.id_dia')
            ->join('horario','horario.id_horario','=','horario_dia.id_horario')
            ->where('horario.id_psicologo',$id_psicologo)
            ->where('habilitado',1)
            ->get();
        $conte=" ";
        $dias=new Dia();

        $dias->lunes = 0;
        $dias->martes = 0;
        $dias->miercoles = 0;
        $dias->jueves = 0;
        $dias->viernes = 0;
        $dias->sabado = 0;
        $dias->domingo = 0;

        for ($i=0; $i < count($query) ; $i++) {
            if($query[$i]->lunes=='1'){
                $dias->lunes=1;
            }
            if($query[$i]->martes=='1'){
                $dias->martes=1;
            }
            if($query[$i]->miercoles=='1'){
                $dias->miercoles=1;
            }
            if($query[$i]->jueves=='1'){
                $dias->jueves=1;
            }
            if($query[$i]->viernes=='1'){
                $dias->viernes=1;
            }
            if($query[$i]->sabado=='1'){
                $dias->sabado=1;
            }
            if($query[$i]->domingo=='1'){
                $dias->domingo=1;
            }
        }
        return $dias;
    }

    /**
     * generadorDeHora
     *
     * Metodo utilizado para rellenar el combobox de horas disponibles de una cita al psicologo
     *
     */

    public static function generadorDeHora($bloque, $dias, $id_psicologo){
        if($bloque=="AM"){
            $datosAm=HorarioDia::select('horario.hora_entrada_am','horario.hora_salida_am')
                ->join('dia','dia.id_dia','=','horario_dia.id_dia')
                ->join('horario','horario.id_horario','=','horario_dia.id_horario')
                ->where('horario.id_psicologo',$id_psicologo)
                ->where('habilitado',1)
                ->where('dia.'.$dias,1)
                ->get();

            $hora_inicio = new DateTime( $datosAm[0]->hora_entrada_am);
            $hora_fin    = new DateTime( $datosAm[0]->hora_salidad_am );
            $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que muestre $hora_fin

            // Si la hora de inicio es superior a la hora fin
            // añadimos un día más a la hora fin
            if ($hora_inicio > $hora_fin) {
                $hora_fin->modify('+1 day');
            }

            // Establecemos el intervalo en minutos
            $intervalo = new DateInterval('PT60M');

            // Sacamos los periodos entre las horas
            $periodo = new DatePeriod($hora_inicio, $intervalo, $hora_fin);

            foreach( $periodo as $hora ) {
                // Guardamos las horas intervalos
                $horas[] =  $hora->format('H:i:s');
            }

            return $horas;

        }else{
            $datosPm=HorarioDia::select('horario.hora_entrada_pm','horario.hora_salida_pm')
                ->join('dia','dia.id_dia','=','horario_dia.id_dia')
                ->join('horario','horario.id_horario','=','horario_dia.id_horario')
                ->where('horario.id_psicologo',$id_psicologo)
                ->where('habilitado',1)
                ->where('dia.'.$dias,1)
                ->get();

            $hora_inicio = new DateTime( $datosPm[0]->hora_entrada_pm);
            $hora_fin    = new DateTime( $datosPm[0]->hora_salida_pm );
            $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que muestre $hora_fin

            // Si la hora de inicio es superior a la hora fin
            // añadimos un día más a la hora fin
            if ($hora_inicio > $hora_fin) {
                $hora_fin->modify('+1 day');
            }

            // Establecemos el intervalo en minutos

            $intervalo = new DateInterval('PT60M');

            // Sacamos los periodos entre las horas
            $periodo = new DatePeriod($hora_inicio, $intervalo, $hora_fin);

            foreach( $periodo as $hora ) {
                // Guardamos las horas intervalos
                $horas[] =  $hora->format('H:i:s');
            }
            return $horas;
        }
    }


    /**
     * validarComprobacionDia
     *
     * Metodo utilizado para comprobar si el dia esta habilitado para trabajar o no
     *
     */
    public static function validarComprobacionDia($fecha, $id_psicologo){
        return $comprobacion = HorarioDia::select('id_horario_dia')
            ->join('dia','dia.id_dia','=','horario_dia.id_dia')
            ->join('horario','horario.id_horario','=','horario_dia.id_horario')
            ->where('horario.id_psicologo',$id_psicologo)
            ->where('habilitado',1)
            ->where('dia.'.$fecha,1)
            ->get();
    }
}
