<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidaciones extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|max:191|min:8',
            'password_confirmation' => 'required|string|max:191|min:8|same:password',
        ];
    }
    public function messages()
    {
        return[ 'unique' => 'El :attribute ya se encuentra registrado',
        'required' => 'El campo :attribute es obligatorio.',
        'same' => 'Las contraseñas no coinciden',
        'max' => 'Demasiados caracteres',
        'min' => 'La contraseña debe contener minimo 8 caracteres'];


    }

    public function attributes()
    {
        return[
            'password_confirmation' => 'Confirmar Contraseña',
            'email' => 'Email',
            'password' => 'Contraseña',



        ];
    }

}