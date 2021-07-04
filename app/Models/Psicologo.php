<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \stdClass;

/**
 * @property int $id_psicologo
 * @property int $id_persona
 * @property string $titulo
 * @property string $especialidad
 * @property string $descripcion
 * @property string $verificado
 * @property string $casa_academica
 * @property string $grado_academico
 * @property string $fecha_egreso
 * @property int $experiencia
 * @property int $imagen_titulo
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property FormacionProfesional[] $formacionProfesionals
 * @property GradoAcademico[] $gradoAcademicos
 * @property Horario[] $horarios
 * @property ServicioPsicologo[] $servicioPsicologos
 * @property Testimonio[] $testimonios
 */
class Psicologo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'psicologo';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_psicologo';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'titulo', 'especialidad', 'descripcion', 'verificado', 'casa_academica', 'grado_academico', 'fecha_egreso', 'experiencia', 'imagen_titulo', 'created_at', 'updated_at'];

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
    public function formacionProfesionals()
    {
        return $this->hasMany('App\Models\FormacionProfesional', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradoAcademicos()
    {
        return $this->hasMany('App\Models\GradoAcademico', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany('App\Models\Horario', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPsicologos()
    {
        return $this->hasMany('App\Models\ServicioPsicologo', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonios()
    {
        return $this->hasMany('App\Models\Testimonio', 'id_psicologo', 'id_psicologo');
    }

    /* Metodo para crear un psicologo */
    public function createPsicologo($id_user, $id_persona)
    {
        $psicologo = new Psicologo();
        $psicologo->id_persona = $id_persona;
        $psicologo->titulo = '';
        $psicologo->especialidad = '';
        $psicologo->descripcion = '';
        $psicologo->verificado = 'EN ESPERA';
        $psicologo->casa_academica = '';
        $psicologo->grado_academico = '';
        $psicologo->experiencia = 0;
        $psicologo->imagen_titulo = '';
        $psicologo->save();

        $direccionAtencion = DireccionAtencion::generarDireccion();

        return $psicologo;
    }

    public function datosPsicologoLogeado()
    {
        $user_id = auth()->user()->id;
        $psicologo = Persona::
        select('id_persona')
            ->with('psicologo')
            ->where('persona.id_user', $user_id)
            ->first();

        if (empty($psicologo)) {
            $psicologo = new stdClass();
            $psicologo->run = '';
            $psicologo->nombre = '';
            $psicologo->apellido_paterno = '';
            $psicologo->apellido_materno = '';
            $psicologo->fecha_nacimiento = '';
            $psicologo->genero = '';
            $psicologo->direccion = '';
            $psicologo->comuna = '';
            $psicologo->region = '';
            $psicologo->telefono = '';
            $psicologo->id_psicologo = '';
            $psicologo->titulo = '';
            $psicologo->especialidad = '';
            $psicologo->descripcion = '';
            $psicologo->verificado = '';
            $psicologo->casa_academica = '';
            $psicologo->grado_academico = '';
            $psicologo->fecha_egreso = '';
            $psicologo->experiencia = '';
            $psicologo->imagen_titulo = '';

        }
        return $psicologo;
    }

    public function updatePsicologo($request)
    {
        return Psicologo::where('id_persona', auth()->user()->persona->id_persona)
            ->update([
                'titulo' => $request->titulo,
                'especialidad' => $request->especialidad,
                'descripcion' => $request->descripcion,
                'casa_academica' => $request->casa_academica,
                'grado_academico' => $request->grado_academico,
                'fecha_egreso' => $request->fecha_egreso,
            ]);
    }

    //metodo obtención modalidades del psicologo
    public static function getModalidades($psicologos)
    {
        foreach ($psicologos as $item) {
            $presencial = false;
            $online = false;

            $obtenerModalidades = ModalidadServicio::getModalidadesServicio($item->id_psicologo);
            foreach ($obtenerModalidades as $item2) {
                if ($item2->presencial == "1") {
                    $presencial = true;
                }
                if ($item2->online == "1") {
                    $online = true;
                }
                if ($presencial == true && $online == true) {
                    break;
                }
            }
            if ($presencial == true) {
                $item->modalidades = "Presencial";
            }
            if ($online == true) {
                $item->modalidades = $item->modalidades . ',' . "Online";
            }

        }
    }

    //obtiene el perfil del psicologo
    public static function getProfile($id)
    {
        //obtención de datos del psicólogo aplicando un join para intercalar datos de otra tabla asociada
        $user = Psicologo::where('id_psicologo', '=', $id)->join('persona', 'psicologo.id_persona', '=', 'persona.id_persona')
            ->firstOrFail();
        return $user;
    }

    //metodo que obtiene lista de psicologos
    public static function getListaPsicologos()
    {
        $psicologos = Psicologo::select('especialidad', 'experiencia', 'id_psicologo', 'id_persona')
            ->with(['persona' => function ($query) {
                $query->select(['id_persona', 'nombre', 'apellido_paterno', 'apellido_materno', 'direccion', 'comuna']);
            }
            ])
            ->with(['servicioPsicologos' => function ($query) {
                $query->select(['id_psicologo', 'id_modalidad_servicio'])
                    ->with(['modalidadServicio' => function ($query) {
                        $query->select(['id_modalidad_servicio', 'presencial', 'online', 'visita']);
                    }
                    ]);
            }
            ])->where('verificado', '=', 'VERIFICADO')
            ->get();


        return $psicologos;
    }

    //metodo obtención modalidades del psicologo
    public static function getModalidad($psicologo)
    {
        return $modalidades = ServicioPsicologo::
        select('id_psicologo', 'id_modalidad_servicio')
            ->with(['modalidadServicio' => function ($query) {
                $query->select(['presencial', 'online', 'visita'])
                    ->groupBy('presencial', 'online', 'visita');
            }])
            ->where('id_psicologo', $psicologo)
            ->get();
    }

    public static function getCentroServicio($id)
    {
        $id_psicologo =ServicioPsicologo::findOrFail($id,['id_psicologo']);
        $id_persona = Psicologo::findOrFail($id_psicologo->id_psicologo,['id_persona']);
        $id_user = Persona::findOrFail($id_persona->id_persona,['id_user']);
        $direccion = DireccionAtencion::select('direccion')->where('id_user', $id_user->id_user)->first();
        return $direccion->direccion;

    }

}

