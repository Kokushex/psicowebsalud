<div class="card mb-3">
    <div class="card-body text-center">
        <div class="row d-flex justify-content-center">
            <div class="col-8 p-2 align-self-center">
                <div class="text-left h-100">
                    <h5 class="title-3 darkblue-text mb-0 align-self-center">{{$user->nombre.' '.$user->apellido_paterno}}
                        <p class="text-4 m-0 bluegray-text">Cuenta verificada <em class="fas fa-check-circle fa-fw lightblue-text"></em></p>
                        <p class="text-4 m-0 bluegray-text"><i class="fas fa-map-marker-alt"></i> {{$user->titulo.' - '.$user->comuna}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
            @include('perfil.includes.details')
    </div>
</div>
