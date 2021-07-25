
@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <link href="{{ asset('assets/css/inicio/welcome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/inicio/nosotros.css') }}" rel="stylesheet">

    <div class="header bannerWelcome bg-gradient-primary py-10 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white" >{{ __('') }}</h1>

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
                                        <img class="imagenNosotros px-3 " src="{{asset('assets')}}/img/brand/logo.png" style="width: 7rem">
                                    </td>
                                    <td>
                                        <h3 class="card-title textoWelcome text-center text-white" >Bienvenido {{auth()->user()->persona->nombre}} {{auth()->user()->persona->apellido_paterno}} </h3>

                                        <p class="card-text textoWelcome text-justify text-white ">
                                            Si ya has verificado tu correo, comienza a utilizar tus funciones que puedes encontrar en tu barra lateral.
                                        </p>
                                        <p class="card-text textoWelcome text-justify text-white ">
                                            Que tengas un buen dia.
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


@endsection


@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

