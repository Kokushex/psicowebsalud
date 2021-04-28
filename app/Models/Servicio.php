<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_servicio
 * @property string $nombre
 * @property string $descripcion
 * @property string $created_at
 * @property string $updated_at
 * @property ServicioPsicologo[] $servicioPsicologos
 */
class Servicio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicio';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_servicio';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPsicologos()
    {
        return $this->hasMany('App\ServicioPsicologo', 'id_servicio', 'id_servicio');
    }
}
