<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_servicio_psicologo
 * @property int $id_psicologo
 * @property int $id_servicio
 * @property int $id_modalidad_servicio
 * @property boolean $estado_servicio
 * @property string $descripcion_particular
 * @property string $updated_at
 * @property string $created_at
 * @property ModalidadServicio $modalidadServicio
 * @property Psicologo $psicologo
 * @property Servicio $servicio
 * @property Reserva[] $reservas
 * @property ServicioPrevision[] $servicioPrevisions
 */
class ServicioPsicologo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicio_psicologo';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_servicio_psicologo';

    /**
     * @var array
     */
    protected $fillable = ['id_psicologo', 'id_servicio', 'id_modalidad_servicio', 'estado_servicio', 'descripcion_particular', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidadServicio()
    {
        return $this->belongsTo('App\Models\ModalidadServicio', 'id_modalidad_servicio', 'id_modalidad_servicio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psicologo()
    {
        return $this->belongsTo('App\Models\Psicologo', 'id_psicologo', 'id_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio', 'id_servicio', 'id_servicio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicioPrevisions()
    {
        return $this->hasMany('App\Models\ServicioPrevision', 'id_servicio_psicologo', 'id_servicio_psicologo');
    }

    /**
     * Metodo que permite mostrar los datos en la tabla de servicio
     */

    public static function mostrarDatosTabla($id_psicologo)
    {
        $serviciosPsicologo = ServicioPsicologo::select('id_servicio_psicologo', 'servicio.nombre', 'estado_servicio')
            ->join('servicio', 'servicio.id_servicio', '=', 'servicio_psicologo.id_servicio')
            ->where('id_psicologo', $id_psicologo)
            ->get();
        return $serviciosPsicologo;
    }

    /**
     * Metodo para obtener los datos especificos de un servicio
     */
    public static function datosDetalle($id_servicio_psicologo)
    {
        $serviciosPsicologo = ServicioPsicologo::select('modalidad_servicio.id_modalidad_servicio', 'precio_modalidad.id_precio_modalidad', 'servicio_psicologo.descripcion_particular', 'servicio.nombre', 'precio_modalidad.precio_presencial', 'precio_modalidad.precio_online',
            'precio_modalidad.precio_visita', "modalidad_servicio.presencial", "modalidad_servicio.online", "modalidad_servicio.visita")
            ->join('servicio', 'servicio.id_servicio', '=', 'servicio_psicologo.id_servicio')
            ->join('modalidad_servicio', 'modalidad_servicio.id_modalidad_servicio', '=', 'servicio_psicologo.id_modalidad_servicio')
            ->join('precio_modalidad', 'precio_modalidad.id_precio_modalidad', '=', 'modalidad_servicio.id_precio_modalidad')
            ->where('id_servicio_psicologo', $id_servicio_psicologo)
            ->get();
        return $serviciosPsicologo;
    }

    public static function getServiciosPsicologo($id)
    {

        return ServicioPsicologo::join('servicio', 'servicio.id_servicio', '=', 'servicio_psicologo.id_servicio')
            ->where('servicio_psicologo.id_psicologo', '=', $id)->where('estado_servicio', '=', '1')->get();

    }


}
