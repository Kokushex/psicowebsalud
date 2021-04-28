<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_precio_modalidad
 * @property int $precio_presencial
 * @property int $precio_online
 * @property int $precio_visita
 * @property string $created_at
 * @property string $updated_at
 * @property ModalidadServicio[] $modalidadServicios
 */
class PrecioModalidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'precio_modalidad';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_precio_modalidad';

    /**
     * @var array
     */
    protected $fillable = ['precio_presencial', 'precio_online', 'precio_visita', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modalidadServicios()
    {
        return $this->hasMany('App\ModalidadServicio', 'id_precio_modalidad', 'id_precio_modalidad');
    }
}
