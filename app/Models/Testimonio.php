<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_testimonio
 * @property int $id_psicologo
 * @property int $id_paciente
 * @property string $titulo
 * @property int $valoracion
 * @property boolean $anonimo
 * @property string $comentario
 * @property string $created_at
 * @property string $updated_at
 * @property Paciente $paciente
 * @property Psicologo $psicologo
 */
class Testimonio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'testimonio';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_testimonio';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'id_paciente', 'titulo', 'valoracion', 'anonimo', 'comentario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'id_paciente', 'id_paciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_psicologo', 'id_psicologo');
    }
}
