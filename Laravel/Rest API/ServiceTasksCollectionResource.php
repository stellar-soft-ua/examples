<?php

namespace App\Http\Resources\Services;

use App\Http\Resources\Traits\WithResponseTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceTasksCollectionResource extends ResourceCollection
{
    use WithResponseTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ServiceJobTasksResource::collection($this->collection),
        ];
    }
}
