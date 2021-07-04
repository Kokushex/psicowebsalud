@php
    $user=session()->get('user');
    $rol=session()->get('rol');
@endphp
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Bienvenido') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mi perfil') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Cerrar Sesión') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <ul class="navbar-nav">

                <!--Titulo de sidebar-->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Inicio') }}
                    </a>
                </li>
                <!--Administracion usuario-->
                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-adm_usuario" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-adm_usuario">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Administracion usuario') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-adm_usuario">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    {{ __('Perfil de usuario') }}
                                </a>
                            </li>

                            
                            <!--tabla administrador-->
                            <!--
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    {{ __('User Management') }}
                                </a>
                            </li>
                            -->

                        </ul>
                    </div>
                </li>


                    <!--Area de trabajo-->
                 <li class="nav-item">
                    <a class="nav-link active" href="#navbar-area_trabajo" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-area_trabajo">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Area de trabajo') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-area_trabajo">
                        <ul class="nav nav-sm flex-column">

                            @if($rol==1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reserva.list') }}">
                                    <i class="ni ni-book-bookmark text-blue"></i> {{ __('Reserva') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reserva.listar') }}">
                                    <i class="ni ni-book-bookmark text-blue"></i> {{ __('Lista de Reservas') }}
                                </a>
                            </li>
                            @endif

                            @if($rol==2)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('horario') }}">
                                    <i class="ni ni-watch-time text-blue"></i> {{ __('Horario') }}
                                </a>
                            </li>                    
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('servicio') }}">
                                     <i class="ni ni-bullet-list-67 text-blue"></i> {{ __('Servicios') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reserva.listarReservasPsicologos') }}">
                                    <i class="ni ni-book-bookmark text-blue"></i> {{ __('Lista de Reservas Psicologo') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agenda') }}">
                                    <i class="ni ni-calendar-grid-58 text-blue"></i> {{ __('Agenda') }}
                                </a>
                            </li>
                            @endif

                            
                            @if($rol==3) 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ges_usuarios') }}">
                                    <i class="ni ni-key-25 text-blue"></i> {{ __('Usuarios') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('solicitudes') }}">
                                    <i class="ni ni-key-25 text-blue"></i> {{ __('Solicitudes Psicologos') }}
                                </a>
                            </li>
                            @endif
                            

                        </ul>
                    </div>
                </li>
</nav>
