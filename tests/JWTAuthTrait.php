<?php

namespace Tests;


use Tymon\JWTAuth\Facades\JWTAuth;

trait JWTAuthTrait
{
    /**
     * return authorization header with JWT token to admin
     *
     * @param $user_id
     * @return array
     */
    private function getJWTHeader($user_id = 1)
    {
        $user = \App\Models\User::findorfail($user_id);
        $token = JWTAuth::fromUser($user);

        return ['Authorization' => "Bearer $token"];
    }
}