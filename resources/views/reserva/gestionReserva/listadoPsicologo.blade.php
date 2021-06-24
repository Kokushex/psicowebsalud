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
