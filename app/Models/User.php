<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordNotification;

use Illuminate\Contracts\Auth\MustVerifyEmails;
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

class User extends Authenticatable implements MustVerifyEmail
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

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'id_user', 'id_user');
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
        $user->email_verified_at = null;
        $user->save();
        return $user;
    }


  /**
     */
    public function generarProfile($rol){
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
                $persona    = new Persona();
                $persona    = $persona->generarPersona();
                $user = $persona->datosAdminLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
        }
    }

    public function getProfile($rol){
        switch ($rol) {
            case 1:
                $paciente = new Paciente();
                $user = $paciente->datosPacienteLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
            case 2:
                $psicologo= new Psicologo();
                $user = $psicologo->datosPsicologoLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
           case 3:
                $persona = new Persona();
                $user = $persona->datosAdminLogeado();
                session()->put(['user' => $user, 'rol' => $rol]);
                break;
        }
    }

    /**
     * Metodo para buscar al usuario por email y rol
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

    /**
     * Metodo para enlazar hacia la notificacion generada en notifications junto al token
     *
     */

     public function sendPasswordResetNotification($token){

        $this->notify(new ResetPasswordNotification($token));

     }

    public function sendEmailVerificationNotification(){

        $this->notify(new VerifyEmail());

    }


    /**
     *Metodo para listar los usuarios en la tabla de gestion de usuarios
    */

    public static function listasCompleta()
    {


        $listasCompleta = DB::table('persona')
            ->join('paciente', 'paciente.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'user_has_roles.id_user_roles as id_user_rol',
                'users.id_user as user_id',
                'persona.id_persona as id_persona',
                'persona.run as rut',
                'users.email as email',
                'users.banned_till as estado',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.telefono as fono',
                'roles.id_roles as id_rol',
                'roles.name as nombre_rol'
            );
        $listasCompleta = DB::table('persona')
            ->join('psicologo', 'psicologo.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'user_has_roles.id_user_roles as id_user_rol',
                'users.id_user as user_id',
                'persona.id_persona as id_persona',
                'persona.run as rut',
                'users.email as email',
                'users.banned_till as estado',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.telefono as fono',
                'roles.id_roles as id_rol',
                'roles.name as nombre_rol'
            )
            ->unionAll($listasCompleta)
            ->orderBy('id_user_rol', 'ASC')
            ->get();

        return $listasCompleta;
    }

    /**
     *Metodo para obtener los valores de los datos de los usuarios en gestion de usuarios
     */

    public static function BuscarValores($id)
    {


        $BuscarValores = DB::table('persona')
            ->join('paciente', 'paciente.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'user_has_roles.id_user_roles as id_user_rol',
                'users.id_user as user_id',
                'persona.id_persona as id_persona',
                'persona.run as rut',
                'users.email as email',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.telefono as fono',
                'roles.name as nombre_rol',
                'user_has_roles.id_rol as id_roles'
            )->where('user_has_roles.id_user_roles', $id);
        $BuscarValores = DB::table('persona')
            ->join('psicologo', 'psicologo.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'user_has_roles.id_user_roles as id_user_rol',
                'users.id_user as user_id',
                'persona.id_persona as id_persona',
                'persona.run as rut',
                'users.email as email',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.telefono as fono',
                'roles.name as nombre_rol',
                'user_has_roles.id_rol as id_roles'
            )
            ->where('user_has_roles.id_user_roles', $id)
            ->unionAll($BuscarValores)
            ->first();

        return $BuscarValores;
    }

    /**
     * metodo que lista los roles
     */

    public static function listaRol()
    {
        $listaRol = Roles::select('id_roles', 'name')->get();
        return $listaRol;
    }
    public static function rol($id)
    {
        $listaRol = Role::select('id_roles', 'name')
            ->where('roles.id', $id)
            ->first();
        return $listaRol;
    }

    /**
     * metodo que busca al usuario si resulta ser un psicologo
     */

    public static function buscarpsicologo($id)
    {
        $buscarpsicologo = DB::table('persona')
            ->join('psicologo', 'psicologo.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'roles.name as nombre_rol',
                'users.id_user as id_user',
                'users.email as email',
                'persona.id_persona as id_per',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.run as rut',
                'persona.direccion as direccion',
                'persona.comuna as comuna',
                'persona.region as region',
                'persona.telefono as fono',
                'persona.fecha_nacimiento as fecha_nac',
                'persona.genero as genero',
                'psicologo.id_psicologo as id_psi',
                'psicologo.grado_academico as grado',
                'psicologo.casa_academica as casa_academica',
                'psicologo.especialidad as especialidad'

            )
            ->where('user_has_roles.id_user_roles', $id)
            ->first();
        return $buscarpsicologo;
    }

    /**
     * metodo que buscar al usuario si resulta ser un paciente
     */

    public static function buscarPaciente($id)
    {

        $buscarpaciente = DB::table('persona')
            ->join('paciente', 'paciente.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->join('user_has_roles', 'user_has_roles.id_user', '=', 'users.id_user')
            ->join('roles', 'roles.id_roles', '=', 'user_has_roles.id_rol')
            ->select(
                'roles.name as nombre_rol',
                'users.id_user as id_user',
                'users.email as email',
                'persona.id_persona as id_per',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.run as rut',
                'persona.direccion as direccion',
                'persona.comuna as comuna',
                'persona.region as region',
                'persona.telefono as fono',
                'persona.fecha_nacimiento as fecha_nac',
                'persona.genero as genero',
                'paciente.id_paciente as id_pac',
                'paciente.escolaridad as escolar',
                'paciente.ocupacion as ocupacion',
                'paciente.estado_civil as estado_civ',
                'paciente.grupo_familiar as grupo_fami',
                //'paciente.estado_clinico as estado_clin'
            )
            ->where('user_has_roles.id_user_roles', $id)
            ->first();
        return $buscarpaciente;
    }

    /**
     * metodo para revisar las solicitudes de psicologos
     */

    public static function psicologoSolicitud()
    {
        $solicitud = DB::table('persona')
            ->join('psicologo', 'psicologo.id_persona', '=', 'persona.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')
            ->select(
                'users.email as email',
                'persona.nombre as nombre',
                'persona.apellido_paterno as apellido_p',
                'persona.apellido_materno as apellido_m',
                'persona.run as rut',
                'persona.telefono as fono',
                'psicologo.id_psicologo as id_psi',
                'psicologo.verificado as verificacion'

            )
            ->where('psicologo.verificado', '=', 'EN ESPERA')
            ->get();
        return $solicitud;
    }

    // permite obtener el campo banned till por medio del email ingresado en el formulario de login correspondiente.
    public static function ban($mail)
    {
        $ban = DB::table('users')
            ->select(
                'users.banned_till'
            )
            ->where('users.email', $mail)
            ->first();
        return $ban;
    }


}
