<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 13:42
 */

namespace App\Extensions;


use Illuminate\Foundation\Http\FormRequest;

class JsonRequest extends FormRequest
{
    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson()
    {
        return true;
    }
}