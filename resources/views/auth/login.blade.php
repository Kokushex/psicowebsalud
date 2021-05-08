@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-5">
                        @if (Route::currentRouteName() == 'login_paciente')
                            <h3 class="box-title mt-5 mb-0 text-center">Iniciar sesión Paciente</h3>
                            <div class="text-muted text-center mt-2 mb-3"><small>{{ __('Iniciar sesión con') }}</small></div>
                            <div class="btn-wrapper text-center">
                                <a href="#" class="btn btn-neutral btn-icon">
                                    <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/facebook.svg"></span>
                                    <span class="btn-inner--text">{{ __('Facebook') }}</span>
                                </a>
                                <a href="#" class="btn btn-neutral btn-icon">
                                    <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/google.svg"></span>
                                    <span class="btn-inner--text">{{ __('Google') }}</span>
                                </a>
                            </div>
                        @else
                            <h3 class="box-title  mt-5 mb-0 text-center">Iniciar sesión Psicólogo</h3>
                            <!-- @include('auth.register_confirmacion') -->
                        @endif
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>
                                    Crea una nueva cuenta o inicia sesión con tus credenciales:
                                    <br>
                                    Correo: <strong>correo@email.com</strong> Contraseña: <strong>secret</strong>
                            </small>
                        </div>
                        @if (session('status'))

                            <script>

                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                                    toastr["error"]('{{ session('status') }}', "Advertencia")
                            </script>


                        @endif
                        <form class="needs-validation" method="POST" action="{{ route('logear', $tipo) }}">
                            @csrf

                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Correo') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                                </div>
                                @error('email')
                                            <span class="invalid-feedback" role="alert">
                                               {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" type="password" value="secret" required>
                                </div>
                                @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                            </span>
                                @enderror
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">{{ __('Recordarme') }}</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Iniciar sesión') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.update'))
                            <a href="{{ route('password.update') }}" class="text-light">
                                <small>{{ __('¿Olvido su contraseña?') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('rol_register') }}" class="text-light">
                            <small>{{ __('Crear una cuenta nueva') }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
