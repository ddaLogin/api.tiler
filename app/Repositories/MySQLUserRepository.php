<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 14:06
 */

namespace App\Repositories;


use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class MySQLUserRepositoryInterface implements UserRepositoryInterface
{
    /**
     * return target model by id
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        return User::findorfail($id);
    }

    /**
     * return user by email
     *
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    /**
     * store|update user
     *
     * @param array $data
     * @param int|null $id
     * @return User
     * @throws \Exception
     */
    public function store(array $data, int $id = null): User
    {
        $user = ($id)?$this->getById($id):new User();

        if(key_exists('password', $data)){
            $user->password = $data['password'];
        }

        $user->fill($data);

        if($user->save()){
            return $user;
        }

        throw new \Exception("Couldn't store user");
    }
}