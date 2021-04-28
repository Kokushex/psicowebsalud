<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_formacion_profesional
 * @property int $id_psicologo
 * @property string $casa_academica
 * @property int $grado_academico
 * @property string $fecha_ingreso
 * @property int $fecha_egreso
 * @property string $created_at
 * @property string $updated_at
 * @property Psicologo $psicologo
 * @property FormacionEspecialidad[] $formacionEspecialidads
 * @property FormacionEtarium[] $formacionEtarias
 */
class FormacionProfesional extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formacion_profesional';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formacion_profesional';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'casa_academica', 'grado_academico', 'fecha_ingreso', 'fecha_egreso', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Psicologo', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formacionEspecialidads()
    {
        return $this->hasMany('App\FormacionEspecialidad', 'id_formacion_profesional', 'id_formacion_profesional');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formacionEtarias()
    {
        return $this->hasMany('App\FormacionEtarium', 'id_formacion_profesional', 'id_formacion_profesional');
    }
}
