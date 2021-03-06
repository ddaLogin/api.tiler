<?php

namespace App\Models;

use App\Extensions\ValidateTrait;
use App\Rules\Base64;
use HttpOz\Roles\Traits\HasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'avatar', 'options'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    public function toArray($cutOptions = true)
    {
        $attributes = $this->attributesToArray();

        if ($cutOptions){
            unset($attributes['options']);
        }

        return array_merge($attributes, $this->relationsToArray());
    }


    /**
     * return all user's posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * return all user's collections
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * return users' likes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class)->where('status', '=', true);
    }

    /**
     * return users' dislikes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dislikes()
    {
        return $this->hasMany(Like::class)->where('status', '=', false);
    }
}
