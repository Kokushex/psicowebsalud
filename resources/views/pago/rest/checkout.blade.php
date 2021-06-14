
<div class='header w-100'>
    <div class='d-flex justify-content-center'>
        <div class='container p-lg-0 pl-4 pr-4  inner'>
            <div class='row mt-5 w-100 d-flex justify-content-center'>
                <div class='col-lg-6 p-0'>
                    <div class='banner w-100'>
                        <div class='text-left mb-5'>
                            <div class="card text">
                                <div class="card-header">
                                    <h3>Proceso de Pago</h3>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Datos de la Reserva</h5>
                                    <p class="card-text"> Usted realizará el pago para la siguiente reserva: </p>
                                    <span>N° de Cita: {{ $reserva->nro_reserva }}</span>
                                    <br>
                                    <span>Valor Cita: $ {{ $reserva->precio }}</span>
                                    <br>
                                    <span>Hora de Cita: {{$reserva->hora_inicio}} </span>
                                    <br>
                                    <span>Fecha de Cita: {{$reserva->fecha}} </span>
                                    <br>
                                    <span>Servicio: {{$servicio->nombre_servicio}} </span>
                                </div>
                                <div class="card-footer">
                                    <div class="row">

                                        <div class="col md-1">
                                            <div class="footer-left" role="group">
                                                <a href="{{Route('profile',$id_user_psicologo)}}" >
                                                    <button style="background-color: #3B83AE" class="btn btn-secondary">Volver Atrás</button>
                                                </a>

                                            </div>
                                        </div>


                                        <div class="col md-2">
                                            <div class="footer-right">
                                                <form method="post" action="{{$return}}">
                                                    <input type="hidden" name="token_ws" value="{{$token}}" />
                                                    <input class="btn btn-primary"  style="background-color:  #3BA699; color:white" type="submit" value="Pagar" />
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col md-1"></div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
