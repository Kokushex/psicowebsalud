@extends('layouts.app')
@section('content')

<link href="{{asset('assets/fullcalendar/main.css')}}" rel='stylesheet' />
<link href="{{asset('assets/css/agenda/agenda.css')}}" rel='stylesheet' />

<div class="header bg-gradient-primary py-7 py-lg-6" style="height: 10rem">
        <div class="container">
            <div class="header-body text-center mt-1 mb-1">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Agenda.') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>


    <script>

        window.onload = () => {
            $(function() {
                var calendarEl = document.getElementById('calendario');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    themeSystem: 'bootstrap',
                    eventClick: function(info) {

                        $('#td_id_res').val(info.event.extendedProps.id_reserva);
                        $('#txt_telefono').val(info.event.extendedProps.telefono);
                        $('#txt_prevision').val(info.event.extendedProps.prevision);
                        $('#txt_precio').val(info.event.extendedProps.precio);
                        $('#txt_modalidad').val(info.event.extendedProps.modalidad);
                        $('#txt_hora_inicio').val(info.event.extendedProps.hora_inicio);
                        $('#txt_fecha_cita').val(info.event.extendedProps.fecha);
                        $('#txt_hora_termino').val(info.event.extendedProps.hora_termino);
                        $('#txt_estado_pago').val(info.event.extendedProps.estado_pago);
                        $('#txt_nombre').val(info.event.extendedProps.nombre);
                        $('#txt_servicio').val(info.event.extendedProps.servicio);

                        //Desplegamos el modal con la informacion
                        $('#modal_agenda').modal()
                    },

                    //funcionalidad para cambiar la zona horaria de fullcalendar
                    timeZone: 'America/Santiago',
                    //funcionalidad para cambiar el idioma de fullcalendar
                    locale: 'Es',
                    //funcionalidad para reemplazar el primer dia en la vista
                    firstDay: 1,
                    //Carga de botones en el encabezado del calendario
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },

                    navLinks: true,

                    //Carga del array de citas y los dias feriados nacionales a través de google
                    eventSources: [{
                        url: '/agenda/listar',
                    },
                        {
                            googleCalendarId: 'es.cl#holiday@group.v.calendar.google.com',

                        }
                    ],
                    googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

                });
                //Renderizado del calendario
                calendar.render();
            });
        }

    </script>

<div class="container mt--10 pb-5"></div>
<div class="card-body text-center fondoCalendario">

    <div class="card tarjeta mt-3">
        <div class="card-header align-items-center">
            <div class="row">
                <div class="col-sm-2 col-md-12">

                </div>
                <div class="col-sm-8 text-center">

                </div>
                <div class="col-sm-12 col-md-12 text-left">
                    <h5>Leyenda:</h5>
                    <div style="display: inline-block;">
                        <i class="fas fa-circle fa-sm" style="color: #1cc961;"></i>
                        <div style="display: inline-block;">Online</div>
                    </div>
                    <div style="display: inline-block;">
                        <i class="fas fa-circle fa-sm" style="color: #d44f9f;"></i>
                        <div style="display: inline-block;">Presencial</div>
                    </div>

                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div id="calendario"></div>
                </div>

            </div>

        </div>


    </div>
</div>

@include('agenda.modalAgenda')

@push('js')
    <script src="{{asset('assets/fullcalendar/main.js')}}"></script>
    <script src="{{ asset('assets/fullcalendar/locales/es.js') }}"></script>


@endpush

@endsection
