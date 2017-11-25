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
     * store|update category
     *
     * @param array $data
     * @param int|null $id
     * @return Category
     * @throws \Exception
     */
    public function store(array $data, int $id = null)
    {
        $category = ($id)?$this->getById($id):new Category();

        $category->fill($data);

        if($category->save()){
            return $category;
        }

        throw new \Exception("Couldn't store category");
    }

    /**
     * return all categories
     *
     * @return Collection
     */
    public function getAll()
    {
        return Category::all();
    }

    /**
     * return all categories order by published posts with count of published posts
     * @return Collection
     */
    public function getAllOrderByPublishedPosts()
    {
        return Category::withCount('posts')->orderBy('posts_count', 'DESC')->get();
    }
}