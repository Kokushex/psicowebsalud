<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_pago
 * @property string $orden_compra
 * @property int $monto
 * @property int $cod_autorizacion
 * @property string $fecha
 * @property string $tipo_pago
 * @property string $tipo_cuota
 * @property int $cantidad_cuota
 * @property int $monto_cuota
 * @property int $numero_tarjeta
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property DetallePago[] $detallePagos
 */
class Pago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_pago';

    /**
     * @var array
     */
    protected $fillable = ['orden_compra', 'monto', 'cod_autorizacion', 'fecha', 'tipo_pago', 'tipo_cuota', 'cantidad_cuota', 'monto_cuota', 'numero_tarjeta', 'id_usuario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detallePagos()
    {
        return $this->hasMany('App\Models\DetallePago', 'id_pago', 'id_pago');
    }
}
