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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container" id="supContainer">
        <!-- Boton modal -->
        <div class="card tarjeta mt-5 ">
            <a class="btn btn-success text-white my-2 mx-4" role="button" data-toggle="modal" data-target="#modalAgregarServicio">
                <i class="ni ni-fat-add"></i>
                Agregar Servicio
            </a>
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
    </div>
        @include('servicios.crearServicio')


    @include('layouts.footers.auth')



@endsection










