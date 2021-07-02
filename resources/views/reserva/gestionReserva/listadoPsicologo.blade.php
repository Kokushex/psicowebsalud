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

    <div class="header bg-gradient-primary py-7 py-lg-6" style="height: 10rem">

        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Lista de Reserva.') }}</h1>
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
    <div>
                <!-- tabla -->
                <div id="table_data">
                    @include('reserva.gestionReserva.partial_listado_reservas_psicologo')
                </div>
                <!-- TÉRMINO TABLA RESULTADOS -->
    </div>

@push('js')
    <link href="{{asset('assets/css/reserva/table.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


@endpush
@endsection
