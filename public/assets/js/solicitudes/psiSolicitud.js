/*
function fn_validar() {
    //evita el submit automatico
    event.preventDefault();

    let form = event.target;

    Swal.fire({
    title: '¿Desea Verificar el estado de este Usuario?',
    text: 'Esta accion actualizara los datos del sistema',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#484AF0',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Verificar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:cambioEstado,


            },
            }
            action: "{{ route('estado', $fila->id_psi) }}",
            Swal.fire(
                'Verificado',
                'Se ha cambiado el estado del usuario.',
                'success'
            );
        };
    });
}

$('.confirm').on('click', function (e) {
    if(confirm($(this).data('confirm'))) {
        return true;
    }else{
        return false;
    }
}); */

//Funcion para cambiar el estado del servicio
$(document).on("click", ".btnVerificado", function() {
    event.preventDefault();

    let form = event.target;
    Swal.fire({
        title: '¿Desea Verificar el estado de este Usuario?',
        text: 'Esta accion actualizara los datos del sistema',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#484AF0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/roles/solicitudes/{id}',
                type: 'POST',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                },
                dataType: 'json',
                success:function(e){
                    table.ajax.reload();
                    toastr["success"]("Se ha cambiado el estado del usuario.");
                },
                error:function(e){
                    alert("no funciona");
                    console.log(e);
                }
            })
        }
    });
});
