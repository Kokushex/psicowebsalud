<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;

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


    public function Buscar($id)
    {



        $usuario = User::BuscarValores($id);
        $nombrerol = $usuario->id_roles;


        if ($nombrerol == 2) {

            $usuario1 = User::buscarpsicologo($id);
            return view('/dash_admin/detallePsicologo', compact('usuario1'));
        } elseif ($nombrerol != 2) {
            $usuario2 = User::buscarPaciente($id);
            return view('/dash_admin/detallePaciente', compact('usuario2'));
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



}
