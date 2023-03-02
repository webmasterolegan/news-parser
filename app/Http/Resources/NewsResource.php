<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attributes = $request['attributes'] ? explode(',', $request['attributes']) : null;

        $data = array_filter([
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'published_at' => $this->published_at,
            'authors' => $this->authors->count() > 0
                ? $this->authors->pluck('name')
                : null,
            'image' =>  $this->image
                ? url('images/' . $this->image->name)
                : null,
        ], fn ($attribute) => $attribute);

        return !$attributes ? $data : Arr::only($data, $attributes);
    }
}
