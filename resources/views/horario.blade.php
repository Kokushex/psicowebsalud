@extends('layouts.app')
@section('content')

    <div class="header bg-gradient-primary py-7 py-lg-6" style="height: 10rem">

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
    <div class="container mt--10 pb-5"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid mt-2" id="supContainer">
        <div class="card shadow mb-12">
            <div class="card-header">
                <h3 class="card-title">Gestión Horario</h3>
            </div>
            <div class="card shadow mb-12">
            <!-- /.container-fluid -->
                <!-- Boton modal -->
                    <div class="card tarjeta mt-5">
                        @if(auth()->user()->persona->psicologo->verificado =='EN ESPERA')
                            <div class="alert alert-warning text-center my-2 mx-4" id="mensajeInformativo">
                                <b id="msgPsicologo">{{__('Confirmación de datos profesionales pendiente.')}}</b>
                            </div>
                        @else
                            <div class="col-lg-3">
                            <a class="btn btn-sm btn-success text-white my-2 mx-4" role="button" data-toggle="modal" data-target="#modalAgregarHorario">
                                <i class="ni ni-fat-add"></i>
                                Agregar Horario
                            </a>
                            </div>
                        @endif
                    </div>
                <!-- Fin-->
                    <div class="card-body">
                    <!--tabla de contenido  -->
                        <div class="table table-striped table-bordered table-responsive">
                            <table id="tablaHorario" class="table table-hover text-center table-striped table-sm" style="width: 100%">
                                <thead>
                                    <tr class="text-lg-center">
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
                    </div>
            </div>
        </div>
    </div>
            <!-- Fin Tabla de Contenido -->

        @include('horario.formulariosHorario')





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
