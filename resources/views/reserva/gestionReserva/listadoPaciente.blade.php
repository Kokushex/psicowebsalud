@extends('layouts.app')
@section('content')
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
                        <h1 class="text-white">{{ __('Lista de Reservas') }}</h1>
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

    <div id="container">
        <div id="table_data">
            @include('reserva.gestionReserva.partial_listado_reservas_paciente_2')
        </div>
    </div>

    @push('js')
        <!--Librerias de Datatables-->
        <link href="{{asset('assets/css/reserva/table.css')}}" rel="stylesheet">

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>

        <script src="{{asset('assets/js/reserva/funciones_lista_reservas.js')}}"></script>

        


    @endpush
@endsection
