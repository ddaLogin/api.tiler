<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    private $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @SWG\Get(
     *   path="/categories",
     *   summary="Get all categories",
     *   tags={"Categories"},
     *   produces={"application/json"},
     *   @SWG\Response( response=200, description="Success"),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all();

        return response()->json($categories, 200);
    }
}
