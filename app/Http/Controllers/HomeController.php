<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            if (auth()->user()) {
                return view('home');
            }else{
                //Si no se encuentra en una sesion es devuelto al inicio
                return view('welcome');
            }
        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }
}
