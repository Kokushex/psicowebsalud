<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col" class="title-4 text-center">N°</th>
            <th scope="col" class="title-4 text-center">RUT</th>
            <th scope="col" class="title-4 text-center">Paciente</th>
            <th scope="col" class="title-4 text-center">Servicio</th>
            <th scope="col" class="title-4 text-center">Fecha</th>
            <th scope="col" class="title-4 text-center">Horario
                <span class="text-muted">(Inicio)</span></th>
            <th scope="col" class="title-4 text-center">Modalidad</th>
            <th scope="col" class="title-4 text-center">Confirmación</th>
            <th scope="col" class="title-4 text-center">Pago</th>
            {{-- <th scope="col" class="title-4 text-center">Prevision</th> --}}
        </tr>
        </thead>

        <tbody>
        @foreach ($reservas as $item)
            <tr>
                <th scope="row" class="text-center">{{$rank++}}</th>
                <td class="text-center">{{$item->rut}}</td>
                <td class="text-center">{{$item->nombre.' '.$item->apellido_paterno}}</td>
                <td class="text-center">{{$item->servicio}}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($item->fecha)) }}</td>
                <td class="text-center">{{ $item->hora_inicio}}</td>
                <td class="text-center">{{$item->modalidad}}</td>
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
                {{-- <td class="text-center">{{$citas->prevision}}</td> --}}
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
@if($reservas->isEmpty())
    <div class="alert alert-danger text-center" id="avisoBusqueda" role="alert">
        No se encuentran resultados, intente con otros parámetros por favor
    </div>
@endif


<ul class="pagination justify-content-center">  {!! $reservas->appends(request()->query())->links() !!} </ul>
