@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-6 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white" >{{ __('Bienvenido a Psicoweb Salud.') }}</h1>
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
    <!--QUIENES SOMOS-->
    <div>
        <div class="row mx-3">
            <div class="">
                <div class="card mt-2">
                    <div class="card-body">
                        <h3 class="card-title">¿Quienes Somos?</h3>
                        <p class="card-text">
                            Psicoweb Salud es una plataforma destinada a recopilar la red de psicólogos más grande del país,
                            para que estos puedan ofrecer sus servicios. A su vez los pacientes podrán tener un acceso de manera
                            rápida y eficiente a los servicios de salud mental que más se acomoden a sus expectativas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MISION Y VISION-->
    <div class="container mt--10 pb-5"></div>

    <div>
            <div class="row mx-8">
                <div class="col-sm-6">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Misión</h5>
                            <p class="card-text">
                                Proporcionar un canal que facilite y fomente el emparejamiento de pacientes y psicologos para concertar citas de atención.
                             </p>
                            <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Visión</h5>
                                <p class="card-text">
                                    Ser una plataforma web de referencia en salud mental a nivel nacional, facilitando la concertación de citas de atención psicologica entre pacientes y profesionales del área.
                                </p>

                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="container mt--10 pb-5"></div>


@endsection


@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
