<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_especialidad
 * @property int $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property FormacionEspecialidad[] $formacionEspecialidads
 */
class Especialidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'especialidad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_especialidad';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formacionEspecialidads()
    {
        return $this->hasMany('App\Models\FormacionEspecialidad', 'id_especialidad', 'id_especialidad');
    }
}
