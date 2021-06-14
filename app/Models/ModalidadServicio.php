<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_modalidad_servicio
 * @property int $id_precio_modalidad
 * @property boolean $presencial
 * @property boolean $online
 * @property boolean $visita
 * @property string $updated_at
 * @property string $created_at
 * @property PrecioModalidad $precioModalidad
 * @property ServicioPsicologo[] $servicioPsicologos
 */
class ModalidadServicio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modalidad_servicio';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_modalidad_servicio';

    /**
     * @var array
     */
    protected $fillable = ['id_precio_modalidad', 'presencial', 'online', 'visita', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function precioModalidad()
    {
        return $this->belongsTo('App\Models\PrecioModalidad', 'id_precio_modalidad', 'id_precio_modalidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPsicologos()
    {
        return $this->hasMany('App\Models\ServicioPsicologo', 'id_modalidad_servicio', 'id_modalidad_servicio');
    }



    //obtener las modalidades de los  servicios del psicologo

    public static function getModalidadesServicioEnPerfil($servicios){

        foreach ($servicios as $key) {

            $modalidades = array();
            $modalidad = ModalidadServicio::join('servicio_psicologo','modalidad_servicio.id_modalidad_servicio', '=' ,'servicio_psicologo.id_modalidad_servicio')->where('servicio_psicologo.id_servicio_psicologo','=',$key->id_servicio_psicologo)->get();

            foreach ($modalidad as $key2) {

                if($key2->presencial == "1"){
                    array_push($modalidades,'Presencial');

                }

                if($key2->visita == "1"){
                    array_push($modalidades,'Visita');

                }

                }

                $key->id_servicio = implode(', ',$modalidades);
            }

        }


    public static function getModalidadesServicio($idPsicologo){
        return ModalidadServicio::join('servicio_psicologo',
            'modalidad_servicio.id_modalidad_servicio','=','servicio_psicologo.id_modalidad_servicio')
            ->select('presencial','online','visita')->where('id_psicologo','=',$idPsicologo)->get();
    }

    /**
     * getModalidadesServicioModal
     *
     * método para obtener las modalidades del servicio para utilizar en el modal a la hora de
     * crear una reserva por parte del paciente
     *
     */
    public static function getModalidadesServicioModal($id){

        $modalidad = ModalidadServicio::join('servicio_psicologo','modalidad_servicio.id_modalidad_servicio', '=' ,'servicio_psicologo.id_modalidad_servicio')->select('presencial','online','id_precio_modalidad')
            ->where('servicio_psicologo.id_servicio_psicologo','=',$id)
            ->first();

        $modalidades = array();
        if($modalidad->presencial == 1){
            array_push($modalidades,'Presencial');

        }

        if($modalidad->online == 1){
            array_push($modalidades,'Online');

        }

        return $modalidades;


    }
}
