<!-- Modal de informacion de cita -->
<div class="modal fade" id="modal_agenda">
    <div class="modal-dialog modal-lg" style="max-width: 1000px">
        <div class="modal-content">

            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h4 class="modal-title text-center w-100 text-center">Detalles Reserva</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">


                <!--fila 1-->
                <div class="row">

                    <!--columna 1.1-->
                    <div class="col-md-12">
                        <label for="basic-url" style="font-weight: bold">Nombre</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-user ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_nombre"
                                   name="txt_nombre">
                        </div>
                    </div>
                    <!--columna 1.2-->
                    <div class="col-md-12">
                        <label for="basic-url" style="font-weight: bold">Servicio</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-hand-holding-medical ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_servicio">
                        </div>
                    </div>
                </div>
                <!--fila 2-->

                <div class="row">
                    <!--columna 2.1-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Teléfono</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-phone-alt ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_telefono">
                        </div>
                    </div>
                    <!--columna 2.2-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Modalidad</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fa fa-laptop ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_modalidad">
                        </div>
                    </div>

                    <!--columna 2.3-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Previsión</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-clinic-medical ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_prevision">
                        </div>
                    </div>
                    <!--columna 2.4-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Precio</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-dollar-sign ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_precio">
                        </div>
                    </div>
                </div>

                <!--fila 3-->
                <div class="row">
                    <!--columna 3.1-->

                    <div class="col-md-3 col-12">
                        <label for="basic-url" style="font-weight: bold">Fecha</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-calendar-alt ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_fecha_cita">
                        </div>
                    </div>
                    <!--columna 3.2-->
                    <div class="col-md-3 col-12">
                        <label for="basic-url" style="font-weight: bold">Hora de inicio</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="far fa-clock ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_hora_inicio">
                        </div>
                    </div>

                    <!--columna 3.3-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Hora de termino</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="far fa-clock ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_hora_termino">
                        </div>
                    </div>
                    <!--columna 3.4-->
                    <div class="col-md-3 col-sm-6">
                        <label for="basic-url" style="font-weight: bold">Estado del Pago</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text input-text-Align"><i
                                        class="fas fa-hand-holding-usd ml-1 colorStyleIcon pull-right"></i>
                                </div>
                            </div>
                            <input readonly type="text" class="form-control text-center" id="txt_estado_pago">
                        </div>
                    </div>
                </div>


            </div>


            <!-- footer del Modal -->
            <div class="modal-footer">
                {{-- <a href="{{route('reserva.listarReservasPsicologo')}}" type="button" id="btn_detalle_cita"
            class="btn btn-info" >Detalles</a> --}}

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
