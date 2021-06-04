@extends('layouts.app')
@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-6">

        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Listado') }}</h1>
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

    <div class="row d-flex justify-content-end">
        <div class="col-md-4">
            <div class="flex-nowrap col ml-auto footer-subscribe p-0">
                <form action="{{ route('reserva.list') }}" id="filtro" method="GET" autocomplete="off">
                    <input class="form-control text-4" name="datoFiltro" id="datoFiltro" type="text"
                           placeholder="Ingrese un nombre o apellido" @if ($filtro_texto != '') value="{{ $filtro_texto }}" @endif />
                    <button type="button" class="btn indigo btn-theme bg-orange" onclick="funcionBuscar()"><i
                            class="fa fa-search p-0"></i></button>
                </form>
            </div>
            <div id="mensaje"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="mensaje"></div>
            <div>
               @foreach($psicologos as $profesional)
                    <div class="col-md-6 mb-3">
                        <div class="card" style="box-shadow: 1px 2px 10px rgb(77, 77, 77);">
                            <div class="row no-gutters d-flex justify-content-center">

                                <div class="col-8 align-self-center">
                                    <div class="card-body p-2">
                                        <a href="{{ route('busqueda', $profesional->id_psicologo) }}">
                                            <h5 class="title-3 darkblue-text mb-0">
                                                {{ $profesional->nombre . ' ' . $profesional->apellido_paterno }}
                                            </h5>
                                        </a>
                                        <p class="text-4 bluegray-text mb-0">
                                            Especialidad: {{ $profesional->especialidad }}
                                        </p>
                                        <p class="text-4 bluegray-text mb-0">
                                            <i class="fas fa-map-marker-alt"></i> {{ $profesional->direccion }}
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
