<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * mostrarDetalle
     *
     * método para obtener detalles del pago...
     *
     */
    public function mostrarDetalle($orden_compra)
    {

        $detalle = DetallePago::getDetallePago($orden_compra);

        return view('pago.ordencompra', ['pago' => $detalle["pago"], 'servicio' => $detalle["servicio"], 'reserva' => $detalle["reserva"], 'user' => $detalle["user"], 'paciente' => $detalle["paciente"]]);
    }
}
