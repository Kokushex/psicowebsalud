<?php

namespace App\Models;

use App\Models\DireccionAtencion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id_persona
 * @property int $id_user
 * @property string $run
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $fecha_nacimiento
 * @property string $genero
 * @property string $telefono
 * @property string $direccion
 * @property string $comuna
 * @property string $region
 * @property string $updated_at
 * @property string $created_at
 * @property User $user
 * @property Paciente[] $pacientes
 * @property Psicologo[] $psicologos
 */
class Persona extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persona';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_persona';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'run', 'nombre', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'genero', 'telefono', 'direccion', 'comuna', 'region', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id_user');
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pacientes()
    {
        return $this->hasMany('App\Models\Paciente', 'id_persona', 'id_persona');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'id_persona', 'id_persona');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_persona', 'id_persona');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function psicologos()
    {
        return $this->hasMany('App\Models\Psicologo', 'id_persona', 'id_persona');
    }
//Cambiar por update persona
    public function updatePersona($request){


        if (isset(auth()->user()->persona->psicologo)) {
            $direccionAtencion = DireccionAtencion::updateDireccionAtencion($request);
        }

        $persona = new Persona();

    return $persona = Persona::where('id_user', Auth::id())
        ->update([
            'run' => $request->run,
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'telefono' => $request->telefono,
            'region' => $request->region,
            'comuna' => $request->comuna,
            'direccion' => $request->direccion,
        ]);

    }
        public static function generarPersona(){

        $persona = new Persona();
        $persona->id_user = Auth::id();
        $persona->save();
        return $persona;

    }



}
