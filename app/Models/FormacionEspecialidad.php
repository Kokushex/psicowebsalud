<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_formacion_especialidad
 * @property int $id_formacion_profesional
 * @property int $id_especialidad
 * @property string $created_at
 * @property string $updated_at
 * @property Especialidad $especialidad
 * @property FormacionProfesional $formacionProfesional
 */
class FormacionEspecialidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'formacion_especialidad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_formacion_especialidad';

    /**
     * @var array
     */
    protected $fillable = ['id_formacion_profesional', 'id_especialidad', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidad()
    {
        return $this->belongsTo('App\Models\Especialidad', 'id_especialidad', 'id_especialidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formacionProfesional()
    {
        return $this->belongsTo('App\Models\FormacionProfesional', 'id_formacion_profesional', 'id_formacion_profesional');
    }
}
