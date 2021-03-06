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
use Illuminate\Database\Eloquent\Collection;

class MySQLUserRepository implements UserRepositoryInterface
{
    /**
     * return target model by id
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id)
    {
        return User::findorfail($id);
    }

    /**
     * return user by email
     *
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email)
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
    public function store(array $data, int $id = null)
    {
        $user = ($id)?$this->getById($id):new User();

        if(key_exists('password', $data)){
            $user->password = bcrypt($data['password']);
        }

        $user->fill($data);

        if($user->save()){
            return $user;
        }

        throw new \Exception("Couldn't store user");
    }

    /**
     * return all users
     *
     * @param array $with
     * @return Collection
     */
    public function all(array $with = [])
    {
        return User::with($with)->get();
    }

    /**
     * return all users order by created at and paginate
     *
     * @param $size
     * @param array $with
     * @return Collection
     */
    public function getAllOrderByCreatedAtAndPaginate($size, array $with = [])
    {
        return User::orderBy('created_at', 'DESC')->with($with)->paginate($size);
    }
}