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
use Illuminate\Database\Eloquent\Collection;

class MySQLPostRepository implements PostRepositoryInterface
{

    /**
     * return post by id
     *
     * @param int $id
     * @param array $with
     * @return Post
     */
    public function getById(int $id, array $with = [])
    {
        return Post::findorfail($id)->with($with);
    }

    /**
     * store|update post
     *
     * @param array $data
     * @param int|null $id
     * @return Post
     * @throws \Exception
     */
    public function store(array $data, int $id = null)
    {
        $post = ($id)?$this->getById($id):new Post();

        $post->fill($data);

        if($post->save()){

            if(key_exists('collections', $data)){
                $post->collections()->sync($data['collections']);
            }

            if(key_exists('categories', $data)){
                $post->categories()->sync($data['categories']);
            }

            return $post;
        }

        throw new \Exception("Couldn't store post");
    }

    /**
     * return all posts
     *
     * @param array $with
     * @return Collection
     */
    public function all(array $with = [])
    {
        return Post::with($with)->get();
    }

    /**
     * return all posts by user id
     *
     * @param $user_id
     * @param array $with
     * @return Collection
     */
    public function getByUserId($user_id, array $with = [])
    {
        return Post::where('user_id', $user_id)->with($with)->get();
    }

    /**
     * return posts ordered by created date and paginate
     *
     * @param $size
     * @param array $with
     * @return Collection
     */
    public function getOrderByCreatedAtAndPaginate($size, array $with = [])
    {
        return Post::orderBy('created_at', 'DESC')->with($with)->paginate($size);
    }

    /**
     * return all posts by user id
     *
     * @param $user_id
     * @param $size
     * @param array $with
     * @return Collection
     */
    public function getByUserIdOrderedByCreatedAtAndPaginate($user_id, $size, array $with = [])
    {
        return Post::where('user_id', $user_id)->orderBy('created_at', 'DESC')->with($with)->paginate($size);
    }
}