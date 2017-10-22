<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 13:50
 */

namespace App\Services;


use App\Interfaces\UserRepositoryInterface;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
        $user = $this->userRepository->store($data);
        if ($user){
            Mail::to($user->email)->send(new UserRegistrationMail($user));
        }
        return $user;
    }

    /**
     * update user by id
     *
     * @param array $data
     * @param int $user_id
     * @return User
     */
    public function update(array $data, int $user_id):User
    {
        return $this->userRepository->store($data, $user_id);
    }
}