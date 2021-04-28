<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_grado_academico
 * @property int $id_psicologo
 * @property string $grado_academico
 * @property string $mencion
 * @property string $updated_at
 * @property string $created_at
 * @property Psicologo $psicologo
 */
class GradoAcademico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'grado_academico';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_grado_academico';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'grado_academico', 'mencion', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_psicologo', 'id_psicologo');
    }
}
