<?php

namespace App\Models;

use App\Extensions\ValidateTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use ValidateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'title', 'text', 'preview',
    ];

    /**
     * return array of validation rules for model
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'user_id' => 'exists:users,id',
            'category_id' => 'exists:categories,id',
            'title' => 'required|max:150',
            'text' => 'required',
        ];
    }
}
