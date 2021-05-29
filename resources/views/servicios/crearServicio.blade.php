<!-- Modal Servicio-->
<div class="modal fade" id="modalAgregarServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('servicios.crear_servicio') }}" id="formAdd">
            <div class="modal-content">
                <div class="card-body p-4">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        <h4 class="mb-3" >Servicio</h4>
                    <div class="modal-body" id="model_body">
                        @csrf
                        @include('servicios.stepServicios')
                        <div id="mensaje">
                        </div>
                        @include('servicios.tabServicios')
                    </div>
                    <div class="" id="modal_footer">
                        <div class="col-lg-4 col-5 float-left">
                            <button type="button" class="btn btn-block text-white text-4" id="prevBtn"
                                    style="background-color: #5e72e4; display:none;"
                                 onclick="nextPrev(-1)"><em class="fas fa-arrow-left"></em>Atrás
                            </button>
                        </div>
                        <div class="col-lg-4 col-5 float-right salto-linea" id="next">
                            <button type="button" class="btn btn-block text-white text-4" id="nextBtn"
                                    style="background-color: #5e72e4;"
                                    onclick="nextPrev(1)">Siguiente<em class="fas fa-arrow-right"></em>
                            </button>
                            <button type="button" class="btn btn-block text-white text-4" id="endBtn"
                                    style="background-color: #5e72e4;"
                                    onclick="agregarServicio()">Guardar<em class="fas fa-arrow-right"></em>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>





