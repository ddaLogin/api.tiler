<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.09.2017
 * Time: 14:04
 */

namespace App\Repositories;


use App\Interfaces\CollectionRepositoryInterface;
use App\Models\Collection;

class MySQLCollectionRepository implements CollectionRepositoryInterface
{

    /**
     * return collection by id
     *
     * @param int $id
     * @return Collection
     */
    public function getById(int $id)
    {
        return Collection::findorfail($id);
    }

    /**
     * return all user's collections
     *
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function byUser($user_id)
    {
        return Collection::where('user_id', $user_id)->get();
    }

    /**
     * store|update collection
     *
     * @param array $data
     * @param int|null $id
     * @return Collection
     * @throws \Exception
     */
    public function store(array $data, int $id = null)
    {
        $collection = ($id)?$this->getById($id):new Collection();

        $collection->fill($data);

        if($collection->save()){
            return $collection;
        }

        throw new \Exception("Couldn't store collection");
    }
}