//Creacion de la Variable table con referencia al Datatable asignado en dashboardHorario con ID tablaHorario
var table = $('#tablaHorario').DataTable({
    "ajax": '/datatable/horario',
    "columns": [
        {data: 'id_horario_dia'},
        {data: 'id_horario'},
        {data: 'id_dia'},
        {data: 'lunes'},
        {data: 'martes'},
        {data: 'miercoles'},
        {data: 'jueves'},
        {data: 'viernes'},
        {data: 'sabado'},
        {data: 'domingo'},
        {data: null, render: function(data, type, row){
            //Comprobacion de dias de trabajo y transformacion a datos legibles
            diasT="";
            if (data.lunes == 1) {
                diasT= "L "
            }
            if (data.martes == 1) {
                diasT= diasT+"M "
            }
            if (data.miercoles == 1) {
                diasT= diasT+"X "
            }
            if (data.jueves == 1) {
                diasT= diasT+"J "
            }
            if (data.viernes == 1) {
                diasT= diasT+"V "
            }
            if (data.sabado == 1) {
                diasT= diasT+"S "
            }
            if (data.domingo == 1) {
                diasT= diasT+"D "
            }
            return diasT;
        }},
        {data: 'hora_entrada_am'},
        {data: 'hora_salida_am'},
        {data: 'hora_entrada_pm'},
        {data: 'hora_salida_pm'},
        //Agregar el boton de descripcion
        {"defaultContent": "<button type='button' class='btn btn-sm btnVer' data-toggle='modal' data-target='#modalDescripcionHorario'><i class='fas fa-eye' style='font-size:20px; color:#484AF0'></i></button>"},
        //Agrega el boton de Modificar
        {"defaultContent": "<button type='button' class='btn btn-sm btnEditar' data-toggle='modal' data-target='#modalEditarHorario'><i class='fas fa-edit' style='font-size:20px; color:#484AF0'></i></button>"},
        //Agrega el boton de Estado
        {data: null, render: function(data, type, row){
        //Realiza comprobacion de estado
            if(data.habilitado){
                return  "<button type='button' class='btn badge badge-success btn-sm btnEliminar'>Habilitado</button>"
            }else{
                return "<button type='button' class='btn badge badge-danger btn-sm btnEliminar'>Deshabilitado</button>"
            }
        }}
    ],
    //Agrega a las columnas la clase hide_me del CS para ocultarlas
    "aoColumnDefs": [ { "sClass": "hide_me", "aTargets": [0,1,2,3,4,5,6,7,8,9] } ],
    "autoWidth": false,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      },
    "order": [
        [2, "desc"]
    ],
});

//Inicializacion de datatable
$(document).ready(function () {
    table;
});

//Funcion de recarga de datos del DataTable
function fn_reloadTabla(){
    table.ajax.reload();
}

//listar los datos del modal agregar
$(document).on("click", ".btnAgregar", function () {
    fila = $(this).closest("tr");
    //Guarda los datos de la fila en variables
    id_horario_dia = fila.find('td:eq(0)').text();
    id_horario = fila.find('td:eq(1)').text();
    id_dia = fila.find('td:eq(2)').text();
    dia_lunes_trabajo = fila.find('td:eq(3)').text();
    dia_martes_trabajo = fila.find('td:eq(4)').text();
    dia_miercoles_trabajo = fila.find('td:eq(5)').text();
    dia_jueves_trabajo = fila.find('td:eq(6)').text();
    dia_viernes_trabajo = fila.find('td:eq(7)').text();
    dia_sabado_trabajo = fila.find('td:eq(8)').text();
    dia_domingo_trabajo = fila.find('td:eq(9)').text();
    hora_entrada_am = fila.find('td:eq(11)').text();
    hora_salida_am = fila.find('td:eq(12)').text();
    hora_entrada_pm = fila.find('td:eq(13)').text();
    hora_salida_pm = fila.find('td:eq(14)').text();
    //Agregando check a cada checkbox dependiendo si ese día esta habilitado a trabajar o no
    if (dia_lunes_trabajo == "1") {
        $("#diaLun").val(1);
        $("#diaLun").prop("checked", true);
    }
    if (dia_martes_trabajo == "1") {
        $("#diaMar").val(1);
        $("#diaMar").prop("checked", true);
    }
    if (dia_miercoles_trabajo == "1") {
        $("#diaMie").val(1);
        $("#diaMie").prop("checked", true);
    }
    if (dia_jueves_trabajo == "1") {
        $("#diaJue").val(1);
        $("#diaJue").prop("checked", true);
    }
    if (dia_viernes_trabajo == "1") {
        $("#diaVie").val(1);
        $("#diaVie").prop("checked", true);
    }
    if (dia_sabado_trabajo == "1") {
        $("#diaSab").val(1);
        $("#diaSab").prop("checked", true);
    }
    if (dia_domingo_trabajo == "1") {
        $("#diaDom").val(1);
        $("#diaDom").prop("checked", true);
    }
    //Se envian los datos recuperados arriba hacia el modal correspondiente
    $("#idHorarioDia").val(id_horario_dia);
    $("#idHorario").val(id_horario);
    $("#idDia").val(id_dia);
    $("#horaEntAM").val(hora_entrada_am);
    $("#horaSalAM").val(hora_salida_am);
    $("#horaEntPM").val(hora_entrada_pm);
    $("#horaSalPM").val(hora_salida_pm);
});

// Funcion para mostrar modal de alerta para confirmar (agregado)

function fn_agregar_horario() {
    //evita el submit automatico
    event.preventDefault();

    let form = event.target;

    //Creo un contador para validar
    var contador = 0;

    //Rescato las horas de trabajo
    var horaEntAMHora = $("#horaEntAM").val();
    var horaSalAMHora = $("#horaSalAM").val();
    var horaEntPMHora = $("#horaEntPM").val();
    var horaSalPMHora = $("#horaSalPM").val();
    var token = $("input[name=_token]").val();

    //separo las horas en 2 digitos y los guardo en variables
    DigEntAm1=horaEntAMHora.charAt(0);
    DigEntAm2=horaEntAMHora.charAt(1);
    DigEntAm3=horaEntAMHora.charAt(3);
    DigEntAm4=horaEntAMHora.charAt(4);

    DigSalAm1=horaSalAMHora.charAt(0);
    DigSalAm2=horaSalAMHora.charAt(1);
    DigSalAm3=horaSalAMHora.charAt(3);
    DigSalAm4=horaSalAMHora.charAt(4);

    DigEntPm1=horaEntPMHora.charAt(0);
    DigEntPm2=horaEntPMHora.charAt(1);
    DigEntPm3=horaEntPMHora.charAt(3);
    DigEntPm4=horaEntPMHora.charAt(4);

    DigSalPm1=horaSalPMHora.charAt(0);
    DigSalPm2=horaSalPMHora.charAt(1);
    DigSalPm3=horaSalPMHora.charAt(3);
    DigSalPm4=horaSalPMHora.charAt(4);

    //Uno las horas con los minutos para hacer un solo numero
    var numEnteroEntAM = DigEntAm1 + DigEntAm2 + DigEntAm3 + DigEntAm4;
    var numEnteroSalAM = DigSalAm1 + DigSalAm2 + DigSalAm3 + DigSalAm4;
    var numEnteroEntPM = DigEntPm1 + DigEntPm2 + DigEntPm3 + DigEntPm4;
    var numEnteroSalPM = DigSalPm1 + DigSalPm2 + DigSalPm3 + DigSalPm4;

    //Si existe un checkbox no marcado, muestrame un mensaje dentro de un div y aumenta el contador en 1, sino  vacia el div de mensajes
    if($("#diaLun").prop("checked") == false && $("#diaMar").prop("checked") == false && $("#diaMie").prop("checked") == false &&
    $("#diaJue").prop("checked") == false && $("#diaVie").prop("checked") == false && $("#diaSab").prop("checked") == false &&
    $("#diaDom").prop("checked") == false){
        contador = 1;
        document.getElementById("mensajeDiasAdd").innerHTML = "<div class='alert alert-danger'>Al menos un día debe estar habilitado</div>";
    }else{
        document.getElementById("mensajeDiasAdd").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaEntAM").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraEntAM").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigEntAm1>=1 && DigEntAm2>1) || (DigEntAm1==2)){//Valido que solo ingrese horas en AM
        contador = 1;
        document.getElementById("mensajeHoraEntAM").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango AM</div>";
    }else{
        document.getElementById("mensajeHoraEntAM").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaSalAM").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraSalAM").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigSalAm1>=1 && DigSalAm2>1) || (DigSalAm1==2)){//Valido que solo ingrese horas en AM
        contador = 1;
        document.getElementById("mensajeHoraSalAM").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango AM</div>";
    }else if(numEnteroEntAM >= numEnteroSalAM){//Valido que la hora entrada Am sea menor a la hora salida Am
        contador = 1;
        document.getElementById("mensajeHoraSalAM").innerHTML = "<div class='alert alert-danger'>La hora entrada AM debe ser menor a la salida AM</div>";
    }else{
        document.getElementById("mensajeHoraSalAM").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaEntPM").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraEntPM").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigEntPm1<=1 && DigEntPm2<2) || (DigEntPm1<1 && DigEntPm2>=2)){//Valido que solo ingrese horas PM
        contador = 1;
        document.getElementById("mensajeHoraEntPM").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango PM</div>";
    }else{
        document.getElementById("mensajeHoraEntPM").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaSalPM").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraSalPM").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigSalPm1<=1 && DigSalPm2<2) || (DigSalPm1<1 && DigSalPm2>=2)){//Valido que solo ingrese horas PM
        contador = 1;
        document.getElementById("mensajeHoraSalPM").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango PM</div>";
    }else if(numEnteroEntPM >= numEnteroSalPM){//Valido que la hora entrada Pm sea menor a la hora salida Pm
        contador = 1;
        document.getElementById("mensajeHoraSalPM").innerHTML = "<div class='alert alert-danger'>La hora entrada PM debe ser menor a la salida PM</div>";
    }else{
        document.getElementById("mensajeHoraSalPM").innerHTML = "";
    }

    //si el contador esta en cero, es decir no hay ningun error, enviame a la otra pantalla
    if(contador==0){
        //alerta de confirnmacion
        Swal.fire({
        title: '¿Desea Agregar este Horario?',
        text: 'Esta accion agregará los datos del sistema',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#484AF0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Agregar'
        }).then((result) => {
            //si se aceptan los cambios
            if (result.value) {
                //se envia el formulario al controlador
                $.ajax({
                   url: $('#formAdd').attr('action'),//se rescata la ruta del formulario
                   type: 'POST',//se enviaran los datos via post
                   data: $('#formAdd').serialize(),//se rescatan todos los input dentro del formulario para ser enviados
                   headers: {
                       'X-CSRF-TOKEN': $("input[name=_token]").val()//Asignando el token del formAdd
                       },
                   dataType: 'json',//Los datos seran enviados como tipo json
                   //En caso de ejecutarse el controlador correctamente
                   success:function(e){//Rescatar la variable de retorno
                       //si la variable de retorno es 0 (0=no agrego), quiere decir que exsisten horarios duplicados
                       if(e.mensaje == 0){
                           console.log(e);
                           //se modifican las opciones del mensaje en pantalla
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
                             //se muestra el mensaje en pantalla
                           toastr["warning"]("Ya existen horarios habilitados con estos dias", "Datos Duplicados");
                       }else{//sino, entonces no existen horarios duplicados y puede agregar
                           console.log(e);
                           //se recarga la tabla dinamicamente de horario
                           table.ajax.reload();
                           //se cierra el modal de Agregar
                           $("#modalAgregar .close").click()
                           //se modifica las opciones del mensaje en pantalla
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
                             //se muestra el mensaje en pantalla
                           toastr["success"]("Horario agregado!", "Exito");
                       }
                   },
                   //En caso de no ejecutarse correcatmente el controlador, avisara por consola el error
                   error:function(e){
                       alert("no funciona");
                       console.log(e);
                   }
               })
            }
        });
    }    
}

//Cuando el modal agregar sea cerrado o cancelado, no esten activados los checkbox
$(document).on("click", ".resetCheckAgregar", function() {
    $("diaLun").prop("checked", false);
    $("diaMar").prop("checked", false);
    $("diaMie").prop("checked", false);
    $("diaJue").prop("checked", false);
    $("diaVie").prop("checked", false);
    $("diaSab").prop("checked", false);
    $("diaDom").prop("checked", false);
});

//Funcion para vaciar los div que contienen mensajes del formulario agregar
$(document).on("click", ".resetMsjAgregar", function () {
    document.getElementById("mensajeDiasAdd").innerHTML = "";
    document.getElementById("mensajeHoraEntAM").innerHTML = "";
    document.getElementById("mensajeHoraSalAM").innerHTML = "";
    document.getElementById("mensajeHoraEntPM").innerHTML = "";
    document.getElementById("mensajeHoraSalPM").innerHTML = "";
});

function resetModalAgregar(){
    $("#formAdd").trigger("reset");
    $("#horaEntAM").prop("disabled", false);
    $("#horaSalAM").prop("disabled", false);
    $("#horaEntPM").prop("disabled", false);
    $("#horaSalPM").prop("disabled", false);
    //Establecer nuevamente como validos los campos
    $('#horaEntAM').removeClass("invalid").addClass("valid");
    $('#horaSalAM').removeClass("invalid").addClass("valid");
    $('#horaEntPM').removeClass("invalid").addClass("valid");
    $('#horaSalPM').removeClass("invalid").addClass("valid");
}