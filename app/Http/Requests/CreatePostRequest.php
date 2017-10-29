<?php

namespace App\Http\Requests;

use App\Rules\CollectionAccess;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'categories.*' => 'exists:categories,id',
            'collections.*' => ['exists:collections,id', new CollectionAccess()],
            'title' => 'required|max:150',
            'text' => 'required',
        ];
    }
}
