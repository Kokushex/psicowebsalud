@extends('layouts.app')
@section('content')
<div class="header bg-gradient-primary py-7 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Administrador de Usuarios.') }}</h1>
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

<!--codigo-->
    <style>
        body {
            background-color: #ECEEFA !important;
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Gestión de Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="container-fluid mt-2">
        <div class="card shadow mb-12">
            <div class="card-header">
                <h3 class="card-title">Solicitudes de Gestión de usuarios</h3>
            </div>
            <div class="card shadow mb-12">

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @elseif (session()->has('danger'))
                    <div class="alert alert-danger">
                        {{session()->get('danger')}}
                    </div>
                @endif
                <div class="card-body">
                    <table id="lista_usuarios" class="table table-striped table-bordered " style="width:100%">
                        <thead>
                        <tr class="tabla_datos_solicitados">
                            <th>#</th>
                            <th>Correo</th>
                            <th>Rut</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach ($usuario2 as $fila)
                            <tr class="text-lg-center">
                                <td>{{ $fila->id_user_rol }}</td>
                                <td>{{ $fila->email }}</td>
                                <td>{{ $fila->rut }}</td>
                                <td>{{ $fila->nombre }} {{ $fila->apellido_p }} {{ $fila->apellido_m }}</td>
                                <td>{{ $fila->fono }}</td>
                                <td>{{ $fila->nombre_rol }}</td>
                                <td>
                                    @if ($fila->estado == 1)
                                        <i class="fas fa-circle text-red"></i>
                                    @else
                                        <i class="fas fa-circle text-green"></i>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary" href="{{ route('detalle.gestion', $fila->id_user_rol) }}" data-toggle="tooltip"
                                           data-placement="bottom" title="Editar Datos">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <!-- envia la id del usuario mostrado en la tabla y lo envia a updateRol.blade.php-->
                                        {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEditRol"
                                        data-idRol="{{ $fila->id_user_rol }}" data-idRolActual="{{ $fila->id_rol }}" data-idUser="{{ $fila->user_id }}" data-idPersona="{{ $fila->id_persona }}">
                                            <i class="fas fa-users-cog" data-toggle="tooltip" data-placement="bottom" title="Cambiar Rol"></i>
                                        </button> --}}
                                        <a href="{{ route('mandaId', $fila->id_user_rol) }}" class="btn btn-warning cambiarRol" data-toggle="tooltip"
                                           data-placement="bottom" title="Editar Rol">
                                            <i class="fas fa-users-cog"></i>
                                        </a>
                                        <!-- botnes de ban y unban que envian el id del usuario por la ruta -->
                                        @if ($fila->estado == 1)
                                            <form action="{{ route('unban', $fila->user_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success" onclick="return confirm('¿Estas seguro de permitir el ingreso de este usuario al sistema?')">
                                                    <i class="fas fa-user-check" data-toggle="tooltip" data-placement="bottom" title="Desbanear Usuario"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('ban', $fila->user_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estas seguro de prohibir el ingreso de este usuario al sistema?')">
                                                    <i class="fas fa-user-lock" data-toggle="tooltip" data-placement="bottom" title="Banear Usuario"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@push('js')

    <!--Sesion script -->
    <script src="{{ asset('assets/js/roles/roles_mantenedor.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#lista_usuarios').DataTable({

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@endpush





    @include('layouts.footers.auth')
@endsection
