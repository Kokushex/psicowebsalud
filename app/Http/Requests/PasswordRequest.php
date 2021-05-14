<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /*public function rules()
    {
        return [
            'old_password' => ['required', 'min:6', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'min:6'],

        ];
    }*/
    public function rules()
    {
        return [
            'contraseña_act' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ];
    }

    public function messages()
    {
        return[
            //'correo.required' => 'El :attribute es obligatorio',
            //'correo.unique' => 'El :attribute no se puede cambiar',
            'contraseña_act.required' => 'Completar la :attribute',
            'password.required' => 'Completar el  campo :attribute',
            'password.min:8' => 'Minino de 8 caracteres la :attribute',
            'password_confirmation.confirmed' => 'Las contraseñas no coinciden',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return[
            'contraseña_act' => 'Contraseña Actual',
            'password' => 'Nueva Contraseña',
            'password_confirmation' => 'Confirmar Contraseña',

        ];
    }
    /*
    public function attributes()
    {
        return [
            'old_password' => __('current password'),
        ];
    }
    */
}
