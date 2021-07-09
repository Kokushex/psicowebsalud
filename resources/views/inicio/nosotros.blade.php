
@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <link href="{{ asset('assets/css/inicio/welcome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/inicio/nosotros.css') }}" rel="stylesheet">

    <div class="header bannerWelcome bg-gradient-primary py-10 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white" >{{ __('Sobre nosotros.') }}</h1>

                        <!--<img src="assets/img/theme/banner.jpg"-->
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

    <!--MISION Y VISION-->
    <div class="container mt--10 pb-5"></div>

    <section class=" mx-3">
        <!--QUIENES SOMOS-->
        <div class="container-fluid">
            <div class="row mx-8">
                <div class="col-sm-12">
                    <div class="card somos mt-2" style="height: 10rem; border-radius: 10rem; background-color: #5e72e4">
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>
                                        <img class="imagenNosotros rounded-circle" src="{{asset('assets')}}/img/theme/plataforma.jpg">
                                    </td>
                                    <td>
                                        <h3 class="card-title textoWelcome text-center text-white" >¿Que es Psicoweb Salud?</h3>
                                        <p class="card-text textoWelcome text-justify text-white ">
                                            Psicoweb Salud es una plataforma destinada a recopilar la red de psicólogos más grande del país,
                                            para que estos puedan ofrecer sus servicios. A su vez los pacientes podrán tener un acceso de manera
                                            rápida y eficiente a los servicios de salud mental que más se acomoden a sus expectativas.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt--10 pb-5"></div>

    <div>
        <div class="row mx-8">
            <div class="col-sm-12" >
                <div class="card mt-2" style="height: 10rem; border-radius: 10rem; background-color: #5e72e4">
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>
                                    <img class="imagenMision rounded-circle" src="{{asset('assets')}}/img/theme/mision.jpg">
                                    <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                                </td>

                                <td>
                                    <h3 class="card-title text-white text-center">Misión</h3>
                                    <p class="card-text text-white text-justify">
                                        Proporcionar un canal que facilite y fomente el emparejamiento de pacientes y psicologos para concertar citas de atención, facilitando y expandiendo el acceso
                                        a la salud mental.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt--10 pb-5"></div>
        <div>
            <div class="row mx-8">
                <div class="col-sm-12">
                    <div class="card mt-2 " style="height:10rem; border-radius: 10rem; background-color: #5e72e4">
                        <div class="card-body" >
                            <table>
                                <tr>
                                    <td>
                                        <img class="imagenVision rounded-circle" src="{{asset('assets')}}/img/theme/vision.jpg">
                                    </td>
                                    <td>
                                        <h3 class="card-title text-white text-center">Visión</h3>
                                        <p class="card-text text-white text-justify-end">
                                            Ser una plataforma web de referencia en salud mental a nivel nacional, facilitando la concertación de citas de atención psicologica entre pacientes y profesionales del área.
                                        </p>
                                    </td>
                                </tr>
                            </table>

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

