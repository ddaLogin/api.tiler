<?php

namespace App\Rules;

use App\Interfaces\CollectionRepositoryInterface;
use App\Repositories\MySQLCollectionRepository;
use Illuminate\Contracts\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class CollectionAccess implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //TODO make repository from DI
        $collection = (new MySQLCollectionRepository())->getById($value);
        return JWTAuth::parseToken()->authenticate()->id == $collection->user_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "You can't use this collection.";
    }
}
