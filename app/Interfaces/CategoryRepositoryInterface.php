<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 14:02
 */

namespace App\Interfaces;


use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    /**
     * return category by id
     *
     * @param int $id
     * @return Category
     */
    public function getById(int $id);

    /**
     * store|update category
     *
     * @param array $data
     * @param int|null $id
     * @return Category
     */
    public function store(array $data, int $id = null);

    /**
     * return all categories
     *
     * @return Collection
     */
    public function getAll();

    /**
     * return all categories order by published posts with count of published posts
     * @return Collection
     */
    public function getAllOrderByPublishedPosts();
}