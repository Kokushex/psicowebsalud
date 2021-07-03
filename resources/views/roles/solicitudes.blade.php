@extends('layouts.app')
@section('content')

    <div class="header bg-gradient-primary py-7 py-lg-6">
        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Solicitudes.') }}</h1>
                        <style>
                            .toast {
                                opacity: 1 !important;
                                box-shadow: 0 0 12px #000 !important;
                            }
                        </style>
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

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Solicitudes de Registros</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Solicitudes</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid mt-5 containerregistros">

        <div class="card shadow mb-12">
            <div class="card-header container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="card-title">Solicitudes de registro de usuarios</h3>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-success text-white float-sm-right" href="https://rnpi.superdesalud.gob.cl/" target="_blank">Superintendencia de Salud<em class="fas fa-arrow-right"></em></a>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-12">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <div class="card-body">
                    <table id="lista_usuarios" class="table table-striped table-bordered align-content-lg-center"
                           style="width:100%">
                        <thead>
                        <tr class="tabla_datos_solicitados">
                            <th>ID</th>
                            <th>Email</th>
                            <th>Rut</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th>Estado</th>
                            <th>Cambiar estado</th>
                            <th>Cambiar estado2</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($solicitud as $fila)
                            <tr class="text-lg-center">
                                <td>{{ $fila->id_psi }}</td>
                                <td>{{ $fila->email }}</td>
                                <td>{{ $fila->rut }}</td>
                                <td>{{ $fila->nombre }} {{ $fila->apellido_p }} {{ $fila->apellido_m }}</td>
                                <td>{{ $fila->fono }}</td>
                                <td>{{ $fila->verificacion }}</td>
                                <td><a class="btn btn-success" href="{{ route('estado', $fila->id_psi) }}"><i
                                            class="fas fa-edit"></i></a></td>
                                <td><a class="btn btn-success" type="submit" class="btnVerificado" onclick="fn_validar();">This shit<i
                                            class="fas fa-edit"></i></a></td>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>        

    <script>
        $(document).ready(function() {
            $('#lista_usuarios').DataTable({
                "scrollX": true,

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });


        });

    </script>

    <!--Solicitud-->
    <script src="{{asset('assets/js/solicitudes/psiSolicitud.js')}}"></script>
@endpush

@endsection

