<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2017
 * Time: 19:32
 */

namespace App\Repositories;


use App\Interfaces\LikeRepositoryInterface;
use App\Models\Like;

class MySQLLikeRepository implements LikeRepositoryInterface
{
    /**
     * return like by user and post
     * @param $post_id
     * @param $user_id
     * @return Like
     */
    public function getByPostAndUser($post_id, $user_id)
    {
        return Like::where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->first();
    }

    /**
     * store like
     * @param array $data
     * @param Like|null $like
     * @return Like
     * @throws \Exception
     * @internal param null $id
     */
    public function store(array $data, Like $like = null)
    {
        $like = $like??new Like();

        $like->fill($data);

        if($like->save()){
            return $like;
        }

        throw new \Exception("Couldn't store like");
    }

    /**
     * delete like by id
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return Like::where('id', $id)->delete();
    }

    /**
     * return like by id
     * @param $id
     * @return Like
     */
    public function getById($id)
    {
        return Like::findorfail($id);
    }
}