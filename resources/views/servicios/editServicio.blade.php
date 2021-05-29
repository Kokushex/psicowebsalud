<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditarServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar Horario</h5>
                <button type="button" class="close resetCheckEditarServicio resetMsjEditarServicio" data-dismiss="modal" aria-label="Close">
                    <span class="resetCheckEditarServicio resetMsjEditarServicio" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarServicio" action="{{ route('servicios.editar_servicio') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_servicio_psicologo" id="id_servicio_psicologo">
                    <input type="hidden" name="id_modalidad_servicio" id="id_modalidad_servicio">
                    <input type="hidden" name="id_modalidad_precio" id="id_modalidad_precio">
                    <label class="text-bold">Servicio</label>
                    <input type="text" id="servicioEdit" name="servicioEdit" class="form-control mb-2 " readonly/>
                    <label class="text-bold">Modalidad</label>
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="presencialEdit" value="0" class="custom-control-input">
                        <input type="checkbox" id="presencialEdit" name="presencialEdit" value="1" class="custom-control-input" onclick="comprobarPresencial()">
                        <label class="custom-control-label" for="presencialEdit">Presencial</label>
                    </div>
                    <input type="text" id="presencialPrecioEdit" name="presencialPrecioEdit" class="form-control mb-2" onkeypress="return soloNumerosPrecioModalidad(event)" disabled=""/>
                    <div id="mensajePrecioPresencial"></div>
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="onlineEdit" value="0" class="custom-control-input">
                        <input type="checkbox" id="onlineEdit" name="onlineEdit" value="1" class="custom-control-input"  onclick="comprobarPresencial()">
                        <label class="custom-control-label" for="onlineEdit">Online</label>
                    </div>
                    <input type="text" id="onlinePrecioEdit" name="onlinePrecioEdit" class="form-control mb-2" onkeypress="return soloNumerosPrecioModalidad(event)"  disabled=""/>
                    <div id="mensajePrecioOnline"></div>
                    <label class="text-bold">Descipción Personal</label>
                    <div id="mensajeDescripcionoEdit"></div>
                            <input type="text-area" id="descripcionPersonalEdit" name="descripcionPersonalEdit" class="form-control mb-2"/>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" class="btnEditar" onclick="fn_editar_servicio() " >Editar</button>
                        <button type="button" class="btn btn-secondary resetCheckEditarServicio resetMsjEditarServicio" data-dismiss="modal" >Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
