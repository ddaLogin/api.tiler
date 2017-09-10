<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.09.2017
 * Time: 13:57
 */

namespace App\Interfaces;


use App\Models\Collection;

interface CollectionRepositoryInterface
{
    /**
     * return collection by id
     *
     * @param int $id
     * @return Collection
     */
    public function getById(int $id);

    /**
     * return all user's collections
     *
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function byUser($user_id);

    /**
     * store|update collection
     *
     * @param array $data
     * @param int|null $id
     * @return Collection
     */
    public function store(array $data, int $id = null);
}