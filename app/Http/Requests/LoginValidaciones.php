<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Cookie;

class LoginValidaciones extends FormRequest
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
        // Para cuando se complete este proyecto para validar email seria bueno
        // utilizar la opcion dns de email, con esto se valida que el email exista.
        if (Cookie::get('access_error') >= 5) {
            return [
                'email' => 'required|email:rfc',
                'password' => 'required',
                'captcha' => 'required|captcha',
            ];
        } else {
            return [
                'email' => 'required|email:rfc',
                'password' => 'required',
            ];
        }
    }
    public function attributes()
    {
        return[
            'password' => 'Contraseña',
            'email' => 'Email',
        ];
    }


}
