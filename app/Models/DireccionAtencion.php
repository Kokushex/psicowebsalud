<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsTo('App\Models\User', 'id_user', 'id_user');
    }

    /**
     * Metodo para generar la direccion de atencion y asociarla con persona
     */
    public static function generarDireccion(){
        $direccionAtencion = new DireccionAtencion();
        $direccionAtencion->id_user = Auth::id();
        $direccionAtencion->save();
        return $direccionAtencion;
    }
    /**
     * Metodo para actualizar la direccion de atencion
     */
    public static function updateDireccionAtencion($request){

        $direccionAtencion = new DireccionAtencion();

        return $direccionAtencion = DireccionAtencion::where('id_user', Auth::id())
            ->update([
                'region' => $request->region,
                'comuna' => $request->comuna,
                'direccion' => $request->direccion,
            ]);
    }



}
