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
        <!-- Alertas? -->

<div class="card-body">
    <table id="lista_reserva" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>N°</th>
            <th>RUT</th>
            <th>Paciente</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Horario
                <span class="text-muted">(Inicio)</span></th>
            <th>Modalidad</th>
            <th>Confirmación</th>
            <th>Pago</th>
            @csrf
        </tr>
        </thead>

        <tbody>
        @foreach ($reservas as $item)
            <tr>
                <th>{{$rank++}}</th>
                <td>{{$item->run}}</td>
                <td>{{$item->nombre.' '.$item->apellido_paterno}}</td>
                <td>{{$item->servicio}}</td>
                <td>{{ date('d-m-Y', strtotime($item->fecha)) }}</td>
                <td>{{ $item->hora_inicio}}</td>
                <td>{{$item->modalidad}}</td>
                <td class="text-center" style="color: #FFF">
                    @if ($item->confirmacion === 'Sin Confirmar')
                        <span class="badge bg-danger">{{$item->confirmacion}}</span>
                    @else
                        <span class="badge bg-success">{{$item->confirmacion}}</span>
                    @endif
                </td>
                <td class="text-center" style="color: #FFF">
                    @if($item->estado_pago === 'Pagado')
                        <span class="badge bg-success">{{$item->estado_pago}}</span>
                    @else
                        <span class="badge bg-danger">{{$item->estado_pago}}</span>
                    @endif
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    @if($reservas->isEmpty())
        <div class="alert alert-danger text-center" id="avisoBusqueda" role="alert">
            No se encuentran resultados, intente con otros parámetros por favor
        </div>
    @endif
</div>

    <ul class="pagination justify-content-center">
        {!! $reservas->appends(request()->query())->links() !!}
    </ul>
        </div>

    </div>

</div>
