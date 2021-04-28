<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_direccion_atencion
 * @property int $id_user
 * @property string $direccion
 * @property string $comuna
 * @property string $region
 * @property boolean $habilitado
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class DireccionAtencion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'direccion_atencion';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_direccion_atencion';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'direccion', 'comuna', 'region', 'habilitado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id_user');
    }
}
