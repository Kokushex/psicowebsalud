<div class="card bg-light mt-4 tarjeta">
    <div class="card-body">
        <div class="table-responsive">


            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="title-4 text-center" style="display:none;"></th>
                    <th scope="col" class="title-4 text-center">Fecha</th>
                    <th scope="col" class="title-4 text-center">Hora inicio</th>
                    {{-- <th scope="col" class="title-4 text-center">Hora.. Termino</th>--}}
                    <th scope="col" class="title-4 text-center">Modalidad</th>
                    {{--   <th scope="col" class="title-4 text-center">Precio</th>----}}
                    <th scope="col" class="title-4 text-center">Estado Reserva</th>
                    <th scope="col" class="title-4 text-center">Estado de Pago</th>
                    <th scope="col" class="title-4 text-center">Ver</th>
                    <th scope="col" class="title-4 text-center">Reagendar</th>
                    <th scope="col" class="title-4 text-center">Cancelar</th>
                    @csrf
                </tr>
                </thead>

                <br>
                <tbody>
                @foreach ($reserva as $reservas)

                    <tr>
                        <th scope="row" class="text-center" style="display:none;">{{$rank++}}</th>
                        <td id="td_fecha{{$reservas->id_reserva}}" class="text-center">{{ date('d-m-Y', strtotime($reservas->fecha))}}</td>
                        <td id="td_hora_inicio{{$reservas->id_reserva}}" class="text-center">{{ date('H:i', strtotime($reservas->hora_inicio)) }}</td>
                        <td class="text-center">{{$reservas->modalidad}}</td>
                        <td class="text-center" id="td_conf{{$reservas->id_reserva}}">{{$reservas->confirmacion}}</td>
                        <td class="text-center">{{$reservas->estado_pago}}</td>
                        <td class="text-center">
                            <a type="button"  onclick="llenarModal({{$reservas->id_reserva}})"
                               style="font-size:20px; color:#484AF0; background-color:transparent;"
                               class="fas fa-eye">
                            </a>
                        </td>

                        {{-- Medir la fecha y hora --}}

                        @if ((date('Y-m-d H:i', strtotime($reservas->fecha.' '.$reservas->hora_inicio))) >= (date('Y-m-d H:i', strtotime('now'))))

                            <td class="text-center" id="td_reg{{$reservas->id_reserva}}">
                                @if ((strtotime($reservas->fecha.' '.$reservas->hora_inicio) > (strtotime('now') + 86400))&&($reservas->confirmacion!="Cancelado"))

                                    <button class="btn btn-secondary far fa-calendar-alt" style="background-color: #3B83AE" onclick="reagendar({{$reservas}});" ></button>

                                @else
                                    -
                                @endif
                            </td>
                            <td id="td_cancelar{{$reservas->id_reserva}}" class="text-center">
                                @if ($reservas->confirmacion!="Cancelado")

                                    <button type="button" id="btn{{$reservas->id_reserva}}" onclick="validarTiempoCancelar({{$reservas}})" class="btn btn-danger btn-sx">X</button>
                                @else
                                    -
                                @endif
                            </td>
                        @else
                            <td class="text-center">-</td><td class="text-center">-</td>

                        @endif
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

        <ul class="pagination justify-content-center">
            {!! $reserva->appends(request()->query())->links() !!}
        </ul>

    </div>

    @include('reserva.gestionReserva.modalDetalles')
</div>
