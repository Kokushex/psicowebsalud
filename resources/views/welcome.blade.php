@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8" style="height: 10rem">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Bienvenido a Psicoweb Salud.') }}</h1>
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
            <div class="row mx-3">
                <div class="col-sm-6">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Misión</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in rutrum erat.
                                Cras vel sollicitudin magna, nec ullamcorper dui. Nullam consequat tempor enim id commodo. Vestibulum
                                ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer in efficitur lectus.
                                Vivamus massa ex, aliquam vel laoreet vitae, feugiat id quam. Duis congue vehicula libero eget convallis.
                             </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Visión</h5>
                                <p class="card-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in rutrum erat.
                                    Cras vel sollicitudin magna, nec ullamcorper dui. Nullam consequat tempor enim id commodo. Vestibulum
                                    ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer in efficitur lectus.
                                    Vivamus massa ex, aliquam vel laoreet vitae, feugiat id quam. Duis congue vehicula libero eget convallis.
                                </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="container mt--10 pb-5"></div>


@endsection
