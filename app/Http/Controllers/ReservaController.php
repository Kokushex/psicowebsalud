<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Reserva;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\Psicologo;
use App\Models\Servicio;
use App\Models\HorarioDia;
use App\Models\ModalidadServicio;
use App\Models\ServicioPrevision;
use App\Models\PrecioModalidad;
use App\Mail\Testmail;

use App\Models\ServicioPsicologo;
use Carbon\Carbon;


class ReservaController extends Controller
{
    public function indexReserva()
    {
        return view('reserva');
    }

//metodo para crear la reserva
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

    /**
     *
     *Comprobacion de reservas ya tomadas
     *
     *
     */

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

            return json_encode(Psicologo::getCentroServicio($request->id));
        }
    }

    /**
     * paginacionAjax
     *
     * generación de paginación ajax utilizada en la gestión de reservas por parte del paciente.
     *
     */
    public function paginacionAjax(Request $request)
    {

        $estadoP = $request->estadopago;
        $paciente = $request->spsocios;
        $fecha = $request->fecha;
        $modalidad = $request->modalidad;
        $socios = session()->get('socios_user');
        if (auth()->user()) {
            if($estadoP == '0' && $paciente == '0' ){
                $reserva = Reserva::filtrosReservas(null,null,null, $fecha, $modalidad);
            }
            if($estadoP != '0' && $paciente == '0'){
                $reserva = Reserva::filtrosReservas(4, $estadoP,null, $fecha,$modalidad);
            }
            if($paciente != '0'){
                $reserva = Reserva::filtrosReservas(3, $estadoP, $paciente, $fecha, $modalidad);
            }
            return view('reserva.gestionReserva.partial_listado_reservas_paciente', ['reserva' => $reserva,'paciente' => $paciente, 'rank' => $reserva->firstItem(), 'estado' => $estadoP, 'socios' => $socios, 'fecha' => $fecha, 'modalidad' => $modalidad]);
        }

    }

    /**
     * getResCantidadPendientes
     *
     * método que lleva a método encapsulado, obtención de cantidad de reservas pendientes de un determinado
     * paciente
     *
     */
    public function getResCantidadPendientes(Request $request)
    {

        if ($request->ajax()) {

            return json_encode(Reserva::getResCantidadPendientes());
        }
    }

    /**
     * llenarModalReservas
     *
     * llenar ventana modal con los datos de la reserva y del paciente asociado a esta
     *
     *
     */
    public function llenarModalReservas(Request $request)
    {
        if ($request->ajax()) {
            $reserva = Reserva::llenarModalReserva($request->id);
            $paciente = Reserva::pacienteReserva($reserva->id_paciente);
            return json_encode([$reserva, $paciente]);
        }
    }

    /**
     * validarFechaHora
     *
     * método utilizado para validar el tiempo transcurrido desde que se ha reservado una cita
     * este método es util a la hora de reagendar y cancelar una reserva ya que hay ciertas restricciones
     * a la hora de realizar estas acciones
     *
     */
    public function validarFechaHora(Request $request)
    {

        if ($request->ajax()) {
            $answer = Reserva::validarFechaHora($request->id_reserva, $request->hora);
            if($answer > 0 && $request->operacion == "reagendar"){
                $disponibilidad = Reserva::validarDisponibilidadPsicologo(null,null,$request->id_reserva);
                if($disponibilidad == 0){
                    $answer = 3;
                }
            }
            return json_encode($answer);
        }
    }

    /**
     * actualizarReserva
     *
     * método que llama a método encapsulado
     * utilizado para actualizar la reserva, esto es cancelarla o cambiar sus fechas
     *
     */
    public function actualizarReserva(Request $request)
    {
        if ($request->ajax()) {

            return json_encode(Reserva::actualizarReserva($request->id, $request->fecha, $request->hora_inicio, $request->confirmacion));
        }
    }


    /**
     *  Función de listar reservas de un profesional
     *  Retorna una lista que corresponde a las reservas asociadas al profesional.
     *
     */
    public function listarReservasProfesional()
    {
        try {
            if (auth()->user()) {
                $filtro="";
                $reservas = Reserva::reservasProfesional(auth()->user()->persona->id_persona);
                return view('reserva.gestionReserva.listadoPsicologo', ['reservas' => $reservas, 'rank' => $reservas->firstItem(),'filtro' => $filtro]);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     *  Recupera los datos de las reservas de un usuario desde la base de datos.
     *  Retorna a la vista y los objetos necesarios para ser mostrados.
     */

    public function listarReservas()
    {
        try {
            if (auth()->user()) {
                $reservas = Reserva::getReservasPorPaciente(auth()->user()->persona->id_persona);
                $paciente = '0';
                $fecha = '';
                $modalidad = '0';
                return view('reserva.gestionReserva.listadoPaciente',
                    ['reserva' => $reservas, 'paciente' => $paciente, 'rank' => $reservas->firstItem(), 'estado' => "0", 'fecha' => $fecha, 'modalidad' => $modalidad]);


            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

}
