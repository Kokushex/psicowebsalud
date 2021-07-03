@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Verifica tu dirección de email') }}</small>
                        </div>
                        <div>

                                <div class="alert alert-success" role="alert">
                                    {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
