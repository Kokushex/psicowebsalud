<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use App\Models\DetallePago;
use App\Models\ServicioPsicologo;

use Transbank\Webpay\WebpayPlus\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WebPayRestController extends Controller
{
    public static function createdTransaction()  //metodo que conlleva a la creación de la transacción
    {
        $sesiones_pago = Session::get('sesiones_pago'); // obtener variable de sesión que contiene la Reserva y el Servicio
        $id_user_psicologo = ServicioPsicologo::join('psicologo', 'psicologo.id_psicologo', '=', 'servicio_psicologo.id_psicologo')->join('persona', 'persona.id_persona', '=', 'psicologo.id_persona')
            ->select('persona.id_user')->where('servicio_psicologo.id_servicio_psicologo', '=', $sesiones_pago["reserva"]->id_servicio_psicologo)->first();
        /* ========== URL de retorno al comercio y token de TBK ===================== */
        $buy_order  = Pago::validarOrdenDeCompraUnica(strval(rand(0, 10000000)));
        session()->put('orden_compra', $buy_order);
        $session_id = strval(rand(60000, 9000000)) . $buy_order;
        $return_url = 'http://127.0.0.1:8000/return';

        $transaction = new Transaction();
        $response = $transaction->create(
            $buy_order,
            $session_id,
            $sesiones_pago["reserva"]->precio,
            $return_url
        //=========================DATOS QUE SON OBLIGATORIOS AL UTILIZAR LA API DE LA LINEA 15=========================
        // $amount,                          // 10000
        // $cvv,                             // 123
        // $card_number,                     // 4239000000000000
        // $card_expiration_date             // AA/MM - 22/10
        //==============================================================================================================
        );

        $return_url = $response->getUrl();
        $token = $response->getToken();
        session()->put('token_transaccion', $token);  // almacen en variable sesión del token

        return view('pago.rest.checkout', ['return' => $return_url, 'token' => $token, 'reserva' => $sesiones_pago["reserva"], 'servicio' => $sesiones_pago["servicio"], 'id_user_psicologo' => $id_user_psicologo->id_user]);
    }


    public function commitedTransaction(Request $request)
    {
        /* Recupera la session de pago para obtener la orden de compra */
        /* ========= Instancia de los Modelos a ocupar =========== */
        try {



            $transaction = new Transaction();
            $req = $request->except('_token');
            $response = $transaction->commit(
                $token = $req["token_ws"]

             );
            $pago = new Pago();
            $pago->orden_compra = Session::get('orden_compra'); //  necesario para retornar solo la orden de compra en caso de error
            Session::forget('orden_compra');

            $sesiones_pago = Session::get('sesiones_pago');
            switch ($response->getResponseCode()) {
                case 0:
                    /*siguiente método: si hay retraso en el pago (por parte del paciente o sistema) se valida si la hora ya ha sido tomada, en tal caso
                    retorna un error, indicando al usuario la problemática
                    */
                    if(Reserva::validarReservaNoTomada($sesiones_pago["reserva"]->fecha,$sesiones_pago["reserva"]->hora_inicio, $sesiones_pago["reserva"]->id_servicio_psicologo)>0){

                        $token_trans= Session::get('token_transaccion');

                        //anulación del pago
                        $this->reembolso($token_trans, $response->getAmount());

                        return view('pago.rest.return', ['pago' => $pago, 'resp' => 99]);

                    }

                    //----------------------------------------------------------------------

                    /*La orden de compra se genera en la createdTransaction*/

                    //almacen en variables de los datos obtenidos de la transacción
                    // session()->put('monto', $resp->getAmount());  --> en caso de reembolso
                    $orden_compra = $response->getBuyOrder();
                    $monto = $response->getAmount();
                    $cod_autorizacion = $response->getAuthorizationCode();
                    $fechaTransaccion = $response->getTransactionDate();
                    $fechaTransaccion = date('Y-m-d H:m:s', strtotime($fechaTransaccion));
                    $numero_tarjeta = $response->getCardDetail();
                    $numero_tarjeta = $numero_tarjeta['card_number'];

                    $fecha = $fechaTransaccion;
                    $tipo_pago = "";
                    $cantidad_cuotas = "";
                    $monto_cuota = "";
                    $tipo_cuota = "";



                    switch ($response->getPaymentTypeCode()) {
                        case ('VD'):
                            $tipo_pago = "Débito";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = 0;
                            $tipo_cuota = 'No Aplica';
                            break;
                        case ('VN');
                            $tipo_pago = 'Venta Normal';
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = $response->getInstallmentsAmount() ? $response->getInstallmentsAmount() : 0;
                            $tipo_cuota = 'Sin Interés';

                            break;
                        case ('SI'):
                            $tipo_pago = "Crédito";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = $response->getInstallmentsAmount() ? $response->getInstallmentsAmount() : 0;
                            $tipo_cuota = 'Sin interés';

                            break;
                        case ('S2'):
                            $tipo_pago = "Crédito";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = $response->getInstallmentsAmount() ? $response->getInstallmentsAmount() : 0;
                            $tipo_cuota = 'Sin interés';
                            break;
                        case ('VP'):
                            $tipo_pago = "Tarjeta de Prepago";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = 0;
                            $tipo_cuota = 'No Aplica';
                            break;
                        case ('VC'):
                            $tipo_pago = "Venta en cuotas";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = $response->getInstallmentsAmount() ? $response->getInstallmentsAmount() : 0;
                            $tipo_cuota = 'Con Interés';
                            break;
                        case ('NC'):
                            $tipo_pago = $response->getInstallmentsNumber()." Cuotas Sin interés";
                            $cantidad_cuotas = $response->getInstallmentsNumber();
                            $monto_cuota = $response->getInstallmentsAmount() ? $response->getInstallmentsAmount() : 0;
                            $tipo_cuota = 'Sin Interés';
                            break;
                    }

                    // retorno del pago para darselo al retorno
                    $param = array(
                        $orden_compra, $monto, $cod_autorizacion, $fecha,
                        $numero_tarjeta, $tipo_pago, $cantidad_cuotas, $monto_cuota, $tipo_cuota
                    );

                    $pago = DetallePago::storeDetallePago($param);



                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
                case -1:
                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
                case -2:
                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
                case -3:
                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
                case -4:
                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
                case -5:
                    Session::forget('sesiones_pago');
                    return view('pago.rest.return', ['pago' => $pago, 'resp' => $response->getResponseCode()]);
                    break;
            }
        } catch (\Throwable $th) {
            /*
            * El uso del número -6 es lógica interna, debido a que al anular la transacción está no devuelve nada
            * en el response desde TBK, puesto que nunca se ejecuta el bloque para confirmar esté.
            */
            //dd($th);
            Session::forget('sesiones_pago');
            return view('pago.rest.return', ['resp' => -6, 'pago' => $pago]);

        }
    }
}
