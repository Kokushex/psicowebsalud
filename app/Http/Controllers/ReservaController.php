<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\Servicio;
use App\Models\HorarioDia;
use App\Models\ModalidadServicio;
use App\Models\ServicioPrevision;
use App\Models\PrecioModalidad;

class ReservaController extends Controller
{
    public function indexReserva()
    {
        return view('reserva');
    }


    public function store(Request $request)
    {
        //validación de inputs venidos desde el formulario
        $validated = $request->validate([
            'rut' => 'required',
            'telefono' => 'required',
            'servicio_id' => 'required',
            'hora_inicioGet' => 'required',
            'fecha' => 'required',
            'modalidad' => 'required',

        ]);
        if ($validated) { //si los inputs están validados
            $retorno = Reserva::store(
                $request->rut,
                $request->telefono,
                $request->servicio_id,
                $request->hora_inicioGet,
                $request->hora_terminoGet,
                $request->fecha,
                $request->modalidad,
                $request->previsionDDD,
                $request->nombre,
                $request->apellido,
                $request->id_paciente_seleccionado
            );

            if ($retorno["reserva"]->prevision != "") {

                $retorno["reserva"]->save();  // almacena la reserva

                // el correo es enviado para confirmar la Reserva
                Mail::to(auth()->user()->email)->send(new Testmail($retorno["reserva"], $retorno["persona"]));

                //redireccion
                return redirect('/reserva/list')->with('messahe', 'Profile updated!');
            } else {

                //busqueda del servicio para almacenarla en variable de sesion
                $servicio = Servicio::getDatosServicio($retorno["reserva"]->id_servicio_psicologo);

                //variables de sesión útiles en el inmediato proceso de pago
                $variables_sesion = ['reserva' => $retorno["reserva"], 'servicio' => $servicio];
                session()->put('sesiones_pago', $variables_sesion);  //sesion creada

                return redirect()->route('pasarela.checkout');
            }
        }
    }

    public function obtenerDiasDisponibles(Request $request){
        $datos=HorarioDia::getDiasHabiles($request->input('id_psicologo'));
        return json_encode($datos);
    }

    /**
     * buscarRut
     * Método invocado por una llamada Ajax para validar el rut si se encuentra en la Base de datos
     *
     */
    public function buscarRut(Request $request)
    {
        $validador = 0;
        if ($request->code == 1) {
            $validador = Paciente::join('persona', 'persona.id_persona', '=', 'paciente.id_persona')->select('persona.run')->where('paciente.id_paciente', '=', $request->id_paciente)->first();
            if ($validador->rut == "") {
                $validador = 3;
            } else {
                $validador = 4;
            }
        }
        if ($validador == 3 || $request->code == 3) {
            $validador = Persona::where('run', '=', $request->run)->select('id_persona')->first();
            if ($validador == null) {
                $validador = 1;
            } else {
                $validador = 0;
            }
        }
        return json_encode($validador);
    }

    /**
     * getDetallesServicioModal
     *
     * método que llama a 3 métodos encapsulados, finalidad obtener detalles de un determinado servicio
     * psicológico
     *
     */
    public function getDetallesServicioModal(Request $request)
    {

        if ($request->ajax()) {

            $modalidades = ModalidadServicio::getModalidadesServicioModal($request->id);
            $previsiones = ServicioPrevision::getPrevisionesServicioModal($request->id);
            return json_encode([$modalidades, $previsiones]);
        }
    }

    public function getPrecioModalidad(Request $request){
        if($request->ajax()){
            return json_encode(PrecioModalidad::getPrecioModalidad($request->modalidad, $request->id_servicio));
        }
    }

    /**
     * obtenerHorasDisponibles
     *
     * Metodo utilizado para obtener el rango de hora que trabaja el psicologo
     *
     */
    public function obtenerHorasDisponibles(Request $request){
        $horas=HorarioDia::generadorDeHora($request->input('bloque'),$request->input('dias'),$request->input('id_psicologo'));
        return json_encode($horas);
    }

    /**
     * horarioPaciente
     *
     * obtener la cantidad de reservas pedidas por el paciente por fecha y hora, la finalidad es
     * validar que el paciente no haya pedido una reserva en la misma fecha y hora, a no ser que
     * haya hecho una cancelación
     */
    public function horarioPaciente(Request $request)
    {
        if ($request->ajax()) {

            return json_encode(Reserva::validarHorarioPaciente($request->id_paciente, $request->fecha, $request->hora_inicio));
        }
    }

    /**
     * comprobacionDiaHabilitado
     *
     * Metodo utilizado para comprobar si el dia esta habilitado para trabajar o no
     *
     */
    public function comprobacionDiaHabilitado(Request $request){
        if($request->ajax()){
            return HorarioDia::validarComprobacionDia($request->fechaD,$request->id_psicologo);
        }
    }

    /*
     *Comprobacion de reservas ya tomadas
     * */

    public function comprobacionReservasTomadas(Request $request){

        if($request->ajax()){

            return Reserva::validarReservaNoTomada($request->fecha,$request->hora_inicioGet,$request->servicio_id);

        }
    }

    /**
     * getCentroServicio
     *
     * método que llama a método encapsulado para obtener el centro del servicio psicológico
     *
     */
    public function getCentroServicio(Request $request)
    {
        if ($request->ajax()) {

            return json_encode(Persona::getCentro($request->id));
        }
    }




}
