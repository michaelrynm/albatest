<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cover = $this->getFirstMediaUrl('cover');
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'content'    => $this->content,
            'cover_url'  => $cover ?: null,
            'category'   => new CategoryResource($this->whenLoaded('category')),
            'author'     => new UserResource($this->whenLoaded('author')),
            'created_at' => $this->created_at,
        ];
    }
}
