<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


/**
 * @property int $id_user
 * @property string $email
 * @property string $password
 * @property string $rememberToken
 * @property string $avatar
 * @property string $provider_id
 * @property string $provider
 * @property string $email_verified_at
 * @property boolean $status
 * @property string $updated_at
 * @property string $created_at
 * @property DireccionAtencion[] $direccionAtencions
 * @property Persona[] $personas
 * @property UserHasRole[] $userHasRoles
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'rememberToken', 'avatar', 'provider_id', 'provider', 'email_verified_at', 'status', 'updated_at', 'created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function direccionAtencions()
    {
        return $this->hasMany('App\Models\DireccionAtencion', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Models\Persona', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userHasRoles()
    {
        return $this->hasMany('App\Models\UserHasRole', 'id_user', 'id_user');
    }


//Metodo para verificar un atributo de usuario
    public function verificarUsuario($campo,$dato){

        return  User::where($campo,$dato)->get();
    }

    //Metodo para crear usuario 
    public function createUsuario($data){
        $user = new User();
        $user->email=$data['email'];
        $user->password=Hash::make($data['password']);//contraseña
        $user->save();
        return $user;
    }
    


  /**
     * Metodo para obtener todos los datos del usuario logeado,
     * se crean las variables de session para utilizar en diferentes vistas.
     */
    public function getProfile($rol){
        switch ($rol) {
            case 1:
                $persona = new Persona();
                $persona = $persona->generarPersona();
                $paciente = new Paciente();
                $paciente = $paciente->createPaciente(Auth::id(), $persona->id_persona);
                $user = $paciente->datosPacienteLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
            case 2:
                $persona    = new Persona();
                $persona    = $persona->generarPersona();
                $psicologo  = new Psicologo();
                $psicologo  = $psicologo->createPsicologo(Auth::id(), $persona->id_persona);
                $user       = $psicologo->datosPsicologoLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
            case 3:
                session()->put(['rol' => $rol]);
                break;
        }
    }

    /**
     * Metodo para buscar al usuario por email y rol
     * @return User
     */
    public function encontrarUserConRol($email,$rol){
        return User::select(
            'users.id_user'
        )
            ->join('user_has_roles', function ($join) {
                $join->on('users.id_user', '=', 'user_has_roles.id_user');
            })
            ->where('users.email',$email)
            ->where('user_has_roles.id_rol',$rol)
            ->first();
    }

}