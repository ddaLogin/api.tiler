<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.08.2017
 * Time: 19:36
 */

namespace App\Repositories;


use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class MySQLPostRepository implements PostRepositoryInterface
{

    /**
     * return post by id
     *
     * @param int $id
     * @return Post
     */
    public function getById(int $id): Post
    {
        return Post::findorfail($id);
    }

    /**
     * store|update post
     *
     * @param array $data
     * @param int|null $id
     * @return Post
     * @throws \Exception
     */
    public function store(array $data, int $id = null): Post
    {
        $post = ($id)?$this->getById($id):new Post();

        $post->fill($data);

        if($post->save()){
            return $post;
        }

        throw new \Exception("Couldn't store post");
    }
}