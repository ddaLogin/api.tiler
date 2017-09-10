<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
     * @SWG\Get(
     *   path="/posts/{post_id}",
     *   summary="Post detail",
     *   tags={"Posts"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="post_id", description="Post id", required=true, type="string", in="path"),
     *   @SWG\Response( response=200, description="Success get post detail"),
     * )
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json($post->toArray(), 200);
    }

    /**
     * @SWG\Get(
     *   path="/users/{user_id}/posts",
     *   summary="Get posts by user",
     *   tags={"Posts"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="user_id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Response( response=200, description="Success get post detail"),
     * )
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function byUser(User $user)
    {
        $posts = $this->postRepository->getByUserId($user->id);

        return response()->json($posts->toArray(), 200);
    }

    /**
     * @SWG\Post(
     *   path="/users/{user_id}/posts",
     *   summary="Publish new post",
     *   tags={"Posts"},
     *   produces={"application/json"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter( name="user_id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="title", description="Title of post", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="text", description="Post's text", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="preview", description="Post's preview", required=false, type="base64", in="formData"),
     *   @SWG\Parameter( name="category_id", description="Post's category id", required=false, type="integer", in="query"),
     *   @SWG\Response( response=201, description="Success create new post"),
     *   @SWG\Response( response=403, description="Access denied"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"jwt_auth":{}}},
     * )
     * @param CreatePostRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreatePostRequest $request, User $user)
    {
        if (JWTAuth::parseToken()->authenticate()->id != $user->id){
            throw new AccessDeniedHttpException();
        }

        $data = $request->all();
        $data['user_id'] = $user->id;
        $post = $this->postService->publish($data);

        return response()->json($post->toArray(), 201);
    }
}
