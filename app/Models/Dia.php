<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_dia
 * @property boolean $lunes
 * @property boolean $martes
 * @property boolean $miercoles
 * @property boolean $jueves
 * @property boolean $viernes
 * @property boolean $sabado
 * @property boolean $domingo
 * @property string $created_at
 * @property string $updated_at
 * @property HorarioDia[] $horarioDia
 */
class Dia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_dia';

    /**
     * @var array
     */
    protected $fillable = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarioDia()
    {
        return $this->hasMany('App\Models\HorarioDia', 'id_dia', 'id_dia');
    }

    public static function recuperarSemanaLaboral($lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo){
        //Se realiza una consulta comparando que dias va a trabajar para que retorne un id de una semana ya asignada(?) en la tabla dia
        $idSemanaTrabajo = Dia::select('id_dia')
                                ->where('lunes','=', $lunes)
                                ->where('martes','=', $martes)
                                ->where('miercoles','=', $miercoles)
                                ->where('jueves','=', $jueves)
                                ->where('viernes','=', $viernes)
                                ->where('sabado','=', $sabado)
                                ->where('domingo','=', $domingo)
                                ->get();
        return $idSemanaTrabajo;
    }
}
