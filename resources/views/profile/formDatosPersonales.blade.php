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
                @if($rol == 2)
                    <label class="form-control-label" for="direccion">{{ __('Direccion de atención') }}</label>
                    <input type="text" name="direccion" id="direccion"
                        class="form-control form-control-alternative{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="{{ __('Direccion') }}" value="{{ auth()->user()->persona->direccion }}" required>

                    @if ($errors->has('direccion'))
                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('direccion') }}</strong>
                                                                    </span>
                    @endif
                @else
                    <label class="form-control-label" for="direccion">{{ __('Direccion') }}</label>
                    <input type="text" name="direccion" id="direccion"
                        class="form-control form-control-alternative{{ $errors->has('direccion') ? ' is-invalid' : '' }}" placeholder="{{ __('Direccion') }}" value="{{ auth()->user()->persona->direccion }}" required>

                    @if ($errors->has('direccion'))
                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('direccion') }}</strong>
                                                                    </span>
                    @endif    
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
        <div class="text-center" id="div_confirmacion1">
            @if(auth()->user()->persona->run != '')
                @if($rol == 2)
                    @if(isset(auth()->user()->persona->psicologo->verificado))
                        @if(auth()->user()->persona->psicologo->verificado =='EN ESPERA')
                            <div class="col-md-12 alert alert-secondary alert-warning"
                                 id="esperandoVerificacion" role="alert"><b>Solicitud en espera de revisión.</b>
                            </div>
                        @else
                            <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Guardar Cambios') }}</button>
                        @endif
                    @else
                        <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Registrar Datos') }}</button>
                    @endif
                @else
                    <button type="submit" class="btn btn-success mt-4" id="update_datosP"> {{ __('Guardar Cambios') }}</button>
                @endif
            @else
                <button type="submit" class="btn btn-success mt-4" id="registrarDatos"> {{ __('Registrar Datos') }}</button>
            @endif
        </div>
    </div>
</form>
