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
            'run' =>'required|regex:/^[kK0-9-]*$/|max:10',
            'nombre' => 'bail|required|regex:/^[a-zA-Z ]*$/|max:191',
            'apellido_paterno' => 'bail|required|regex:/^[a-zA-Z-]*$/|max:191',
            'apellido_materno' => 'bail|required|regex:/^[a-zA-Z-]*$/|max:191',
            'fecha_nacimiento'=> 'required|date',
            'genero'=> 'required|not_in:0',
            'comuna'=> 'required|not_in:0',
            'region'=> 'required|not_in:0',
            'telefono'=> 'required|digits:9',
            'direccion'=> 'bail|regex:/^[a-zA-Z0-9 .-]*$/|max:191',            
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

