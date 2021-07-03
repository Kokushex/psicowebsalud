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
    confirmButtonText: 'Verificar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/roles/solicitudes',
                type: 'GET',
                data: x
            })
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
});