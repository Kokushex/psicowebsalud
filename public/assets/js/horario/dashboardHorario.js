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
                       //si la variable de retorno es 0 (0=no agrego), quiere decir que existen horarios duplicados
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
                           $("#modalAgregarHorario .close").click()
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
                   //En caso de no ejecutarse correctamente el controlador, avisara por consola el error
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

//Listar datos en modal editar

//Captura los datos de la fila en la cual fue accionada la funcion
$(document).on("click", ".btnEditar", function () {
    fila = $(this).closest("tr");
    //guarda los datos de la fila en variables
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
        $("#diaLunEdit").val(1);
        $("#diaLunEdit").prop("checked", true);
    }
    if (dia_martes_trabajo == "1") {
        $("#diaMarEdit").val(1);
        $("#diaMarEdit").prop("checked", true);
    }
    if (dia_miercoles_trabajo == "1") {
        $("#diaMieEdit").val(1);
        $("#diaMieEdit").prop("checked", true);
    }
    if (dia_jueves_trabajo == "1") {
        $("#diaJueEdit").val(1);
        $("#diaJueEdit").prop("checked", true);
    }
    if (dia_viernes_trabajo == "1") {
        $("#diaVieEdit").val(1);
        $("#diaVieEdit").prop("checked", true);
    }
    if (dia_sabado_trabajo == "1") {
        $("#diaSabEdit").val(1);
        $("#diaSabEdit").prop("checked", true);
    }
    if (dia_domingo_trabajo == "1") {
        $("#diaDomEdit").val(1);
        $("#diaDomEdit").prop("checked", true);
    }
    //Asigno los valores recuperados de la tabla al modal Editar Horario
    $("#idHorarioDia").val(id_horario_dia);
    $("#idHorario").val(id_horario);
    $("#idDia").val(id_dia);
    $("#horaEntAMEdit").val(hora_entrada_am);
    $("#horaSalAMEdit").val(hora_salida_am);
    $("#horaEntPMEdit").val(hora_entrada_pm);
    $("#horaSalPMEdit").val(hora_salida_pm);
});

//Funcion para mostrar los datos en el modal y editar el horario
function fn_editar_horario() {

    //evita el submit automatico
    event.preventDefault();
    let form = event.target;

    //creo un contador para validar
    var contador = 0;

    //Rescato las horas de trabajo
    var horaEntAMHora = $("#horaEntAMEdit").val();
    var horaSalAMHora = $("#horaSalAMEdit").val();
    var horaEntPMHora = $("#horaEntPMEdit").val();
    var horaSalPMHora = $("#horaSalPMEdit").val();

    //Separo las horas en 2 digitos y los guardo en variables
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

    //Valido que si existe ningun checkbox marcado, que me lanze una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#diaLunEdit").prop("checked") == false && $("#diaMarEdit").prop("checked") == false && $("#diaMieEdit").prop("checked") == false &&
    $("#diaJueEdit").prop("checked") == false && $("#diaVieEdit").prop("checked") == false && $("#diaSabEdit").prop("checked") == false &&
    $("#diaDomEdit").prop("checked") == false){
        contador = 1;
        document.getElementById("mensajeDiasEdit").innerHTML = "<div class='alert alert-danger'>Al menos un día debe estar habilitado</div>";
    }else{
        document.getElementById("mensajeDiasEdit").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaEntAMEdit").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraEntAMEdit").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigEntAm1>=1 && DigEntAm2>1) || (DigEntAm1==2)){//Valido que solo ingrese horas en AM
        contador = 1;
        document.getElementById("mensajeHoraEntAMEdit").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango AM</div>";
    }else{
        document.getElementById("mensajeHoraEntAMEdit").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaSalAMEdit").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraSalAMEdit").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigSalAm1>=1 && DigSalAm2>1) || (DigSalAm1==2)){//Valido que solo ingrese horas en AM
        contador = 1;
        document.getElementById("mensajeHoraSalAMEdit").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango AM</div>";
    }else if(numEnteroEntAM >= numEnteroSalAM){//Valido que la hora entrada Am sea menor a la hora salida Am
        contador = 1;
        document.getElementById("mensajeHoraSalAMEdit").innerHTML = "<div class='alert alert-danger'>La hora entrada AM debe ser menor a la salida AM</div>";
    }else{
        document.getElementById("mensajeHoraSalAMEdit").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaEntPMEdit").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraEntPMEdit").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigEntPm1<=1 && DigEntPm2<2) || (DigEntPm1<1 && DigEntPm2>=2)){//Valido que solo ingrese horas PM
        contador = 1;
        document.getElementById("mensajeHoraEntPMEdit").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango PM</div>";
    }else{
        document.getElementById("mensajeHoraEntPMEdit").innerHTML = "";
    }

    //Valido si es que el valor dentro del input time esta vacio, muestre una alerta y que el contador sea 1, sino, que limpie el div de mensajes
    if($("#horaSalPMEdit").val()==""){
        contador = 1;
        document.getElementById("mensajeHoraSalPMEdit").innerHTML = "<div class='alert alert-danger'>Debe elegir una hora</div>";
    }else if((DigSalPm1<=1 && DigSalPm2<2) || (DigSalPm1<1 && DigSalPm2>=2)){//Valido que solo ingrese horas PM
        contador = 1;
        document.getElementById("mensajeHoraSalPMEdit").innerHTML = "<div class='alert alert-danger'>Hora incorrecta, debe estar en el rango PM</div>";
    }else if(numEnteroEntPM >= numEnteroSalPM){//Valido que la hora entrada Pm sea menor a la hora salida Pm
        contador = 1;
        document.getElementById("mensajeHoraSalPMEdit").innerHTML = "<div class='alert alert-danger'>La hora entrada PM debe ser menor a la salida PM</div>";
    }else{
        document.getElementById("mensajeHoraSalPMEdit").innerHTML = "";
    }

    //si el contador esta en cero, es decir no hay ningun error, enviame a la otra pantalla
    if(contador==0){

     //alerta de confirnmacion
     Swal.fire({
     title: '¿Desea Editar este Horario?',
     text: 'Esta accion actualizara los datos del sistema',
     type: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#484AF0',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Editar'
     }).then((result) => {
         //si se aceptan los cambios
         if (result.value) {
            $.ajax({
                url: $('#formEditarHorario').attr('action'),//se rescata la ruta del formulario
                type: 'POST',//se enviaran los datos via post
                data: $('#formEditarHorario').serialize(),//se rescatan todos los input dentro del formulario para ser enviados
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()//Asignando el token del formEditarHorario
                    },
                dataType: 'json',//Los datos seran enviados como tipo json
                //En caso de ejecutarse el controlador correctamente
                success:function(e){//Rescatar la variable de retorno
                    //si la variable de retorno es 0 (0=no edito), quiere decir que existen horarios duplicados
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
                    }else{//sino, entonces no existen horarios duplicados y puede editar
                        console.log(e);
                        //se recarga la tabla dinamicamente de horario
                        table.ajax.reload();
                        //se cierra el modal de editar
                        $("#modalEditarHorario .close").click()
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
                        toastr["success"]("Horario editado!", "Exito");
                    }
                },//En caso de no ejecutarse correctamente el controlador, avisara por consola el error
                error:function(e){
                    alert("no funciona");
                    console.log(e);
                }
            })
         }
     });
    }
}

//Cuando el modal editar sea cerrado o cancelado, no esten activados los checkbox
$(document).on("click", ".resetCheckEditar", function () {
    $("#diaLunEdit").prop("checked", false);
    $("#diaMarEdit").prop("checked", false);
    $("#diaMieEdit").prop("checked", false);
    $("#diaJueEdit").prop("checked", false);
    $("#diaVieEdit").prop("checked", false);
    $("#diaSabEdit").prop("checked", false);
    $("#diaDomEdit").prop("checked", false);
});

//Funcion para vaciar los div que contienen mensajes del formulario editar
$(document).on("click", ".resetMsjEditar", function () {
    document.getElementById("mensajeDiasEdit").innerHTML = "";
    document.getElementById("mensajeHoraEntAMEdit").innerHTML = "";
    document.getElementById("mensajeHoraSalAMEdit").innerHTML = "";
    document.getElementById("mensajeHoraEntPMEdit").innerHTML = "";
    document.getElementById("mensajeHoraSalPMEdit").innerHTML = "";
});

$(document).on("click", ".btnEliminar", function () {
    var fila = 0;
    fila = $(this).closest("tr");
    //Rescata los datos de la Fila y los agrega a una Variable para poder enviarlos a la ruta
    var dataHorario = new FormData();
    dataHorario.append('id_horario_dia', fila.find('td:eq(0)').text());
    dataHorario.append('diaLun', fila.find('td:eq(3)').text());
    dataHorario.append('diaMar', fila.find('td:eq(4)').text());
    dataHorario.append('diaMie', fila.find('td:eq(5)').text());
    dataHorario.append('diaJue', fila.find('td:eq(6)').text());
    dataHorario.append('diaVie', fila.find('td:eq(7)').text());
    dataHorario.append('diaSab', fila.find('td:eq(8)').text());
    dataHorario.append('diaDom', fila.find('td:eq(9)').text());
    //alert("ID_HORARIO_DIA: "+ id_horario_dia)
    let form = event.target;
    //alerta de confirmacion
    Swal.fire({
        title: '¿Seguro que desea Cambiar este estado?',
        text: 'Esta accion agregará los datos del sistema',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#484AF0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Cambiar'
    }).then((result) => {
        //si se aceptan los cambios
        if (result.value) {
            //se envia el formulario al controlador
            $.ajax({
                url: '/horario/cambiarHorarioAjax',
                //Enviar los datos via post
                type: 'POST',
                //Se asignan los datos a enviar
                data: dataHorario,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                },
                dataType: 'json',
                success:function(e){
                    //Rescatar la variable de retorno
                    //si la variable de retorno es 0 (0=no modifico estado), quiere decir que existen horarios en conflicto
                    if(e.mensaje == 0){
                        console.log(e);
                        toastr.options = {
                            //Modifica las opciones del mensaje en pantalla
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
                        //Muestro el mensaje en pantalla
                        toastr["warning"]("Ya existe un día habilitado, porfavor deshabilitar.", "Días en Conflicto");
                    }else{
                        //si se realizo con exito
                        console.log(e);
                        //Recarga la tabla dinamicamente de horario
                        table.ajax.reload();
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
                        toastr["success"]("¡Cambio de estado realizado con Exito!");
                    }
                },
                error:function(e){
                   //En caso de no ejecutarse correcatmente el controlador, avisara por consola el error
                    alert("no funciona");
                   console.log(e);
                }
            })
        }
    });
});

$(document).on("click", ".btnVer", function () {
    var fila = $(this).closest("tr");
    var textDias= "";
    var textHoras= "";
    if(fila.find('td:eq(3)').text()=='1'){
        textDias = "Lunes <br>"
    }
    if(fila.find('td:eq(4)').text()=='1'){
        textDias = textDias +"Martes <br>"
    }
    if(fila.find('td:eq(5)').text()=='1'){
        textDias = textDias +"Miercoles <br>"
    }
    if(fila.find('td:eq(6)').text()=='1'){
        textDias = textDias +"Jueves <br>"
    }
    if(fila.find('td:eq(7)').text()=='1'){
        textDias = textDias +"Viernes <br>"
    }
    if(fila.find('td:eq(8)').text()=='1'){
        textDias = textDias +"Sabado <br>"
    }
    if(fila.find('td:eq(9)').text()=='1'){
        textDias = textDias +"Domingo "
    }
    textHoras= "<a><b>Hora de Entrada AM:</b> "+fila.find('td:eq(11)').text()+"</a><br>";
    textHoras = textHoras + "<a><b>Hora de Salida AM:</b> "+fila.find('td:eq(12)').text()+"</a><br>";
    textHoras = textHoras + "<a><b>Hora de Entrada PM:</b> "+fila.find('td:eq(13)').text()+"</a><br>";
    textHoras = textHoras + "<a><b>Hora de Salida PM:</b> "+fila.find('td:eq(14)').text()+"</a><br>";
    $("#diasTrabajo").html("").append(textDias);
    $("#horasTrabajo").html("").append(textHoras);
});