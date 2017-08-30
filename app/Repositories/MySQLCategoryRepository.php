<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.08.2017
 * Time: 17:23
 */

namespace App\Repositories;


use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class MySQLCategoryRepository implements CategoryRepositoryInterface
{
    /**
     * return category by id
     *
     * @param int $id
     * @return Category
     */
    public function getById(int $id)
    {
        return Category::findorfail($id);
    }

    /**
     * return all categories
     *
     * @return Collection
     */
    public function all()
    {
        return Category::all();
    }
}