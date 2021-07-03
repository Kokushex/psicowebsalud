
(function () {
    // elementos inicializados como ocultos
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("contenedor_correo").style.display = "none";

    // configuración para token en cabeceras de llamadas Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



})();

var flag = 0;  // contador validante del botón siguiente del modal que registra la reserva
var comprobacion_prevision = 0;

// evento change del checkbox de terminos y condiciones
$("#condicionesid").on('change', function () {
    if (this.checked) {   // si está checkado.
        $("#nextBtn").hide();
        if ($("#hidenPrevision").val() == "") {
            $("#nextBtn").before('<button type="button" id="submit_1" onclick="comprobacionDiaHabilitado()" class="btn btn-block green white-text text-4"><i class="far fa-calendar-check fa-fw"></i>Ir a Pagar</button>');
        } else {
            $("#precio_particular_label").hide();
            $("#nextBtn").before('<button type="button" onclick="comprobacionDiaHabilitado()" id="submit_2" class="btn btn-block green white-text text-4"><i class="far fa-calendar-check fa-fw"></i>Reservar</button>');
        }
    } else {
        $("#submit_1").remove();
        $("#nextBtn").show();
    }
});

/* función que hace comprobación a través de Ajax para impedir choque de reservas por retraso
 de confirmación por parte del paciente, se ejecuta antes de confirmar la reserva  */
function comprobate(){
    var fechaSF = $("#fecha").val();

    $.ajax({
        type: 'get',
        url: '/comprobacionYaTomadas',
        data: {
            fecha: cambiarFormatoFecha(Date.parse(fechaSF)),
            hora_inicioGet: $("#hora_inicioGet").val(),
            servicio_id: $("#servicio_id").val()
        },
        datatype: 'json',
        success:function(e){
            var datos = JSON.parse(e);
            console.log(e);
            if(datos==0){

                var form = document.getElementById("modalForm");
                form.submit();

            }else{

                //manejar mensaje de error reserva ya tomada por demora
                alert('Lo siento, ha ocurrido un error, reserva con la misma fecha y hora ya ha sido tomada');

            }
        },
        error:function(e){
            console.log(e);
            console.log("malo");
        }
    });
}

/* función que hace una comprobación si el psicologo deshabilito un dia de su horario, mientras un paciente
esta en proceso de reservar una hora en ese día */
function comprobacionDiaHabilitado(){
    var fechaD = $("#verificacionD").val();
    var id = $("#id_psicologo_seleccionado").val();
    $.ajax({
        url: '/comprobacionDiaHabilitado',
        type: 'get',
        data: { fechaD: fechaD,
            id_psicologo: id
        },
        success:function(e){
            if(e != 0){
                comprobate();
            }else{
                //Modifica las opciones del mensaje en pantalla
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                //Muestra el mensaje en pantalla
                toastr["warning"]("El psicologo a deshabilitado este día, intente con otro","Dia Deshabilitado");

            }
        },
        error:function(e){
            console.log(e);
            console.log("malo");
        }
    });

}

// acciones al hacer click en el botón siguiente, modal para registrar reserva
$("#nextBtn").on('click', function () {

    flag += 1;
    document.getElementById("nextBtn").disabled = true;
    console.log(flag);
    if ($("#hidenHoras").val() == "si") {
        document.getElementById("nextBtn").disabled = false;

    }

    if (flag == 2) {
        document.getElementById("nextBtn").disabled = true;
        let checkCondiciones = document.getElementById("condicionesid");

        if (checkCondiciones.checked) {

            $("#nextBtn").hide();

            if ($("#hidenPrevision").val() == "") {
                $("#nextBtn").before('<button type="button" id="submit_1" onclick="comprobate()" class="btn btn-block green white-text text-4"><i class="far fa-calendar-check fa-fw"></i>Ir a Pagar</button>');
            } else {
                $("#nextBtn").before('<button type="button" onclick="comprobate()" id="submit_2" class="btn btn-block green white-text text-4"><i class="far fa-calendar-check fa-fw"></i>Reservar</button>');
            }

        } else {
            $("#submit_1").remove();
            $("#nextBtn").show();
        }

    }

    document.getElementById("prev").style.display = "none";
    $("#rutD").text($("#rut").val());
    $("#correoD").text($("#correo").val());
    $("#telefonoD").text($("#telefono").val());
    $("#nombreCompletoD").text($("#nombre").val() + " " + $("#apellido").val());


})

// acciones sujetas al botón "atrás" del modal|
$("#prevBtn").on('click', function () {

    flag -= 1;
    if (flag == 1) {

        document.getElementById("prev").style.display = "none";
        $("#submit").remove();
        $("#nextBtn").show();
    }

    if (flag == 0) {
        document.getElementById("prev").style.display = "block";
    }
})

// validación de rut en modal de reserva
window.validarRut = function (rut) {

    var flag = true;
    var msg = document.getElementById("msgRun");


    if (rut == "") {
        msg.style.display = "none";
        flag = false;
    } else {

        // si el rut es válido
        if (Fn.validaRut(rut)) {

            flag = true;
            msg.style.display = "none";
            msg.innerHTML = "";


        } else {
            msg.style.display = "block";
            msg.innerHTML = "El Rut no es válido";

            flag = false;
        }
    }

    return flag;
};



function validarEmail(valor, flag) {
    if (/^\w+([\.-]?\w+)*@(?:|hotmail|outlook|yahoo|live|gmail|prueba)\.(?:|com|es|cl)+$/.test(valor)) {
        document.getElementById("correo").style.borderColor = "";
    } else {
        flag = false;
        document.getElementById("correo").style.borderColor = "red";
    }
    return flag;
}

window.validarTelefono = function (telefono, flag) {
    if (telefono == "") {
        flag = false;
        document.getElementById("telefono").style.borderColor = "red";
    } else {
        document.getElementById("telefono").style.borderColor = "";
    }
    return flag;
}

window.validarNombre = function (nombre, flag) {
    if (nombre == "") {
        flag = false;
        document.getElementById("nombre").style.borderColor = "red";
    } else {
        document.getElementById("nombre").style.borderColor = "";
    }
    return flag;
}

window.validarApellido = function (apellido, flag) {
    if (apellido == "") {
        flag = false;
        document.getElementById("apellido").style.borderColor = "red";
    } else {
        document.getElementById("apellido").style.borderColor = "";
    }
    return flag;
}

// función click del primer botón siguiente que se muestra en el modal de la reserva
$("#button").on('click', function () {

    document.getElementById("nextBtn").disabled = true;

    if ($("#hidenModalidad").val() != "") {
        document.getElementById("nextBtn").disabled = false;
    }


    var rut = $("#rut").val();
    var email = $("#correo").val();
    var telefono = $("#telefono").val();
    var codigo = $("#codigo").val();
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    validar = validarRut(rut);
    if (validar != true) {
        document.getElementById("rut").style.borderColor = "red";
    } else {
        document.getElementById("rut").style.borderColor = "";
    }
    validar = validarEmail(email, validar);
    validar = validarTelefono(telefono, validar);
    validar = validarNombre(nombre, validar);
    validar = validarApellido(apellido, validar);
    if (validar == true) {

        var code = document.getElementById("slFiltro").value;
        var msg = document.getElementById("msgRun");

        /* algoritmo que verifica que el rut no ingresado no se encuentre ya registrado en la
         base de datos, esto se utiliza a la hora de crear una carga (paciente asociado) a través del modal  */
        if (code != 2) {
            var run = document.getElementById("rut").value;
            var id_paciente = document.getElementById("id_paciente_seleccionado").value;

            $.ajax({
                type: 'get',
                url: '/buscarRut',
                data: {
                    rut: run,
                    code: code,
                    id_paciente: id_paciente
                }
            })
                .done(function (data) {
                    var datos = JSON.parse(data);


                    if (datos == 0) {//el rut ya existe

                        msg.innerHTML = "";
                        avanceModalStep1();  // función que permite el avance en el step

                    } else {


                        msg.style.display = "block";
                        msg.innerHTML = "El rut ya está siendo utilizado en nuestros registros";

                    }
                });

        } else {

            msg.innerHTML = "";
            avanceModalStep1();
        }

    }
})


$("#prev").on('click', function () {
    document.getElementById("prev").style.display = "none";
    $("#estado_boton").remove();
    $("#h1").text("Identificación del paciente");
    document.getElementById("servicios").style.display = "none";
    document.getElementById("button").style.display = "block";
    document.getElementById("datos_rut").style.display = "block";
    document.getElementById("nextBtn").style.display = "none";
})


/* evento change de la fecha, captura su valor y cada vez que se cambie la fecha el botón
siguiente ha de quedar inhabilitado */
$("#fecha").on('changeDate', function (e) {
    var fechaSeleccionada = $(this).val();
    document.getElementById("nextBtn").disabled = true;
});


function avanceModalStep1() {

    $("#correoD").text($("#correo").val());
    $("#telefonoD").text($("#codigo").val() + $("#telefono").val());
    $("#h1").text("Seleccione su servicio");


    document.getElementById("servicios").style.display = "block";
    $("#nextBtn").before('<input type="hidden" id="estado_boton">');

    document.getElementById("button").style.display = "none";
    document.getElementById("datos_rut").style.display = "none";
    document.getElementById("nextBtn").style.display = "block";
    document.getElementById("prev").style.display = "block";

}


//función utilizada para validar boton siguiente y dar valores a inputs que almacenan horas y fechas
function funcionHoras() {
    var dropdown1 = document.getElementById('cbxHorasDisponibles');
    var a = dropdown1.options[dropdown1.selectedIndex];
    $("#mensajeHora").remove();
    if (a.index > 0) {
        var id_paciente = $("#id_paciente_seleccionado").val();

        $.ajax({
            type: "get",
            url: "/horarioPaciente",
            data: {
                id_paciente: id_paciente,
                fecha: $("#fecha").val(),
                hora_inicio: $("#cbxHorasDisponibles").val()
            }
        })
            .done(function (data) {
                var dato = JSON.parse(data);
                if (dato == 1) {

                    var $msjHora = $('<div style=\'margin-top:8px\' class="alert alert-warning alert-dismissible" id="mensajeHora"><a class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Ops!</strong> Esta hora ya esta reservada, intente con otra</div>')
                    $("#fechas").append($msjHora);
                    $("#hidenHoras").val("no");
                    document.getElementById("nextBtn").disabled = true;

                } else {
                    $("#mensajeHora").remove();
                    $("#hidenHoras").val("si");
                    document.getElementById("nextBtn").disabled = false;
                }
            });
    } else {
        $("#mensajeHora").remove();
        document.getElementById("nextBtn").disabled = true;
        $("#hidenHoras").val("no");
    }

    let str = $("#cbxHorasDisponibles").val();

    $("#hora_inicioD").text(str.slice(0, 5));
    $("#hora_inicioGet").val(str.slice(0, 5));

    let fecha = $("#fecha").val();

    var fechaMod = cambiarFormatoFecha(Date.parse(fecha));

    $("#fechaD").text(fechaMod);

}

function cambiarFormatoFecha(fecha) {
    var today = new Date(fecha);
    var dd = today.getDate();

    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10)
    {
        dd='0'+dd;
    }

    if(mm<10)
    {
        mm='0'+mm;
    }

    today = yyyy+'-'+mm+'-'+dd;
    return today;
}

var precio = 0;

// change del servicio psicologo, diferentes funciones sujetas a su selección
$("#servicio_id").on('change', function () {

    comprobacion_prevision = 0;
    $("#modalidad_id").remove();
    $("#centro_id").remove();
    $("#prevision_id").remove();
    $("#precio_id").remove();
    $("#fecha_id").remove();
    $("#servicioD").text($("#servicio_id option:selected").text());
    document.getElementById("nextBtn").disabled = true;
    $("#hidenModalidad").val("");
    var servicio_id = $(this).val();
    if ($.trim(servicio_id) != '') {
        var $modalidad = $('<div id="modalidad_id" class="mt-1" ><label for="modalidad" class="text-5 darkgray-text text-bold">Modalidad</label>' +
            "<select class='custom-select pl-3 pr-3 mt-1 text-4 bluegray-text' name='modalidad' id='modalidad'></select></div>");
        $("#servicios").append($modalidad);
        $("#modalidad").append($("<option value=''>Indica tu modalidad de atencion</option>"));

        // llamada que trae detalles del servicio
        $.ajax({
            type: "get",
            url: "/getDetailsServicio",
            data: {
                id: servicio_id
            }
        })
            .done(function (data) {
                var retorno = JSON.parse(data);
                var modalidad = retorno[0];
                var prevision = retorno[1];
                var $prevision = $('<div id="prevision_id" class="mt-1" ><label for="prevision" class="text-5 darkgray-text text-bold">Tipo de Pago</label>' +
                    "<select class='custom-select pl-3 pr-3 mt-1 text-4 bluegray-text' name='prevision'  id='prevision'></select></div>");
                $("#servicios").append($prevision);
                $("#prevision").append($("<option value='' class='text-4 bluegray-text'>Particular</option>"));
                if (prevision != "") {
                    for (let i = 0; i < prevision.length; i++) {
                        $("#prevision").append($("<option value='" + prevision[i] + "' class='text-4 bluegray-text'>" + prevision[i] + "</option>"));
                    }
                }
                for (let i = 0; i < modalidad.length; i++) {
                    $("#modalidad").append($("<option value='" + modalidad[i] + "' class='text-4 bluegray-text'>" + modalidad[i] + "</option>"));
                }

                $("#prevision").on('change', function () {
                    var previ = $(this).val();
                    //función ajax comprobador de no tener más de una con prevision no pagada..
                    $.ajax({
                        type: "get",
                        url: "/getCantidadReservasPrevision"
                    })
                        .done(function (data) {
                            var datos = JSON.parse(data);
                            comprobacion_prevision = datos;
                            if (comprobacion_prevision > 0 && previ != '') {

                                document.getElementById("nextBtn").disabled = true;
                                $("#prevision_id").append($('<div style=\'margin-top:8px\' class="alert alert-danger alert-dismissible" id="mensajePrevision"><a class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Ops!</strong> Lo sentimos, usted cuenta con una reserva con Previsión impaga </div>'));
                            } else {
                                comprobacion_prevision = 0;
                                $("#mensajePrevision").remove();
                                if ($("#hidenModalidad").val() != "") {
                                    document.getElementById("nextBtn").disabled = false;
                                }
                            }

                        });

                    // si no hay previsión seleccionada, cambia valores u oculta elementos
                    if (previ == '') {
                        $("#precio_id").show();
                        $("#previsionD").text("Particular");
                        $("#precioD").text(precio);
                        $("#hidenPrevision").val("");
                    } else {
                        $("#precio_id").hide();
                        $("#previsionD").text(previ);
                        $("#hidenPrevision").val($("#prevision").val());
                        $("#precio_id").hide();
                        $("#precioD").text("");
                    }
                });

            })
            .fail(function (data) {

            });

        $("#modalidad").on('change', function () {
            $('#precio_id').remove();
            $("#hidenModalidad").val("asdf");
            var dropdown1 = document.getElementById('modalidad');
            var a = dropdown1.options[dropdown1.selectedIndex];
            if(a.index > 0){
                // llamada para traer el precio de las modalidades
                $.ajax({
                    type:'get',
                    url:'/getPrecioModalidad',
                    data:{
                        modalidad: $(this).val(),
                        id_servicio: document.getElementById("servicio_id").value
                    }
                })
                    .done(function(data){
                        var datos = JSON.parse(data);//
                        var $precios = $('<div id="precio_id" class="mt-1" ><label for="preci" class="text-5 darkgray-text text-bold">Precio Particular</label></div>');
                        $("#servicios").append($precios);
                        $("#precio_id").show();
                        $("#precio_id").append($('<input id="precioServicio" type="text" readonly="true" class="form-control text-4 bluegray-text">'));
                        precio =  datos['precio'];
                        document.getElementById('precioServicio').value =precio;
                        $("#precioD").text($("#precioServicio").val());
                        $("#previsionD").text("Particular");
                    });
            }else{
                $('#precio_id').remove();
            }
            if (a.index == 0) {
                $("#hidenModalidad").val("");
            }
            if (a.index > 0 || $("#hidenModalidad").val() != "") {
                document.getElementById("nextBtn").disabled = false;
            } else {
                document.getElementById("nextBtn").disabled = true;
            }
            if (a.index == 0 || comprobacion_prevision > 0) {
                document.getElementById("nextBtn").disabled = true;
            }
            $("#centro_id").remove();
            $("#modalidadD").text($("#modalidad option:selected").text());
            var tipoModalidad = $("#modalidad").val();
            /*
            *
            * Modalidad Presencial
            *
            * */
            if (tipoModalidad == "Presencial") {
                var $centro = $('<div id="centro_id" class="mt-1" ><label for="centro" class="text-5 darkgray-text text-bold">Direccion de Atencion</label></div>');
                $("#servicios").append($centro);
                $.ajax({
                    type: "get",
                    url: "/getCentroServicio",

                    data: {
                        id: servicio_id
                    }

                })
                    .done(function (data) {
                        var datos = JSON.parse(data);
                        console.log(datos);
                        $("#centro_id").append($('<input id="datosCentro" type="text" readonly="true" class="form-control text-4 bluegray-text">'));
                        var nombre = document.getElementById('datosCentro');
                        nombre.value = datos;
                    })
                    .fail(function (data) {

                    });
            }
        });
        /* llamada para obtener los días disponibles de atención del psicólogo,
            el retorno es desplegado en el calendario
        */
        //     $.ajax({
        //         type: "get",
        //         url: "/getDiasDisponiblesPsicologo",
        //         data: {
        //             id_user_psicologo: $("#id_user_psicologo").val()
        //         }
        //     })
        //         .done(function (data) {
        //             var datosFecha = document.getElementById("fecha");
        //             var datos = JSON.parse(data);
        //             datosFecha.min = datos[1];
        //             datosFecha.max = datos[0];
        //             datosFecha.value = datos[1];
        //             mostrarHorasDisponibles(datos[1]);
        //         })
    }
    $("#hidenPrevision").val("");
    $("#precioD").text("");
});


// lógica aplicada a reserva para cargas
$("#slFiltro").on('change', function () {

    var fono = document.getElementById("telefono");
    var rut = document.getElementById("rut");
    var nombre = document.getElementById("nombre");
    var apellido = document.getElementById("apellido");
    var code = document.getElementById("slFiltro").value;

    switch (code) {
        case '3':  // en caso de crear una nueva carga (paciente asociado)

            if (document.getElementById("carga_id") != null) {
                document.getElementById("carga_id").remove();
            }

            document.getElementById("id_paciente_seleccionado").value = "0";
            document.getElementById("contenedor_carga").style.display = "none"
            document.getElementById("div_nombre").style.display = "block";
            document.getElementById("div_apellido").style.display = "block";
            document.getElementById("div_rut").style.display = "block";

            rut.readOnly = false;
            nombre.readOnly = false;
            apellido.readOnly = false;
            fono.value = "";
            rut.value = "";
            nombre.value = "";
            apellido.value = "";
            break;

        case '2':
            //en caso de ser una carga existente

            if (document.getElementById("carga_id") != null) {
                document.getElementById("carga_id").remove();
            }
            document.getElementById("div_nombre").style.display = "none";
            document.getElementById("div_apellido").style.display = "none";
            document.getElementById("div_rut").style.display = "none";

            // llamada para obtener los pacientes asociados del paciente titular
            $.ajax({
                type: "get",
                url: "/getCargasPacienteTitular"
            })
                .done(function (data) {
                    var datos = JSON.parse(data);

                    if (datos != "") {
                        document.getElementById("contenedor_carga").style.display = "block"
                        var $select_carga = $('<div id="carga_id" class="mt-1" ><label for="carga" class="text-5 darkgray-text text-bold">Seleccione Paciente (Rut | Nombre)</label>' +
                            "<select class='custom-select pl-3 pr-3 mt-1 text-4 bluegray-text' name='carga' onchange='cargaSelect()' id='carga'></select></div>");

                        $("#div_select").append($select_carga);

                        // generar options con los valores entregados, en este caso rut + nombre + apellido
                        for (let i = 0; i < datos.length; i++) {
                            $("#carga").append($("<option value='" + datos[i]["id_paciente"] + "' class='text-4 bluegray-text'>" + datos[i]["rut"] + " | " + datos[i]["nombre"] +' '+ datos[i]["apellido_paterno"] +"</option>"));
                        }

                        cargaDatos();

                    }

                })

            break;
        case '1':  // en caso de hacer una reserva para mi (paciente titular)
            rut.readOnly = true;
            nombre.readOnly = true;
            apellido.readOnly = true;

            document.getElementById("div_nombre").style.display = "block";
            document.getElementById("div_apellido").style.display = "block";
            document.getElementById("div_rut").style.display = "block";


            if (document.getElementById("carga_id") != null) {
                document.getElementById("carga_id").remove();
            }

            rut.value = document.getElementById("rutTitular").value;
            nombre.value = document.getElementById("nombreTitular").value;
            apellido.value = document.getElementById("apellidoTitular").value;
            fono.value = document.getElementById("fonoTitular").value;
            document.getElementById("id_paciente_seleccionado").value = document.getElementById("id_paciente_titular").value;


            break;

    }


});


// obtención de datos de una carga (paciente asociado) seleccionado en el Select
function cargaDatos() {

    var id_carga = document.getElementById("carga").value;
    document.getElementById("id_paciente_seleccionado").value = id_carga;

    $.ajax({
        type: "get",
        url: "/getDatosCarga",
        data: {
            id_carga: id_carga
        }
    })
        .done(function (data) {
            var datos = JSON.parse(data);
            document.getElementById("rut").value = datos["rut"];
            document.getElementById("telefono").value = datos["telefono"];
            document.getElementById("nombre").value = datos["nombre"];
            document.getElementById("apellido").value = datos["apellido_paterno"];


        })



}

//select  de la carga change carga
function cargaSelect() {

    cargaDatos();
}

// Valida el rut con su cadena completa "XXXXXXXX-X"
var Fn = {

    validaRut: function (rutCompleto) {
        rutCompleto = rutCompleto.replace("‐", "-");
        if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto))
            return false;
        var tmp = rutCompleto.split('-');
        var digv = tmp[1];
        var rut = tmp[0];
        if (digv == 'K') digv = 'k';

        return (Fn.dv(rut) == digv);
    },
    dv: function (T) {
        var M = 0, S = 1;
        for (; T; T = Math.floor(T / 10))
            S = (S + T % 10 * (9 - M++ % 6)) % 11;
        return S ? S - 1 : 'k';
    }
}


/**
 * Metodo para validar numero del rut
 * Este método contempla rut de 9 y 10 dígitos.
 *
 */
function soloNumerosRut(e) {
    var rut = document.getElementById("rut").value;
    if (rut.length < 7) {
        var key = window.Event ? e.which : e.keyCode;
        return key >= 48 && key <= 57;
    } else {
        var key = e.keyCode || e.which;
        var teclado = String.fromCharCode(key).toLowerCase();
        var letra = "123456789k0-";
        if (rut.length < 8) {
            if (letra.indexOf(teclado) == -1) {
                return false;
            }
        }
        if(rut.length == 8 && rut.indexOf("-") == 7){
            var letra = "123456789k0";
            document. getElementById("rut"). setAttribute("maxlength", "9");
            if (rut.length < 9) {
                if (letra.indexOf(teclado) == -1) {
                    return false;
                }
            }
        }
        if(rut.length == 9 && rut.indexOf("-") == 8){
            var letra = "123456789k0";
            document. getElementById("rut"). setAttribute("maxlength", "10");
            if (rut.length < 10) {
                if (letra.indexOf(teclado) == -1) {
                    return false;
                }
            }
        }
    }
}


/**
 * Metodo para permitir solo letras con o sin espacios
 */
function sololetras(e, espace) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = "qwertyuiopasdfghjklñzxcvbnm ";
    especiales = "8-37-38-46-164";
    teclado_especial = false;

    for (var i in especiales) {
        if (key == especiales[i]) {
            teclado_especial = true;
            break;
        }
    }

    if (espace == true) {
        if (e.keyCode == 32) {
            return false;
        }
    }

    if (letras.indexOf(teclado) == -1 && !teclado_especial) {
        return false;
    }
}



// función que permite solo el ingreso de números en los imput.
function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}

/**
 *Funcion para rescatar los dias deshabilitados y dar restriccion de tiempo en el datepicker
 */
$(document).ready( function () {
    var id=$("#id_psicologo_seleccionado").val();
    $.ajax({
        url: '/obtenerDiasDisponibles',
        type: 'POST',
        data: { id_psicologo: $("#id_psicologo_seleccionado").val() },
        dataType: 'json',
        success:function(e){
            $diasT='';
            if (e.lunes == 0) {
                $diasT= '1,';
            }
            if (e.martes == 0) {
                $diasT = $diasT+"2,";
            }
            if (e.miercoles == 0) {
                $diasT = $diasT+"3,";
            }
            if (e.jueves == 0) {
                $diasT = $diasT+"4,";
            }
            if (e.viernes == 0) {
                $diasT = $diasT+"5,";
            }
            if (e.sabado == 0) {
                $diasT = $diasT+"6,";
            }
            if (e.domingo == 0) {
                $diasT = $diasT+"0";
            }
            //console.log($diasT);
            $('#fecha').datepicker({
                daysOfWeekDisabled: $diasT,
                todayHighlight:	true,
                language: 'es',
                startDate: '+1d',
                endDate: '+90d'
            });

        },
        error:function(e){
            console.log(e);
        }
    })

})

/**
 *Personalizacion del DatePicker
 */
$.fn.datepicker.dates['es'] = {
    days:  ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    daysShort: ["Dom","Lun","Mar","Mié","Juv","Vie","Sáb"],
    daysMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sá"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene","Feb","Mar","Abr", "May","Jun","Jul","Ago","Sep", "Oct","Nov","Dic"],
    today: "Hoy",
    clear: "Limpiar",
    //  format: "mm-dd-yyyy",
    titleFormat: "mm yyyy", /* Leverages same syntax as 'format' */
    weekStart: 1
};

/**
 *Funcion que cuando cambia la fecha haga visible el bloque horario y oculte la hora
 */
$("#fecha").change(function(e) {
    var element2 = document.getElementById("divBloqueHorario");
    var element = document.getElementById("divHorasList");
    element2.classList.remove("hide-me");
    element.classList.add("hide-me");
    document.ready = document.getElementById("cbxTipoHorario").value = '';

});

/**
 *Funcion que cuando cambia el bloque horario a valor null, oculte las horas y deshabilita el boton siguiente
 */
$("#cbxTipoHorario").change(function(e) {

    var select = document.getElementById('cbxTipoHorario');
    select.addEventListener('change',
        function(){
            var selectedOption = this.options[select.selectedIndex];
            if(selectedOption.value==""){
                var element = document.getElementById("divHorasList");
                element.classList.add("hide-me");
                document.getElementById("nextBtn").disabled = true;
            }
        });

});


/* Cada vez que el paciente eliga un bloque am o pm, se ejecutara un ajax para rellenar el combobox
de horas dispoibles del psicologo */
let dias = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
$( "#cbxTipoHorario" ).change(function(e) {
    let date  = new Date(document.getElementById("fecha").value);
    var bloqueHorario = $("#cbxTipoHorario").val();
    var id=$("#id_psicologo_seleccionado").val();

    $("#verificacionD").text(""+dias[date.getDay()]);
    $("#verificacionD").val(""+dias[date.getDay()]);
    if($("#cbxTipoHorario").val()!==""){
        $.ajax({
            url: '/obtenerHorasDisponibles',
            type: 'POST',
            data: { bloque: bloqueHorario,
                dias: dias[date.getDay()],
                id_psicologo:id
            },
            dataType: 'json',
            success:function(e){
                var element = document.getElementById("divHorasList");
                element.classList.remove("hide-me");
                var opciones =" ";
                opciones = opciones+'<option value="">Seleccione una hora</option>'
                for (let index = 0; index < e.length; index++) {
                    opciones = opciones+'<option value="'+e[index]+'">'+e[index]+'</option>'
                }
                $("#cbxHorasDisponibles").html("").append(opciones);
                console.log("bueno");
            },
            error:function(e){
                console.log(e);
                console.log("malo");
            }
        })
    }
});



