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


                <form id="detalleUser" action="{{route('updatePsi')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id_user"value="{{$usuario1->id_user}}">
                    <input type="hidden"name="id_per"value="{{$usuario1->id_per}}">
                    <input type="hidden"name="id_psi"value="{{$usuario1->id_psi}}">

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">

                            <div class="form-group">
                                <label for="">Correo</label>
                                <input class="form-control" required maxlength="191" id="email" name="email"
                                       value="{{$usuario1->email}}" type="email">

                            </div>
                            @error('telefono')
                            <strong>{{$message}}</strong>
                            @enderror
                            <div class="form-group">
                                <label for="">Rut</label>
                                <input type="text" class="form-control" placeholder="ejemplo 12123456-2" required
                                       onkeypress="return soloNumerosRut(event)" id="rut" maxlength="20" name="rut"
                                       value="{{$usuario1->rut}}">
                            </div>
                            <div class="form-group">
                                <label for="">Telefono</label>
                                <input type="text" class="form-control" required onkeypress="return soloNumeros(event)"
                                       maxlength="30" name="telefono" value="{{$usuario1->fono}}" pattern="[0-9]+">


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


                            <div class="form-group ">
                                <label for="">Fecha Nacimiento</label>
                                <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento"  min="1930-04-01" max="2017-01-01"
                                       value="{{$usuario1->fecha_nac ? date('Y-m-d', strtotime($usuario1->fecha_nac)) : ''}}"
                                       placeholder="Fecha de nacimiento" required>
                            </div>




                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" required maxlength="191" name="nombre"
                                       value="{{$usuario1->nombre}}" pattern="[a-zA-Z]+">
                            </div>
                            <div class="form-group">
                                <label for="">Apellido Paterno</label>
                                <input type="text" class="form-control" required maxlength="191" name="apellido_paterno"
                                       value="{{$usuario1->apellido_p}}"  pattern="[a-zA-Z]+">
                            </div>
                            <div class="form-group">
                                <label for="">Apellido Materno</label>
                                <input type="text" class="form-control" maxlength="191" name="apellido_materno"
                                       value="{{$usuario1->apellido_m}}" required pattern="[a-zA-Z]+">
                            </div>

                            <div class="form-group">
                                <label for="">Direccion</label>
                                <input type="text" class="form-control" maxlength="191" name="direccion"
                                       value="{{$usuario1->direccion}}" >
                            </div>

                            <!--Genero-->
                            <div class="form-group">
                                <label class="form-control-label" for="genero">{{ __('Genero') }}</label>
                                <select class="form-control select2 select2-hidden-accessible"
                                        name="genero" id="genero">
                                    <option value="">Seleccionar genero</option>
                                    <option value="M" {{($usuario1->genero == "M") ? 'selected' : ''}}>
                                        Masculino</option>
                                    <option value="F" {{($usuario1->genero =="F") ? 'selected' : ''}}>
                                        Femenino</option>
                                    <option value="O" {{($usuario1->genero =="O") ? 'selected' : ''}}>
                                        Otro</option>
                                </select>

                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Rol</label>
                        <input type="text" class="form-control" name="name" readonly value="{{$usuario1->nombre_rol}}">
                    </div>




                    <div class="form-group">

                        <div class="title"></div>
                        <h3>Datos Psicologo</h3>
                    </div>




                    <div class="form-group">
                        <label for="">Grado</label>
                        <input type="text" class="form-control" name="grado"  value="{{$usuario1->grado}}">
                    </div>

                    <div class="form-group">
                        <label for="">Casa academica</label>
                        <input type="text" class="form-control" name="casa_aca"  value="{{$usuario1->casa_academica}}">
                    </div>

                    <div class="form-group">
                        <label for="">Especialidad </label>
                        <input type="text" class="form-control" name="especial"  value="{{$usuario1->especialidad}}">
                    </div>
                    <a href="{{route('ges_usuarios')}}" class="btn btn-sm btn-secondary">Volver</a>
                    <button id="update_user" type="submit" class="btn btn-primary float-right" value="Aceptar" style="background-color:#3C4BB7;">Guardar Cambios</button>


                </form>
            </div>
        </div>
    </div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="{{asset('assets/js/roles/roles_funciones.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{asset('assets/js/perfil/RegionesYcomunas.js')}}"></script>

    <script>
        window.onload = ( () => {
            $('#regiones').val('{{$usuario1->region}}').change();
            $('#comunas').val('{{$usuario1->comuna}}').change();
        });
    </script>

@endpush

@endsection
