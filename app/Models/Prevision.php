<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_prevision
 * @property int $descripcion
 * @property string $created_at
 * @property string $updated_at
 * @property ServicioPrevision[] $servicioPrevisions
 */
class Prevision extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prevision';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_prevision';

    /**
     * @var array
     */
    protected $fillable = ['descripcion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPrevisions()
    {
        return $this->hasMany('App\ServicioPrevision', 'id_prevision', 'id_prevision');
    }
}
