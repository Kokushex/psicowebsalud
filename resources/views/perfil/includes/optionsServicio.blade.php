<div class="card mb-3">
    <div class="card-body">
        <h4 class="title-4 darblue-text text-center"> Servicios</h4>
        <div class="accordion js-accordion" id="acc">
            <div class="accordion__item js-accordion-item">
                @if (count($servicios) > 0)
                    @foreach ($servicios as $servicio)
                        <div class="accordion-header js-accordion-header"><strong>{{ $servicio->nombre }}</strong>
                        </div>
                        <div class="accordion-body js-accordion-body">
                            <div class="accordion-body__contents" id="contenido">
                                <strong>{{ $servicio->nombre }}</strong>
                                <hr>
                                <div class='desc'><strong>Descripción: </strong>{{ $servicio->descripcion }}</div>
                                <div><strong id="dura">Duración:</strong> 60 Minutos<span></span></div>
                                <div><strong>Modalidad: </strong>{{ $servicio->id_servicio }}</div>
                                <div><strong>Valor:</strong> ${{ $servicio->precio_particular }}</div>
                            </div>

                        </div>

                    @endforeach
                @else
                    <div class="alert alert-warning text-4">No hay servicios registrados</div>
                @endif

            </div><!-- end of accordion body -->
        </div><!-- end of accordion item -->
    </div>
</div>
