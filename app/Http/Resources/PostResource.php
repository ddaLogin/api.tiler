<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Post $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'published' => $this->published,
            'preview' => $this->preview,
            'tags' => $this->tags,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'user_id' => $this->user_id,
            $this->mergeWhen($this->relationLoaded('user'), [
                'user' => $this->user
            ]),
            $this->mergeWhen($this->relationLoaded('categories'), [
                'categories' => $this->categories->pluck('id')
            ]),
            $this->mergeWhen($this->relationLoaded('collections'), [
                'collections' => CollectionResource::collection($this->collections)
            ]),
            $this->mergeWhen($this->relationLoaded('likes'), [
                'likes' => LikeResource::collection($this->likes)
            ]),
            $this->mergeWhen($this->relationLoaded('dislikes'), [
                'dislikes' => LikeResource::collection($this->dislikes)
            ])
        ];
    }
}
