<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_especialidad_etaria
 * @property string $descripcion
 * @property string $rango_etario
 * @property string $created_at
 * @property string $updated_at
 * @property FormacionEtarium[] $formacionEtarias
 */
class EspecialidadEtaria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'especialidad_etaria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_especialidad_etaria';

    /**
     * @var array
     */
    protected $fillable = ['descripcion', 'rango_etario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formacionEtarias()
    {
        return $this->hasMany('App\Models\FormacionEtarium', 'id_especialidad_etaria', 'id_especialidad_etaria');
    }
}
