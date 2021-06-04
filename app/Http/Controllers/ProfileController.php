<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\PerfilValidaciones;
use App\Models\Persona;
use App\Models\Paciente;
use App\Models\Psicologo;
use App\Models\User;
use App\Models\UserHasRoles;
use App\Models\ModalidadServicio;
use App\Models\ServicioPsicologo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
  /*  public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }*/

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /*public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }*/



    public function update(PerfilValidaciones $request)
    {
        //Obtener datos de usuario en la variable de session para actualizarla
        $user=session()->get('user');
        $persona = new Persona();
        //Encontrar usuario a actualizar
        $request->id_persona=$user->id_persona;
        $persona = $persona->updatePersona($request);
        if(!empty($persona)){
            $user->nombre = $request->nombre;
            $user->apellido_paterno = $request->apellido_paterno;
            $user->apellido_materno = $request->apellido_materno;
            $user->fecha_nacimiento = $request->fecha_nacimiento;
            $user->genero = $request->genero;
            $user->telefono = $request->telefono;
            $user->region = $request->region;
            $user->comuna = $request->comuna;
            $user->direccion = $request->direccion;
            session()->put(['user' => $user]);
            return json_encode($user);
        }else{
            return 'No se encuentran datos';

        }
    }

    public function registrarDatosPersonales(PerfilValidaciones $request){
        //nueva persona
        $persona = new Persona();
        //guardare ne rol, el usuariorol  donde id user, sea el auth de user-> el primero
        $rol = UserHasRoles::select('id_rol')->where('id_user', auth()->user()->id_user)->first(); //id
        //rol igual a id_roles que lo rescata de rol
        $rol = $rol->id_rol;

        $persona = $persona->updatePersona($request);

        $user = session()->get('user');

        //guardar datos del request en cada campo que corresponda

        //request
        if(!empty($persona)){
            $user->run = $request->run;
            $user->nombre = $request->nombre;
            $user->apellido_paterno = $request->apellido_paterno;
            $user->apellido_materno = $request->apellido_materno;
            $user->fecha_nacimiento = $request->fecha_nacimiento;
            $user->genero = $request->genero;
            $user->telefono = $request->telefono;
            $user->region = $request->region;
            $user->comuna = $request->comuna;
            $user->direccion = $request->direccion;
            session()->put(['user' => $user]);
            return json_encode($user);
        }else{
            return 'No se ha encontrado ningun dato del perfil';
        }
    }

    //metodo para cambiar la contraseña
    public function updatePassword(PasswordRequest $request)
    {
        //guardar en var user el id, desde auth buscar el id
        $user = User::findOrFail(auth()->user()->id_user);
        //Guardar en var $clave, la contraseña actual desde el request
        $clave = $request->contraseña_act;
        //si check metodo para trabajar contraseñas, comprueba clave y la password actual en la bd, la data succes es  true
        if (Hash::check($clave, $user->password)) {
            $data['success'] = true;
            //Buscar el user donde id sea el id del usuario auth, pasar a actualizar la password, con metodo make de hash con la clave nueva
            User::where('id_user', auth()->user()->id_user)
                ->update([
                    'password' => Hash::make($request->password),
                ]);
        } else {
            //Si no pasa la clave guardar en succes false
            $data['success'] = false;
        }
        //retornar data del request
        return view('profile.edit');
    }

    public function updatePaciente(Request $request)
    {
        $paciente = new Paciente();
        $paciente = $paciente->updatePaciente($request);
        if(!empty($paciente)){
            $user=session()->get('user');
            $user->escolaridad=$request->escolaridad;
            $user->ocupacion=$request->ocupacion;
            $user->estado_civil=$request->estado_civil;
            $user->grupo_familiar=$request->grupo_familiar;
            session()->put('user', $user);
            return json_encode($user);
        }else{
            return 'No se encuentran datos';
        }
    }


    public function updatePsicologo(Request $request)
    {
        $psicologo = new Psicologo();
        $psicologo = $psicologo->updatePsicologo($request);
        if(!empty($psicologo)){
            $user=session()->get('user');
            $user->titulo=$request->titulo;
            $user->especialidad=$request->especialidad;
            $user->casa_academica=$request->casa_academica;
            $user->grado_academico=$request->grado_academico;
            $user->fecha_egreso=$request->fecha_egreso;
            $user->experiencia=$request->experiencia;
            session()->put(['user' => $user]);
            return json_encode($user);

        }else{
            return 'No se encuentran datos';
        }

    }

    public function getProfile($id)
    {

        $user = Psicologo::getProfile($id);

        // obtención de los servicios asociados a ese psicólogo
        $servicios = ServicioPsicologo::getServiciosPsicologo($id);

        //obtener modalidades del servicio según psicologo
        ModalidadServicio::getModalidadesServicioEnPerfil($servicios);

        //obtención datos usuario para llenado en modal_create_reserva
        $usuarioLogeado="";
        //$disponibilidad = Reserva::validarDisponibilidadPsicologo($user->id, $user->id_psicologo, null);
            //verificar autenticación para tomar datos de usuario
        if (auth()->user()) {
            $usuarioLogeado = Paciente::getDatosLogeado();
        }
        //retorno a la vista
        return view('perfil.profile', compact('user', 'servicios', 'usuarioLogeado', ));
    }
}
