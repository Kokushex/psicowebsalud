<!--                      Modals                         -->

<!-- Modal Agregar -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAgregarHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Agregar Horario</h5>
          <button type="button" class="close resetCheckAgregar resetMsjAgregar" data-dismiss="modal" aria-label="Close" onclick="resetModalAgregar()">
            <span class="resetCheckAgregar resetMsjAgregar" onclick="resetModalAgregar()" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="formAdd" action="{{ route('crearHorario') }}" method="POST">
                @csrf
                <label class="text-bold">Dias de Trabajo</label>

                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaLun" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaLun" name="diaLun" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaLun">Lunes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaMar" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaMar" name="diaMar" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaMar">Martes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaMie" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaMie" name="diaMie" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaMie">Miercoles</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaJue" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaJue" name="diaJue" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaJue">Jueves</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaVie" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaVie" name="diaVie" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaVie">Viernes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaSab" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaSab" name="diaSab" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaSab">Sabado</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaDom" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaDom" name="diaDom" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaDom">Domingo</label>
                </div>
                <div id="mensajeDiasAdd"></div>
                <label class="text-bold">Hora Entrada AM</label>
                <input required type="time" id="horaEntAM" name="horaEntAM" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraEntAM"></div>
                <label class="text-bold">Hora Salida AM</label>
                <input required type="time" id="horaSalAM" name="horaSalAM" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraSalAM"></div>
                <label class="text-bold">Hora Entrada PM</label>
                <input required type="time" id="horaEntPM" name="horaEntPM" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraEntPM"></div>
                <label class="text-bold">Hora Salida PM</label>
                <input required type="time" id="horaSalPM" name="horaSalPM" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraSalPM"></div>
            </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" class ="btnAgregarHorario" onclick="fn_agregar_horario()">Registrar Horario</button>
                    <button type="button" class="btn btn-danger resetCheckAgregar resetMsjAgregar" data-dismiss="modal" onclick="resetModalAgregar()">Cancelar</button>
                </div>
            </form>
      </div>
    </div>
</div>
