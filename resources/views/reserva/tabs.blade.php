
<div class="tab text-4" id="tab">

    <div class="text-center mb-4">
        <h1 class="title-4 darkblue-text" id="h1">
            Identificación del paciente
        </h1>
    </div>
    <div class="form-group row">
        <div class="col-md-12 contenedor" id="contenedor">
            <div id="datos_rut">
                <form action="">
                    <div class="form-group row pl-3 pr-3 mb-3">
                        <div class="col-md-12">
                            <input type="hidden" id="id_paciente_titular" @if (auth()->user())
                            value="{{$usuarioLogeado->id_paciente}}"
                                @endif>
                            <input type="hidden" name="id_paciente_seleccionado" id="id_paciente_seleccionado" @if (auth()->user())
                            value="{{$usuarioLogeado->id_paciente}}"
                                @endif>
                            <input type="hidden" id="slFiltro" @if (auth()->user())
                            value="1"
                                @endif>
                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_carga" style="display: none">

                        <div class="col-md-12" id="div_select">
                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3" id="contenedor_correo">
                        <label class="col-md-12 text-5 darkgray-text text-bold">Correo</label>
                        <div class="col-md-12">
                            <input type="hidden" id="id_psicologo_seleccionado" value="{{$user->id_psicologo}}">
                            <input type="hidden" id="id_user_psicologo" value="{{$user->id_user}}">
                            <input id="correo" type="email" readonly="true" class="form-control text-4 bluegray-text" name="correo" @if (auth()->user())
                            value="{{$usuarioLogeado->email}}"
                                   @endif  required="" autocomplete="correo">
                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3">
                        <label for="telefono" class="col-md-12 text-5 darkgray-text text-bold">Telefono</label>

                        <div class="col-5">
                            <input disabled="" type="text" class="form-control text-4 bluegray-text" name="codigo" id="codigo" value="+569">
                        </div>
                        <div class="col-7">
                            <input id="telefono" @if (auth()->user())
                            value="{{$usuarioLogeado->telefono}}"
                                   @endif maxlength="9" minlength="1" type="Tel" onkeypress="return soloNumeros(event)" class="form-control text-4 bluegray-text pt-2 pb-2 " placeholder="Telefono" name="telefono" autocomplete="telefono" autofocus="">


                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3" id="div_rut">
                        <label class="col-md-12 text-5 darkgray-text text-bold">Rut</label>
                        <div class="col-12">
                            <input id="rut" onkeypress="return soloNumerosRut(event)" maxlength="10" type="text" placeholder="Ejemplo: 12345678-0" @if (auth()->user()&&$usuarioLogeado->run!="")
                            value="{{$usuarioLogeado->run}}" readonly="true"
                                   @endif class="form-control text-4 bluegray-text" name="rut"  required="" autocomplete="rut">
                            <label id="msgRun" style="color: red; display:none"></label>
                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3" id="div_nombre">
                        <label class="col-md-12 text-5 darkgray-text text-bold">Nombre</label>
                        <div class="col-12">
                            <input id="nombre" type="text" placeholder="Nombre" @if (auth()->user())
                            value="{{$usuarioLogeado->nombre}}" readonly="true"
                                   @endif class="form-control text-4 bluegray-text" name="nombre" onkeypress="return sololetras(event)"  required="" autocomplete="nombre">
                        </div>
                    </div>
                    <div class="form-group row pl-3 pr-3 mb-3" id="div_apellido">
                        <label class="col-md-12 text-5 darkgray-text text-bold">Apellido</label>
                        <div class="col-12">
                            <input id="apellido" type="text" placeholder="Apellido" @if (auth()->user())
                            value="{{$usuarioLogeado->apellido_paterno}}" readonly="true"
                                   @endif class="form-control text-4 bluegray-text pt-2 pb-2" name="apellido" onkeypress="return sololetras(event)"  required="" autocomplete="apellido">
                        </div>
                    </div>
            </div>


            <div id="servicios" id="servicios" style="display: none;">
                <label for="servicio_id" class="text-5 darkgray-text text-bold"  id="label_id">Servicio</label>
                @if(count($servicios)>0)
                    <select class="custom-select text-4 bluegray-text"  name="servicio_id" id="servicio_id">
                        <option value="" class="text-4 bluegray-text">Indica tu Servicio</option>
                        @foreach($servicios as $nombre)
                            <option value="{{$nombre->id_servicio_psicologo}}" class="text-4 bluegray-text">{{$nombre->nombre}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="tab text-4" style="display: none;">
    <div class="text-center mb-4">
        <h1 class="title-4 darkblue-text">
            Seleccione fecha
        </h1>
    </div>
    <div class="form-group row">
        <div class="col-md-12 contenedor" id="contenedor_fecha">
            <div class="form-group">
                <div id="fechas">
                    <div><label for="custom-select" class="col-md-12 text-5 darkgray-text text-bold">Fecha</label>
                        <input class="form-control" type="text" placeholder="Buscar Horario" value="" readonly min="" name="fecha" id="fecha">
                    </div>
                    <br>
                    <div class="mt-1 hide-me" id="divBloqueHorario"> <label for="custom-select" class="col-md-12 text-5 darkgray-text text-bold">Bloque de Tiempo</label>
                        <select class="custom-select pl-3 pr-3 mt-1 text-4 bluegray-text" name="cbxTipoHorario" id="cbxTipoHorario">
                            <option value="">Seleccione AM o PM</option>
                            <option value="AM">Bloque AM</option>
                            <option value="PM">Bloque PM</option>
                        </select>
                    </div>
                    <br>
                    <div class="mt-1 hide-me" id="divHorasList"><label for="custom-select" class="col-md-12 text-5 darkgray-text text-bold">Horario</label>
                        <select class="custom-select pl-3 pr-3 mt-1 text-4 bluegray-text" name="cbxHorasDisponibles" id="cbxHorasDisponibles" onchange="funcionHoras()">
                        </select>
                    </div>

                </div>
            </div>
            {{--  <input type="hidden" id="termino" name="hora_terminoD"> --}}
        </div>
    </div>
</div>
<div class="tab text-4" style="display: none;">
    <div class="text-center mb-4">
        <h1 class="title-4 darkblue-text">
            Detalles de tu reserva
        </h1>
    </div>
    <div class="form-group row">
        <div class="col-md-12 contenedor" id="contenedor_detalle">
            <table class="table table-bordered table-hover">
                <tbody>
                <input class="hide-me" type="text" id="verificacionD">
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Servicio</label></th>
                    <td class="text-4 bluegray-text" id="servicioD"></td>
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Nombre Completo</label></th>
                    <td class="text-4 bluegray-text" id="nombreCompletoD"></td>
                    <input type="hidden" name="direccionD" id="direccion">
                    <input type="hidden" id="nombreTitular"

                           @if (auth()->user())
                           value="{{$usuarioLogeado->nombre}}"
                        @endif >
                    <input type="hidden" id="apellidoTitular"

                           @if (auth()->user())
                           value="{{$usuarioLogeado->apellido_paterno}}"
                        @endif >
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Modalidad</label></th>
                    <td class="text-4 bluegray-text" id="modalidadD"></td>
                    <input type="hidden" id="hidenModalidad">
                    <input type="hidden" id="hidenHoras">
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Fecha</label></th>
                    <td class="text-4 bluegray-text" id="fechaD"></td>
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Hora inicio</label></th>
                    <td class="text-4 bluegray-text" id="hora_inicioD"></td>
                    <input type="hidden" name="hora_inicioGet" id="hora_inicioGet">
                </tr>

                {{--   <tr>
                       <th scope="row"><label class="text-5 darkgray-text text-bold">Hora termino</label></th>
                       <td class="text-4 bluegray-text" id="hora_terminoD"></td>
                       <input type="hidden" name="hora_terminoGet" id="hora_terminoGet">
                   </tr>
                   --}}
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Tipo Pago</label></th>
                    <td class="text-4 bluegray-text" id="previsionD"></td>
                    <input type="hidden" id="hidenPrevision" name="previsionDDD">
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Precio</label></th>
                    <td class="text-4 bluegray-text" id="precioD"></td>
                    <input type="hidden" name="precioD" id="precio">
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Rut</label></th>
                    <td class="text-4 bluegray-text" id="rutD"></td>
                    <input type="hidden" name="rutD" id="rutDa">
                    <input type="hidden" id="rutTitular"

                           @if (auth()->user())
                           value="{{$usuarioLogeado->run}}"
                        @endif
                    >
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Correo</label></th>
                    <td class="text-4 bluegray-text" id="correoD"></td>
                </tr>
                <tr>
                    <th scope="row"><label class="text-5 darkgray-text text-bold">Telefono</label></th>
                    <td class="text-4 bluegray-text" id="telefonoD"></td>
                    <input type="hidden" id="fonoTitular"

                           @if (auth()->user())
                           value="{{$usuarioLogeado->telefono}}"
                        @endif
                    >
                </tr>
                </tbody>
            </table>
            <label><input class="" type="checkbox" id="condicionesid" name="condiciones"> si acepto los terminos y condiciones. <a href="" data-dismiss="modal" data-toggle="modal" data-target="#condiciones">Leer mas</a> </label><br>
        </div>
    </div>
