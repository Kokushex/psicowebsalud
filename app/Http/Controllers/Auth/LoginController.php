<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidaciones; //agregada
use App\Models\User; //agregada
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //agregada
use Cookie; //agregada
use Auth; /*agregado*/



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

    //Metodo para la que la vista cargada sea con los apartados para paciente
    protected function viewLoginPaciente(){
        return view('auth.login');
    }
    //Metodo para la que la vista cargada sea con los apartados para psicologo
    protected function viewLoginPsicologo(){
        return view('auth.login');
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
            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                // Verificar si el usuario corresponde con el rol
                $user=new User();
                $user=$user->encontrarUserConRol($request['email'],$tipo);
                if(is_null($user) || empty($user)){
                    //Deslogear usuario
                    Auth::logout();
                    return back()->with('status','No tienes acceso para ingresar al sitio.');
                }else{
                    //Si es paciente se logea o si el psicologo esta verificado
                    //if($tipo == 1 || $tipo ==2 || $tipo == 3){
                    if($tipo == 1 || $tipo ==2){ 
                        Cookie::queue('access_error', 0, 10);
                        Auth::login($user);
                        //Logeo para el administrador
                        // if($tipo== 3){
                        //     $user->getProfile($tipo);
                        //     return redirect()->to('/dashboard');
                        // }else{
                            $user->getProfile($tipo);
                            return redirect()->to('/home');
                        //}
                    }else{
                        return back()->with('status','Psicologo no autorizado.');
                    }
                }
            }else{
                Cookie::queue('access_error', Cookie::get('access_error')+1, 10);
                return back()->with('status','Credenciales incorrectas.');
            }
    }
}
