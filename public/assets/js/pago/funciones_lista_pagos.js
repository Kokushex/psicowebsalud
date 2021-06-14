(function () {

    // configuración para token en cabeceras de llamadas Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

})();




// funcion utilizada para paginación ajax, se obtiene el valor del page
$(document).on('click', '.pagination a', function (event) {

    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];  // obtención de número de page
    pagination(page);
});

// método puente que ejecuta el llamado ajax
function pagination(page) {

    configPaginacionAjax(page);
}

// función principal que configura la paginación ajax, recepciona el parámetro de la página
// dentro de esta se consideran elementos que tienen relación con otros filtros
function configPaginacionAjax(page, reset_filtro=null){

    // si el evento que ejecutó esta funcion es el boton que limpia los filtros, entonces...
    if(reset_filtro!=null){

        var orden = "";
        var ano = "0";
        var mes = "0";

    }else{  // si el evento que ejecuto esta funcion es caja de texto o select

        var orden = document.getElementById('input_orden').value;
        var ano = document.getElementById('select_ano').value;
        var mes = document.getElementById('select_mes').value;
    }

    $.ajax({

        url: "/pasareladepago/listPay/page?page="+page+"&mes="+mes+"&ano="+ano+"&orden="+orden,
        success: function (data) {
            $("#table_data").html(data);
        }
    })

    // idem configuración de arriba, solo procede si se le ha hecho click al boton limpiafiltros
    if(reset_filtro!=null){

        document.getElementById("form_pagos").reset();  // restablece campos del form (select e imput)

    }
}

// funcion filtrar por orden de compra (campo de texto)
$("#input_orden").on('keyup', function () {

    hidenShowBotonLimpiarFiltro("input_orden");
    configPaginacionAjax("1");

});

// funcion filtrar por mes al seleccionar el "select" del mes
$("#select_mes").on('change', function () {

    hidenShowBotonLimpiarFiltro("select_mes");
    configPaginacionAjax("1");

});

// funcion boton limpiar filtros
$("#botonLimpiar").on('click', function () {

    $("#botonLimpiar").fadeOut(2000);
    configPaginacionAjax("1","limpiar_filtros");

});

// funcion filtrar por ano al seleccionar "select" del ano..
$("#select_ano").on('change', function () {


    hidenShowBotonLimpiarFiltro("select_ano");
    configPaginacionAjax("1");

});

// funcion que muestra o quita el botón de filtrar
function hidenShowBotonLimpiarFiltro(input){

    // captura de elemento
    var elemento = document.getElementById(input);

    // validación para generar el botón "limpiar filtro" con efecto
    if(elemento.value=="0"||elemento.value==""){
        $("#botonLimpiar").fadeOut(2000);
    }else{
        $("#botonLimpiar").fadeIn(2000);
    }

}


// función que permite solo el ingreso de números en los imput.
function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}

