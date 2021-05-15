//Declaracion de variables

var divPasswordConfir = $('#divPasswordConfir');
var divPasswordConfir2 = $('#divPasswordConfir2');
var contra_act = $('#contraseña_act');
var contra_nueva = $('#password');
var contra_conf = $('#password_confirmation');
var nombre = $("#nombre");
var apellido_pa = $("#apellido_paterno");
var apellido_ma = $("#apellido_materno");
var registroPsicologo = false;


$(document).ready(function() {
    $("#icono_imagen").mouseover(function() {
        $('#icono_imagen').animate({ opacity: 0.5 });
        $('#icono_imagen').css('cursor', 'pointer');
    }).mouseout(function() {
        $('#icono_imagen').animate({ opacity: 1 });
    });
    $("#imagen_id").mouseover(function() {
        $('#imagen_id').css('cursor', 'pointer');
    });

    colocarMaximoFecha();
    // Enmascarar el input Rut en formato deseado
    $("#run").inputmask({
        mask:"9[9999999]-[9|K|k]",
    });

    /*
    //Se deshabilita el rut si ya existe en el formulario
    if ($('#rut').val() != '') {
        $("#rut").attr('readonly', 'true');
    }
    */

    //Si el mensaje de verificación ya existe, se deshabilitan los inputs
    /*if ($('#esperandoVerificacion').length) {
        $('#form_datos_personales input, #form_datos_personales select').each(
            function(index) {
                var input = $(this);
                input.attr('disabled', '');
            }
        );
    }*/

    //Comparacion de contraseñas que se muestra si no coinciden
    contra_conf.blur(function() {

        if (contra_nueva.val() != contra_conf.val() && contra_nueva.val() != "") {
            divPasswordConfir.show();
            divPasswordConfir2.show();
        } else {
            divPasswordConfir.hide();
            divPasswordConfir2.hide();
        }
    });

    //Comparacion de contraseñas que se muestra si no coinciden
    contra_nueva.blur(function() {
        if (contra_nueva.val() != contra_conf.val() && contra_conf.val() != "") {
            divPasswordConfir.show();
            divPasswordConfir2.show();
        } else {
            divPasswordConfir.hide();
            divPasswordConfir2.show();
        }
    });

    //Verificacion de formulario de Actualizar Password completado o no
    var form = document.getElementById("form");
    form.addEventListener(
        "submit",
        function(event) {
            event.preventDefault();
            var form_correcto = true,
                elementos = this.elements,
                total = elementos.length;

            /**
             * Ciclo que verifica cada elemento del formulario para validar si no esta vacio y si lo esta
             *coloca su borde de color rojo y cambia la variable form_correcto a false.
             */
            for (var i = 0; i < total; i++) {
                elementos[i].setAttribute("style", "border: 1px solid #ced4da");
                if (!elementos[i].value.trim().length) {
                    if (
                        elementos[i].type != "checkbox" &&
                        elementos[i].type != "submit"
                    ) {
                        elementos[i].setAttribute(
                            "style",
                            "border: 1px solid #ff0000"
                        );
                        form_correcto = false;
                    }
                }
            }
            // si el formulario es correcto y completado ejecuta la funcion actualizarPassword la que se encarga de actualizar la clave,
            // si no mostrar mensaje de claves no coinciden
            if (form_correcto) {
                if (contra_conf.val() == contra_nueva.val()) {
                    updatePassword();

                } else {
                    divPasswordConfir.show();
                    divPasswordConfir2.show();
                }

            } else {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr["error"]('Complete todos los campos.', "Error al cambiar contraseña");

            }
        },
        false
    );

});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
    //Verificacion que se completen datos esenciales de la persona
    $("#form_datos_personales").bind("submit", function() {

            if ($('#registrarDatos').length) {
                registraDatosAjax();
            } else {
                updateAjax(1, $("#form_datos_personales"));
            }

        return false;
    });


    //Variable para impedir que se utilize el boton si es que no esta habilitado y condición para dejar el boton en false.
    var estadoBtnDatosComplementarios = true;
    if ($('#update_datos_comple').attr('disabled') == 'disabled') {
        estadoBtnDatosComplementarios = false;
    }

    //Se utiliza la variable para saber si el registro de datos es del Psicologo.
    if ($('#msgPsicologo').length) {
        registroPsicologo = true;
    }
    //Declaracion de metodo para la accion de submit del formulario
    $("#form_datos_complementarios").bind("submit", function() {
        if (estadoBtnDatosComplementarios) {
            updateAjax(2, $("#form_datos_complementarios"));
        }
        return false;
    });

    //Mostrar y/o ocultar contraseña de los inputs
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });

});

/*
*Metodo para eliminar la fecha, que no deje seleccionar más del año actual.
*/
function colocarMaximoFecha() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    $("#fecha_nacimiento").attr("max", today);
}

/**
*Metodo para Registrar los Datos de un paciente o psicologo en estado de en Espera, cuando aun no es validado por el admin
*/
function registraDatosAjax() {
    btnEnviar = $("#registrarDatos");
    div = $("#div_confirmacion1");
    form = $("#form_datos_personales");
    $.ajax({
        type: form.attr("method"),
        url: '/profile/registrarDatosPersonales',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            btnEnviar.html('Registrando..'); // Para input de tipo button
            btnEnviar.attr("disabled", "disabled");
        },
        complete: function(data) {
            btnEnviar.html('Guardar cambios');
            btnEnviar.removeAttr("disabled");
        },
        success: function (data) {
            /* console.log(data);
            updateDatosPerf(data);
            div.append($('<div class="col-md-12 alert alert-secondary alert-success" id="alert" role="alert">Se registraron sus datos</div>'));
            setTimeout(function() {
                $("#alert").fadeOut(1500);
            }, 1500);
            setTimeout(function() {
                $("#alert").remove();
            }, 4000); */
            $("#registrarDatos").attr('id_user', 'update_datosP');
            $('#mensajeInformativo').remove();
            $("#run").attr('readonly', 'true');
            if (registroPsicologo) {
                //Recorrer todos los inputs y desabilitarlos
                $('#form_datos_personales input, #form_datos_personales select').each(
                    function(index) {
                        var input = $(this);
                        input.attr('readonly', 'true');
                    }
                );
                btnEnviar.remove();
                /*$('#mensajeInformativo').append($('<div class="alert alert-warning text-center" id="mensajeInformativo"><b id="msgPsicologo">Su solicitud esta en espera de Revisión.</b></div>'));
                div.append($('<div class="col-md-12 alert alert-secondary alert-warning" id="alert" role="alert"><b>Solicitud en Revisión</b></div>'));
                */
                location.reload();

            }

        },
        error: function(error) {
            //Validar que llege el error
            console.log(error);
            if (error.responseJSON.hasOwnProperty('errors')){
                //Validar Rut incompleto, mal escrito o ya se encuentra ingresado
                Object.keys(error.responseJSON.errors).forEach(function(jB){
                    var arr = error.responseJSON.errors[jB];
                    console.log(arr); //will print the array belongs to each property.
                    arr.forEach(element =>{
                        console.log(element); //verAlertas
                    })
                  });
            }

        }
    });
}



/**
 * Metodo para actualizacion de datos personales y complementarios
 * @param {formulario a utilizar} form_datos_personales
 * @param {formulario con datos} form
 */
function updateAjax(formulario, form) {
    $('#run').prop("disabled",false);
    $('#run').attr("readonly","readonly");
    var btnEnviar, div;
    switch (formulario) {
        case 1:
            btnEnviar = $("#update_datosP");
            div = $("#div_confirmacion1");
            break;
        case 2:
            btnEnviar = $("#update_datos_comple");
            div = $("#div_confirmacion2");
            break;
    }
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            btnEnviar.html('Guardando..'); // Para input de tipo button
            btnEnviar.attr("disabled", "disabled");
        },
        complete: function(data) {
            btnEnviar.html('Guardar cambios');
            btnEnviar.removeAttr("disabled");
        },
        success: function(data) {
            // si es correcto, remueve el readonly y deja el disabled activado en el run
            $('#run').removeAttr('readonly');
            $('#run').prop("disabled",true);
            //Metodo en esta vista
            //updateDatosPerf(data);
            //Entregar mensaje de actualización de datos
            /*swal({
                title: "Exito",
                text: "Se actualizaron sus datos",
                icon: "success",
            });
            div.append($('<div class="col-md-12 alert alert-secondary alert-success" id="alert" role="alert">Se actualizaron sus datos</div>'));
            setTimeout(function() {
                $("#alert").fadeOut(1500);
            }, 1500);
            setTimeout(function() {
                $("#alert").remove();
            }, 4000); */

        },
        error: function(error) {
            // si existe error, remueve el readonly y deja el disabled activado en el rut
            $('#run').removeAttr('readonly');
            $('#run').prop("disabled",true);
            //valido que llegue error
            if (error.responseJSON.hasOwnProperty('errors')) {
                Object.keys(error.responseJSON.errors).forEach(function(jB){
                    var arr = error.responseJSON.errors[jB];
                    console.log(arr); //will print the array belongs to each property.
                    arr.forEach(element =>{
                        verAlertas(element);
                    })
                  });

            }
        }
    });
}

/*Funcion para mostrar mensajes de Errores en el perfil, se debe de llamar en el ajax en la parte de error.
 * Este metodo pasa por parametro el id del div a utilizar y el mensaje del json, para luego mostrar el mensaje
 * correspondiente de error.
 * @param {id del div, el mensaje} El id del div en la vista, el mensaje de error de JSON
 */
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
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr["error"](mensaje, "Error de envio.");
}




///////////////////////////////////////////////SOBRE MI ///////////////////////////////////////////////////////////////////
/*Metodo para setear datos en "Sobre mi" en Psicologo y paciente
 *Esta funcion lo que realiza es setear en la parte de sobre mi, los datos mas relavantes que el usuario actualice
 *en sus datos personales y academicos.
 * @param {data} la data del ajax
 */
/*
function updateDatosPerf(data) {
    $('#run').text(data.run);
    $('#nombre').text(data.nombre);
    $('#userNombreApelli').append(" ", data.apellido_paterno);
    $('#userNombreApelli').append(" ", data.apellido_materno);
    $('#userTitulo').text(data.titulo);
    $('#direcPerf').text(data.direccion);
    $('#direcPerf').append(" ", data.comuna);
    $('#direcPerf').append(" ", data.region);
    $('#descriPerf').text(data.descripcion);
    //para paciente educacion y ocupacion.
    $('#educaPerf').text(data.escolaridad);
    $('#userProfesion').text(data.ocupacion);
}
*/


/**
 * Metodo para actualizar la contraseña del usuario con ajax asincronica.
 */
function updatePassword() {
    var btnEnviar = $('#update_password');

    $.ajax({
        type: $('#form').attr("method"),
        url: $('#form').attr("action"),
        data: $('#form').serialize(),
        dataType: 'json',
        beforeSend: function() {
            btnEnviar.html('Guardando..');
            btnEnviar.attr("disabled", "disabled");
        },
        complete: function(data) {
            btnEnviar.html('Guardar cambios');
            btnEnviar.removeAttr("disabled");
        },
        success: function(data) {
            //Dejar campos vacios
            contra_act.val("");
            contra_conf.val("");
            contra_nueva.val("");
            //Si la data es false que se comprobo en el controller se envie un mensaje con la contraseña actual incorrecta
            if (data['success'] == false) {
                //contra_act.addClass("is-invalid");
                //document.getElementById("contraseña_act").setAttribute("style","border: 1px solid #ff0000");
                div.append($('<div class="col-md-12 alert alert-secondary alert-danger" id="alert" role="alert">Contraseña actual incorrecta</div>'));
                setTimeout(function() {
                    $("#alert").fadeIn();
                    $("#alert").fadeOut(1500);
                }, 1500);
                setTimeout(function() {
                    $("#alert").remove();
                }, 4000);
              //Si es true, muestra el mensaje devuelve contraseña actualizada correctamente
            } else if (data['success'] == true) {
                console.log(data);
                // swal({
                //     title: "Exito",
                //     text: "Contraseña actualizada",
                //     icon: "success",
                // });
                // div.append($('<div class="col-md-12 alert alert-secondary alert-success" id="alert" role="alert">Contraseña actualizada</div>'));
                // setTimeout(function() {
                //     $("#alert").fadeIn();
                //     $("#alert").fadeOut(1500);
                // }, 1500);
                // setTimeout(function() {
                //     $("#alert").remove();
                // }, 4000);
            }

        },
        //Validar fuera de ajax
        error: function(data) {
            console.log(data);
            // toastr.options = {
            //     "closeButton": true,
            //     "debug": false,
            //     "newestOnTop": true,
            //     "progressBar": true,
            //     "positionClass": "toast-top-center",
            //     "preventDuplicates": false,
            //     "showDuration": "300",
            //     "hideDuration": "1000",
            //     "timeOut": "5000",
            //     "extendedTimeOut": "1000",
            //     "showEasing": "swing",
            //     "hideEasing": "linear",
            //     "showMethod": "fadeIn",
            //     "hideMethod": "fadeOut"
            // }
            //
            // toastr["error"]('La contraseña debe ser de minimo 8 caracteres.', "Contraseña nueva");
        }
    });
}

/**
 * Metodo para actualizar la imagen de perfil del usuario
 */
$(function() {
    $avatarInput = $('#file-input');
    $avatarform = $('#update');
    $avatarImage = $("#imagen_id");
    $avatarProfile = $("#profile_id");
    avatarUrl = $avatarform.attr('action');
    $avatarInput.on('change', function() {
        var formData = new FormData();
        formData.append('file', $avatarInput[0].files[0]);
        console.log(formData);
        $.ajax({
                url: avatarUrl + '?' + $avatarform.serialize(),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false
            })
            .done(function(data) {
                if (data.success) {
                    swal({
                        title: "Exito",
                        text: "Foto de perfil actualizada",
                        icon: "success",
                    });
                    $avatarImage.attr('src', data.file_name + '?' + new Date().getTime());
                    $avatarProfile.attr('src', data.file_name + '?' + new Date().getTime());
                    $('#nav_img_perfil').attr('src', data.file_name + '?' + new Date().getTime());
                }
            })
            .fail(function() {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                toastr["error"]('La imagen subida no tiene formato correcto.', "Archivo no compatible");


            });
    });
});












