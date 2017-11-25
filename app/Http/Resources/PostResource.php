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

        $relation = $request->get('relations', 1);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'preview' => $this->preview,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'user_id' => $this->user_id,
            $this->mergeWhen($relation, [
                'user' => $this->user,
                'categories' => $this->categories->pluck('id'),
                'collections' => CollectionResource::collection($this->collections),
                'likes' => LikeResource::collection($this->likes),
                'dislikes' => LikeResource::collection($this->dislikes)
            ])
        ];
    }
}
