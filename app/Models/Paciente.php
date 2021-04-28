<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_paciente
 * @property int $id_persona
 * @property string $escolaridad
 * @property string $ocupacion
 * @property string $estado_civil
 * @property string $grupo_familiar
 * @property string $estado_clinico
 * @property string $informacion
 * @property string $observacion_alta
 * @property string $tipo_alta
 * @property string $tipo_paciente
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property Reserva[] $reservas
 * @property Testimonio[] $testimonios
 */
class Paciente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'paciente';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_paciente';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'escolaridad', 'ocupacion', 'estado_civil', 'grupo_familiar', 'estado_clinico', 'informacion', 'observacion_alta', 'tipo_alta', 'tipo_paciente', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'id_persona', 'id_persona');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_paciente', 'id_paciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonios()
    {
        return $this->hasMany('App\Models\Testimonio', 'id_paciente', 'id_paciente');
    }
}
