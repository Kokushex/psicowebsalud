// ---- Nueva Función Buscar ----- //

function funcionBuscar(){


    if(document.getElementById("datoFiltro").value==""&&document.getElementById("filtro_texto")==null)

    {

        //toastr.error
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-center",

        }
        toastr["error"]("Error de Contraseña", "No actualizado");
        console.log('Ingrese datos para filtrar'); // Crea el toast segun la caracteristica o restriccion dada.

    }else{

        $("#filtro").trigger("submit");
        // ejecuta el form, inicia la busqueda aplicando el filtro

    }

}


