<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_servicio_psicologo
 * @property int $id_psicologo
 * @property int $id_servicio
 * @property int $id_modalidad_servicio
 * @property boolean $estado_servicio
 * @property string $descripcion_particular
 * @property string $updated_at
 * @property string $created_at
 * @property ModalidadServicio $modalidadServicio
 * @property Psicologo $psicologo
 * @property Servicio $servicio
 * @property Reserva[] $reservas
 * @property ServicioPrevision[] $servicioPrevisions
 */
class ServicioPsicologo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicio_psicologo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_servicio_psicologo';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'id_servicio', 'id_modalidad_servicio', 'estado_servicio', 'descripcion_particular', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidadServicio()
    {
        return $this->belongsTo('App\Models\ModalidadServicio', 'id_modalidad_servicio', 'id_modalidad_servicio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio', 'id_servicio', 'id_servicio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPrevisions()
    {
        return $this->hasMany('App\Models\ServicioPrevision', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }
}
