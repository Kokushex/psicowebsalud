<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Testmail;
use App\Models\Reserva;

class MailController extends Controller
{
    public function send($id){

        Reserva::confirmarReservaMail($id);

        return view('emails/correoconfirmado');
    }
}
