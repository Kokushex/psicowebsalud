<div class="row">
    <div class="col-12">
        <ul class="nav p-0 nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
            <li class="nav-item m-0" role="presentation">
                <a class="nav-link active text-4 bluegray-text" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                    <p class="m-0">
                        <i class="fas fa-school"></i> General
                    </p>
                </a>
            </li>
            <li class="nav-item m-0" role="presentation">
                <a class="nav-link text-4 bluegray-text" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                    <p class="m-0">
                        <i class="far fa-file-alt"></i> Especialidades
                    </p>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active white bluegray-text" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item pl-0 mb-3">
                        <div class="darkblue-text text-medium text-4">
                            Titulo Psicólogo
                            <p class="m-0 bluegray-text text-4">
                                <em class="fas fa-graduation-cap fa-fw indigo-text"></em> {{$user->titulo}} - Sin especialidad
                            </p>
                        </div>
                    </li>
                    <li class="list-group-item pl-0 mb-3">
                        <div class="darkblue-text text-medium text-4">
                            Formado en
                            <p class="m-0 bluegray-text text-4">
                                <em class="fas fa-university fa-fw indigo-text"></em> {{$user->casa_academica}}
                            </p>
                        </div>
                    </li>
                    <li class="list-group-item pl-0 mb-3">
                        <div class="darkblue-text text-medium text-4">
                            Egresado en
                            <p class="m-0 bluegray-text text-4">
                                <em class="fas fa-calendar fa-fw indigo-text"></em> {{$user->fecha_egreso}}
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade white bluegray-text" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active white bluegray-text" id="pills-contact" role="tabpanel" aria-labelledby="pills-home-tab">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item pl-0 mb-3">
                                    <div class="darkblue-text text-medium text-4">
                                        Doctorado
                                        <p class="m-0 bluegray-text text-4">
                                            <em class="fas fa-graduation-cap fa-fw indigo-text"></em> {{$user->titulo}} - Sin especialidad
                                        </p>
                                    </div>
                                </li>
                                <li class="list-group-item pl-0 mb-3">
                                    <div class="darkblue-text text-medium text-4">
                                        Magister
                                        <p class="m-0 bluegray-text text-4">
                                            <em class="fas fa-university fa-fw indigo-text"></em> {{$user->casa_academica}}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade white bluegray-text" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
