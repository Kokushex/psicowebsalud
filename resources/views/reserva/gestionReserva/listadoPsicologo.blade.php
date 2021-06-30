@extends('layouts.app')
@section('content')
    @if (session('mensaje'))
        <div class="alert alert-success text-center">
            {{session('mensaje')}}
        </div>
    @endif

    @if (session('mensaje'))
        <div class="alert alert-success text-center">
            {{session('mensaje')}}
        </div>
    @endif

    <div class="header bg-gradient-primary py-7 py-lg-6">

        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Lista de Reservas.') }}</h1>
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

        <div class="card bg-light mt-4">
            <div class="card-body bg-light">
                <div class="form-inline float-right mb-3">
                    <div class="input-group-prepend">
                        <input type="text" class="form-control" name="buscar" value="{{$filtro}}" id="filtro_texto"
                               title="filtre por nombre, apellido o rut del paciente" placeholder="Ingrese nombre, apellido o rut">
                    </div>
                </div>
                <!-- tabla -->
                <div id="table_data">
                    @include('reserva.gestionReserva.partial_listado_reservas_psicologo')
                </div>
                <!-- TÉRMINO TABLA RESULTADOS -->
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{{asset('assets/js/reserva/funciones_lista_reservas_psico.js')}}"></script>

@endsection
