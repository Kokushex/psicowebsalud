<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;


/**
 * @property int $id_reserva
 * @property int $id_paciente
 * @property int $id_servicio_psicologo
 * @property string $nro_reserva
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $hora_termino
 * @property string $modalidad
 * @property string $prevision
 * @property int $precio
 * @property string $estado_pago
 * @property string $created_at
 * @property string $updated_at
 * @property Paciente $paciente
 * @property ServicioPsicologo $servicioPsicologo
 * @property DetallePago[] $detallePagos
 */
class Reserva extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reserva';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_reserva';

    /**
     * @var array
     */
    protected $fillable = ['id_paciente', 'id_servicio_psicologo', 'nro_reserva', 'fecha', 'hora_inicio', 'hora_termino', 'modalidad', 'prevision', 'precio', 'estado_pago', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'id_paciente', 'id_paciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicioPsicologo()
    {
        return $this->belongsTo('App\Models\ServicioPsicologo', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detallePagos()
    {
        return $this->hasMany('App\Models\DetallePago', 'id_reserva', 'id_reserva');
    }

    /**
     * validarHorarioPaciente
     *
     * valida la cantidad de reservas pedidas en un determinado horario (fecha y hora) por parte del paciente
     *
     */
    public static function validarHorarioPaciente($id_paciente, $fecha, $hora_inicio)
    {
        $fechaformatoingles= date('Y-m-d', strtotime($fecha));
        return Reserva::where('confirmacion', '!=', 'Cancelado')
            ->where('id_paciente', '=', $id_paciente)
            ->where('fecha', '=', $fechaformatoingles)
            ->where('hora_inicio', '=', $hora_inicio)->count();
    }

    /**
     * validarReservaNoTomada
     *
     * método para validar que la reserva (fecha y hora) no haya sido tomada mientras el paciente
     * paga por medio de WebPay,
     *
     */
    public static function validarReservaNoTomada($fecha_reserva, $hora_inicio, $id_servicio_psicologo)
    {

        return Reserva::where('reserva.fecha', '=', $fecha_reserva)
            ->where('reserva.hora_inicio', '=', $hora_inicio)
            ->where('reserva.confirmacion', '!=', 'Cancelado')
            ->where('reserva.id_servicio_psicologo','=',$id_servicio_psicologo)
            ->count();
    }

    /**
     * store
     *
     * método que trabaja principalmente registro de la Reserva
     *
     *
     */
    public static function store($rut, $telefono, $servicio_id, $hora_inicioGet, $hora_terminoGet, $fecha, $modalidad, $prevision, $nombre = null, $apellido = null, $id_paciente_seleccionado = null)
    {

        if (auth()->user()) {

            //--lógica que verifica y actualiza datos como el telefono y el rut del paciente de no tenerlos ---//
            $id_paciente = $id_paciente_seleccionado;
            $persona = new Persona();



            if ($id_paciente_seleccionado == 0) {

                $data = array();
                $data['run'] = $rut;
                $data['nombres'] = $nombre;
                $data['apellido_pa'] = $apellido;
                $data['apellido_ma'] = '';
                $persona = Persona::createPersona($data);
                $persona->telefono = $telefono;
                $persona->save();
                $paciente = Paciente::createPaciente(auth()->user()->id, $persona->id_persona);
                $paciente->tipo_paciente = 'Carga';
                $paciente->save();
                $id_paciente = $paciente->id_paciente;

            } else {

                $persona = Persona::select("*")->join('paciente', 'paciente.id_persona', '=', 'persona.id_persona')
                    ->where('paciente.id_paciente', '=', $id_paciente_seleccionado)->first();

                if ($persona->run == null) {
                    $persona->run = $rut;
                }
                $persona->telefono = $telefono;
                $persona->save();
            }

            // --------------------------------------------------------------------------------------------//

            $reserva = new Reserva();

            $reserva->id_servicio_psicologo = $servicio_id;

            //validar que no se repita el número de la reserva
            $numero_random = 0;
            $comprobacion_nro = 0;
            while ($comprobacion_nro < 1) {

                $numero_random = strval(rand(1, 9999999));

                $cantidad = Reserva::where('nro_reserva', '=', $numero_random)->count();
                if ($cantidad == 0) {

                    $reserva->nro_reserva = $numero_random;
                    $comprobacion_nro++;
                }
            }

            $reserva->hora_inicio = $hora_inicioGet;
            $hora_terminoGet = strtotime($hora_inicioGet) + 3600;
            $hora_terminoGet = date('H:i', $hora_terminoGet);
            $reserva->hora_termino =  $hora_terminoGet;
            $fechaformatoingles= date('Y-m-d', strtotime($fecha));
            $reserva->fecha = $fechaformatoingles;
            $reserva->modalidad = $modalidad;

            // si no hay previsión obtenida
            if ($prevision != "") {
                $reserva->prevision = $prevision;
            }

            //busqueda de precio de servicio seleccionado solo en caso de no contar con previsión
            if ($prevision == "") {

                $reserva->precio =  PrecioModalidad::getPrecioModalidad($modalidad, $servicio_id)->precio;

            }

            $reserva->confirmacion = ('Sin Confirmar');
            $reserva->estado_pago = ('Pendiente');
            $reserva->id_paciente = $id_paciente;


            return ["reserva" => $reserva, "persona" => $persona];
        }
    }


    /**
     * getReservasPorPaciente
     *
     * obtener reservas del paciente, paginadas x 5, recibe como parámetro un filtro, en caso de ser nulo
     * devolverá todas las reservas del paciente, en caso de recibirlo devolverá las reservas según el
     * filtro aplicado (Estado Pendiente o Estado Pagado)
     *
     */
    public static function getReservasPorPaciente()
    {

        return Reserva::select('id_reserva', 'hora_inicio', 'modalidad', 'confirmacion', 'estado_pago', 'fecha')
            ->join('paciente', 'paciente.id_paciente', '=', 'reserva.id_paciente')
            ->where('paciente.id_persona', '=', auth()->user()->persona->id_persona)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')->paginate(5);
    }

    /**
     * getAsociadosTitular
     * Método para realizar el llenado de la etiqueta select, para realizar los filtros por socios
     *
     */
    public static function getAsociadosTitular($id_persona)
    {
        $socios = Persona::join('paciente', 'paciente.id_persona', '=', 'persona.id_persona')
            ->select('persona.nombre', 'persona.apellido_paterno', 'persona.run', 'paciente.id_paciente')
            ->where('paciente.id_persona', '=', $id_persona)->get();
        return $socios;
    }

    /**
     * filtrosReservas
     *
     * Método que realizara el filtrado de las reservas dependiedo los parametros ingresados.
     * Filtros Aplicados: estado_pago(Pendiente, Pagado), paciente o todos, modalidad o todas, fecha.
     * El retorno estará paginado x 5, para ser desplegados en la vista.
     *
     * @param  mixed $codigo
     * @param  mixed $estado_pago
     * @param  mixed $id_paciente
     * @param  mixed $fecha
     * @param  mixed $modalidad
     * @return Reserva retorna todas las reservas filtradas según los parametros ingresados.
     */
    public static function filtrosReservas($codigo  = null, $estado_pago = null, $id_paciente = null, $fecha = null, $modalidad = null)
    {
        switch ($codigo) {
            case 3:
                if ($estado_pago != '0') {
                    $reserva = Reserva::select('id_reserva', 'fecha', 'hora_inicio', 'modalidad', 'confirmacion', 'estado_pago', 'id_paciente', 'precio')
                        ->where('estado_pago', $estado_pago)->where('id_paciente', '=', $id_paciente);
                    if ($fecha == '') {
                        if ($modalidad == '0') {
                            return $reserva = $reserva->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        } else {
                            return $reserva = $reserva->where('modalidad', $modalidad)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        }
                    } else {
                        if ($modalidad == '0') {
                            return $reserva = $reserva->where('fecha', $fecha)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        } else {
                            return $reserva = $reserva->where('modalidad', $modalidad)->where('fecha', $fecha)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        }
                    }
                } else {
                    $reserva = Reserva::select('id_reserva', 'fecha', 'hora_inicio', 'modalidad', 'confirmacion', 'estado_pago', 'id_paciente', 'precio')
                        ->where('id_paciente', '=', $id_paciente);
                    if ($fecha == '') {
                        if ($modalidad == '0') {
                            return $reserva = $reserva->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        } else {
                            return $reserva = $reserva->where('modalidad', $modalidad)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        }
                    } else {
                        if ($modalidad == '0') {
                            return $reserva = $reserva->where('fecha', $fecha)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        } else {
                            return $reserva = $reserva->where('modalidad', $modalidad)->where('fecha', $fecha)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                        }
                    }
                }
                break;
            case 4:
                $reserva = Reserva::select('reserva.id_reserva', 'reserva.fecha', 'reserva.hora_inicio', 'reserva.modalidad', 'reserva.confirmacion', 'reserva.estado_pago', 'reserva.id_paciente', 'reserva.precio')
                    ->join('paciente', 'paciente.id_paciente', '=', 'reserva.id_paciente')
                    ->where('paciente.id_user', '=', auth()->user()->id)
                    ->where('estado_pago', $estado_pago);
                if ($fecha != '') {
                    if ($modalidad == '0') {
                        return $reserva = $reserva->where('fecha', $fecha)->orderBy('hora_inicio', 'desc')->paginate(5);
                    } else {
                        return $reserva = $reserva->where('fecha', $fecha)->where('modalidad', $modalidad)->orderBy('hora_inicio', 'desc')->paginate(5);
                    }
                } else {
                    if ($modalidad == '0') {
                        return $reserva = $reserva->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    } else {
                        return $reserva = $reserva->where('modalidad', $modalidad)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    }
                }
                break;
            default:
                $reserva = Reserva::select('reserva.id_reserva', 'reserva.fecha', 'reserva.hora_inicio', 'reserva.modalidad', 'reserva.confirmacion', 'reserva.estado_pago', 'reserva.id_paciente', 'reserva.precio')
                    ->join('paciente', 'paciente.id_paciente', '=', 'reserva.id_paciente')
                    ->where('paciente.id_user', '=', auth()->user()->id);
                if ($fecha == '') {
                    if ($modalidad == '0') {
                        return $reserva = $reserva->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    } else {
                        return $reserva = $reserva->where('modalidad', $modalidad)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    }
                } else {
                    if ($modalidad == '0') {
                        return $reserva = $reserva->where('fecha', $fecha)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    } else {
                        return $reserva = $reserva->where('fecha', $fecha)->where('modalidad', $modalidad)->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'desc')->paginate(5);
                    }
                }
                break;
        }
    }

    /**
     * getResCantidadPendientes
     *
     * obtención de cantidad de reservas pendientes por usuario
     *
     * @return int
     */
    public static function getResCantidadPendientes()
    {

        return Reserva::join('paciente', 'paciente.id_paciente', '=', 'reserva.id_paciente')
            ->join('persona', 'persona.id_persona', '=', 'paciente.id_persona')
            ->where('reserva.confirmacion', '=', 'Sin Confirmar')
            ->where('paciente.id_persona', '=', auth()->user()->persona->id_persona)
            ->count();
    }

    /**
     * llenarModalReserva
     *
     * obtener datos de la Reserva para autocompletar ventana Modal
     *
     * @param  int $id_reserva
     * @return ServicioPsicologo  : varios datos seleccionados en la consulta
     */
    public static function llenarModalReserva($id_reserva)
    {

        return ServicioPsicologo::join('psicologo', 'psicologo.id_psicologo', '=', 'servicio_psicologo.id_psicologo')
            ->join('persona', 'persona.id_persona', '=', 'psicologo.id_persona')
            ->join('reserva', 'reserva.id_servicio_psicologo', '=', 'servicio_psicologo.id_servicio_psicologo')
            ->join('modalidad_servicio', 'modalidad_servicio.id_modalidad_servicio', '=', 'servicio_psicologo.id_modalidad_servicio')
            ->join('servicio', 'servicio.id_servicio', '=', 'servicio_psicologo.id_servicio')
            ->select(
                'reserva.id_paciente',
                'reserva.fecha',
                'reserva.hora_inicio',
                'reserva.hora_termino',
                'servicio.nombre as nombre_servicio',
                'servicio.descripcion as descripcion_servicio',
                'modalidad',
                'precio',
                'persona.nombre',
                'persona.apellido_paterno'
            )
            ->where('reserva.id_reserva', '=', $id_reserva)->first();
    }

    /**
     * pacienteReserva
     * Método para recuperar la información personal de un paciente
     *
     * @param  mixed $id_paciente
     * @return Paciente retorna el nombre y apellido de la persona
     */
    public static function pacienteReserva($id_paciente)
    {
        return Paciente::join('persona', 'persona.id_persona', 'paciente.id_persona')
            ->where('paciente.id_paciente', $id_paciente)
            ->select('persona.nombre', 'persona.apellido_paterno','persona.run','persona.telefono')
            ->first();
    }


    /**
     * validarFechaHora
     *
     * validación de tiempo transcurrido desde que se registró una reserva
     *
     */
    public static function validarFechaHora($id_reserva, $hora)
    {

        $answer = 0;

        $reserva = Reserva::select('fecha', 'hora_inicio', 'confirmacion')->where('id_reserva', '=', $id_reserva)->first();
        if ($reserva->confirmacion != 'Cancelado') {
            $fecha = $reserva->fecha . " " . $reserva->hora_inicio;

            // -------   VALIDACION DE HORAS PARA REAGENDAR O CANCELAR     ------ //
            $fecha1 = Carbon::now(); //fecha inicial
            $fecha2 = new DateTime($fecha); //fecha de cierre

            $intervalo = $fecha1->diff($fecha2);  // toma la diferencia

            $retorno_anos = $intervalo->format('%Y');
            $retorno_meses = $intervalo->format('%M');
            $retorno_dias = $intervalo->format('%D');   // obtener dias faltantes
            $retorno_horas = $intervalo->format('%H');

            // si han pasado o no más de cierta cantidad de horas, el request trae las horas como parámetro
            if ($retorno_anos > 0 || $retorno_meses > 0 || $retorno_dias > 0 || $retorno_horas >= $hora) {
                $answer = 1;
            }
        }

        return $answer;
    }

    /**
     * actualizarReserva
     *
     * actualización de la reserva, cancelación o cambio de fechas
     *
     * @param  int $id_reserva
     * @param  string $fecha
     * @param  string $hora_inicio
     * @param  string $confirmacion
     * @return Reserva
     */
    public static function actualizarReserva($id_reserva, $fecha = null, $hora_inicio = null, $confirmacion = null)
    {
        //  $tokenx = session("token_transaccion");  potencial utilización en el reembolso
        //  $monto = session("monto");        potencial utilización en el reembolso

        //  $response = "";   potencial utilización en el reembolso
        $reserva = Reserva::findOrFail($id_reserva);
        $persona = Reserva::pacienteReserva($reserva->id_paciente);

        //CANCELAR RESERVA
        if ($confirmacion != null) {   // el parámetro es el descriminador, si es nulo Cancela la Reserva
            $reserva->confirmacion = "Cancelado";
            $fecha = $reserva->fecha . " " . $reserva->hora_inicio;

            // -------   VALIDACION DE HORAS PARA CANCELAR  (REEMBOLSO)     ------ //
            $fecha1 = Carbon::now(); //fecha inicial
            $fecha2 = new DateTime($fecha); //fecha de cierre

            $intervalo = $fecha1->diff($fecha2);  // toma la diferencia

            $retorno_anos = $intervalo->format('%Y');
            $retorno_meses = $intervalo->format('%M');
            $retorno_dias = $intervalo->format('%D');   // obtener dias faltantes
            $retorno_horas = $intervalo->format('%H');

            // si faltan más de 12 horas
            if ($retorno_anos > 0 || $retorno_meses > 0 || $retorno_dias > 0 || $retorno_horas >= 12) {

                //
                // TRABAJAR REEMBOLSO AQUI
                //
            }

            // se obtiene el email de esta manera porque es posible que la cancelación +
            // sea realizada por el psicólogo

            //$paciente = Paciente::findOrFail($reserva->id_paciente);
            //$usuario_paciente = User::findOrFail($paciente->id_user);

            $paciente = Paciente::findOrFail($reserva->id_paciente);
            $persona_paciente= Persona::findOrFail($paciente->id_persona);
            $usuario_paciente = User::findOrFail($persona_paciente->id_user);

            Mail::to($usuario_paciente->email)->send(new Testmail($reserva, $persona, "cancelacion"));
            // envio de email en caso de cancelación


        } else {   // si Confirmación no es nulo Actualiza la fecha de la Reserva // ACTUALIZAR FECHAS

            $reserva->fecha = $fecha;
            $reserva->hora_inicio = $hora_inicio;
            $hora_terminoGet = strtotime($reserva->hora_inicio) + 3600;
            $hora_terminoGet = date('H:i', $hora_terminoGet);
            $reserva->hora_termino = $hora_terminoGet;

            Mail::to(auth()->user()->email)->send(new Testmail($reserva, $persona, "reagendacion"));
            //envio de email en caso de reagendación
        }

        $reserva->save();
        return $reserva;
    }

    public static function reservasProfesional($id)
    {

        return Reserva::join('servicio_psicologo', 'servicio_psicologo.id_servicio_psicologo', '=', 'reserva.id_servicio_psicologo')
            ->join('psicologo', 'psicologo.id_psicologo', '=', 'servicio_psicologo.id_psicologo')
            ->join('paciente', 'paciente.id_paciente', '=', 'reserva.id_paciente')
            ->join('persona', 'persona.id_persona', '=', 'paciente.id_persona')
            ->join('servicio', 'servicio.id_servicio', '=', 'servicio_psicologo.id_servicio')
            ->select('persona.run', 'persona.nombre', 'persona.apellido_paterno', 'servicio.nombre as servicio', 'reserva.fecha', 'reserva.hora_inicio', 'reserva.confirmacion', 'reserva.estado_pago', 'reserva.modalidad')
            ->where('psicologo.id_persona', '=', $id)->paginate(5);
    }



}
