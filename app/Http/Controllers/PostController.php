<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends ApiController
{
    private $postService;

    /**
     * PostController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
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
     *   @SWG\Parameter( name="preview", description="Post's preview", required=false, type="file", in="formData"),
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
