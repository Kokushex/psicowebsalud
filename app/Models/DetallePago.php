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
        return $this->belongsTo('App\Models\Pago', 'id_pago', 'id_pago');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserva()
    {
        return $this->belongsTo('App\Models\Reserva', 'id_reserva', 'id_reserva');
    }

/**
 * storeDetallePago
 *
 * Método utilizado para almacenar el pago, detalle pago, actualizar ciertos estados
 *
 */

    public static function storeDetallePago($param){

        // esta variable de sesión obtiene la reserva y el servicio, variable instanciada en metodo Modelo Reserva
        $sesiones_pago = session('sesiones_pago');

        $pago = Pago::storePago($param);
        $detallePago    = new DetallePago();

        // se puede o no instanciar un modelo Reserva para hacer esta actualización de sus datos en BD
        // esta vez se ha optado por hacerlo de manera directa desde la variable de sesión indexada
        $sesiones_pago["reserva"]->confirmacion = "Confirmado";
        $sesiones_pago["reserva"]->estado_pago = "Pagado";

        $sesiones_pago["reserva"]->save();

        $detallePago->id_servicio = $sesiones_pago["servicio"]->id_servicio_psicologo;
        $detallePago->id_reserva = $sesiones_pago["reserva"]->id_reserva;
        $detallePago->id_pago = $pago->id_pago;
        $detallePago->save();

        $persona = Persona::join('paciente','paciente.id_persona','=','persona.id_persona')
            ->join('reserva','reserva.id_paciente','=','paciente.id_paciente')
            ->where('reserva.id_paciente','=',$sesiones_pago["reserva"]->id_paciente)->first();

        // envio email SOLO notificatorio ya que al pagar se confirma automáticamente
        //Mail::to(auth()->user()->email)->send(new Testmail($sesiones_pago["reserva"], $persona, "notificacion"));

        // retorno de pago utilizado en el controlador que lo utiliza en WebPayRestController
        return $pago;

    }
}
