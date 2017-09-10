<?php

namespace App\Http\Requests;

use App\Models\Post;
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
            'category_id' => 'exists:categories,id',
            'collection_id' => ['exists:collections,id', new CollectionAccess()],
            'title' => 'required|max:150',
            'text' => 'required',
        ];
    }
}
