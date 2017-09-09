<?php

namespace App\Models;

use App\Extensions\ValidateTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'title', 'text', 'preview',
    ];
}
