<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends ApiController
{
    private $postService;
    private $postRepository;

    /**
     * PostController constructor.
     * @param PostService $postService
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostService $postService, PostRepositoryInterface $postRepository)
    {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
    }

    /**
     * @SWG\Get(
     *   path="/posts",
     *   summary="Get all posts",
     *   tags={"Posts"},
     *   produces={"application/json"},
     *   @SWG\Response( response=200, description="Success"),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = $this->postRepository->all();

        return response()->json($posts, 200);
    }

    /**
     * @SWG\Post(
     *   path="/posts",
     *   summary="Publish new post",
     *   tags={"Posts"},
     *   produces={"application/json"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter( name="title", description="Title of post", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="text", description="Post's text", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="preview", description="Post's preview", required=false, type="base64", in="formData"),
     *   @SWG\Parameter( name="category_id", description="Post's category id", required=false, type="integer", in="query"),
     *   @SWG\Response( response=201, description="Success create new post"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"jwt_auth":{}}},
     * )
     * @param CreatePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreatePostRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = JWTAuth::parseToken()->authenticate()->id;

        $post = $this->postService->publish($data);

        return response()->json($post->toArray(), 201);
    }
}
