<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Document</title>
    <style>
        a {
            color: white;
        }

        a:hover {
            color: #5e72e4;
        ;
        }

        a:active {
            color: #5e72e4;
        ;
        }
    </style>
</head>


<body>
<div class="container">
    <!-- INFORMACIÓN DEL COMERCIO -->
    <div style="text-align: center;">
        <img src="argon/img/brand/blue.png" style="width:100%; max-width:250px;">
    </div>
    <div class="mt-2" style="text-align: center;">
        <span>Psicoweb Salud</span> |
        <span>Direccion, CL</span> <br>
        <span>(+56 9) 999 999 99</span> |
        <span>psicowebsalud@gmail.com</span>
    </div>
    <!-- INFORMACIÓN DEL COMERCIO -->
    <!-- INFORMACIÓN DEL CLIENTE -->
    <table class="table table-sm customer-grid mt-2">
        <thead>
        <tr style="background-color: #5e72e4;">
            <th colspan="4" style="color: white">INFORMACIÓN DE CLIENTE</th>
        </tr>
        </thead>
        <tr>
            <td> Nombre: </td>
            <td nowrap>
                {{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}
            </td>
            <td> Correo: </td>
            <td>
                {{$user->email }}
            </td>
        </tr>
    </table>
    <!-- INFORMACIÓN DEL CLIENTE -->
    <!-- INFORMACIÓN DEL TRANSACCIÓN -->
    <table class="table table-sm customer-grid mt-2">
        <tr style="background-color: #5e72e4;">
            <th colspan="5" style="font-size: small; color:white">DATOS DE TRANSACCIÓN</th>
        </tr>
        <tr>
            <td colspan="2" nowrap>
                <span>Orden de Compra: </span>
            </td>
            <td style="text-align: right">
                {{$pago->orden_compra}}
            </td>
            <td>
                <span>Tipo de Pago:</span>
            </td>
            <td style="text-align: left; font-family: DejaVu Sans, sans-serif;" nowrap>
                {{$pago->tipo_pago}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span>N° de Tarjeta:</span>
            </td>
            <td>
                {{$pago->numero_tarjeta}}
            </td>
            <td nowrap>
                <span>Tipo de Cuota:</span>
            </td>
            <td nowrap style="text-align: left">
                {{$pago->tipo_cuota}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span>Cod. Autorización:</span>
            </td>
            <td>
                {{$pago->cod_autorizacion}}
            </td>
            <td>
                <span>N° de Cuotas:</span>
            </td>
            <td style="text-align: left;">
                {{$pago->cantidad_cuotas}} <span class="text-muted" style="font-size: x-small;"> (de $ {{$pago->monto_cuota }})</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span>Hora: </span>
            </td>
            <td>
                {{ date('H:i', strtotime($pago->fecha)) }}
            </td>
            <td>
                <span>Fecha: </span>
            </td>
            <td style="text-align: left;">
                {{ date('d-m-Y', strtotime($pago->fecha)) }}
            </td>
        </tr>
    </table>
    <!-- INFORMACIÓN DEL TRANSACCIÓN -->
    <!-- DETALLE DE TRANSACCIÓN -->
    <table class="table table-sm customer-grid mt-2">
        <thead style="background-color: #5e72e4; font-size: small;">
        <tr>
            <th style="color: white">Descripción</th>
            <th style="color: white">Fecha reserva</th>
            <th style="color: white">Hora reserva</th>
            <th>&nbsp;</th>
            <th style="color: white">Precio</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                {{ $servicio->descripcion }}
            </td>
            <td>
                {{ $reserva->fecha }}
            </td>
            <td colspan="2">
                {{ date('H:i', strtotime($reserva->hora_inicio)) }} - {{ date('H:i', strtotime($reserva->hora_termino)) }}
            </td>
            <td>
                $ {{ $pago->monto }}
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                Subtotal
                <span class="text-muted" style="font-size: xx-small;"> (CLP)</span>
                :
            </td>
            <td>$ {{ $pago->monto }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">Desc. (x%):</td>
            <td>$ 0</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                Total
                <span class="text-muted" style="font-size: xx-small;"> (CLP)</span>
                :
            </td>
            <td> $ {{ $pago->monto }}</td>
        </tr>
        </tfoot>
    </table>
    <!-- DETALLE DE TRANSACCIÓN -->
    <!-- MENSAJES FINALES -->
    <div>
        <div class="text-center">¡Gracias por tu preferencia! </div>
        <div class="text-center">Equipo Psicoweb Salud</div>
    </div>
    <!-- MENSAJES FINALES -->
    <!-- FOOTER -->
    <footer class="page-footer">
        <div style="background-color: #5e72e4;">
            <!-- SEGURIDAD -->
            <table class="table table-sm table-borderless" style="font-size: x-small; background-color: #969BAA;">
                <tbody>
                <tr>
                    <td rowspan="2" class="text-center mt-3">
                        <img src="assets/img/icons/warning_shield.png">
                    </td>
                    <td> No acceda a e-mail ni SMS desconocidos.</td>
                    <td> Mantenga actualizado su antivirus. </td>
                </tr>
                <tr>
                    <td>No haga clic en enlaces o archivos de esos e-mails ni SMS.</td>
                    <td>Desconfíe de mensajes de ofertas, promociones o premios increíbles. </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <!-- SEGURIDAD -->
            <!-- RR.SS -->
            <div class="row py-1 d-flex align-items-center">
                <div class="col-md-12 text-center" style="font-size: smaller;">

                    <a style="text-align: center"> | Psicoweb Salud </a>

                </div>
            </div>
            <div class="text-center" style="color: white;">
                Psicoweb Salud. Copyright &copy; Todos los derechos reservados.
            </div>
            <!-- RR.SS -->
        </div>
    </footer>
    <!-- FOOTER -->
</div>
</body>

</html>
