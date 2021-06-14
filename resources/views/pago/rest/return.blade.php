

<div class='header w-100'>
    <div class='d-flex justify-content-center'>
        <div class='row w-100 d-flex justify-content-center'>
            <div class='col-lg-8 col-md-10 col-sm-11 p-0'>
                @switch($resp)
                    @case(0)
                    <div class='text-center mt-2'>
                        <div class='alert alert-success text-center'>
                            ¡Se ha realizado con éxito su reserva y su cita se encuentra pagada!
                            Se ha enviado una copia a su correo registrado.
                            Este mensaje es automático, será redirigido al detalle de su pago en
                            <span id='relojito'>15</span> segundos...
                        </div>
                    </div>
                    <div class="container">
                        <div class="bg-light p-3">
                            <h1 class="text-center m-0">Detalle Reserva</h1>
                            <div class="row pt-3 mb-2">
                                <div class="col-md-8 pull-left"><img src="{{ asset('assets/img/logoV2.png') }} "
                                                                     class="img-responsive" height="60px" class="logo" />
                                    <h2 style="    display: inline;vertical-align: middle;font-weight: 500;">Psicologos
                                        Temuco</h2>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h5 class="pt-4">Orden de reserva: {{ $pago->orden_compra }}</h5>
                                    <p class="text-muted mb-0"><i>Pedido: {{ $pago->fecha }}</i></p>
                                </div>
                            </div>
                            <div class="row b-t ">
                                <div class="col-md-6 text-right">
                                    <h5>Detalles del pago</h5>
                                    <p>Numero de cita: {{ $pago->numero_tarjeta }}</p>
                                    <p>Cod. de autorización: {{ $pago->cod_autorizacion }}</p>
                                    <p>Cantidad de cuotas: {{ $pago->cantidad_cuotas }}</p>
                                    <p>Monto de cuotas: {{ $pago->monto_cuota }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 sm-12 table-responsive-sm">

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Tipo de pago</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $pago->tipo_pago }}</td>
                                            <td>${{ $pago->monto }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="bg-dark text-white pl-3 pr-3" style="background: #2A3240 !important;">
                            <div class="row">
                                <div class="col-md-3 text-left"
                                     style="display: inline-block;vertical-align: middle;padding: 25px 15px;">
                                    <a href="" class="btn btn-sm btn-secondary"> Volver Atrás</a>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p>Esto es un resumen de su pago. para descargar el comprobante lo encontrara en su
                                        lista de pagos</p>
                                </div>
                                <div class="col-md-3 text-right centered"
                                     style="display: inline-block;vertical-align: middle;padding: 15px;">
                                    <a href="" class="btn btn-sm btn-primary"> Ir a Detalle de Pago</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                    @case(-1)
                    <div class='alert alert-danger text-center'>
                        Ha ocurrido un error al procesar la transacción (Orden de Compra:
                        {{ $pago->orden_compra }}).
                        Por favor, verifique los datos ingresados al momento de pagar.
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(-2)
                    <div class='alert alert-danger text-center'>
                        Ha ocurrido un error al procesar la transacción .
                        Por favor, verifique los datos de su tarjeta y/o su cuenta asociada.
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(-3)
                    <div class='alert alert-danger text-center'>
                        Ha ocurrido un error al procesar la transacción, su pago a sido rechazado (Orden de
                        Compra: {{ $pago->orden_compra }}).
                        Por favor, verifique su cuenta.
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(-4)
                    <div class='alert alert-danger text-center'>
                        Ha ocurrido un error, la transacción ha sido rechazada (Orden de Compra:
                        {{ $pago->orden_compra }}).
                        Por Favor consulte con el banco de su tarjeta.
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(-5)
                    <div class='alert alert-danger text-center'>
                        ¡Ha ocurrido un error, verifique el estado de su cuenta con su banco! (Orden de
                        Compra: {{ $pago->orden_compra }})
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(-6)
                    <div class='alert alert-danger text-center'>
                        El pago ha sido anulado (Orden de Compra: {{ $pago->orden_compra }}), no se ha
                        generado ningun cargo a su tarjeta.
                        Este mensaje es automático, será redirigido en <span id='relojito'>15</span>
                        segundos...
                    </div>
                    @break
                    @case(99)
                    <div class='alert alert-danger text-center'>
                        Esta transacción ha sido anulada, debido a que la reserva solicitada no se encuentra
                        disponible.
                        Por favor inténtelo con otra hora y/o fecha.
                        Lamentamos las molestias. Este mensaje es automático, será redirigido en <span
                            id='relojito'>15</span> segundos...
                    </div>
                    @break
                @endswitch
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    window.onload = updateClock;
    var totalTime = 15;

    function updateClock() {
        document.getElementById('relojito').innerHTML = totalTime;
        if (totalTime == 0) {
            if ({{ $resp }} === 0) {
                window.location.replace('/pasareladepago/ordencompra/{{ $pago->orden_compra }}');
            } else {
                window.location.replace('/home');
            }
        } else {
            totalTime -= 1;
            setTimeout('updateClock()', 1500);
        }
    }

</script>

</html>
