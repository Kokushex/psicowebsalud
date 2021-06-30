    <div class="card mb-3">
        <div class="card-body p-4 text-center">
            <h4 class="title-4 darblue-text">¿Necesitas ayuda?</h4>
            @if (auth()->user())
                @if(auth()->user()->persona->run != '')
                    <button class="btn btn-block indigo white-text text-4 mb-3 u-button-style u-palette-3-base u-btn-1"
                            data-toggle="modal" data-target="#create">
                        <em class="far fa-calendar-check fa-fw"></em> Reservar cita
                    </button>
                @else
                <div class="alert alert-warning" id="mensajeInformativo">
                    {{ __('Al completar sus datos podrá acceder a todas las funcionalidades que ofrecemos.') }}
                </div>
                @endif
            @else
                <div class="alert alert-warning" id="mensajeInformativo">
                    {{ __('Al registrarse podrá acceder a todas las funcionalidades que ofrecemos.') }}
                </div>
            @endif
            <!--
            <button id="btnModal" class="btn btn-block white indigo-text indigo-border text-4 " data-toggle="modal"
                    data-target="#modalMensaje">
                <em class="far fa-paper-plane fa-fw"></em> Enviar mensaje
            </button>
            -->
        </div>

<!--RESERVA-->
@include('reserva.create')

    </div>
