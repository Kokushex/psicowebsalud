<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify');
    }

    public function resend()
    {
        auth()->user()->sendEmailVerificationNotification();

        return redirect()->to('/auth/correoEnviado');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->to('/home'); // <-- change this to whatever you want
    }

    public function correoEnviado(){
        return view('auth.correoEnviado');
    }


}
