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
                                    <div class="tab-content">
                                        <div class="tab-pane" id="d_personal">
                                        <!--FORMULARIO DATOS-->
                                            <hr class="my-4" />
                                            <form method="post" action="{{ route('perfilUpdate')  }}" id="form_datos_personales">
                                                <!--@method('put')-->
                                                @csrf

                                                <h6 class="heading-small text-muted mb-4">{{ __('Información de usuario') }}</h6>

                                                <div class="pl-lg-4">
                                                <!--RUN-->
                                                    <div class="form-group">
                                                        <label for="run" class="col-sm-3 col-form-label">Run</label>
                                                        <input type="text" class="form-control" id="run" name="run"
                                                              placeholder="Ingrese RUN" value="{{auth()->user()->persona->run}}"
                                                               onKeyPress=" return soloNumerosRut(event)" onBlur="onRunBlur(this)"
                                                            {{(auth()->user()->persona->run !='') ? 'disabled' : ''}}>

                                                        <div id="alertErrorRun"></div>
                                                    </div>

                                                    <!--Nombre-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nombre">{{ __('Nombre') }}</label>
                                                        <input type="text" name="nombre" id="nombre" class="form-control "
                                                        placeholder="{{ __('Nombre') }}" value="{{auth()->user()->persona->nombre}}" required autofocus>

                                                    </div>

                                                    <!--Apellido Paterno-->
                                                    <div class="row" >
                                                        <div class="form-group{{ $errors->has('ape_paterno') ? ' has-danger' : '' }} col-6">
                                                            <label class="form-control-label" for="apellido_paterno">{{ __('Apellido Paterno') }}</label>
                                                            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control form-control-alternative{{ $errors->has('ape_paterno') ? ' is-invalid' : '' }}" placeholder="{{ __('Apellido Paterno') }}" value="{{auth()->user()->persona->apellido_paterno }}" required>

                                                            @if ($errors->has('ape_paterno'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('ape_paterno') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--Apellido Materno-->
                                                        <div class="form-group col-6" >
                                                            <label class="form-control-label" for="apellido_materno">{{ __('Apellido Materno') }}</label>
                                                            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control form-control-alternative{{ $errors->has('ape_materno') ? ' is-invalid' : '' }}" placeholder="{{ __('Apellido Materno') }}" value="{{ auth()->user()->persona->apellido_materno }}" required>

                                                            @if ($errors->has('ape_paterno'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('ape_paterno') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!--Genero-->
                                                        <div class="form-group col-6">
                                                            <label class="form-control-label" for="genero">{{ __('Genero') }}</label>
                                                            <select class="form-control select2 select2-hidden-accessible"
                                                                    name="genero" id="genero">
                                                                <option value="">Seleccionar genero</option>
                                                                <option value="M" {{(Auth::User()->persona->genero == "M") ? 'selected' : ''}}>
                                                                    Masculino</option>
                                                                <option value="F" {{(Auth::User()->persona->genero =="F") ? 'selected' : ''}}>
                                                                    Femenino</option>
                                                                <option value="O" {{(Auth::User()->persona->genero =="O") ? 'selected' : ''}}>
                                                                    Otro</option>
                                                            </select>

                                                        </div>
                                                        <!--Fecha Nacimiento-->
                                                        <div class="form-group col-6">
                                                            <label class="form-control-label" for="fecha_nacimiento">{{ __('Fecha Nacimiento') }}</label>
                                                            <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento"  min="1930-04-01" max="2017-01-01"
                                                                            value="{{auth()->user()->persona->fecha_nacimiento ? date('Y-m-d', strtotime(auth()->user()->persona->fecha_nacimiento)) : ''}}"
                                                                            placeholder="Fecha de nacimiento" required>
                                                        </div>
                                                     </div>
                                                    <div class="row">
                                                        <!--Telefono-->
                                                        <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} col-6">
                                                            <label class="form-control-label" for="telefono">{{ __('Telefono') }}</label>
                                                            <input type="text" name="telefono" id="telefono"
                                                            class="form-control form-control-alternative{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="{{ __('telefono') }}" value="{{ auth()->user()->persona->telefono }}" required>

                                                            @if ($errors->has('telefono'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('telefono') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <!--Direccion-->
                                                        <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }} col-6">
                                                            <label class="form-control-label" for="direccion">{{ __('Direccion') }}</label>
                                                            <input type="text" name="direccion" id="direccion"
                                                            class="form-control form-control-alternative{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="{{ __('Direccion') }}" value="{{ auth()->user()->persona->direccion }}" required>

                                                            @if ($errors->has('direccion'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('direccion') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <!--Region-->
                                                        <div class="form-group col-6">
                                                            <label class="form-control-label" for="regiones">{{ __('Region') }}</label>
                                                            <select class="form-control select2 select2-hidden-accessible" name="region" id="regiones" >

                                                            </select>
                                                        </div>
                                                        <!--Comuna-->
                                                        <div class="form-group col-6">
                                                            <label class="form-control-label" for="comunas">{{ __('Comuna') }}</label>
                                                                            <select class="form-control select2 select2-hidden-accessible"
                                                                                name="comuna" id="comunas">

                                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- LOGICA PARA MOSTRAR LOS BOTONES O MENSAJE DE ESTADO -->
                                                    <div id="div_confirmacion1">
                                                        @if(auth()->user()->persona->run != '')
                                                            @if($rol == 2)
                                                                @if(isset(auth()->user()->persona->psicologo->verificado))
                                                                    @if(auth()->user()->persona->psicologo->verificado =='EN ESPERA')
                                                                         <div class="col-md-12 alert alert-secondary alert-warning"
                                                                            id="esperandoVerificacion" role="alert"><b>Solicitud en espera de revisión.</b>
                                                                         </div>
                                                                    @else
                                                                        <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Registrar Datos 1') }}</button>
                                                                    @endif

                                                                @else
                                                                    <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Guardar Cambios 2') }}</button>
                                                                @endif
                                                            @else
                                                                    <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Guardar Cambios 3') }}</button>

                                                            @endif
                                                        @else

                                                            <button type="submit" class="btn btn-success mt-4" id="registrarDatos"> {{ __('Registrar Datos 4') }}</button>

                                                        @endif
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <!--FIN FORMULARIO DATOS PERSONALES-->

                                        <div class="active tab-pane" id="c_contraseña">

                                            <!--Formulario Contraseña-->

                                                    <hr class="my-4" />
                                                    <form method="post" id="form" action="{{ route('perfilActualizarPass') }}" autocomplete="off" class="form-horizontal">
                                                        @method('put')
                                                        @csrf
                                                        <h6 class="heading-small text-muted mb-4">{{ __('Contraseña') }}</h6>

                                                        @if (session('password_status'))
                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                {{ session('password_status') }}
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        <div class="pl-lg-4">
                                                        <!--Email-->
                                                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                                <label class="form-control-label" for="email">{{ __('Correo') }}</label>
                                                                <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required readonly>

                                                            </div>


                                                            <div class="form-group">
                                                                <label class="form-control-label" >{{ __('Contraseña Actual') }}</label>
                                                                <div class="input-group" id="show_hide_password">
                                                                    <input type="password" name="contraseña_act" id="contraseña_act" class="form-control" placeholder="{{ __('Contraseña Actual') }}" >
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><a href="">
                                                                                    <i class="fa fa-eye-slash"></i></a>
                                                                            </span>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="password" >{{ __('Nueva Contraseña') }}</label>
                                                                <div class="input-group" id="show_hide_password">
                                                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Nueva Contraseña') }}">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><a href="">
                                                                                    <i class="fa fa-eye-slash"></i></a>
                                                                            </span>
                                                                        </div>
                                                                </div>
                                                                <!--Alerta-->
                                                                <div class="invalid-feedback offset-sm-3 col-sm-8" role="alert" id="divPasswordConfir">
                                                                    Las contraseñas no coinciden.
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-control-label" for="password_confirmation" >{{ __('Confirmar nueva contraseña') }}</label>
                                                                <div class="input-group" id="show_hide_password">
                                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmar Nueva Contraseña') }}" >
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><a href="">
                                                                                    <i class="fa fa-eye-slash"></i></a>
                                                                            </span>
                                                                        </div>
                                                                </div>
                                                                    <!--Alerta-->
                                                                <div class="invalid-feedback offset-sm-3 col-sm-8" role="alert" id="divPasswordConfir2">
                                                                                Las contraseñas no coinciden.
                                                                </div>
                                                            </div>



                                                            <div class="text-center">
                                                                <button type="submit" id="update_password" class="btn btn-success mt-4">{{ __('Cambiar contraseña') }}</button>
                                                            </div>
                                                            <div id="showErrores"></div>
                                                        </div>
                                                    </form>
                                        </div>
                                        <!--FIN FORMULARIO CONTRASEÑA-->
                                    @switch($rol)
                                        @case(2)
                                        <!--FORMULARIO Psicologo -->
                                        <div class=" tab-pane" id="form_datos_complementarios">
                                            <hr class="my-4" />
                                            <form method="post" action="{{route('perfilUpdatePsicologo')}}" id="form_datos_complementarios">
                                                @csrf
                                                <h6 class="heading-small text-muted mb-4">{{ __('Información Adicional') }}</h6>
                                                <div class="pl-lg-4">
                                                    <!--Titulo-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="titulo">{{ __('Titulo') }}</label>
                                                        <input type="text" name="titulo" id="titulo" class="form-control " placeholder="{{ __('Titulo') }}" value="{{auth()->user()->persona->psicologo->titulo }}" required>
                                                    </div>
                                                    <!--Especialidad-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="especialidad">{{ __('Especialidad') }}</label>
                                                        <input type="text" name="especialidad" id="especialidad" class="form-control " placeholder="{{ __('Especialidad') }}" value="{{auth()->user()->persona->psicologo->especialidad }}" required>
                                                    </div>

                                                    <!--Casa Academica-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="casa_academica">{{ __('Casa Academica') }}</label>
                                                        <input type="text" name="casa_academica" id="casa_academica" class="form-control " placeholder="{{ __('Casa Academica') }}" value="{{auth()->user()->persona->psicologo->casa_academica }}" required>
                                                    </div>
                                                    <!--Grado Academico-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="grado_academico">{{ __('Grado Academico') }}</label>
                                                        <input type="text" name="grado_academico" id="grado_academico" class="form-control " placeholder="{{ __('Grado Academico') }}" value="{{auth()->user()->persona->psicologo->grado_academico }}" required>
                                                    </div>
                                                    <!--Fecha Egreso-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="fecha_egreso">{{ __('Fecha Egreso') }}</label>
                                                        <input class="form-control" type="date" name="fecha_egreso" id="fecha_egreso"
                                                               min="1930-04-01" max="2021-04-30"

                                                               value="{{auth()->user()->persona->psicologo->fecha_egreso ? date('Y-m-d', strtotime(auth()->user()->persona->psicologo->fecha_egreso)) : ''}}"
                                                               placeholder="Fecha Egreso" required>
                                                    </div>
                                                    <!--Experiencia-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="experiencia">{{ __('Experiencia') }}</label>
                                                        <input type="text" name="experiencia" id="experiencia" class="form-control " placeholder="{{ __('Experiencia') }}" value="{{auth()->user()->persona->psicologo->experiencia}}" required>
                                                    </div>
                                                    <!--Descripcion-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="descripcion">{{ __('Descripcion') }}</label>
                                                        <textarea type="text" name="descripcion" id="descripcion" class="form-control " placeholder="{{ __('Descripcion') }}" value="{{auth()->user()->persona->psicologo->descripcion}}" required></textarea>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="offset-sm-3 col-sm-8" id="div_confirmacion2">
                                                            <button type="submit" class="btn btn-success mt-4" id="update_datos_comple">{{ __('Guardar Cambios') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @break
                                        @case(1)
                                        <!--FORMULARIO Paciente -->
                                        <div class=" tab-pane" id="d_otros">
                                            <hr class="my-4" />
                                            <form method="post" action="{{route('perfilUpdatePaciente')}}" id="form_datos_complementarios">
                                                @csrf
                                                <h6 class="heading-small text-muted mb-4">{{ __('Información Adicional') }}</h6>
                                                <div class="pl-lg-4">
                                                    <!--Escolaridad-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="escolaridad">{{ __('Escolaridad') }}</label>
                                                        <input type="text" name="escolaridad" id="escolaridad" class="form-control " placeholder="{{ __('Escolaridad') }}" value="{{auth()->user()->persona->paciente->escolaridad}}" required>
                                                    </div>
                                                    <!--Ocupacion-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="ocupacion">{{ __('Ocupacion') }}</label>
                                                        <input type="text" name="ocupacion" id="ocupacion" class="form-control " placeholder="{{ __('Ocupacion') }}" value="{{auth()->user()->persona->paciente->ocupacion}}" required>
                                                    </div>

                                                    <!--Estado Civil-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="estado_civil">{{ __('Estado Civil') }}</label>
                                                        <input type="text" name="estado_civil" id="estado_civil" class="form-control " placeholder="{{ __('Estado Civil') }}" value="{{auth()->user()->persona->paciente->estado_civil}}" required>
                                                    </div>
                                                    <!--Grupo familiar-->
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="grupo_familiar">{{ __('Grupo familiar') }}</label>
                                                        <input type="text" name="grupo_familiar" id="grupo_familiar" class="form-control " placeholder="{{ __('Grupo familiar') }}" value="{{auth()->user()->persona->paciente->grupo_familiar}}" required>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="offset-sm-3 col-sm-8" id="div_confirmacion2">
                                                            <button type="submit" class="btn btn-success mt-4" id="update_datos_comple">{{ __('Guardar Cambios') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
        @include('layouts.footers.auth')

    </div>

    <!--Scripts: NOTA EL ORDEN LES AFECTA, si jquery esta abajo del script a funcionar los otros no funcionaran-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/inputmask/inputmask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

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

@endsection

