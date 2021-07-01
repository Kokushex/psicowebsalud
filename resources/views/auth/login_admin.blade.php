
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Psicoweb Salud | Administrador</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="{{asset('assets/css/perfil/all.min.css')}}" rel="stylesheet">
    <!-- icheck bootstrap -->
    <!-- Theme style -->
    <link href="{{asset('assets/css/perfil/adminlte.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/perfil_dashboard/plugins/fontawesome-free/css/all.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<style>
    .login-page {
        height: 100vh;
        width: 100%;
        background-color: #07065C !important;
    }

</style>

<body class="hold-transition login-page">



<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="">
        <a class="navbar-brand d-flex justify-content-center" href="{{ url('/') }}">
            <img src="{{asset('argon/img/brand/blue.png')}}" height="70px" />
        </a>
        <div class="card-header text-center">
            <a href="{{ url('/') }}" class="h1"><b></b></a>
        </div>
        <div class="card-body">
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
                    toastr["error"]('{{ session('
                    status ') }}', "Advertencia")
                </script>


            @endif
            <p class="login-box-msg">Ingresa con tus credenciales</p>
            @php $tipo=3 @endphp
            <form class="needs-validation" method="POST" action="{{ route('logear', $tipo) }}">
                @csrf
                <div class="input-group mb-3">
                    <input name="email" class="form-control" placeholder="Correo" autocomplete="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <p class="text-4">{{$message}}</p>
                    <span class="invalid-feedback" role="alert">
                            {{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @if (Cookie::get('access_error')>=5)
                    <div class="form-group row pl-4 pr-4 mb-5">
                        <div class="captcha col-md-12 ">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                &#x21bb;
                            </button>
                        </div>
                    </div>

                    <div class="form-group row pl-4 pr-4 mb-5">
                        <input id="captcha" type="text" class="pt-2 pb-2 text-4 form-control"
                               placeholder="Enter Captcha" name="captcha">
                    </div>
                    @error('captcha')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                @endif
                <div class="row">
                    <div class="col-7">
                    </div>
                    <!-- /.col -->
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->


        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/js/perfil_dashboard/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/js/perfil_dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/perfil_dashboard/js/adminlte.js')}}"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>

</html>
