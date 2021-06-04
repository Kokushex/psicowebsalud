@extends('layouts.app')
@section('content')
<div class="header bg-gradient-primary py-7 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Reserva.') }}</h1>
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

    @if (session('mensaje'))
        <div class="alert alert-success text-center">
            {{session('mensaje')}}
        </div>
    @endif

    <div class="container">
        <div class="card  bg-light mt-4">
            <div class="card-body bg-light text-center">
                <h1 >Lista de Reservas</h1>
            </div>
        </div>

        <div class="card bg-light mt-4">
            <div class="card-body bg-light">
                <div class="form-inline float-right mb-3">
                    <div class="input-group-prepend">
                        <!-- <span class="input-group-text" style="background-color: #484AF0;">
                            <<i class="fas fa-search" style="color:white"></i>
                        </span> -->
                        <input type="text" class="form-control" name="buscar" value="{{}}" id="filtro_texto"
                               title="filtre por nombre, apellido o rut del paciente" placeholder="Ingrese nombre, apellido o rut">
                    </div>
                </div>
                <!-- tabla -->
                <div id="table_data">
                    @include('reserva.gestionReserva.listadoReservaPsi')
                </div>
                <!-- TÉRMINO TABLA RESULTADOS -->
            </div>
        </div>
    </div>


    @include('layouts.footers.auth')
@endsection
