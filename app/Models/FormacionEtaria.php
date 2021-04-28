<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_formacion_etaria
 * @property int $id_formacion_profesional
 * @property int $id_especialidad_etaria
 * @property string $created_at
 * @property string $updated_at
 * @property EspecialidadEtarium $especialidadEtarium
 * @property FormacionProfesional $formacionProfesional
 */
class FormacionEtaria extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formacion_etaria';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formacion_etaria';

    /**
     * @var array
     */
    protected $fillable = ['id_formacion_profesional', 'id_especialidad_etaria', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidadEtarium()
    {
        return $this->belongsTo('App\EspecialidadEtarium', 'id_especialidad_etaria', 'id_especialidad_etaria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formacionProfesional()
    {
        return $this->belongsTo('App\FormacionProfesional', 'id_formacion_profesional', 'id_formacion_profesional');
    }
}
