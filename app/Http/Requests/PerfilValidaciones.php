<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PerfilValidaciones extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'run' =>'required|max:10',
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required:alpha',
            'fecha_nacimiento'=> 'required',
            'genero'=> 'required|not_in:0',
            'comuna'=> 'required|not_in:0',
            'region'=> 'required|not_in:0',
            'telefono'=> 'required|max:9|min:9',
            
        ];
    }

    public function messages()
    {
        return [
            'run.required' => 'El :attribute es obligatorio',

        ];
    }

    public function attributes()
    {
        return [
            'run' => 'Run',
            
        ];
    }
}

