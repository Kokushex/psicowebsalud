<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_detalle_pago
 * @property int $id_pago
 * @property int $id_reserva
 * @property int $subtotal
 * @property string $created_at
 * @property string $updated_at
 * @property Pago $pago
 * @property Reserva $reserva
 */
class DetallePago extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_pago';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_detalle_pago';

    /**
     * @var array
     */
    protected $fillable = ['id_pago', 'id_reserva', 'subtotal', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pago()
    {
        return $this->belongsTo('App\Pago', 'id_pago', 'id_pago');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserva()
    {
        return $this->belongsTo('App\Reserva', 'id_reserva', 'id_reserva');
    }
}
