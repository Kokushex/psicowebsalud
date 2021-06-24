<style>

    .claseMia{
        background-color: #3B83AE;
    }

</style>

<!-- Modal Ver Detalle -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles Reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table>
                            <tr>
                                <th scope="col" class="title-4 text-center">Paciente : <label style="font-weight: normal" id="td_paciente_reserva"></label> </th>
                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Fecha : <label style="font-weight: normal" id="td_fecha"></label> </th>


                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Servicio Psicológico : <label style="font-weight: normal" id="td_servicio"></label> </th>


                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Descripcion del Servicio : <label style="font-weight: normal" id="td_descripcion_servicio"></label> </th>


                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Psicologo : <label style="font-weight: normal" id="td_nombre_psico"></label></th>

                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Hora Inicio : <label style="font-weight: normal" id="td_hora_inicio"></label></th>

                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Hora Termino : <label style="font-weight: normal" id="td_hora_termino"></label></th>

                            </tr>
                            <tr>
                                <th scope="col" class="title-4 text-center">Modalidad : <label style="font-weight: normal" id="td_modalidad"></label></th>

                            </tr>

                            <tr>
                                <th scope="col" class="title-4 text-center">Precio : <label style="font-weight: normal" id="td_precio"></label></th>

                            </tr>

                            <tr id="tr_centro" style="visibility: hidden">
                                <th scope="col" class="title-4 text-center">Centro : <label style="font-weight: normal" id="td_centro"></label></th>

                            </tr>

                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>








<!-- Modal Ver Reagendar -->
<div class="modal" id="modalReagendar" tabindex="-1" role="dialog" aria-labelledby="..." aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="container">
                <div class="modal-header">
                    <h5 id="titulo">Reagendar</h5>
                    <input type="hidden" id="id_reserva" value="">
                    <button class="close" data-dismiss="modal" aria-label="Cerrar"></button>
                    <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <div id="contenedor_datos">
                        <div id="div_fechas">

                            <label for="servicio_id" class="text-5 darkgray-text text-bold">Servicio</label>
                            <input type="hidden" id="id_servicio" value="">
                            <input type="text" id ="nombre_servicio" placeholder="" class="form-control"  disabled><br>
                            <label for="datos" class="text-5 darkgray-text text-bold">Datos Reserva</label>
                            <div class="row" name="datos" id="datosAnteriores">
                            </div>
                            <br><div id="nuevosDatos" style="\margin-top:-40px\">
                                <label for="fecha" class="text-5 darkgray-text text-bold">Nueva Fecha:</label>
                                <input class="form-control" placeholder="Buscar Horario" value="" name="fecha" type="date"  id="fecha">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">

                        <div class="col md-6">
                            <button class="btn btn-secondary footer-left" data-dismiss="modal" type="button">Cancelar</button>
                        </div>

                        <div class="col md-6">
                            <button class="btn btn-info footer-right" style="background-color: #3BA699"  onclick="confirmar(1,'Confirmar Operación!','¿Estas Seguro de Reagendar?','Se Reagendo Exitosamente!');" id="btnAgendax" type="button">Agendar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
