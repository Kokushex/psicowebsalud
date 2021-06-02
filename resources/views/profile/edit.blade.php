@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hola') . ' '. auth()->user()->persona->nombre,
        'description' => __('Este es tu perfil. Aqui puede editar tu información personal'),
        'class' => 'col-lg-7'
    ])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/css/inputmask.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    @php
    $user=session()->get('user');
    $rol=session()->get('rol');
    @endphp

    <style>
        .toast {
            opacity: 1 !important;
            box-shadow: 0 0 12px #000 !important;
        }
    </style>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-info mr-4">{{ __('Reserva') }}</a>
                            <a href="#" class="btn btn-sm btn-default float-right">{{ __('Principal') }}</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    <div>
                                        <span class="heading" value="{{auth()->user()->persona->nombre}}">{{auth()->user()->persona->nombre}} {{auth()->user()->persona->apellido_paterno}}</span>
                                        <span class="description">{{auth()->user()->email}}</span>
                                        <br>
                                        @if($rol == 2)
                                            <span class="description">{{auth()->user()->persona->psicologo->verificado}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br>
            <!--PERFIL-->
            <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item mt-2"><a class="nav-link active" href="#c_contraseña" data-toggle="tab">Cambiar contraseña</a></li>
                                        <li class="nav-item mt-2"><a class="nav-link" href="#d_personal" data-toggle="tab">Datos personales</a></li>
                                        @if($rol==2)
                                            <li class="nav-item mt-2"><a class="nav-link" href="#d_otros_psicologo" data-toggle="tab">Datos profesionales</a></li>
                                        @elseif($rol==1)
                                            <li class="nav-item mt-2"><a class="nav-link" href="#d_otros" data-toggle="tab">Datos Adicionales</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div>
                                    @if($rol == 2)
                                        <!--Comprobacion de verificacion de psicologo-->
                                            @if($user->verificado=='EN ESPERA')
                                                <div class="alert alert-warning text-center" id="mensajeInformativo">
                                                    <b id="msgPsicologo">Solicitud en espera de revisión.</b>
                                                </div>
                                                <div class="alert alert-warning" id="mensajeInformativo">
                                                    {{ __('Debe completar sus datos para poder acceder a todas las funcionalidades que ofrecemos,') }}
                                                    <b id="msgPsicologo">{{__('previo a espera de la confirmación por nuestra parte de sus datos profesionales.')}}
                                                    </b>
                                                </div>
                                            @endif
                                    @else
                                        <!-- Se usa isset para verificar campo vacio-->
                                            @if(isset($user->persona->run))
                                                <div class="alert alert-warning" id="mensajeInformativo">
                                                    {{ __('Al completar sus datos podrá acceder a todas las funcionalidades que ofrecemos,') }}
                                                    @if($rol == 1)
                                                        <b id="msgPsicologo">{{__('previo a espera de la confirmación de sus datos personales.')}}</b>
                                                    @endif
                                                </div>
                                            @endif
                                    @endif
                                </div>
                            </div>
                            <!--FIND DEL CARD HEADER-->
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <h3 class="mb-0">{{ __('Editar Perfil') }}</h3>
                                    </div>
                                    @include('profile.tabsPerfil')
                                </div>
                            </div>
                    </div>
            </div>
        </div>
        @include('layouts.footers.auth')

    </div>

    <!--Scripts: NOTA EL ORDEN LES AFECTA, si jquery esta abajo del script a funcionar los otros no funcionaran-->
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/inputmask/inputmask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{asset('assets/js/perfil/perfil2.js')}}"></script>
    <script src="{{asset('assets/js/perfil/RegionesYcomunas.js')}}"></script>
    <script src="{{asset('assets/js/perfil/validaciones.js')}}"></script>

    <script>
        window.onload = ( () => {
            $('#regiones').val('{{Auth::User()->persona->region}}').change();
            $('#comunas').val('{{Auth::User()->persona->comuna}}').change();
            @if($rol == 2)
                $('#descripcion').val('{{Auth::User()->persona->psicologo->descripcion}}').change();
            @endif
        });
    </script>
    @endpush

@endsection

