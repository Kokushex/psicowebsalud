<style>
    .claseMia {
        background-color: #3B83AE;
    }

</style>

<div class="modal fade" id="create">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('reserva.create') }}" id="modalForm">
            <div class="modal-content">
                <div class="card-body p-4">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>x</span>
                    </button>
                    <h4 class="mb-3">Reserva</h4>
                </div>
                <div class="modal-body p-4" id="model_body">
                    @csrf
                    @include('reservas.steps')
                    <div id="mensaje">
                    </div>
                    @include('reservas.tabs')
                </div>
                <div class="" id="modal_footer">
                    <div class="col-lg-4 col-5 float-left">
                        <button type="button" class="btn btn-block  white-text text-4" id="prevBtn"
                                style="background-color: #737b80; display:none;" onclick="nextPrev(-1)"><em
                                class="fas fa-arrow-left"></em> Atrás</button>
                        <button type="button" class="btn btn-block  white-text text-4" id="prev"
                                style="background-color: #737b80; display: none;"><em class="fas fa-arrow-left"></em>
                            Atrás</button>
                    </div>
                    <div class="col-lg-4 col-6 float-right" id="next">
                        <button type="button" class="btn btn-block white-text text-4" style="background-color: #3b83ae"
                                id="button">Siguiente <em class="fas fa-arrow-right"></em> </button>
                        <button type="button" class="btn btn-block white-text text-4" id="nextBtn"
                                style="background-color: #3b83ae" onclick="nextPrev(1)">Siguiente <em
                                class="fas fa-arrow-right"></em></button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
