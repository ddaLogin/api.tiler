<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return PostResource
     */
    public function index(Request $request)
    {
        $size = $request->get('size', config('common.defaultPostCount'));
        $with = $this->checkRelationsNeed(['user', 'collections', 'categories:id', 'likes.user', 'dislikes.user']);
        $posts = $this->postRepository->getOrderByCreatedAtAndPaginate($size, $with);

        return PostResource::collection($posts->appends($request->all()));
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
     * @return PostResource
     */
    public function show(Post $post)
    {
        $with = $this->checkRelationsNeed(['user', 'categories:id', 'collections', 'likes.user', 'dislikes.user']);
        $post->loadMissing($with);
        return new PostResource($post);
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
     * @param Request $request
     * @param User $user
     * @return PostResource
     */
    public function byUser(Request $request, User $user)
    {
        $size = $request->get('size', config('common.defaultPostCount'));
        $with = $this->checkRelationsNeed(['collections', 'categories:id', 'likes.user', 'dislikes.user']);
        $posts = $this->postRepository->getByUserIdOrderedByCreatedAtAndPaginate($user->id, $size, $with);

        return PostResource::collection($posts->appends($request->all()));
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
     *   @SWG\Parameter( name="preview", description="Post's preview", required=false, type="string", in="formData"),
     *   @SWG\Parameter( name="tags[]", description="Post's tags", required=false, type="array", in="formData", @SWG\Items(type="string"), collectionFormat="multi"),
     *   @SWG\Parameter( name="categories[]", description="Post's categories id", required=false, type="array", @SWG\Items(type="integer"), collectionFormat="multi", in="query"),
     *   @SWG\Parameter( name="collections[]", description="Post's collections id", required=false, type="array", @SWG\Items(type="integer"), collectionFormat="multi", in="query"),
     *   @SWG\Response( response=201, description="Success create new post"),
     *   @SWG\Response( response=403, description="Access denied"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"passport":{}}},
     * )
     * @param CreatePostRequest $request
     * @param User $user
     * @return PostResource
     */
    public function create(CreatePostRequest $request, User $user)
    {
        if (Auth::id() != $user->id){
            return response()->json(trans('app.accessDenied'), 403);
        }

        $data = $request->all();
        $data['user_id'] = $user->id;
        $post = $this->postService->publish($data);

        return new PostResource($post);
    }
}
