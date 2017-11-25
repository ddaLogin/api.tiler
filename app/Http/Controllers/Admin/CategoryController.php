<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $categoryRepository;

    /**
     * UserController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * categories page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.category.index', [
            'categories' => $this->categoryRepository->getAllOrderByPublishedPosts(),
        ]);
    }

    /**
     * create category page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.create', [
            'category' => new Category(),
        ]);
    }

    /**
     * edit category page
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.category.create', [
            'category' => $category,
        ]);
    }

    /**
     * store new category
     *
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->categoryRepository->store($request->only('name'));

        return redirect()->route('admin.categories.index');
    }

    /**
     * update category
     *
     * @param Category $category
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Category $category, CreateCategoryRequest $request)
    {
        $this->categoryRepository->store($request->only('name'), $category->id);

        return redirect()->route('admin.categories.index');
    }
}
