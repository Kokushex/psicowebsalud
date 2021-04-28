<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_horario
 * @property int $id_psicologo
 * @property string $hora_entrada_am
 * @property string $hora_salida_am
 * @property string $hora_entrada_pm
 * @property string $hora_salida_pm
 * @property string $created_at
 * @property string $updated_at
 * @property Psicologo $psicologo
 * @property HorarioDium[] $horarioDias
 */
class Horario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'horario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_horario';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'hora_entrada_am', 'hora_salida_am', 'hora_entrada_pm', 'hora_salida_pm', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarioDias()
    {
        return $this->hasMany('App\Models\HorarioDium', 'id_horario', 'id_horario');
    }
}
