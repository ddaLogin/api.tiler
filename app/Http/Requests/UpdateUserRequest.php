<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'min:2|max:15',
            'surname' => 'min:3|max:20',
            'email' => ['email', Rule::unique('users')->ignore($this->user->id)],
            'password' => 'confirmed',
            'current_password' => 'required',
        ];
    }
}
