/**
 * Script para realizar diferentes validaciones a los datos ingresados
 * en los formularios; como formatos de correo, letras, numeros y
 * campos vacios.
 */


//Obtener formulario


const modal_container = document.getElementById('modal_container');
const close = document.getElementById('close');
const continuar = document.getElementById('continuar');

if (modal_container) {
    continuar.addEventListener('click', () => {
        form.submit();
    });

    close.addEventListener('click', () => {
        modal_container.classList.remove('show');
    });
}


/**
 * Metodo para recargar el captch en el login
 */
$('#reload').click(function () {
    $.ajax({
        type: 'GET',
        url: '/reload-captcha',
        dataType: "html",
        success: function (data) {
            $(".captcha span").html(data);
            console.log(data);
        }
    });
});

/**
 * Metodo ajax para verificar que no se repita el run ingresado
 * Se utiliza el selector del input run para realizar la
 * verificacion con el metodo blur y llamar al controlador de
 * registro
 */
$('#run').blur(function () {
    if(!$('#run').empty()) {
        $.ajax({
            url: '/register/run',
            method: 'POST',
            data: {
                run: $('input[name="run"]').val(),
                _token: $('input[name="_token"]').val(),
            },
            error: function (data) {
                //rojo siempre
                $('#run').attr('style', 'border: 1px solid #ff0000');
                $('#msgRun').text("El run esta en uso");
                $('#msgRun').show().html(data.responseJSON.error).css({
                    'color': 'red',
                    'text-align': 'center'
                })
            },
            success: function (data) {
                //
            }
        })
    }
});

/**
 * Metodo para verificar que ninguno de los campos del formulario no esten vacios.
 * Se le asigna una funcion al boton "submit" del formulario, se capturan todos los
 * campos del formulario y se analiza que no esten vacios y si lo estan se devolvera
 * un valor false. Luego se valida que el run y correo tengan la estructura correcta, de
 * lo contrario se devuelve un valor false.
 */
var form = document.getElementById("form");
form.addEventListener(
    "submit",
    function (event) {
        event.preventDefault();
        var form_correcto = true,
            elementos = this.elements,
            total = elementos.length,
            email = document.getElementById('email').value;
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

        if (form_correcto) {
            //alert("Usuario registrado exitosamente");
            if (valCorreo(email) === false) {
                document
                    .getElementById("email")
                    .setAttribute("style", "border: 1px solid #ff0000");
                // alert('El email no es valido');
            } else {
                this.submit();
            }

        } else {
            alert("Complete todos los campos");
        }
    },
    false
);

/**
 * Metodo para validar que run ingresado sea validado segun el algoritmo
 * para de verificacionm (SOLO SE VERIFICA QUE SEA VALIDO, NO QUE SI EXISTA).
 * Cuano el run no es valido se devuelve un valor false y se remarca el borde
 * del campo run con color rojo (#ff0000).
 * @param {run del input a validar} run
 */
function valRun(run) {
    var msgRun = "";
    var runText = "";
    var runText = run.split("-");
    var confirm = false;
    document
        .getElementById("run")
        .setAttribute("style", "border: 1px solid #ced4da");
    //Condicional para que verifique que se ingreso el -
    if (runText.length < 2) {
        document
            .getElementById("run")
            .setAttribute("style", "border: 1px solid #ff0000");
    } else {
        //Algoritmo de verificacion de run
        var runDiv = runText[0].split("");
        var serie = 2;
        var suma = 0;
        var resultParcial;
        var resultado;
        for (var i = runDiv.length - 1; i >= 0; i--) {
            if (serie == 8) {
                serie = 2;
            }
            var prod = runDiv[i] * serie;
            suma = suma + prod;
            serie++;
        }
        var resultParcial = suma % 11;
        var resultado = 11 - resultParcial;
        if (resultado == runText[1] || resultado == 10) {
            //Run valido
            confirm = true;
        } else {
            //Run incorrecto
            document
                .getElementById("run")
                .setAttribute("style", "border: 1px solid #ff0000");
        }
        //Validacion aparte de run 11111111-1 y demas
        var runInva = 0;
        for (var x = 1; x < 9; x++) {
            for (var i = runDiv.length - 1; i >= 0; i--) {
                if (runDiv[i] == x) {
                    runInva++;
                }
            }
            if (runText[1] == x) {
                runInva++;
            }
        }
        if (runInva == 9) {
            document
                .getElementById("run")
                .setAttribute("style", "border: 1px solid #ff0000");
        }

    }
    document.getElementById("msgRun").innerHTML = msgRun;
    return confirm;
}

/**
 * Metodo para validar numero del run
 * @param {tecla del input} e
 */
function soloNumerosRun(e) {
    var run = document.getElementById("run").value;
    if (run.length < 8) {
        var key = window.Event ? e.which : e.keyCode;
        return key >= 48 && key <= 57;
    } else {
        var key = e.keyCode || e.which;
        var teclado = String.fromCharCode(key).toLowerCase();
        var letra = "-";
        if (run.length < 9) {
            if (letra.indexOf(teclado) == -1) {
                return false;
            }
        } else {
            letra = "12345678k";
            if (letra.indexOf(teclado) == -1) {
                return false;
            }
        }
    }
}

/**
 * Metodo para validar el correo, se retorna un valor false si esta incorrecto,
 * y de lo contrario se envia un valor true. Se realiza mediante las condiciones
 * de que el correo ingresado tenga una estructura de correo
 * con @ y . separador de dominio
 * @param {Valor del email en el input} email
 */
function valCorreo(email) {
    var valido = false,
        arroba = email.split("@");
    document
        .getElementById("email")
        .setAttribute("style", "border: 1px solid #ff0000");
    if (arroba.length == 2) {
        var punto = arroba[1].split(".");
        if (punto.length >= 2) {
            if (punto[1].length >= 2) {
                valido = true;
                document
                    .getElementById("email")
                    .setAttribute("style", "border: 1px solid #ced4da");
            }
        }
    }
    return valido;
}

/**
 * Metodo para permitir solo letras con o sin espacios
 * @param {Evento de una tecla} e
 * @param {True para no permitir espacios o false de lo contrario} espace
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

/**
 * Metodo para validar que solo se ingresen numeros, se recibe la tecla
 * oprimida para verificar si la key corresponde a un numero y es que no
 * se devuelve un valor false, lo que no permite que se ingrese el caracter
 * @param {Tecla oprimida} e
 */
function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode;
    return key >= 48 && key <= 57;
}


/**
 * Metodo que comprobara y verificara el run si es valido o no, para ello recibe de la vista el objeto.
 * El metodo se llama en la vista con ese nombre onRunBlur en el campo input run con el atributo onblur.
 * Con la condición el metodo mostrara en un pequeño mensaje si el run es valido o no es correcto.
 */
function onRunBlur(obj) {
    //Se evalua el run en la funcion VerificaRun que esta más abajo, si es igual a 1 verdadero
    if (VerificaRun(obj.value) == 1) {
        $('#alertErrorRun').append($('<span class="badge badge-success"  id="alertSucces" >EL RUN ES VALIDO</span>'));
        setTimeout(function () {
            $('#alertSucces').fadeIn();
            $('#alertSucces').fadeOut(1500);
        }, 1500);
        setTimeout(function () {
            $('#alertSucces').remove();
        }, 4000);
    }
    else {
        //si es igual a 2, falso run incorrecto
        if (VerificaRun(obj.value) == 2) {
            $('#alertErrorRun').append($('<span class="badge badge-danger"  id="alertSucces" >EL RUN NO ES CORRECTO</span>'));
            $('#run').val("");
            setTimeout(function () {
                $('#alertSucces').fadeIn();
                $('#alertSucces').fadeOut(1500);
            }, 1500);
            setTimeout(function () {
                $('#alertSucces').remove();
            }, 4000);
        }
        else {
            //CAMPO VACIO NO MOSTRAR NADA
        }
    }


}

/**
 * Este metodo verifica si el run esta bien escrito y valida segun el algoritmo,
 * solo verifica que sea valido, no que exista.
 * Por parametro llega la variable Run, para luego ser analizada segun caracteres, espacios, puntos
 * Valida la sumatoria, el resto y la letra K
 * Retorna 1 si es true, Retorna 2 si es falso, Retorna 3 si es en blanco
 * @param {el run} run
 * @returns 1, 2 or 3
 */
function VerificaRun(run) {
    //condicion si el run tiene los caracteres completos y sin espacios con su guion
    if (run.toString().trim() != '' && run.toString().indexOf('-') > 0) {
        var caracteres = new Array();
        var serie = new Array(2, 3, 4, 5, 6, 7);
        var dig = run.toString().substr(run.toString().length - 1, 1);
        run = run.toString().substr(0, run.toString().length - 2);

        //Ciclo for para iterar el largo del run y guardar en array
        for (var i = 0; i < run.length; i++) {
            caracteres[i] = parseInt(run.charAt((run.length - (i + 1))));
        }

        var sumatoria = 0;
        var k = 0;
        var resto = 0;

        for (var j = 0; j < caracteres.length; j++) {
            if (k == 6) {
                k = 0;
            }
            sumatoria += parseInt(caracteres[j]) * parseInt(serie[k]);
            k++;
        }

        //Validar resto
        resto = sumatoria % 11;
        dv = 11 - resto;

        //Validar letra K
        if (dv == 10) {
            dv = "K";
        }
        else if (dv == 11) {
            dv = 0;
        }
        //si es correcto la sumatoria y su letra k con (==) con el digito verificador retornar true 1
        if (dv.toString().trim().toUpperCase() == dig.toString().trim().toUpperCase())
            return 1;
        else
            //si es falso retornar 2
            return 2;
    }
    else {
        // si el campo es blanco, todo lo contrario a lo anterior, return false 3
        return 3;
    }
}

