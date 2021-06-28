// ---- Nueva Función Buscar ----- //

function funcionBuscar(){


    if(document.getElementById("datoFiltro").value==""&&document.getElementById("filtro_texto")==null){

        toastr.error('Ingrese un Nombre o Apellido'); // Crea el toast segun la caracteristica o restriccion dada.

    }else{

        $("#filtro").trigger("submit");  // ejecuta el form, inicia la busqueda aplicando el filtro

    }

}
