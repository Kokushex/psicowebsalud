<?php

namespace App\Models;

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
}
