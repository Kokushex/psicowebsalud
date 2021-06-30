<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


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

    public function descargarDetalle($orden_compra)
    {
        //obtener detalles del pago
        $detalle = DetallePago::getDetallePago($orden_compra);

        $pdf = PDF::loadView('pago.pagoDetalle', ['pago' => $detalle["pago"], 'servicio' => $detalle["servicio"], 'user' => $detalle["user"], 'reserva' => $detalle["reserva"]]);

        return $pdf->download("pago-detalle-" . $detalle["pago"]->fecha . ".pdf");
    }
}
