<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.08.2017
 * Time: 17:26
 */

namespace App\Extensions;


trait ValidateTrait
{
    /**
     * return array of validation rules for model
     *
     * @return array
     */
    abstract public function getValidationRules():array;
}