//Creacion de la Variable table con referencia al Datatable asignado en dashboardServicio con ID tablaServicio
var table = $('#tablaServicio').DataTable({
    "ajax": '/datatable/servicio',
    "columns": [
        {data: 'id_servicio_psicologo'},
        {data: 'nombre'},
        {"defaultContent": "<button type='button' class='btn btn-sm btnVer' data-toggle='modal' data-target='#modalDescripcion'><i class='fas fa-eye' style='font-size:20px; color:#484AF0'></i></button>"},
        {"defaultContent": "<button type='button' class='btn btn-sm btnEditar' id='btnEditarTabla' data-toggle='modal' data-target='#modalEditarServicio'><i class='fas fa-edit' style='font-size:20px; color:#484AF0'></i></button>"},
        {data: null, render: function(data, type, row){
                if(data.estado_servicio){
                    return  "<button type='button' class='btn badge badge-success btn-sm btnEstado'>Habilitado</button>"
                }else{
                    return "<button type='button' class='btn badge badge-danger btn-sm btnEstado'>Deshabilitado</button>"
                }
            }
        }
    ],
    "aoColumnDefs": [ { "sClass": "hide_me", "aTargets": [0] } ],
    "autoWidth": false,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    "order": [
        [2, "desc"]
    ],

});

//funcion para agregar servicios
function agregarServicio() {
    event.preventDefault();
    if(comprobacionTotal()==false){
        return false
    }else{
        Swal.fire({
            title: '¿Seguro que desea agregar este servicio?',
            text: 'Esta accion agregará los datos al sistema',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#484AF0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.getElementById("txtPrecioModPresencialServicio").disabled = false;
                document.getElementById("txtPrecioModOnlineServicio").disabled = false;
                var texto = $("#txtNombreServicio").find('option:selected').text(); // Capturamos el texto del option seleccionado
                var data = $('#formAdd').serializeArray();
                data.push({name: "textoOption", value: texto});

                $.ajax({
                    url: $('#formAdd').attr('action'),
                    type: 'POST',
                    data: $.param(data),
                    headers: {
                        'X-CSRF-TOKEN': $("input[name=_token]").val()
                    },
                    dataType: 'json',
                    success:function(e){
                        console.log(e);
                        toastr["success"]("Servicio Agregado Exitosamente", "Agregar");
                        $("#modalAgregarServicio .close").click()
                        table.ajax.reload();
                        actualizarSelect2();
                        resetModalAgregar();
                        bloquearCampos();

                    },
                    error:function(e){
                        console.log(e);
                    }
                })
            }
        });
    }
}

//Funcion que comprueba si al menos hay una modalidad activada con su respectivo precio
function comprobacionTotal(){
    resetMensajes();
    if(($("#chxModPresencialServicio").prop("checked") && $("#txtPrecioModPresencialServicio").val()>0)
        || ($("#chxModOnlineServicio").prop("checked") && $("#txtPrecioModOnlineServicio").val()>0)
        ){
        return true;
    }else{
        document.getElementById("mensajeAdd5").innerHTML = "<div class='alert alert-danger'>Al menos debe haber una modalidad activada con su precio mayor a 0</div>";
        return false;
    }
}

//Funcion que limpia los mensajes
function resetMensajes(){
    document.getElementById("mensajeAdd1").innerHTML = "";
    document.getElementById("mensajeAdd2").innerHTML = "";
    document.getElementById("mensajeAdd3").innerHTML = "";
    document.getElementById("mensajeAdd4").innerHTML = "";
    document.getElementById("mensajeAdd5").innerHTML = "";
}

//Funcion que resetea el modal agregar
function resetModalAgregar(){
    $("#formAdd").trigger("reset");
    $("#txtPrecioModPresencialServicio").prop("disabled", true);
    $("#txtPrecioModOnlineServicio").prop("disabled", true);
    $("#prevBtn").click();
    document.getElementById("txtNombreServicio").focus();
}

//Funcion para bloquear campos
function bloquearCampos(){
    $("#cbxEstadoServicio").prop("disabled", true);
    $("#txtDesGeneralServicio").prop("disabled", true);
    $("#txtaDesPersonalServicio").prop("disabled", true);
    $("#chxModPresencialServicio").prop("disabled", true);
    $("#chxModOnlineServicio").prop("disabled", true);
    $("#txtPrecioModPresencialServicio").prop("disabled", true);
    $("#txtPrecioModOnlineServicio").prop("disabled", true);
    $("#txtPrecioModVisitaServicio").prop("disabled", true);
    $("#nextBtn").prop("disabled", true);
}
//Funcion para desbloquear campos
function desbloquearCampos(){
    $("#cbxEstadoServicio").prop("disabled", false);
    $("#txtDesGeneralServicio").prop("disabled", false);
    $("#txtaDesPersonalServicio").prop("disabled", false);
    $("#chxModPresencialServicio").prop("disabled", false);
    $("#chxModOnlineServicio").prop("disabled", false);
    $("#txtPrecioModPresencialServicio").prop("disabled", true);
    $("#txtPrecioModOnlineServicio").prop("disabled", true);
    $("#txtPrecioModVisitaServicio").prop("disabled", true);
    $("#nextBtn").prop("disabled", false);
}

//funcion para que un input solo acepte numeros
function soloNumerosPrecioModalidad(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}

//función que permite verificar el valor del checkbox,
//de ser falso deshabilita la opción de ingresar un valor a la modalidad
function comprobarPresencial(){
    if($("#presencialEdit").prop("checked") == false){
        document.getElementById('presencialPrecioEdit').disabled=true;
    }else{
        document.getElementById('presencialPrecioEdit').disabled=false;
    }if ($("#onlineEdit").prop("checked") == false) {
        document.getElementById('onlinePrecioEdit').disabled=true;
    } else {
        document.getElementById('onlinePrecioEdit').disabled=false;
    }
}

/*
Funcion para traer los datos mediante el id y poder ubicarlos en el formulario de editar,
al realizar click en el boton modificar de la tabla
*/

$(document).on("click", ".btnEditar", function () {
    fila = $(this).closest("tr");
    var dataServicio = new FormData();
    dataServicio.append('id_servicio_psicologo', fila.find('td:eq(0)').text());
    $.ajax({
        url: '/servicios/detallesServicios',
        type: 'POST',
        data: dataServicio,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $("input[name=_token]").val()
        },
        dataType: 'json',
        success:function(e){
            console.log(e);
            //Rescatar la variable de retorno
            $("#id_servicio_psicologo").val(fila.find('td:eq(0)').text());
            $("#id_modalidad_servicio").val(e[0].id_modalidad_servicio);
            $("#id_modalidad_precio").val(e[0].id_precio_modalidad);

            $("#servicioEdit").val(e[0].nombre);
            $("#descripcionPersonalEdit").val(e[0].descripcion);
            var presencialEdit = e[0].presencial;
            var onlineEdit = e[0].online;
            $("#presencialPrecioEdit").val(e[0].precio_presencial);
            $("#onlinePrecioEdit").val(e[0].precio_online);
            if (presencialEdit == "1") {
                $("#presencialEdit").prop("checked", true);
                $("#presencialPrecioEdit").prop("disabled", false);
            }else{
                $("#presencialEdit").prop("checked", false);
                $("#presencialPrecioEdit").prop("disabled", true);
            }
            if (onlineEdit == "1") {
                $("#onlineEdit").prop("checked", true);
                $("#onlinePrecioEdit").prop("disabled", false);
            }else{
                $("#onlineEdit").prop("checked", false);
                $("#onlinePrecioEdit").prop("disabled", true);
            }
        },
        error:function(e){
            alert("no funciona");
            console.log(e);
        }
    })
});

//funcion para editar los campos desde el modal
function fn_editar_servicio(){
    //evita el submit automatico
    event.preventDefault();
    let form = event.target;
    //creo un contador para validar
    var contador = 0;
    if($("#presencialPrecioEdit").val()==""){
        contador = 1;
        document.getElementById("mensajePrecioPresencial").innerHTML = "<div class='alert alert-danger'>Debe ingresar un valor a la modalidad</div>";
    }else{
        document.getElementById("mensajePrecioPresencial").innerHTML ="";
    }

    if($("#onlinePrecioEdit").val()==""){
        contador = 1;
        document.getElementById("mensajePrecioOnline").innerHTML = "<div class='alert alert-danger'>Debe ingresar un valor a la modalidad</div>";
    }else{
        document.getElementById("mensajePrecioOnline").innerHTML ="";
    }

    if(contador==0){
        Swal.fire({
            title: '¿Desea Editar este Servicio?',
            text: 'Esta accion actualizará los datos del sistema',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#484AF0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.getElementById("presencialPrecioEdit").disabled = false;
                document.getElementById("onlinePrecioEdit").disabled = false;
                $.ajax({
                    url: $('#formEditarServicio').attr('action'),
                    type: 'POST',
                    data: $('#formEditarServicio').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $("input[name=_token]").val()
                    },
                    dataType: 'json',//Los datos seran enviados como tipo json
                    //En caso de ejecutarse el controlador correctamente
                    success:function(e){//Rescatar la variable de retorno
                        //Muestro el mensaje ne pantalla
                        toastr["success"]("Servicio Editado Exitosamente", "Editar");
                        $("#modalEditarServicio .close").click()
                        table.ajax.reload();
                        console.log(e);
                    },//En caso de no ejecutarse correcatmente el controlador, avisara por consola el error
                    error:function(e){
                        alert("no funciona");
                        console.log(e);
                    }
                })
            }
        });
    }
}
//resetea el modal en caso de no ingresar valores a los campos precios
$(document).on("click", ".resetMsjEditarServicio", function () {
    document.getElementById("mensajePrecioPresencial").innerHTML = "";
    document.getElementById("mensajePrecioOnline").innerHTML = "";
});
//función que permite resetear los checkbox al cerrar el modal
$(document).on("click", ".resetCheckEditarServicio", function () {
    $("#presencialEdit").prop("checked", false);
    $("#onlineEdit").prop("checked", false);
});

//Funcion para cambiar el estado del servicio
$(document).on("click", ".btnEstado", function () {
    var fila = 0;
    fila = $(this).closest("tr");
    var dataServicio = new FormData();
    dataServicio.append('id_servicio_psicologo', fila.find('td:eq(0)').text());
    let form = event.target;
    Swal.fire({
        title: '¿Seguro que desea Cambiar este estado?',
        text: 'Esta accion agregará los datos del sistema',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#484AF0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Cambiar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/servicios/cambiarEstado',
                type: 'POST',
                data: dataServicio,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                },
                dataType: 'json',
                success:function(e){
                    table.ajax.reload();
                    toastr["success"]("¡Cambio de estado realizado con Exito!");
                },
                error:function(e){
                    alert("no funciona");
                    console.log(e);
                }
            })
        }
    });
});


//Funcion para mostrar a tra ves del modal descripcion los detalles del servicio
$(document).on("click", ".btnVer", function () {
    var fila = 0;
    fila = $(this).closest("tr");
    var dataServicio = new FormData();
    dataServicio.append('id_servicio_psicologo', fila.find('td:eq(0)').text());
    $.ajax({
        url: '/servicios/detallesServicios',
        type: 'POST',
        data: dataServicio,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $("input[name=_token]").val()
        },
        dataType: 'json',
        success:function(e){
            $("#nomServicio").html("").append(e[0].nombre);
            $("#descServicio").html("").append(e[0].descripcion_particular);
            $("#precPresencial").html("").append(e[0].precio_presencial);
            $("#precOnline").html("").append(e[0].precio_online);
            var precioPresencial = (e[0].precio_presencial);
            var precioOnline = (e[0].precio_online);
            console.log(e[0].nombre);
            console.log(e[0].descripcion_particular);
            console.log(precioPresencial);
            console.log(precioOnline);
            if(precioPresencial > 0){

                $("#dispPresencial").html("").append("Disponible");
            }else{
                $("#dispPresencial").html("").append("No Disponible");
            }
            if(precioOnline > 0){

                $("#dispOnline").html("").append("Disponible");
            }else{
                $("#dispOnline").html("").append("No Disponible");
            }
        },
        error:function(e){
            alert("no funciona");
            console.log(e);
        }
    })
});


//Configuracion de los mensajes en pantalla
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

//deshabilitar/habilitar checkbox
$(document).on("click", "#chxModPresencialServicio", function () {
    if($("#chxModPresencialServicio").prop("checked")){
        document.getElementById("txtPrecioModPresencialServicio").disabled = false;
    }else{
        document.getElementById("txtPrecioModPresencialServicio").disabled = true;
        document.getElementById("txtPrecioModPresencialServicio").value = "0";
    }
});
$(document).on("click", "#chxModOnlineServicio", function () {
    if($("#chxModOnlineServicio").prop("checked")){
        document.getElementById("txtPrecioModOnlineServicio").disabled = false;
    }else{
        document.getElementById("txtPrecioModOnlineServicio").disabled = true;
        document.getElementById("txtPrecioModOnlineServicio").value = "0";
    }
});

//Funcion que muestra la descripcion general en caso de que ya exista un servicio con un nombre ya ingresado
//en la bd.
//Parte rescatando el valor del option, se desbloquean los campos correspondientes y se valida si el option es distinto al primero que
//despues se valida si es un numero o no, de ser asi, se limpian los campos de mensaje y se envia el valor del option, el cual
//retorna la descripcion de dicho option que a su vez se bloquea la casilla de esta.
function mostrarDatosServicio(){
    var indice = $("#txtNombreServicio").val();
    $("#nextBtn").prop("disabled", false);
    desbloquearCampos();
    if(indice!=0){
        var valoresAceptados = /^[0-9]+$/;
        if(indice.match(valoresAceptados)){
            resetMensajes();
            var dataServicio = new FormData();
            dataServicio.append('index', indice);
            $.ajax({
                url: '/servicios/rellenarModalAgregar',
                type: 'POST',
                data: dataServicio,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                },
                dataType: 'json',
                success:function(e){
                    $("#txtDesGeneralServicio").prop("disabled", true);
                    document.getElementById("txtDesGeneralServicio").value =  e[0]["descripcion"];
                },
                error:function(e){
                    console.log(e);
                }
            })
        }else{
            document.getElementById("txtDesGeneralServicio").value="";
        }
    }else{
        bloquearCampos();
        $("#formAdd").trigger("reset");

    }
}
//Funcion que al momeno de cargar la pagina, muestra la tabla de servicios, se le asigna propiedades al select
//con la clase "js-example-basic-single"(tags: pueda crear sus propios nombres de servicio; createTag: cuando crea un tag,
//retorne en el value un texto que diga sinId), se bloquean los campos del modal agregar servicio y se rellena el select de
//los nombres de los servicios
$(document).ready(function () {
    table;
    $('.js-example-basic-single').select2({
        width: '100%',
        tags:true,
        createTag: function (params) {
            return {
                id: "sinId",
                text: params.term
            }
        }
    });
    bloquearCampos();
    actualizarSelect2();
});

//funcion que elimina los option del select "txtNombreServicio" y los vuelve a insertar con los datos mas actualizados
function actualizarSelect2(){
    var select = document.getElementById("txtNombreServicio");
    var length = select.options.length;
    for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
    }
    $.ajax({
        url: '/servicios/cargarDatosSelect2',
        type: 'GET',
        success:function(e){
            var retorno = JSON.parse(e);
            $("#txtNombreServicio").append($("<option selected value='0' class='text-4 bluegray-text'>Ingresar Nombre del Servicio</option>"));
            if (retorno != "") {
                for (let i = 0; i < retorno.length; i++) {
                    $("#txtNombreServicio").append($("<option value='" + retorno[i]["id_servicio"] + "' class='text-4 bluegray-text'>" + retorno[i]["nombre"] + "</option>"));
                }
            }
        },
        error:function(e){
            alert("no funciona");
            console.log(e);
        }
    })
}
