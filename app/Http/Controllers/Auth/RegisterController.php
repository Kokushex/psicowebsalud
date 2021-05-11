<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidaciones;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserHasRoles;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   /* protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
*/
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

        //Metodo para la vista de seleccion de registro
        protected function viewRegistroRol(){
            return view('auth.rol_register');
        }
        //Metodo para la que la vista cargada sea con los apartados para paciente
        protected function viewRegistroPaciente(){
            return view('auth.register');
        }
        //Metodo para la que la vista cargada sea con los apartados para psicologo
        protected function viewRegistroPsicologo(){
            return view('auth.register');
        }
        //Metodo para la confirmacion que se genera a las cuentas de psicologo
        protected function viewRegistroConfirmacion(){
            return view('auth.register_confirmacion');
        }



    //podria necesitar el actuar de registerValidaciones para poder controlar las excepciones que se puedan generar
    
    
    protected function createUser(RegisterValidaciones $data)
    {
       // return User::create([
        
            $tipo=$this->obtenerTipoSegunRuta();
            
            $user = new User();
            $user=$user->verificarUsuario('email',$data['email']);
                             
            if(count($user)==0){
                /* 'email' => $data['email'],
                'password' => Hash::make($data['password']), */
                if($data['password']==$data['password_confirmation']){
                    $user = new User();
                    $user->createUsuario($data);
                   
                    $user=User::latest()->first();
                    $usuarioRol=new UserHasRoles();

                    if($tipo==1){
                        //Tipo 1 = paciente
                        $usuarioRol->asignarUsuarioRol($user->id_user,1);
                        auth()->login($user);
                        $user->generarProfile($tipo);
                        return redirect()->to('/profile'); //('/email/verify')
                    }else{
                        //tipo 2 = psicologo
                        $usuarioRol->asignarUsuarioRol($user->id_user,2);
                        auth()->login($user);
                        $user->generarProfile($tipo);
                        return redirect()->to('/profile'); //('/email/verify
                    }
                }else{
                    $status = 'Las contraseñas no coinciden este es.';
                    return back()->with(compact('status'));
                }
            }else{
                //Aca si ya se encuentra registrado, enviar al login correspondiente
                $email = $data['email'];
                switch($tipo){
                    case 1:
                        return redirect('/login_paciente')->with('email',$email);
                        break;
                    case 2:
                        return redirect('/login_psicologo')->with('email',$email);
                        break;
                }
            }



            

       // ])
        ;
    }

/*metodo para seleccionar el tipo de registro deseado (Paciente o psicologo),
esto ayuda posteriormente para otorgar un rol al usuario
*/

    private function obtenerTipoSegunRuta(){
        $tipo=0;
        switch(Route::currentRouteName()){
            case "createPaciente":
                $tipo=1;
                break;
            case "createPsicologo":
                $tipo=2;
                break;
            default:
                $tipo=0;
        }
        return $tipo;
    }
}

