<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.08.2017
 * Time: 19:34
 */

namespace App\Interfaces;


use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    /**
     * return post by id
     *
     * @param int $id
     * @param array $with
     * @return Post
     */
    public function getById(int $id, array $with = []);

    /**
     * store|update post
     *
     * @param array $data
     * @param int|null $id
     * @return Post
     */
    public function store(array $data, int $id = null);

    /**
     * return all posts
     *
     * @param array $with
     * @return Collection
     */
    public function all(array $with = []);

    /**
     * return all posts by user id
     *
     * @param $user_id
     * @param array $with
     * @return Collection
     */
    public function getByUserId($user_id, array $with = []);

    /**
     * return posts ordered by created date and paginate
     *
     * @param $size
     * @param array $with
     * @return Collection
     */
    public function getOrderByCreatedAtAndPaginate($size, array $with = []);

    /**
     * return all posts by user id
     *
     * @param $user_id
     * @param $size
     * @param array $with
     * @return Collection
     */
    public function getByUserIdOrderedByCreatedAtAndPaginate($user_id, $size, array $with = []);
}