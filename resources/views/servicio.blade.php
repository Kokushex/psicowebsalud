@extends('layouts.app')
@section('content')

    <div class="header bg-gradient-primary py-7 py-lg-6">

            <div class="container">
                <div class="header-body text-center mt-1 mb-1">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">{{ __('Servicios.') }}</h1>
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

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Servicios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Gestión de Servicios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container" id="supContainer">
        <div class="card mb-5">
        <!-- Boton modal -->
        <div class="card tarjeta mt-5">
                @if(auth()->user()->persona->psicologo->verificado =='EN ESPERA')
                    <div class="alert alert-warning text-center my-2 mx-4" id="mensajeInformativo">
                        <b id="msgPsicologo">{{__('Confirmación de datos profesionales pendiente.')}}</b>
                    </div>
                @else
                    <a class="btn btn-success text-white my-2 mx-4" role="button" data-toggle="modal" data-target="#modalAgregarServicio">
                        <i class="ni ni-fat-add"></i>
                        Agregar Servicio
                    </a>
                @endif
            </div>
        <!-- Fin-->

        <!--tabla ejemplo-->
            <div class="table-responsive">
                      <table id="tablaServicio" class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                              <th class="hide_me">#id_servicio_psicologo</th>
                            <th >Nombre</th>
                            <th >Descripcion</th>
                            <th >Modificar</th>
                            <th >Estado</th>
                          </tr>
                        </thead>
                      </table>
            </div>

        @include('servicios.descripServicios')

        @include('servicios.editServicio')

        @include('servicios.crearServicio')
        </div>
    </div>

    @include('layouts.footers.auth')
    @push('js')
        <!--Librerias de Datatables-->
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!--select2-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!--Servicio-->
        <script src="{{ asset('assets/js/servicios/dashServicios.js') }}"></script>
        <script src="{{asset('assets/js/servicios/steperServicio.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/servicios/servicio.css')}}">
    @endpush


@endsection










