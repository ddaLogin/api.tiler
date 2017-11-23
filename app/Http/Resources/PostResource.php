<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    /** @var Post $this */

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
            'preview' => $this->preview,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'user_id' => $this->user_id,
            'user' => $this->user,
            'categories' => $this->categories->pluck('id'),
            'collections' => CollectionResource::collection($this->collections),
            'likes' => LikeResource::collection($this->likes),
            'dislikes' => LikeResource::collection($this->dislikes)
        ];
    }
}
