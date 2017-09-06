<?php

namespace Tests;


use Tymon\JWTAuth\Facades\JWTAuth;

trait JWTAuthTrait
{
    /**
     * return authorization header with JWT token to admin
     *
     * @param $user
     * @return array
     */
    private function getJWTHeader($user = null)
    {
        if(!$user){
            $user = \App\Models\User::findorfail(1);
        }
        $token = JWTAuth::fromUser($user);

        return ['Authorization' => "Bearer $token"];
    }
}