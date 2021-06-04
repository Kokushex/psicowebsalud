<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/white.png" style="width: 50%"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navbar items -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('reserva.list') }}">
                        <i class="ni ni-planet"></i>
                        <span class="nav-link-inner--text">{{ __('Reserva') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('rol_register') }}"> <!--register-->
                        <i class="ni ni-circle-08"></i>
                        <span class="nav-link-inner--text">{{ __('Registro') }}</span>
                    </a>
                </li>
                <!-- Iniciar Sesión navbar
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('login') }}">
                        <i class="ni ni-key-25"></i>
                        <span class="nav-link-inner--text">{{ __('Iniciar Sesión') }}</span>
                    </a>
                </li> -->
                <li class="nav-item dropdown" >
                        <a class="nav-link dropdown-toggle nav-link-icon btn btn-light" href="#" data-toggle="dropdown"
                            style="border-radius: 100px; border: 1px solid rgb(226, 224, 224); background-color:#825ee4">
                            <i class="ni ni-key-25"></i>
                            <span class="nav-link-inner--text" >{{ __('Iniciar Sesión') }}</span>
                        </a>
                        <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
                            <!-- opciones dropdown-->
                            <li>
                                <a class="dropdown-item text-sm-lg" href="{{ route('login_paciente') }}">
                                <i class="fas fa-user fa-lg " style="padding-right: 5%"></i>Paciente</a>
                            </li>
                            <li class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-sm-lg" href="{{ route('login_psicologo') }}">
                                    <i class="fas fa-portrait fa-lg" style="padding-right: 4%"></i>Psicólogo</a>
                                </li>
                            <li class="dropdown-divider"></li>
                            <!-- End dropdown -->
                        </ul>
                    </li>
            </ul>
        </div>
    </div>
</nav>
