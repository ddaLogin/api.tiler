<?php

namespace App\Models;

use App\Extensions\ValidateTrait;
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
        'name', 'surname', 'email', 'password',
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
            'password' => 'required|confirmed'
        ];
    }

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
