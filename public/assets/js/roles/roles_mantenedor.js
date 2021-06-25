//Funcion click en boton de eliminar rol para recuperar ID y llevarlo al Modal
$(document).on('click','.deleteRol',function(){
    var rolID=$(this).attr('data-rolid');
    $('#rol_id').val(rolID);
    $('#modalDeleterol').modal('show');
});
//Funcion click en boton de guardar cambios en updateRol.blade.php para recuperar ID y mostrar el Modal
$(document).on('click','.CambioRol',function(){
    var rolID=$(this).attr('data-rolid');
    $('#rol_id').val(rolID);
    $('#modalCambioRol').modal('show');
});
$(document).on('click','.update',function(){
    var rolID=$(this).attr('data-rolid');
    $('#rol_id').val(rolID);
    $('#update').modal('show');
});
