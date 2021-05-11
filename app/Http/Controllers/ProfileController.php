<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\PerfilValidaciones;
use App\Http\Requests\P;
use Illuminate\Support\Facades\Hash;


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
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }



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
}
