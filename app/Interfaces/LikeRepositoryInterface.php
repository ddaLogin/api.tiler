<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2017
 * Time: 19:28
 */

namespace App\Interfaces;


use App\Models\Like;

interface LikeRepositoryInterface
{
    /**
     * return like by user and post
     * @param $post_id
     * @param $user_id
     * @return mixed
     */
    public function getByPostAndUser($post_id, $user_id);

    /**
     * return like by id
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * store like
     * @param array $data
     * @param Like|null $like
     * @return mixed
     * @internal param null $id
     */
    public function store(array $data, Like $like = null);

    /**
     * delete like by id
     * @param $id
     * @return mixed
     */
    public function delete($id);
}