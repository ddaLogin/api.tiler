<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 13:50
 */

namespace App\Services;


use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserService
{
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * registration new user
     *
     * @param array $data
     * @return User
     */
    public function registration(array $data):User
    {
        return $this->userRepository->store($data);
    }
}