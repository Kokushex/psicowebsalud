@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary py-7 py-lg-6">
    <div class="container">
        <div class="header-body text-center mt-1 mb-1">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{{ __('Confirmación de pago.') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>

<div class="container mt--10 pb-5"></div>

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
                                                <a href="{{Route('reserva.list')}}" >
                                                    <button style="background-color: #FFFFFF; border-color: #5e72e4" class="btn btn-secondary">Volver Atrás</button>
                                                </a>

                                            </div>
                                        </div>


                                        <div class="col md-2">
                                            <div class="footer-right">
                                                <form method="post" action="{{$return}}">
                                                    <input type="hidden" name="token_ws" value="{{$token}}" />
                                                    <input class="btn btn-primary"  style="background-color:  #5e72e4; color:white" type="submit" value="Pagar" />
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

@endsection
