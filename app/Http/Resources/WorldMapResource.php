<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorldMapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'entities' => EntityResource::collection($this->whenLoaded('entities')),
            'relationships' => RelationshipResource::collection($this->whenLoaded('relationships')),
        ];
    }
}
