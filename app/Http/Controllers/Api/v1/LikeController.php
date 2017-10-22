<?php

namespace App\http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ToggleLikeRequest;
use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends ApiController
{
    private $likeService;

    /**
     * LikeController constructor.
     * @param LikeService $likeService
     */
    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * @SWG\Put(
     *   path="/posts/{post_id}/likes",
     *   summary="Toggle like",
     *   tags={"Likes"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="post_id", description="Post id", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="status", description="Like = 1 Dislike = 0", required=true, type="number", in="query"),
     *   @SWG\Response( response=200, description="Success toggle like"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"passport":{}}},
     * )
     * @param ToggleLikeRequest $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(ToggleLikeRequest $request, Post $post)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['post_id'] = $post->id;

        $like = $this->likeService->toggle($data);
        if(!is_int($like)){
            return response()->json($like->toArray(), 200);
        } else {
            return response()->json([], 200);
        }
    }
}
