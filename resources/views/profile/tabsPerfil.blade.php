<div class="tab-content" >

    <!--Formulario Contraseña-->
    <div class="active tab-pane" id="c_contraseña">
        <hr class="my-4" />
        @include('profile.formContraseña')
    </div>
    <!--FIN FORMULARIO CONTRASEÑA-->

    <!--FORMULARIO DATOS-->
    <div class="tab-pane" id="d_personal">
        <hr class="my-4" />
        @include('profile.formDatosPersonales')

    </div>
    <!--FIN FORMULARIO DATOS PERSONALES-->

        @switch($rol)

            @case(1)
            <!--FORMULARIO Paciente -->
                <div class=" tab-pane" id="d_otros">
                    <hr class="my-4" />
                    @include('profile.formDatosPaciente')
                </div>
            @break
            <!-- FIN FORMULARIO Paciente -->
            @case(2)
            <!--FORMULARIO Psicologo -->
                <div class=" tab-pane" id="d_otros_psicologo">
                    <hr class="my-4" />
                    @include('profile.formDatosPsicologo')
                </div>
            @break
            <!-- FIN FORMULARIO Psicologo -->

        @endswitch
</div>


