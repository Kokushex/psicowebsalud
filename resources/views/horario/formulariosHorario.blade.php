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

<!-- Modal Editar -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditarHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar Horario</h5>
          <button type="button" class="close resetCheckEditar resetMsjEditar" data-dismiss="modal" aria-label="Close">
            <span class="resetCheckEditar resetMsjEditar" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="formEditarHorario" action="{{ route('editarHorario') }}" method="POST">
                @csrf
                @method('PUT')
                <label class="text-bold">Dias de Trabajo</label>
                <input type="hidden" name="idHorarioDia" id="idHorarioDia">
                <input type="hidden" name="idHorario" id="idHorario">
                <input type="hidden" name="idDia" id="idDia">
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaLunEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaLunEdit" name="diaLunEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaLunEdit">Lunes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaMarEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaMarEdit" name="diaMarEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaMarEdit">Martes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaMieEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaMieEdit" name="diaMieEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaMieEdit">Miercoles</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaJueEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaJueEdit" name="diaJueEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaJueEdit">Jueves</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaVieEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaVieEdit" name="diaVieEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaVieEdit">Viernes</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaSabEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaSabEdit" name="diaSabEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaSabEdit">Sabado</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="diaDomEdit" value="0" class="custom-control-input">
                    <input type="checkbox" id="diaDomEdit" name="diaDomEdit" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="diaDomEdit">Domingo</label>
                </div>
                <div id="mensajeDiasEdit"></div>
                <label class="text-bold">Hora Entrada AM</label>
                <input required type="time" id="horaEntAMEdit" name="horaEntAMEdit" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraEntAMEdit"></div>
                <label class="text-bold">Hora Salida AM</label>
                <input required type="time" id="horaSalAMEdit" name="horaSalAMEdit" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraSalAMEdit"></div>
                <label class="text-bold">Hora Entrada PM</label>
                <input required type="time" id="horaEntPMEdit" name="horaEntPMEdit" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraEntPMEdit"></div>
                <label class="text-bold">Hora Salida PM</label>
                <input required type="time" id="horaSalPMEdit" name="horaSalPMEdit" placeholder="Hora Entrada" class="form-control mb-2 validar">
                <div id="mensajeHoraSalPMEdit"></div>
        </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" class="btnEditarHorario" onclick="fn_editar_horario();">Editar</button>
                    <button type="button" class="btn btn-secondary resetCheckEditar resetMsjEditar" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
      </div>
    </div>
</div>

<!-- Modal Descripcion -->
<div class="modal fade" id="modalDescripcionHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Descripción del Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: -32.5px">
                    <div class="col-md-4">
                        <div class="card tarjeta mt-4">
                            <center>
                                <label class="text-bold" >Dias de Trabajo</label>
                                <div id="diasTrabajo"></div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card tarjeta mt-4 cardTabla" style="padding-bottom: 3px">
                            <center>
                                <label class="text-bold">Horas de Trabajo</label>
                            </center>
                            <div id="horasTrabajo"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>