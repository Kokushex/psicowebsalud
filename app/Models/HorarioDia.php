<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_horario_dia
 * @property int $id_dia
 * @property int $id_horario
 * @property string $created_at
 * @property string $updated_at
 * @property Dium $dium
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
    public function dium()
    {
        return $this->belongsTo('App\Dium', 'id_dia', 'id_dia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horario()
    {
        return $this->belongsTo('App\Horario', 'id_horario', 'id_horario');
    }
}
