@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
                  

    <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-4 text-center">
                            <h3 class="box-title mt-4 mb-0">ADMINISTRADOR</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Registrate con tus credenciales') }}</small>
                        </div>
                        @if (session('status'))
                                <div class="alert alert-danger" role="alert">
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
                                </div>
                            @endif
                                <form role="form" class="form-horizontal mt-3 form-material needs-validation" method="post"
                                    action="{{ route('createAdmin') }}" id="formulario">
                        
                            @csrf
                           
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <!--Correo-->
                                    <input class="form-control" placeholder="Correo" name="email" id="email"
                                        onBlur="valCorreo(this.value);" onpaste="return false" @error('email') is-invalid
                                        @enderror name="email" value="{{ old('email') }}">


                                    @error('email')

                                        <script>
                                            toastr.options = {
                                                "closeButton": true,
                                                "debug": false,
                                                "newestOnTop": true,
                                                "progressBar": true,
                                                "positionClass": "toast-top-center",
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
                                            toastr["error"]("{{ $message }}", "Advertencia")

                                        </script>
                                    @enderror
                            </div>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>

                                    <input class="form-control" type="password" placeholder="Contraseña" name="password"
                                        id="password">
                                </div>
                                @error('password')
                                    <script>
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "newestOnTop": true,
                                            "progressBar": true,
                                            "positionClass": "toast-top-center",
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
                                        toastr["error"]("{{ $message }}", "Advertencia")

                                    </script>
                                @enderror        
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                        <div>
                                            <input class="form-control" type="password" placeholder="Confirmar Contraseña"
                                                name="password_confirmation" id="password_confirmation">
                                        </div>
                                        @error('password_confirmation')
                                            <script>
                                                toastr.options = {
                                                    "closeButton": true,
                                                    "debug": false,
                                                    "newestOnTop": true,
                                                    "progressBar": true,
                                                    "positionClass": "toast-top-center",
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
                                                toastr["error"]("{{ $message }}", "Advertencia")

                                            </script>
                                        @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('Crear cuenta') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
