@extends('layouts.app')
@section('content')

    <div class="header bg-gradient-primary py-7 py-lg-6">

        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Reserva psicologo') }}</h1>
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

    <input type="hidden" id="idPerfil" value="{{auth()->id()}}">
    <div class="container" style="margin-top: 100px; min-height: 600px">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @include('perfil.includes.informacion')
            </div>
            <div class="col-lg-6 pr-0 pl-0">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="text-lightblue text-bold mb-3 py-1">Acerca</h3>
                        <p class="text-4 bluegray-text">{{$user->descripcion}}</p>
                    </div>
                </div>

                    @include('perfil.includes.Ayuda')

                @include('perfil.includes.optionsServicio')
        </div>
    </div>

    @push('js')

            <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
            <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

            <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
            <script src="{{ asset('assets/js/reserva/modal_create_reserva.js') }}"></script>
            <script src="{{ asset('assets/js/reserva/steper.js') }}"></script>

            <link rel="stylesheet" type="text/css" href="{{asset('assets/css/reserva/reserva.css')}}">

            <script>
                function alerta(){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        html: "Verifica que estes <strong>Autenticado</strong> y que el Psicólogo tenga <strong>disponibilidad</strong> en sus servicios",
                        cancelButtonText: '<i class="fas fa-times"></i> Cerrar',
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonColor: '#3b83ae',
                    });
                }
            </script>

            <link href="{{ asset('assets/css/acordeon.css') }}" rel="stylesheet">
            <script src="{{ asset('assets/js/acordeon.js') }}"></script>

    @endpush

@endsection
