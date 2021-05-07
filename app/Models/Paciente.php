<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

//         $paciente = Paciente::select(
//             'persona.run',
//             'persona.nombre',
//             'persona.apellido_paterno',
//             'persona.apellido_materno',
//             'persona.fecha_nacimiento',
//             'persona.genero',
//             'persona.direccion',
//             'persona.comuna',
//             'persona.region',
//             'persona.telefono',

//             'paciente.id_paciente',
//             'paciente.escolaridad',
//             'paciente.ocupacion',
//             'paciente.estado_civil',
//             'paciente.grupo_familiar',
//             'paciente.estado_clinico',
//             'paciente.informacion',
//             'paciente.observacion_alta',
//             'paciente.tipo_alta',
//             'paciente.tipo_paciente'
//         )
//             /*->join('users', function ($join) {
//                 $join->on('users.id', '=', 'persona.id_user');
//             })
//             ->join('persona', function ($join) {
//                 $join->on('paciente.id_persona', '=', 'persona.id_persona');
//             })
// */
//             ->join('users', function ($join) {
//                 $join->on('users.id_user', '=', 'persona.id_user');
//             })
//             ->join('persona', function ($join) {
//                 $join->on('paciente.id_persona', '=', 'persona.id_persona');
//             })

//             ->where('users.id_user', '=', $user_id)
//             ->first();
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
}
