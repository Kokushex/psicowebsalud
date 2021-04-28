<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_modalidad_servicio
 * @property int $id_precio_modalidad
 * @property boolean $presencial
 * @property boolean $online
 * @property boolean $visita
 * @property string $updated_at
 * @property string $created_at
 * @property PrecioModalidad $precioModalidad
 * @property ServicioPsicologo[] $servicioPsicologos
 */
class ModalidadServicio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'modalidad_servicio';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_modalidad_servicio';

    /**
     * @var array
     */
    protected $fillable = ['id_precio_modalidad', 'presencial', 'online', 'visita', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function precioModalidad()
    {
        return $this->belongsTo('App\Models\PrecioModalidad', 'id_precio_modalidad', 'id_precio_modalidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPsicologos()
    {
        return $this->hasMany('App\Models\ServicioPsicologo', 'id_modalidad_servicio', 'id_modalidad_servicio');
    }
}
