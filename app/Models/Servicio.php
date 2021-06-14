<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_servicio
 * @property string $nombre
 * @property string $descripcion
 * @property string $created_at
 * @property string $updated_at
 * @property ServicioPsicologo[] $servicioPsicologos
 */
class Servicio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicio';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_servicio';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPsicologos()
    {
        return $this->hasMany('App\Models\ServicioPsicologo', 'id_servicio', 'id_servicio');
    }

    public static function buscarServicioDuplicado($parametro){
        return Servicio::select('id_servicio')
            ->where('nombre','=',$parametro)
            ->first();
    }

    public static function datosParaSelect2(){
        return Servicio::select('id_servicio','nombre')
            ->get();
    }

    public static function rellenarModalAgregar($value){
        return Servicio::select('servicio.descripcion')
            ->where('servicio.id_servicio','=',$value)
            ->get();
    }

    /**
     * getDatosServicio
     *
     * obtener varios datos asociados al un determinado servicio psicológico.
     *
     */
    public static function getDatosServicio($id_servicio_psicologo){
        return Servicio::join('servicio_psicologo','servicio_psicologo.id_servicio','=','servicio.id_servicio')
            ->join('psicologo','psicologo.id_psicologo','=','servicio_psicologo.id_psicologo')
            ->join('persona','persona.id_persona','=','psicologo.id_persona')
            ->where('servicio_psicologo.id_servicio_psicologo','=',$id_servicio_psicologo)
            ->select('servicio.nombre as nombre_servicio','persona.nombre as nombre_psicologo','persona.apellido_paterno as apellido_psicologo', 'servicio.id_servicio','persona.id_user','servicio_psicologo.id_servicio_psicologo')
            ->first();

    }
}
