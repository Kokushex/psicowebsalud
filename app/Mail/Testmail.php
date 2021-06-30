<?php

namespace App\Mail;

use App\Centro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Servicio;
use App\ServicioPsicologo;
use App\User;

class Testmail extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto = 'Confirmar Reservar';
    public $mensaje;
    public $persona;
    public $servicio;
    public $psicologo;
    public $reserva;
    public $centro;
    public $accion;

    /**
     * Create a new message instance...
     *
     * @return void
     */
    public function __construct($reserva, $persona, $accion = null)
    {


        if(auth()->user()){

            $this->persona = $persona;
            $this->reserva = $reserva;
            $this->accion = $accion;
        }

        // utilizar eloquent

        $datos = Servicio::getDatosServicio($reserva->id_servicio_psicologo);


        if($reserva["modalidad"]=="Presencial"){
            //$this->centro =  Centro::getCentroServicio($reserva["id_servicio_psicologo"]);
        }
        $this->mensaje = $reserva;
        $this->servicio=$datos->nombre_servicio;
        $this->psicologo=$datos->nombre_psicologo.' '.$datos->apellido_psicologo;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.contact');

    }
}
