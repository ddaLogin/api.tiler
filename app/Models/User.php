<?php

namespace App\Models;

use App\Extensions\ValidateTrait;
use App\Rules\Base64;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ValidateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * return array of validation rules for model
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'name' => 'required|min:2|max:15',
            'surname' => 'min:3|max:20',
            'email' => 'required|email|unique:users',
            'avatar' => [new Base64()],
            'password' => 'required|confirmed',
        ];
    }
}
