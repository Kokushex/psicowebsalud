<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

        //$detallePago->id_servicio = $sesiones_pago["servicio"]->id_servicio_psicologo;
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


    /**
     * getDetallePago
     *
     * método para obtener detalles del pago de la reserva
     *
     */
    public static function getDetallePago($orden_compra){

        $pago       = Pago::where('orden_compra','=', $orden_compra)->first();
        $detalle    = DetallePago::where('id_pago','=', $pago->id_pago)->first();
        $reserva    = Reserva::findOrFail($detalle->id_reserva);
        $servicio   = Servicio::join('servicio_psicologo','servicio_psicologo.id_servicio','=','servicio.id_servicio')
            ->join('reserva','reserva.id_servicio_psicologo','=','servicio_psicologo.id_servicio_psicologo')
            ->select('servicio.nombre','servicio.descripcion')->where('servicio_psicologo.id_servicio_psicologo','=',$reserva->id_servicio_psicologo)->first();

        $user       = Pago::datosDePagoUsuario(auth()->user()->id_user);

        $paciente   = Paciente::getDatosPaciente($reserva->id_reserva);

        // almacen de los objetos en un arreglo
        $detalles =  array("pago" => $pago, "detalle" => $detalle, "reserva" => $reserva,
            "servicio" => $servicio, "user" => $user, 'paciente'=>$paciente);

        return $detalles;

    }
}
