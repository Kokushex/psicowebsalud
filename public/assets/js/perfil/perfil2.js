//Variables
var contra_act = $('#contraseña_act');
var contra_nueva = $('#password');
var contra_conf = $('#password_confirmation');
var registroPsicologo = false;

$(document).ready(function (){
     if ($('#esperandoVerificacion').length){
      $('#form_datos_personales input, #form_datos_personales select').each(
          function (index){
              var input = $(this);
              input.attr('disabled', '');
          }
      );
     }

    //Verificacion de formulario para actualizar el password
    var form = document.getElementById("form");
    form.addEventListener(
        "submit",
        function (event){
            event.preventDefault();
            var form_correcto = true,
                elementos = this.elements,
                total = elementos.length;

            for (var i=0; i < total; i++){
                elementos[i].setAttribute("style", "border: 1px solid #ced4da");
                if (!elementos[i].value.trim().length){
                    if (
                        elementos[i].type != "checkbox" &&
                        elementos[i].type != "submit"
                    ){
                        elementos[i].setAttribute(
                            "style",
                            "border: 1px solid #ff0000"
                        );
                        form_correcto = false;
                    }
                }
            }
            //Formulario correcto y completado
            if (form_correcto){
                if (contra_conf.val() == contra_nueva.val()){
                    updatePassword();
                }else {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "preventDuplicates": true,
                        "positionClass": "toast-top-center",

                    }
                    toastr["error"]("Error de Contraseña", "No actualizado");
                }
            }else {
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "preventDuplicates": true,
                    "positionClass": "toast-top-center",

                }
                toastr["warning"]("Campos vacios", "Alerta");
            }
        },
        false
    );
});
//////////////////////////////////////////////////////////////////////////////////
$(document).ready(function (){
    //Verificacion de datos de persona
    $("#form_datos_personales").bind("submit", function (){

        if ($('#registrarDatosPersonales').length){
            registraDatosAjax();
        }else {
            updateAjax(1, $("#form_datos_personales"));
        }
        return false;
    });
    //Variable para impedir que se utilize el boton
    var estadoBtnDatosComplementarios = true;
    if ($('#update_datos_comple').attr('disabled') == 'disabled'){
        estadoBtnDatosComplementarios = false;
    }
    //Variable utilizada para verificar si el registro es del psicologo
    if ($('#msgPsicologo').length){
        registroPsicologo = true;
    }
    //Declaracion de metodo para la accion de submit del formulario
    $("#form_datos_complementarios").bind("submit", function (){
        if (estadoBtnDatosComplementarios){
            updateAjax(2, $("#form_datos_complementarios"));
        }
        return false;
    });
    //Mostrar y ocultar contraseñas
    $("#show_hide_password a").on('click', function (event){
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr('type') == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });

});

// Metodo para que no deje seleccionar mas del año actual

function colocarMaximoFecha() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth();
    var yyyy = today.getFullYear();
    if (dd < 10){
        dd = '0' + dd
    }
    if (mm < 10){
        mm = '0' + mm
    }
    today = yyyy + '-' + 'mm' + '-' + dd;
    $("#fecha_nacimiento").attr("max", today);
}

function registraDatosAjax(){
    btnEnviar = $("#registrarDatos");
    div = $("#div_confirmacion1");
    form = $("#form_datos_personales");
    $.ajax({
        type: form.attr("method"),
        url: '/profile/registrarDatosPersonales',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function (){
            btnEnviar.html('Registrando...');
            btnEnviar.removeAttr("disabled");
        },
        complete: function (data){
          btnEnviar.html('Guardar Cambios');
          btnEnviar.removeAttr("disabled");
        },
        success: function (data){
            toastr["success"]("Datos Registrados", "Registro Exitoso");
            $("#registrarDatos").attr('id_user', 'update_datosP');
            //$("#mensajeInformativo").remove();
            $("#run").attr('readonly', 'true');
            //si el registro es del psicologo
            if(registroPsicologo){
                //recorre todos los inputs y deshabilitarlos
                $('#form_datos_personales input, #form_datos_personales select').each(
                    function (index){
                        var input = $(this);
                        input.attr('readonly', 'true');
                    }
                );
                btnEnviar.remove();

                location.reload();
            }
        },
        //reliazado para verificar los errores
        error: function (error) {
            //validar que llegue el error
            console.log(error);
            if(error.responseJSON.hasOwnProperty('errors')){
                //validar Rut
                Object.keys(error.responseJSON.errors).forEach(function (jB){
                    var arr = error.responseJSON.errors[jB];
                    console.log(arr);
                    arr.forEach(element =>{
                        console.log(element);
                    })
                });
            }
        }
    });
}
//actualizar datos
function  updateAjax(formulario, form) {
    $('#run').prop("disabled", false);
    $('#run').attr("readonly", "readonly");
    var btnEnviar, div;
    switch (formulario){
        case 1:
            btnEnviar = $("#update_datosP");
            div = $("#div_confirmacion1")
            break;
        case 2:
            btnEnviar = $("#update_datos_comple");
            div = $("#div_confirmacion2")
            break;
    }
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function (){
            btnEnviar.html('Guardando...');
            btnEnviar.attr("disabled", "disabled");
        },
        complete: function (data){
            btnEnviar.html('Guardar Cambios');
            btnEnviar.removeAttr("disabled");
        },
        success: function (data){
            //remueve el readonly y activar disabled
            $('#run').removeAttr('readonly');
            $('#run').prop("disabled", true);
            toastr["success"]('Datos Actualizados.', "Exito");
        },
        error: function (error){
            $('#run').removeAttr('readonly');
            $('#run').prop("disabled", true);
            if (error.responseJSON.hasOwnProperty('errors')){
                Object.keys(error.responseJSON.errors).forEach(function (jB){
                    var arr = error.responseJSON.errors[jB];
                    console.log(arr);
                    arr.forEach(element =>{
                        verAlertas(element);
                    })
                });
            }
        }
    });
}

function verAlertas(mensaje) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "50000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr["error"](mensaje, "Error de envio.");
}


function updatePassword(){
    var btnEnviar = $('#update_password');

    $.ajax({
        type: $('#form').attr("method"),
        url: $('#form').attr("action"),
        data: $('#form').serialize(),
        dataType: 'json',
        beforeSend: function () {
            btnEnviar.html('Guardando...');
            btnEnviar.attr("disabled", "disabled");
        },
        complete: function (data){
            btnEnviar.html('Guardar Cambios');
            btnEnviar.removeAttr("disabled");
        },
        success: function (data){
            //dejar campos vacios
            contra_act.val("");
            contra_conf.val("");
            contra_nueva.val("");

            if (data['success'] == false){
                contra_act.addClass("is-invalid");
                document.getElementById("contraseña_act").setAttribute("style", "border: 1px solid #ff0000");

                toastr["error"]('Contraseña actual incorrecta.', "Error");

                div.append($('<div class="col-md-12 alert alert-secondary alert-danger" id="alert" role="alert">Contraseña actual incorrecta</div>'));
                setTimeout(function (){
                    $("#alert").fadeIn();
                    $("#alert").fadeOut(1500);
                }, 1500);
                setTimeout(function (){
                    $("#alert").remove();
                    }, 4000);
            } else if (data['success'] == true){


                toastr["success"]('Contraseña actualizada.', "Exito");

                div.append($('<div class="col-md-12 alert alert-secondary alert-success" id="alert" role="alert">Contraseña actualizada</div>'));
                setTimeout(function (){
                    $("#alert").fadeIn();
                    $("#alert").fadeOut(1500);
                }, 1500);
                setTimeout(function (){
                    $("#alert").remove();
                }, 4000);
            }
        },
        error: function (data){
            console.log(data);

        }
    })
}
