<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_servicio_prevision
 * @property int $id_prevision
 * @property int $id_servicio_psicologo
 * @property string $created_at
 * @property string $updated_at
 * @property Prevision $prevision
 * @property ServicioPsicologo $servicioPsicologo
 */
class ServicioPrevision extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicio_prevision';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_servicio_prevision';

    /**
     * @var array
     */
    protected $fillable = ['id_prevision', 'id_servicio_psicologo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prevision()
    {
        return $this->belongsTo('App\Models\Prevision', 'id_prevision', 'id_prevision');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicioPsicologo()
    {
        return $this->belongsTo('App\Models\ServicioPsicologo', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }
}
