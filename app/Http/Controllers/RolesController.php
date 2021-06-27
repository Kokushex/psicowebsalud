<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use App\Models\Persona;
use App\Models\Paciente;
use App\Models\Psicologo;

class RolesController extends Controller
{
    public function indexRoles()
    {
        return view('roles');
    }


    /**
     * Metodo para ingresar a la vista de gestion de usuarios
     */

    public function Listar()
    {

        $usuario2 = User::listasCompleta();
        $listaDeRoles = User::listaRol();
        return view('gestionUsuarios', compact('usuario2', 'listaDeRoles'));
    }

    /**
     * Metodo para buscar los usuarios
     *
     */

    public function Buscar($id)
    {



        $usuario = User::BuscarValores($id);
        $nombrerol = $usuario->id_roles;


        if ($nombrerol == 2) {

            $usuario1 = User::buscarpsicologo($id);
            return view('/roles/detallePsicologo', compact('usuario1'));
        } elseif ($nombrerol != 2) {
            $usuario2 = User::buscarPaciente($id);
            return view('/roles/detallePaciente', compact('usuario2'));
        }

    }

    /**
     * Metodo que busca al usuario en UsuarioRol y envia los datos a la vista updateRol.blade.php
     * try catch para controlar exepciones y error (para futura revisión)
     */
    public function mandaId($id)
    {
        $rol = UsuarioRol::findOrFail($id);
        $datos = User::BuscarValores($id);
        $listaDeRoles = User::listaRol();
        return view('dashboard.dash_admin.updateRol', compact('rol', 'listaDeRoles', 'datos'));
    }

    /**
    *Funcion que permite hacer el cambio en el campo banned_till dependiendo del id de usuario que se recibe
    */

    public function ban($id)
    {
        $updateban = User::findOrFail($id);
        $updateban->banned_till = "1";
        $updateban->save();
        return back()->with('success', 'Usuario baneado');
    }
    public function unban($id){
        $updateban=User::findOrFail($id);
        $updateban->banned_till="0";
        $updateban->save();
        return back()->with('success', 'Usuario desbaneado');
    }

    /**
     * Metdoo para realizar la actualizacion en los campos necesarios para el paciente
     */
    public function updatePa(Request $request)
    {
        $iduser = $request->id_user;
        $idper = $request->id_per;
        $idpac = $request->id_pac;

        $correo = $request->email;

        $rut = $request->rut;
        $telefono = $request->telefono;
        $comuna = $request->comuna;
        $region = $request->region;
        $fecha_nac = $request->fecha_nacimiento;
        $nombre = $request->nombre;
        $apellido_p = $request->apellido_paterno;
        $apellido_m = $request->apellido_materno;
        $direccion = $request->direccion;
        $genero = $request->genero;

        $estado_civ = $request->estado_civ;
        $escolaridad = $request->escolar;
        $profesion = $request->profesion;
        $estado_cli = $request->estado_cli;
        $grupo_fam = $request->grupo_fam;

        $updateuser = User::findOrFail($iduser);
        $updateuser->email = $correo;

        $updatepaciente = Paciente::findOrFail($idpac);
        $updatepaciente->estado_civil = $estado_civ;
        $updatepaciente->escolaridad = $escolaridad;
        $updatepaciente->ocupacion = $profesion;
        $updatepaciente->estado_clinico = $estado_cli;
        $updatepaciente->grupo_familiar = $grupo_fam;

        $updatepersona = Persona::findOrFail($idper);
        $updatepersona->run = $rut;
        $updatepersona->telefono = $telefono;
        $updatepersona->comuna = $comuna;
        $updatepersona->region = $region;
        $updatepersona->fecha_nacimiento = $fecha_nac;
        $updatepersona->nombre = $nombre;
        $updatepersona->apellido_paterno = $apellido_p;
        $updatepersona->apellido_materno = $apellido_m;
        $updatepersona->direccion = $direccion;
        $updatepersona->genero = $genero;

        $updateuser->save();
        $updatepaciente->save();
        $updatepersona->save();
        return back()->with('success', 'Datos editados con exito');;
    }

    /**
     * Metodo para realizar la actualizacion en los campos necesarios para el psicologo
     */

    public function updatePsi(Request $request)
    {
        $iduser = $request->id_user;
        $idper = $request->id_per;
        $idpsi = $request->id_psi;

        $correo = $request->email;

        $rut = $request->rut;
        $telefono = $request->telefono;
        $comuna = $request->comuna;
        $region = $request->region;
        $fecha_nac = $request->fecha_nacimiento;
        $nombre = $request->nombre;
        $apellido_p = $request->apellido_paterno;
        $apellido_m = $request->apellido_materno;
        $direccion = $request->direccion;
        $genero = $request->genero;

        $grado = $request->grado;
        $casa_academica = $request->casa_aca;
        $especialidad = $request->especial;


        $updateuser = User::findOrFail($iduser);
        $updateuser->email = $correo;

        $updatepsicologo = Psicologo::findOrFail($idpsi);
        $updatepsicologo->grado_academico = $grado;
        $updatepsicologo->casa_academica = $casa_academica;
        $updatepsicologo->especialidad = $especialidad;

        $updatepersona = Persona::findOrFail($idper);
        $updatepersona->run = $rut;
        $updatepersona->telefono = $telefono;
        $updatepersona->comuna = $comuna;
        $updatepersona->region = $region;
        $updatepersona->fecha_nacimiento = $fecha_nac;
        $updatepersona->nombre = $nombre;
        $updatepersona->apellido_paterno = $apellido_p;
        $updatepersona->apellido_materno = $apellido_m;
        $updatepersona->direccion = $direccion;
        $updatepersona->genero = $genero;

        $updateuser->save();
        $updatepsicologo->save();
        $updatepersona->save();
        return back()->with('success', 'Datos editados con exito');
    }

    /**
     * Metodo para
     */

    public function solicitudes()
    {
        $solicitud = User::psicologoSolicitud();
        return view('roles.solicitudes', compact('solicitud'));
    }

    /**
     * Metodo para
     */

    public function cambioEstado($id)
    {
        $updateestado = Psicologo::findOrFail($id);
        $updateestado->verificado = "VERIFICADO";
        $updateestado->save();
        return back()->with('success', 'Estado cambiado');
    }




}
