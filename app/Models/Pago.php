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
 * @property int $id_user
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
    protected $fillable = ['orden_compra', 'monto', 'cod_autorizacion', 'fecha', 'tipo_pago', 'tipo_cuota', 'cantidad_cuota', 'monto_cuota', 'numero_tarjeta', 'id_user', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function detallePagos()
    {
        return $this->hasMany('App\Models\DetallePago', 'id_pago', 'id_pago');
    }


    /**
     * storePago
     *
     * almacenar datos del pago en la bd
     *
     */
    public static function storePago($param){


        $pago = new Pago();
        $pago->orden_compra = $param[0];
        $pago->monto = $param[1];
        $pago->cod_autorizacion = $param[2];
        $pago->fecha = $param[3];
        $pago->numero_tarjeta = $param[4];
        $pago->tipo_pago = $param[5];
        $pago->cantidad_cuota = $param[6];
        $pago->monto_cuota = $param[7];
        $pago->tipo_cuota = $param[8];
        $pago->id_user = auth()->user()->id_user;

        $pago->save();

        return $pago;

    }


    /**
     * validarOrdenDeCompraUnica
     *
     * método para validar que el numero otorgado a la orden de compra sea único
     *
     */
    public static function validarOrdenDeCompraUnica($numero_random){

        $comprobacion_nro = 0;
        $retorno = 0;
        while ($comprobacion_nro<1) {

            $cantidad = Pago::where('orden_compra','=',$numero_random)->count();
            if($cantidad==0){

                $retorno = $numero_random;

                $comprobacion_nro++;
            }
        }

        return $retorno;
    }

    /**
     * datosDeUsuarioPago
     *
     * obtener datos del usuario autenticado titular del pago.
     *
     */
    public static function datosDePagoUsuario($id_user){


        return Pago::join('users','users.id_user','=','pago.id_user')
              ->join('persona','persona.id_user','=','users.id_user')
              ->join('paciente','paciente.id_persona','=','persona.id_persona')

            ->select('persona.nombre','persona.apellido_paterno','persona.apellido_materno','users.email')
            ->where('users.id_user','=',$id_user)->first();


    }

}
