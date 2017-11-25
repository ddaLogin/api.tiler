<?php

namespace App\Http\Resources;

use App\Models\Collection;
use Illuminate\Http\Resources\Json\Resource;

class CollectionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
