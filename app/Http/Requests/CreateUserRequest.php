<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:2|max:15',
            'surname' => 'min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'terms' => 'required|accepted',
        ];
    }
}
