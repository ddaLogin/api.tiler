<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 14:02
 */

namespace App\Interfaces;


use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * return user by id
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id);

    /**
     * return user by email
     *
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email);

    /**
     * store|update user
     *
     * @param array $data
     * @param int|null $id
     * @return User
     */
    public function store(array $data, int $id = null);
}