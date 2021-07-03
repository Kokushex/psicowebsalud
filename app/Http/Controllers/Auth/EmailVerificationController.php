<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{

    public function show()
    {
        return view('auth.verify');
    }

    public function request()
    {
        auth()->user()->sendEmailVerificationNotification();

        //return back()->with('success', 'Link de Verificacion enviado.');
        return redirect()->to('/auth/correoEnviado');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->to('/home'); // <-- change this to whatever you want
    }

    public function correoEnviado()
    {
        return view('auth.correoEnviado');
    }


}
