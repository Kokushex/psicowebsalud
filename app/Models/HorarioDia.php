<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_horario_dia
 * @property int $id_dia
 * @property int $id_horario
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
    protected $fillable = ['id_dia', 'id_horario', 'created_at', 'updated_at'];

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

    public static function mostrarDatosTabla($id_psicologo){
        $horarioDias = HorarioDia::select('horario_dias.id_horario_dias','horario_dias.id_horario','horario_dias.id_dia'
            ,'dias.lunes','dias.martes','dias.miercoles','dias.jueves','dias.viernes','dias.sabado','dias.domingo',
            'horario.hora_entrada_am','horario.hora_salidad_am','horario.hora_entrada_pm','horario.hora_salida_pm','horario_dias.habilitado')
            ->join('dias','dias.id_dias','=','horario_dias.id_dia')
            ->join('horario','horario.id_horario','=','horario_dias.id_horario')
            ->where('horario.id_psicologo',$id_psicologo)
            ->get();
        return $horarioDias;
    }
}
