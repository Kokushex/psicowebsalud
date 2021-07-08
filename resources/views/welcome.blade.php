@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <link href="{{ asset('assets/css/inicio/welcome.css') }}" rel="stylesheet">

    <div class="header bg-gradient-primary py-6 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white" >{{ __('Bienvenido a Psicoweb Salud.') }}</h1>
                        <!--<img src="argon/img/brand/blue.png">-->

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
    <section class="seccion1 mx-3">
        <!--QUIENES SOMOS-->
        <div>
            <div class="row mx-8">
                <div class="">
                    <div class="card somos mt-2">
                        <div class="card-body">
                            <h3 class="card-title text-center text-white" >¿Quienes Somos?</h3>
                            <p class="card-text text-justify text-white">
                                Psicoweb Salud es una plataforma destinada a recopilar la red de psicólogos más grande del país,
                                para que estos puedan ofrecer sus servicios. A su vez los pacientes podrán tener un acceso de manera
                                rápida y eficiente a los servicios de salud mental que más se acomoden a sus expectativas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="seccion1 table-responsive-sm"  style="height: 30rem;" >
        <div class="card card_funcion mx-6">
            <div class="card-header encabezado_funcion text-center ">
                <h3 class="text-white" >¿Cómo funciona Psicoweb Salud?</h3>
            </div>
            <div class="card-body mb-4 py-2">
                        <div class="row mx-8">
                            <div class="col-sm-4">
                                <div class="card tarjeta-img mt-2" >
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Registrate.</h5>
                                        <img src="assets/img/icons/registrar.png" style="width: 30%">
                                        <p class="card-text text-white">
                                            Registrate  y completa tus datos.
                                         </p>

                                        <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="card tarjeta-img mt-2" >
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Busca a tu psicologo.</h5>
                                        <img src="assets/img/icons/buscar.png" style="width: 30%">
                                            <p class="card-text text-white">
                                                Selecciona el psicologo que mas te acomode.
                                            </p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="card tarjeta-img mt-2" >
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Reserva</h5>
                                        <img src="assets/img/icons/reserva.png" style="width: 30%">
                                        <p class="card-text text-white">
                                            Reserva en la fecha y hora de tu elección.
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </section>
@endsection


