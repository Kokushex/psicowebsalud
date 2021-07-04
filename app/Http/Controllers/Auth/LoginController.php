<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidaciones;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Dotenv\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Cookie;
use Auth;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    /**
     * Metodo para que la vista cargada sea con los apartados para paciente
     */

    protected function viewLoginPaciente(){
        return view('auth.login');
    }
    /**
     * Metodo para que la vista cargada sea con los apartados para psicologo
     */

    protected function viewLoginPsicologo(){
        return view('auth.login');
    }
    /**
     * Metodo para ingresar a la vista de login de administrador
     */
    protected function index_login_admin(){
        return view('auth.login_admin');
    }

    //////Tipo segun ruta metodo 1
    //Metodo para seleccionar tipo de usuario que puede iniciar sesion desde la vista actual
    // private function obtenerTipoSegunRuta(){
    //     $tipo=0;
    //     switch(Route::currentRouteName()){
    //         case "login_Paciente":
    //             $tipo=1;
    //             break;
    //         case "login_Psicologo":
    //             $tipo=2;
    //             break;
    //         default:
    //             $tipo=0;
    //     }
    //     return $tipo;
    // }

    //////Tipo segun ruta metodo 2
    /**
     * Metodo para retornar la vista de login con la variable
     * de tipo que es para saber a que login se quiere acceder
     * tipo 1 de paciente y tipo 2 de usuario
     * @return View
     */
    protected function index_login(){
        //Crear cookie con valor 0 y duracion de 60 minutos
        cookie('access_error', 0, 60);
        $ruta_nombre =Route::currentRouteName();
        switch($ruta_nombre){
            case "login_paciente":
                $tipo=1;
                return view ('auth/login')->with('tipo',$tipo);
                break;
            case "login_psicologo":
                $tipo=2;
                return view ('auth/login')->with('tipo',$tipo);
                break;
            default:
                return view ('/');
                break;
        }
    }

    protected function logear(LoginValidaciones $request,$tipo){



            //Auth::attempt metodo para logear al usuario si corresponde
            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'],
            /*['g-recaptcha' => $request['g-recaptcha']]*/
            ])) {

                // Verificar si el usuario corresponde con el rol
                $user=new User();
                $user=$user->encontrarUserConRol($request['email'],$tipo);
                //Verificar si el usuario existe

                if(is_null($user) || empty($user)){
                    //Deslogear usuario
                    Auth::logout();
                    return back()->with('status','Tipo de cuenta incorrecta.');
                }else{
                    $dato=User::ban($request->email);
                    $dato1=$dato->banned_till;
                    if($dato1=='1') {
                        Auth::logout();
                        return back()->with('status', 'Usted ha sido baneado.');
                    }else{
                        //Si es paciente se logea o si el psicologo esta verificado
                        //if($tipo == 1 || $tipo ==2 || $tipo == 3){
                        if($tipo == 1 || $tipo ==2){
                            Cookie::queue('access_error', 0, 10);
                            Auth::login($user);
                            $user->getProfile($tipo);
                            return redirect()->to('/home');
                        }elseif($tipo== 3){
                            $user->getProfile($tipo);
                             return redirect()->to('/gestionUsuarios');
                        }else{
                            return back()->with('status','Usuario no autorizado.');
                        }
                    }
                }
            }else{
                Cookie::queue('access_error', Cookie::get('access_error')+1, 10);
                return back()->with('status','Usuario y/o Clave incorrecta(s).');
            }
    }

    public function loginView(){
        return view ('welcome');
    }

    public function validator (array $data)
    {
            return Validator::make($data,[
            'g-recaptcha-response' =>function($attribute, $value, $fail) {
                $secretKey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "URL: https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remote=$userIP";
                $response = file_get_contents($url);
                $response = json_decode($response);
                if(!$response->success){
                    $fail($attribute.'google reCaptcha failed');
                }
            }

            ]);
    }




}
