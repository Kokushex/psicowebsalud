<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_dia
 * @property boolean $lunes
 * @property boolean $martes
 * @property boolean $miercoles
 * @property boolean $jueves
 * @property boolean $viernes
 * @property boolean $sabado
 * @property boolean $domingo
 * @property string $created_at
 * @property string $updated_at
 * @property HorarioDium[] $horarioDias
 */
class Dia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_dia';

    /**
     * @var array
     */
    protected $fillable = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarioDias()
    {
        return $this->hasMany('App\Models\HorarioDium', 'id_dia', 'id_dia');
    }
}
