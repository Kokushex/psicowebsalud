@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

<link href="{{ asset('assets/css/formulario.css') }}" rel="stylesheet">


<div class="header bg-gradient-primary py-7 py-lg-8">
    <div class="container">
    <div class="hero white-text" style="background-image: url('{{asset('assets/img/dashboardShadow.jpg')}}')">
    <div class="indigo-overlay">
        <div class="container d-flex justify-content-center">
            <div class="row mt-1 mb-1 d-flex justify-content-center">
                <div class="col-md-8 align-self-center">
                    <div class="text-center" style=" color: #fff;">
                        <h1 class="title-2 mb-4" style ="color: #fff">Registrate</h1>
                        <p class="text-2 text-regular"><b>Bienvenido a la seccion de registro, selecciona el tipo de usuario para continuar</b>
</p>
                    </div>
                </div>
            </div>
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


<div class="container">

    <div class="row mt-4">
        <div class="col-12">
            <div class="col-12">
                
                <!-- CARD -->
                <div class="card bg-secondary shadow border-0 ">
                    <div class="card-header bg-transparent pb-5">
                        <h3 style="text-align: center;">Selecciona el tipo de usuario que eres para registrarte:</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                            <!--<h3 style="text-align: center; color: #8373e6;" >¿Que tipo de usuario eres?</h3>-->
                        
                        <div class="radio-buttons mb-5 ">
                            <label class="custom-radio">
                                <span class="radio-btn"><i class="las la-check"></i>
                                <a href="{{ route('register_paciente') }}">
                                        <div class="hobbies-icon">
                                            <i class="fas fa-user text-blue"></i>
                                            <h3 class="titulo_us" style ="color: #8373e6;" >Paciente</h3>
                                        </div>
                                    </a>
                                </span>
                            </label>
                            <label class="custom-radio">
                                <span class="radio-btn"><i class="las la-check "></i>
                                <a href="{{ route('register_psicologo') }}">
                                        <div class="hobbies-icon">
                                            <i class="far fa-id-badge text-blue"></i>
                                            <h3 class="titulo_us"  style ="color: #8373e6;">Psicólogo</h3>
                                        </div>
                                    </a>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection