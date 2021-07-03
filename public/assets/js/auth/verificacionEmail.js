function enviarVerificacion(){
    window.location.href = '/email/resend';
}

$( document ).ready(function() {
    if(!($('#mensaje').length)){
        window.location.href = '/email/resend';
    }
});
