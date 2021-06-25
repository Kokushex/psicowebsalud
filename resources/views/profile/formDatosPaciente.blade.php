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
            <div class="text-center" id="div_confirmacion2">
                <button type="submit" class="btn btn-success mt-4" id="update_datos_comple">{{ __('Guardar Cambios') }}</button>
            </div>
        </div>
    </div>
</form>
