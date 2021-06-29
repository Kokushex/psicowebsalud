@extends('layouts.app')
@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Editar Usuario.') }}</h1>
                        <style>
                            .toast {
                                opacity: 1 !important;
                                box-shadow: 0 0 12px #000 !important;
                            }
                        </style>
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



    <div class="card shadow mb-4" style="margin-top:1rem">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary" style="text-align: left;">Datos del Usuario</h4>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}<br>

                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="mb-2">


                <form id="detalleUser"action="{{route('updatePa')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id_user"value="{{$usuario2->id_user}}">
                    <input type="hidden"name="id_per"value="{{$usuario2->id_per}}">
                    <input type="hidden"name="id_pac"value="{{$usuario2->id_pac}}">
                    <div class="form-group">
                        <label for="">Correo</label>
                        <input class="form-control" required maxlength="191" id="email" name="email" 
                            value="{{$usuario2->email}}" type="email">
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            @error('telefono')
                            <strong>{{$message}}</strong>
                            @enderror
                            <div class="form-group">
                                <label for="">Rut</label>
                                <input type="text" class="form-control" placeholder="ejemplo 12123456-2" required
                                       onkeypress="return soloNumerosRut(event)" id="rut" maxlength="20" name="rut"
                                       value="{{$usuario2->rut}}">
                            </div>
                            <!--Nombre-->
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" required maxlength="191" name="nombre"
                                       value="{{$usuario2->nombre}}" pattern="[a-zA-Z ]+">
                            </div>
                            <!--Apellido Paterno-->
                            <div class="form-group">
                                <label for="">Apellido Paterno</label>
                                <input type="text" class="form-control" required maxlength="191" name="apellido_paterno"
                                       value="{{$usuario2->apellido_p}}" pattern="[a-zA-Z]+">
                            </div>
                            <!--Apellido Materno-->
                            <div class="form-group">
                                <label for="">Apellido Materno</label>
                                <input type="text" class="form-control" maxlength="191" name="apellido_materno"
                                       value="{{$usuario2->apellido_m}}" required pattern="[a-zA-Z]+">
                            </div>
                            <!--Genero-->
                            <div class="form-group">
                                <label class="form-control-label" for="genero">{{ __('Genero') }}</label>
                                <select class="form-control select2 select2-hidden-accessible"
                                        name="genero" id="genero">
                                    <option value="">Seleccionar genero</option>
                                    <option value="M" {{($usuario2->genero == "M") ? 'selected' : ''}}>
                                        Masculino</option>
                                    <option value="F" {{($usuario2->genero =="F") ? 'selected' : ''}}>
                                        Femenino</option>
                                    <option value="O" {{($usuario2->genero =="O") ? 'selected' : ''}}>
                                        Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <!--Fecha Nacimiento-->
                            <div class="form-group ">
                                <label for="">Fecha Nacimiento</label>
                                <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento"  min="1930-04-01" max="2017-01-01"
                                       value="{{$usuario2->fecha_nac ? date('Y-m-d', strtotime($usuario2->fecha_nac)) : ''}}"
                                       placeholder="Fecha de nacimiento" required>
                            </div>
                            <!--Telefono-->
                            <div class="form-group">
                                <label for="">Telefono</label>
                                <input type="text" class="form-control" required onkeypress="return soloNumeros(event)"
                                       maxlength="30" name="telefono" value="{{$usuario2->fono}}"  pattern="[0-9]+">
                            </div>
                            <!--Direccion-->
                            <div class="form-group">
                                <label for="">Direccion</label>
                                <input type="text" class="form-control" maxlength="191" name="direccion"
                                       value="{{$usuario2->direccion}}">
                            </div>                         
                            <!--Region-->
                            <div class="form-group">
                                    <label class="form-control-label" for="regiones">{{ __('Region') }}</label>
                                    <select class="form-control select2 select2-hidden-accessible" name="region" id="regiones" >

                                    </select>
                            </div>
                            <!--Comuna-->
                            <div class="form-group">
                                    <label class="form-control-label" for="comunas">{{ __('Comuna') }}</label>
                                    <select class="form-control select2 select2-hidden-accessible"
                                            name="comuna" id="comunas">

                                    </select>
                            </div>
                        </div>
                    </div>
                    <!--Datos Paciente-->
                    <div class="form-group">
                        <label for="">Rol</label>
                        <input type="text" class="form-control" name="name" readonly value="{{$usuario2->nombre_rol}}">
                    </div>
                    <div class="form-group">
                        <div class="title"></div>
                        <h3>Datos Paciente</h3>
                    </div>
                    <div class="form-group">
                        <label for="">Estado Civil</label>
                        <input type="text" class="form-control" name="estado_civ"  value="{{$usuario2->estado_civ}}" required pattern="[a-zA-Z ]+">
                    </div>
                    <div class="form-group">
                        <label for="">Escolaridad</label>
                        <input type="text" class="form-control" name="escolar"  value="{{$usuario2->escolar}}" required pattern="[a-zA-Z ]+">
                    </div>
                    <div class="form-group">
                        <label for="">Profesion</label>
                        <input type="text" class="form-control" name="profesion"  value="{{$usuario2->ocupacion}}" required pattern="[a-zA-Z ]+">
                    </div>
                    <div class="form-group">
                        <label for="">Grupo Familiar</label>
                        <input type="text" class="form-control" name="grupo_fam"  value="{{$usuario2->grupo_fami}}">
                    </div>
                    <a href="{{route('ges_usuarios')}}" class="btn btn-sm btn-secondary">Volver</a>
                    <button id="update_user" type="submit" class="btn btn-primary float-right" value="Aceptar" style="background-color:#3C4BB7;">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
@push('js')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="{{asset('assets/js/roles/roles_funciones.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{asset('assets/js/perfil/RegionesYcomunas.js')}}"></script>


    <script>
        window.onload = ( () => {
            $('#regiones').val('{{$usuario2->region}}').change();
            $('#comunas').val('{{$usuario2->comuna}}').change();
        });
    </script>

@endpush

@endsection
