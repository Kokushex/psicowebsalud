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
