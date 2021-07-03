(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (document.getElementById('hidenMensaje') != null) {

        mensaje_entrada_lista("1");

        document.getElementById('hidenMensaje').remove();

    } else {

        $.ajax({
            type: 'get',
            url: '/getResCantidadPendientes',
        })
            .done(function (data) {
                var dato = JSON.parse(data);

                if (dato > 0) {
                    mensaje_entrada_lista("2");
                }

            });

    }

})();
//Variables utilizadas para generar horas disponibles cuando reagenda y si la hora ya fue tomada
var gobal_id_psicologo = 0;
var gobal_id_user_psicologo = 0;
var global_id_paciente = 0;




//Función encargada de notificar al usuario logueado, tenemos 2 casos: Al  realizar una reserva con previsión y al tener reservas pendientes de confirmación.
function mensaje_entrada_lista(cantidad) {
    var cuerpo = "";
    if (cantidad == "1") {
        cuerpo = "SE LE HA ENVIADO UN EMAIL PARA QUE CONFIRME SU RESERVA";
    } else {
        cuerpo = "TIENE UNA RESERVA PENDIENTES DE CONFIRMACIÓN, REVISE SU EMAIL POR FAVOR.";
    }
    swal({
        title: "CONFIRMACIÓN PENDIENTE",
        text: cuerpo,
        icon: "info",
        closeModal: true,
        buttons: {
            confirm: {
                text: "OK",
                visible: true,
                className: "claseMia",
                closeModal: true
            }

        }
    })

}
//función para validar el tiempo previo faltante a la reserva para hacer el reembolso correspondiente
function validarTiempoCancelar(reserva) {
    $.ajax({
        type: 'get',
        url: '/validarFechaHora',
        data: {
            id_reserva: reserva['id_reserva'],
            hora: 12,
            operacion: "cancelar"
        }
    })
        .done(function (data) {
            var dato = JSON.parse(data);
            var mensaje_cancelar = "";
            if (reserva["precio"] == null) {
                mensaje_cancelar = "";
            } else {
                if (dato == "1") {
                    mensaje_cancelar = "Al cancelar se reembolsará el valor pagado de la reserva";
                } else {
                    mensaje_cancelar = "Faltan menos de 12 hrs antes de la atención, por lo tanto al cancelar no se reembolsará ningún valor de lo pagado";
                }
            }
            confirmar(2, '¿Desea Cancelar su Reserva?', mensaje_cancelar, 'Se Canceló Exitosamente!', reserva);
        });

}
//Función para realizar llamado Ajax para actualizar la reserva cancelandola
function cancelarReserva(reserva) {

    $.ajax({
        type: "get",
        url: "/actualizarReserva",
        data: {
            id: reserva["id_reserva"],
            confirmacion: "asdf"
        }
    })

}

//Función encargada de realizar llamado Ajax para completar los datos del modal ver detalle y además despliega esté.
function llenarModal(id_res) {
    $.ajax({
        type: "get",
        url: "/llenarModalReservas",
        data: {
            id: id_res
        }
    })
        .done(function (data) {
            var datos = JSON.parse(data);
            var retorno = datos[0];
            var paciente = datos[1];
            document.getElementById("td_paciente_reserva").innerText = paciente["nombre"]+" "+ paciente["apellido_paterno"];
            var fecha_td = conversorFecha(retorno["fecha"]);
            document.getElementById("td_fecha").innerText = fecha_td;
            document.getElementById("td_modalidad").innerText = retorno["modalidad"];
            document.getElementById("td_hora_inicio").innerText = retorno["hora_inicio"];
            document.getElementById("td_hora_termino").innerText = retorno["hora_termino"];
            if (retorno["precio"] != null) {
                document.getElementById("td_precio").innerText = "$ " + retorno["precio"];
            } else {
                document.getElementById("td_precio").innerText = "Precio Previsión";
            }
            document.getElementById("td_servicio").innerText = retorno["nombre_servicio"];
            document.getElementById("td_descripcion_servicio").innerText = retorno["descripcion_servicio"];
            document.getElementById("td_nombre_psico").innerText = retorno["nombre"] + " " + retorno["apellido_paterno"];
            if (retorno["modalidad"] == "Presencial") {
                document.getElementById("tr_centro").style.visibility = "visible";
                document.getElementById("td_centro").innerText = retorno["centro"];
            } else {
                document.getElementById("tr_centro").style.visibility = "hidden";
            }
            $("#exampleModal").modal("show");
        })
}

/*Función encargada de notificar al paciente a través de un llamado ajax al reagendar.
*Esta función verifica que no cuente con una reserva existente en la fecha y la hora seleccionada por el paciente. */
function horas(id_paciente) {
    $.ajax({
        type: "get",
        url: "/horarioPaciente",
        data: {
            id_paciente: id_paciente,
            fecha: $("#fecha").val(),
            hora_inicio: $("#horas").val()
        }
    })
        .done(function (data) {
            var dato = JSON.parse(data);
            if (dato == 1) {
                var $msjHora = $('<div style=\'margin-top:8px; opacity: 0.6\' class="alert alert-warning alert-dismissible" id="mensajeHora"><a style="opacity: 1.0" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong style="opacity: 1.0">Ops!</strong> Ya Tienes Una reserva, seleccione otra hora</div>')
                $("#nuevosDatos").append($msjHora);
                //bloquearBtn
                document.getElementById("btnAgendax").disabled = true;
            } else {
                $("#mensajeHora").remove();
                //dejar Pasar
                document.getElementById("btnAgendax").disabled = false;
            }
        });
}


//Función encargada de recolectar los datos para reagendar la reserva mediante un llamado ajax.
function agendar() {
    var nuevaFecha = $("#fecha").val();
    var nuevaHora = $("#horas").val();
    var idReserva = $("#id_reserva").val();
    nuevaHora = nuevaHora.split('-');
    var h_inicio = nuevaHora[0].trim() + ":00";
    $.ajax({
        type: "get",
        url: "/actualizarReserva",
        data: {
            id: idReserva,
            fecha: nuevaFecha,
            hora_inicio: h_inicio

        }
    });
}

/*Encargada de validar si la reserva seleccionada puede ser reagendada, de lo contrario notificará al paciente que no puede reagendar.
* Si la reserva cumple con los requisitos esta función desplegará un modal con la información específica para poder reagendar.*/
function reagendar($reservas) {
    document.getElementById("btnAgendax").disabled = true;
    document.getElementById("id_reserva").value = $reservas['id_reserva'];
    $.ajax({
        type: 'get',
        url: '/validarFechaHora',
        data: {
            id_reserva: $reservas['id_reserva'],
            hora: 24,
            operacion: "reagendar"
        }
    })
        .done(function (data) {
            var dato = JSON.parse(data);

            if (dato == 1) {

                $.ajax({
                    type: "get",
                    url: "/getDatosReservaPagada",
                    data: {
                        id_reserva: $reservas['id_reserva']
                    }
                })
                    .done(function (data) {
                        var datos = JSON.parse(data);
                        var reserva = datos[0];

                        var servicio = datos[1];
                        var servivico_psicologo = datos[2];
                        document.getElementById("id_servicio").value = servicio['id_servicio'];
                        document.getElementById("nombre_servicio").value = servicio['nombre_servicio'];
                        var fechaAntigua = reserva['fecha'].split("-");
                        $("#mensajeHoras").remove();
                        $("#fechaAnterior").remove();
                        $("#horaAnterior").remove();
                        $("#datosAnteriores").append("<div class='col md-5' style=\'margin-top:-15px\' id='fechaAnterior'><p id='preFecha'>Fecha:" + fechaAntigua[2] + "-" + fechaAntigua[1] + "-" + fechaAntigua[0] + "<p> </div>");
                        $("#datosAnteriores").append("<div class='col md-5'  style=\'margin-top:-15px\' id='horaAnterior'><p id='preHora'>Hora:" + reserva['hora_inicio'] + " - " + reserva['hora_termino'] + "<p> </div>");
                        $.ajax({
                            type: "get",
                            url: "/getDiasDisponiblesPsicologo",
                            data: {
                                id_user_psicologo: servicio['id_user']
                            }
                        })
                            .done(function (data) {
                                var datosFecha = document.getElementById("fecha");
                                var datos = JSON.parse(data);
                                datosFecha.min = datos[1];
                                datosFecha.max = datos[0];
                                datosFecha.value = datos[1];
                                horasDisponible(datos[1], servivico_psicologo['id_psicologo'], servicio['id_user'], $reservas['id_paciente']);
                                $("#mensajeHoras").remove();
                                $("#mensajeHora").remove();
                            })

                        $("#fecha").on('change', function () {
                            var fechaS = $(this).val();
                            $("#mensajeHoras").remove();
                            $("#mensajeHora").remove();
                            horasDisponible(fechaS, servivico_psicologo['id_psicologo'], servicio['id_user'], $reservas['id_paciente']);
                        });
                        $("#modalReagendar").modal("show");
                    })
                    .fail(function (data) {
                    });
            } else {
                var msj = "No puede reagendar ya tiene -24Hrs"
                if(dato==3){
                    msj = "El Psicologo no Tiene Horas Disponibles";
                }
                swal({
                    title: "¡Lo sentimos!",
                    text: msj,
                    icon: "error",
                    buttons: {

                        confirm: {
                            text: "OK",
                            visible: true,
                            className: "claseMia",
                            closeModal: true
                        }

                    }
                })
            }

        });
}


/*Función donde se realiza un llamado ajax a la ruta ‘/horasPsicologo’, dónde está desplegará un combobox con las horas disponibles,
* de lo contrario notificará con un mensaje.*/
function horasDisponible(fechaSeleccionada, id_psicologo, id_user_psicologo, id_paciente) {
    $.ajax({
        type: "get",
        url: "/horasPsicologo",
        data: {
            fechaSeleccionada: fechaSeleccionada,
            id_psicologo: id_psicologo,
            id_user_psicologo: id_user_psicologo
        }
    })
        .done(function (data) {
            var horasD = JSON.parse(data);
            $("#mensajeHoras").remove();
            $("#div_horas").remove();
            if (horasD[0] != "NO TIENE HORAS DISPONIBLES") {

                var $horas = $('<div id="div_horas" class="mt-1" ><label for="horas" class="text-5 darkgray-text text-bold">Horas Disponibles</label>' +
                    "<select class='custom-select pl-3 pr-3 mt-1 text-4 bluegray-text' onchange='horas(" + id_paciente + ")' name='horas' id='horas'></select></div>");
                $("#nuevosDatos").append($horas);
                $("#horas").append($("<option value=''>Selecciona Nueva Hora</option>"));
                for (let i = 0; i < horasD.length; i++) {
                    $("#horas").append($("<option value='" + horasD[i] + "' class='text-4 bluegray-text'>" + horasD[i] + "</option>"));
                }
                gobal_id_psicologo = id_psicologo;
                gobal_id_user_psicologo = id_user_psicologo;
                global_id_paciente = id_paciente;
            } else {
                $("#div_horas").remove();
                $("#nuevosDatos").append($('<div style=\'margin-top:8px; opacity: 0.6\' class="alert alert-danger alert-dismissible" id="mensajeHoras"><a style="opacity: 1.0" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong style="opacity: 1.0">Ops!</strong> No hay hora disponible, seleccione otra fecha</div>'));
                document.getElementById("btnAgendax").disabled = true;

            }
        });
}


//operaciones confirmadas, algoritmo interno solo contempla metodos asociados a reserva
function confirmar(num, titulo, texto, mensaje, reserva = null) {
    var validador =false;
    swal({
        title: titulo,
        text: texto,
        icon: "warning",
        buttons: true,
        buttons: {

            cancel: {
                text: "Cancelar",
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: "OK",
                visible: true,
                className: "claseMia",
                closeModal: true
            }
        },
        dangerMode: false,
    })
        .then((willDelete) => {
            if (willDelete) {
                if (num == 1) {
                    var nuevaHora = $("#horas").val();
                    nuevaHora = nuevaHora.split('-');
                    var h_inicio = nuevaHora[0].trim() + ":00";
                    $.ajax({
                        type: 'get',
                        url: '/comprobacionYaTomadas',
                        data: {
                            fecha: $("#fecha").val(),
                            hora_inicioGet: h_inicio,
                            servicio_id: $("#id_servicio").val()
                        }
                    })
                        .done(function (data) {
                            var datos = JSON.parse(data);
                            if(datos==0){
                                agendar();
                                var nuevaFecha = document.getElementById('fecha').value;
                                var nuevaHora = document.getElementById('horas').value;
                                var retorno = conversorFecha(nuevaFecha);
                                document.getElementById('td_fecha' + document.getElementById('id_reserva').value).innerText = retorno;
                                document.getElementById('td_hora_inicio' + document.getElementById('id_reserva').value).innerText = nuevaHora;
                                notificaciones(mensaje);
                                var $modal = $('#modalReagendar');
                                $modal.modal('hide');

                            }else{
                                notificaciones("Ops!, Hora no disponible, seleccione otra");
                                var fecha = $("#fecha").val();
                                horasDisponible(fecha,gobal_id_psicologo,gobal_id_user_psicologo,global_id_paciente);
                            }
                        });
                } else {
                    cancelarReserva(reserva);
                    var idRes = reserva["id_reserva"];
                    document.getElementById("btn" + idRes).remove();
                    document.getElementById("td_cancelar" + idRes).innerText = "-";
                    document.getElementById("td_reg" + idRes).innerText = "-";
                    document.getElementById("td_conf" + idRes).innerText = "Cancelado";
                    notificaciones("Su Reserva fue Cancelada");

                }

            }
            else {
                notificaciones("Operación Cancelada");
            }
        });
}



//mensaje de alerta tipo sweetAlert
function notificaciones(mensaje){
    icono = "success";
    if(mensaje == "Ops!, Hora no disponible, seleccione otra" || mensaje == "Operación Cancelada"){
        icono = "";
    }
    swal(mensaje,{
        icon: icono,
        buttons: {
            confirm: {
                text: "OK",
                visible: true,
                className: "claseMia",
                closeModal: true
            }
        }
    });
}

// conversor de fechas a formato dd/mm/yyyy
function conversorFecha(fecha) {

    var current_datetime = fecha.split("-");
    var ano = current_datetime[0];
    var mes = current_datetime[1];
    var dia = current_datetime[2];

    var retorno = dia + '-' + mes + '-' + ano;
    return retorno;

}

$(document).ready(function() {
    $('#lista_reserva_paciente').DataTable( {
        "scrollX": true,
        "paginate": false,
        "dom": 'lrtp'
                
    } );
} );
