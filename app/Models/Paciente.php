<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use \stdClass;
/**
 * @property int $id_paciente
 * @property int $id_persona
 * @property string $escolaridad
 * @property string $ocupacion
 * @property string $estado_civil
 * @property string $grupo_familiar
 * @property string $estado_clinico
 * @property string $informacion
 * @property string $observacion_alta
 * @property string $tipo_alta
 * @property string $tipo_paciente
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property Reserva[] $reservas
 * @property Testimonio[] $testimonios
 */
class Paciente extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paciente';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_paciente';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'escolaridad', 'ocupacion', 'estado_civil', 'grupo_familiar', 'estado_clinico', 'informacion', 'observacion_alta', 'tipo_alta', 'tipo_paciente', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'id_persona', 'id_persona');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_paciente', 'id_paciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonios()
    {
        return $this->hasMany('App\Models\Testimonio', 'id_paciente', 'id_paciente');
    }

    public static function createPaciente($id_user, $id_persona){//------------basicamente agregarle el return
        $paciente = new Paciente();

        $paciente->id_persona=$id_persona;
        //Estos datos son recopilados para el trabajo del psicologo
        $paciente->escolaridad='';
        $paciente->ocupacion='';
        $paciente->estado_civil='';
        $paciente->grupo_familiar='';
        //
        $paciente->estado_clinico='';
        $paciente->informacion='';
        $paciente->observacion_alta='';
        $paciente->tipo_alta='';
        $paciente->tipo_paciente='Titular';

        $paciente->save();
        return $paciente;
    }

    public function datosPacienteLogeado(){
        $user_id = auth()->user()->id;
        $paciente = Persona::
        select('id_persona')
        ->with('paciente')
        ->where('persona.id_user', $user_id)
        ->first();

            if(empty($paciente)){
                $paciente = new stdClass();
                $paciente->run= '';
                $paciente->nombre= '';
                $paciente->apellido_paterno= '';
                $paciente->apellido_materno= '';
                $paciente->fecha_nacimiento= '';
                $paciente->genero= '';
                $paciente->direccion= '';
                $paciente->comuna= '';
                $paciente->region= '';
                $paciente->telefono= '';
                $paciente->id_paciente= '';
                $paciente->escolaridad= '';
                $paciente->ocupacion= '';
                $paciente->estado_civil= '';
                $paciente->grupo_familiar= '';
                $paciente->estado_clinico='';
                $paciente->informacion='';
                $paciente->observacion_alta='';
                $paciente->tipo_alta='';
                $paciente->tipo_paciente='';

            }
        return $paciente;
    }

    public function updatePaciente($request){
        return Paciente::where('id_persona', auth()->user()->persona->id_persona)
            ->update([
                'escolaridad' => $request->escolaridad,
                'ocupacion' => $request->ocupacion,
                'estado_civil' => $request->estado_civil,
                'grupo_familiar' => $request->grupo_familiar,
            ]);
    }

    public static function getDatosLogeado(){
        $usuarioLogeado = Paciente::join('persona', 'persona.id_persona', '=', 'paciente.id_persona')
            ->join('users', 'users.id_user', '=', 'persona.id_user')->select('users.email','persona.nombre',
                'persona.apellido_paterno','persona.run','persona.telefono','paciente.id_paciente')
            ->where('users.id_user', '=', auth()->user()->id_user)->first();

        return $usuarioLogeado;
    }

    /**
     * getDatosPaciente
     *
     * obtencion de datos generales del paciente de una determinada reserva
     *
     */
    public static function getDatosPaciente($id_reserva){

        $paciente = Paciente::join('persona','persona.id_persona','=','paciente.id_persona')
            ->join('reserva','reserva.id_paciente','=','paciente.id_paciente')
            ->where('reserva.id_reserva','=',$id_reserva)
            ->select('persona.nombre','persona.apellido_paterno','persona.apellido_materno',
                'persona.fecha_nacimiento as edad')
            ->first();

        $fecha = Carbon::parse($paciente->edad); //captura de edad
        $edadCalculada = Carbon::now()->diffInYears($fecha); //calculo de edad
        $paciente->edad = $edadCalculada;

        return $paciente;

    }

}
