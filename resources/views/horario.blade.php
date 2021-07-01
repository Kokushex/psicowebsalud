@extends('layouts.app')
@section('content')

    <div class="header bg-gradient-primary py-7 py-lg-6">

        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Horario.') }}</h1>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mt--10 pb-5"></div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Horario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Horario</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container" id="supContainer">
        <div class="card mb-5">
        <!-- Boton modal -->
            <div class="card tarjeta mt-5">
                @if(auth()->user()->persona->psicologo->verificado =='EN ESPERA')
                    <div class="alert alert-warning text-center my-2 mx-4" id="mensajeInformativo">
                        <b id="msgPsicologo">{{__('Confirmación de datos profesionales pendiente.')}}</b>
                    </div>
                @else
                    <a class="btn btn-success text-white my-2 mx-4" role="button" data-toggle="modal" data-target="#modalAgregarHorario">
                        <i class="ni ni-fat-add"></i>
                        Agregar Horario
                    </a>
                @endif
            </div>
        <!-- Fin-->
          
            <!--tabla de contenido  -->
            <div class="table-responsive">
                <table id="tablaHorario" class="table table-hover text-center table-striped table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th class="hide_me">#id_horario_dia</th>
                            <th class="hide_me">#id_horario</th>
                            <th class="hide_me">#id_dia</th>
                            <th class="hide_me">#Lunes</th>
                            <th class="hide_me">#Martes</th>
                            <th class="hide_me">#Miercoles</th>
                            <th class="hide_me">#Jueves</th>
                            <th class="hide_me">#Viernes</th>
                            <th class="hide_me">#Sabado</th>
                            <th class="hide_me">#Domingo</th>
                            <th>Dias de Trabajo</th>
                            <th id="entradaAM">Hora Entrada AM</th>
                            <th id="salidaAM">Hora Salida AM</th>
                            <th id="entradaPM">Hora Entrada PM</th>
                            <th id="salidaPM">Hora Salida PM</th>
                            <th>Ver</th>
                            <th>Modificar</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Fin Tabla de Contenido -->
        
        @include('horario.formulariosHorario')
        </div>  
        
    </div>

    @include('layouts.footers.auth')
    @push('js')
        <!--Librerias de Datatables-->

        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!--Horario-->
        <script src="{{asset('assets/js/horario/dashboardHorario.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/horario/horario.css')}}">
    @endpush

@endsection
