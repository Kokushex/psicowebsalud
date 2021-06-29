<?php

namespace App\Http\Controllers;

use App\Models\ServicioPsicologo;
use App\Models\ModalidadServicio;
use App\Models\PrecioModalidad;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;



class ServicioController extends Controller
{
    public function indexServicio()
    {
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            if (auth()->user()) {
                //Se filtra el acceso solo a usuarios psicologos
                if(isset(auth()->user()->persona->psicologo->id_psicologo)) {
                    $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
                    //Devuelve la vista de DashboardHorario al encontrarse en una sesion
                    return view('servicio');
                }else{
                return view('home');
                }
            }else{
                //Si no se encuentra en una sesion es devuelto al inicio
                return view('welcome');
            }
        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }

    //Funcion para listar datos
    public function datos(){
        //Se abre un Try-Catch para que en caso de algun error se imprima un mensaje
        try {
            //Se autentifica el usuario
            $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
            //Se realiza una consulta para buscar los datos pertinentes de las diferentes tablas para cargar el DATATABLE

            //Se llama la funcion mostrarDatosTabla() dentro del modelo HorarioDias
            $servicios = ServicioPsicologo::mostrarDatosTabla($id_psicologo);
            //Se regresan los datos en forma de JSON para que la funcion en Ajax cargue los datos
            return datatables()->of($servicios)->toJson();

        } catch (\Exception $e) {
            //Se imprime el error encontrado
            print_r($e->getMessage());
        }
    }
    //funcion para guardar un nuevo servicio
    public function guardarServicio(Request $request){
        $id_psicologo = auth()->user()->persona->psicologo->id_psicologo;
        $dato = Servicio::buscarServicioDuplicado($request->textoOption);
        if($dato != null){
            $idServicio = $dato->id_servicio;
        }else {
            $servicio = Servicio::create([
                'nombre' => $request->textoOption,
                'descripcion' => $request->txtDesGeneralServicio]);
                $idServicio = $servicio->id_servicio;
        }

            $precioModalidad = PrecioModalidad::create([
                'precio_presencial' => $request -> txtPrecioModPresencialServicio,
                'precio_online' => $request -> txtPrecioModOnlineServicio,
            ]);
            $idPrecioModalidad = $precioModalidad->id_precio_modalidad;

            $modalidadServicio = ModalidadServicio::create([
                'presencial' => $request -> chxModPresencialServicio,
                'online' => $request -> chxModOnlineServicio,
                'id_precio_modalidad' => $idPrecioModalidad,
            ]);
            $idModalidadServicio = $modalidadServicio->id_modalidad_servicio;

            $servicioPsicologo = ServicioPsicologo::create([
                'id_psicologo' => $id_psicologo,
                'id_servicio' => $idServicio,
                'id_modalidad_servicio' => $idModalidadServicio,
                'estado_servicio' => $request->cbxEstadoServicio,
                'descripcion_particular' => $request->txtaDesPersonalServicio
            ]);
            return 1;
    }

    public function editarServicio(Request $request){
        $serviciosUpdate = ServicioPsicologo::findOrFail($request->id_servicio_psicologo);
        $serviciosUpdate->descripcion_particular = $request->descripcionPersonalEdit;
        $serviciosUpdate->save();

        $modalidad = ModalidadServicio::findOrFail($request->id_modalidad_servicio);
        $modalidad->presencial = $request->presencialEdit;
        $modalidad->online = $request->onlineEdit;
        $modalidad->visita = $request->visitaEdit;

        if($modalidad-> presencial == 0 && $modalidad -> online == 0){
            $estadoUpdate = ServicioPsicologo::findOrFail($request->id_servicio_psicologo);
            $estadoUpdate -> estado_servicio = 0;
            $estadoUpdate -> save();
        }
        $modalidad->save();

        $precioModalidad = PrecioModalidad::findOrFail($request->id_modalidad_precio);
        $precioModalidad->precio_presencial = $request->presencialPrecioEdit;
        $precioModalidad->precio_online = $request->onlinePrecioEdit;
        $precioModalidad->precio_visita = $request->visitaPrecioEdit;

        $precioModalidad->save();

        return 1;
    }
    //funcion para habilitar o deshabilitar un servicio
    public function cambiarEstadoServicio(Request $request){
        $serviciosPsicologo = ServicioPsicologo::findOrFail($request->input('id_servicio_psicologo'));
        if ($serviciosPsicologo->estado_servicio == 1) {
            $serviciosPsicologo->estado_servicio = 0;
        } else {
            $serviciosPsicologo->estado_servicio = 1;
        }
        $serviciosPsicologo->save();
        return response()->json(['mensaje'=>'1']);
    }

    //funcion que llama al metodo en el modelo de servicio para evitar duplicados
    public function buscarServicioDuplicado(Request $request){
        $datos = Servicio::buscarServicioDuplicado($request->parametros);
        return json_encode($datos);
    }

    public function detalleServicio(Request $request){
        $servicios = ServicioPsicologo::datosDetalle($request->id_servicio_psicologo);
        return $servicios;
    }


    public function cargarDatosSelect2(){
        $datos = Servicio::datosParaSelect2();
        return json_encode($datos);
    }

    public function rellenarModalAgregar(Request $request){
        $datos=Servicio::rellenarModalAgregar($request->index);
        return json_encode($datos);
    }



}
