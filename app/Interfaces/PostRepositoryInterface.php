<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.08.2017
 * Time: 19:34
 */

namespace App\Interfaces;


use App\Models\Post;

interface PostRepositoryInterface
{
    /**
     * return post by id
     *
     * @param int $id
     * @return Post
     */
    public function getById(int $id):Post;

    /**
     * store|update post
     *
     * @param array $data
     * @param int|null $id
     * @return Post
     */
    public function store(array $data, int $id = null):Post;
}