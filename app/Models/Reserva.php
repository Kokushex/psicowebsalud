<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;


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

}
