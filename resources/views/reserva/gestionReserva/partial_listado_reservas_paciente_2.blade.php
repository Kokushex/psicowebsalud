    <div class="container mt--10 pb-5"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reservas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista Reserva</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="container-fluid mt-2">
        <div class="card shadow mb-12">
            <div class="card-header">
                <h3 class="card-title">Reservas</h3>
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
                    <table class="table table-striped table-bordered " style="width:100%">
                        <thead>
                        <tr class="tabla_datos_solicitados">
                            <th></th>
                            <th>Fecha</th>
                            <th>Hora inicio</th>
                            <th>Modalidad</th>
                            <th>Estado Reserva</th>
                            <th>Estado de Pago</th>
                            <th>Ver</th>
                            @csrf
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reserva as $reservas)
                            <tr class="text-lg-center">
                                <th>{{$rank++}}</th>
                                <td id="td_fecha{{$reservas->id_reserva}}">{{ date('d-m-Y', strtotime($reservas->fecha))}}</td>
                                <td id="td_hora_inicio{{$reservas->id_reserva}}">{{ date('H:i', strtotime($reservas->hora_inicio)) }}</td>
                                <td>{{$reservas->modalidad}}</td>
                                <td class="text-center" id="td_conf{{$reservas->id_reserva}}">{{$reservas->confirmacion}}</td>
                                <td>{{$reservas->estado_pago}}</td>
                                <td>
                                    <a type="button"  onclick="llenarModal({{$reservas->id_reserva}})"
                                        style="font-size:20px; color:#484AF0; background-color:transparent;"
                                        class="fas fa-eye">
                                    </a>
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    @if($reserva->isEmpty())
                        <div class="alert alert-danger text-center" id="avisoBusqueda" role="alert">
                            Sin reservas que mostrar.
                        </div>
                    @endif
                </div>

                    <ul class="dataTables_paginate text-center" style="display: table" >
                        {!! $reserva->appends(request()->query())->links() !!}
                    </ul>

            </div>
        </div>
        @include('reserva.gestionReserva.modalDetalles')
    </div>
