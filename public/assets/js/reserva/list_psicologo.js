// ---- Nueva Función Buscar ----- //

function funcionBuscar(){


    if(document.getElementById("datoFiltro").value==""&&document.getElementById("filtro_texto")==null)

    {

        //toastr.error
        console.log('Ingrese datos para filtrar'); // Crea el toast segun la caracteristica o restriccion dada.

    }else{

        $("#filtro").trigger("submit");
        // ejecuta el form, inicia la busqueda aplicando el filtro

    }

}

function buscarComuna(){

    if(document.getElementById("comunaFiltro").value==""&&document.getElementById("filtro_comuna")==null)

        {

            //toastr.error
            console.log('Ingrese datos para filtrar'); // Crea el toast segun la caracteristica o restriccion dada.

        }else{

        $("#filtro").trigger("submit");
        // ejecuta el form, inicia la busqueda aplicando el filtro

    }

}


