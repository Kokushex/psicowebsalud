<!-- Step 1 de modal agregar servicio -->
<div class="tab text-4" id="tab">
    <div class="text-center mb-4">
        <h1 class="title-4 darkblue-text" id="h1">
            Agregar Servicio
        </h1>
    </div>
    <div class="form-group row">
        <div class="col-md-12 contenedor" id="contenedor">
            <div>

                <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_nombreServicio">
                    <label class="col-md-12 text-5 darkgray-text text-bold">Nombre del Servicio</label>
                    <div class="col-md-12">
                        <select onchange=mostrarDatosServicio() class="js-example-basic-single js-states form-control" name="txtNombreServicio" id="txtNombreServicio">
                        </select>
                    </div>
                    <div class="col-md-12" id="mensajeAdd1"></div>
                </div>

                <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_estadoServicio">
                    <label class="col-md-12 text-5 darkgray-text text-bold">Estado</label>
                    <div class="col-md-12">
                        <select class="form-control" name="cbxEstadoServicio" id="cbxEstadoServicio">
                            <option value="">Seleccione un Estado</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                    </div>
                    <div class="col-md-12" id="mensajeAdd2"></div>
                </div>

                <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_desGeneralServicio">
                    <label class="col-md-12 text-5 darkgray-text text-bold">Descripción General</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control text-4 bluegray-text" name="txtDesGeneralServicio" id="txtDesGeneralServicio">
                    </div>
                    <div class="col-md-12" id="mensajeAdd3"></div>
                </div>

                <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_desPersonalServicio">
                    <label class="col-md-12 text-5 darkgray-text text-bold">Descripción Personal</label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="txtaDesPersonalServicio" id="txtaDesPersonalServicio" cols="60" rows="10"></textarea>
                    </div>
                    <div class="col-md-12" id="mensajeAdd4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Step 2 de modal agregar servicio -->
<div class="tab text-4" style="display: none;">

    <div class="text-center mb-4">
        <h1 class="title-4 darkblue-text" id="h1">
            Agregar Servicio
        </h1>
    </div>
    <div class="form-group row">
        <div class="col-md-12 contenedor" id="contenedor">
            <div>
                <div class="col-md-12" id="mensajeAdd5"></div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="chxModPresencialServicio" value="0" class="custom-control-input">
                    <input type="checkbox" id="chxModPresencialServicio" name="chxModPresencialServicio" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="chxModPresencialServicio">Presencial</label>
                    <input type="number" class="form-control text-4 bluegray-text " name="txtPrecioModPresencialServicio" id="txtPrecioModPresencialServicio" placeholder="Precio de Modalidad Presencial">
                </div><br>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="chxModOnlineServicio" value="0" class="custom-control-input">
                    <input type="checkbox" id="chxModOnlineServicio" name="chxModOnlineServicio" value="1" class="custom-control-input">
                    <label class="custom-control-label" for="chxModOnlineServicio">Online</label>
                    <input type="number" class="form-control text-4 bluegray-text " name="txtPrecioModOnlineServicio" id="txtPrecioModOnlineServicio" placeholder="Precio de Modalidad Online">
                </div><br>
            </div>
        </div>
    </div>
</div>
