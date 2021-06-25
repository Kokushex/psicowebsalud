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
        <!--Descripcion-->
        <div class="form-group">
            <label class="form-control-label" for="descripcion">{{ __('Descripcion') }}</label>
            <textarea type="text" name="descripcion" id="descripcion" class="form-control " placeholder="{{ __('Descripcion') }}" value="{{auth()->user()->persona->psicologo->descripcion}}" required></textarea>
        </div>
        <div class="text-center">
            <div class="text-center" id="div_confirmacion2">
                <button type="submit" class="btn btn-success mt-4" id="update_datos_comple">{{ __('Guardar Cambios') }}</button>
            </div>
        </div>
    </div>
</form>
