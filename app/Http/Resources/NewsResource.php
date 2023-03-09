<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Utilities\GetAttributesFromRequest;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $r_attributes = GetAttributesFromRequest::data($request);

        $default_attributes = array_merge(
            config('parser.news_attributes'),
            config('parser.news_relations')
        );

        $attributes = !empty($r_attributes)
            ? array_intersect($r_attributes, $default_attributes)
            : $default_attributes;

        $data = [];
        foreach ($attributes as $attribute) {
            $data[$attribute] = match($attribute) {
                'authors' => $this->authors->count() > 0 ? $this->authors->pluck('name') : null,
                'image' =>  $this->image ? url(config('parser.images_path') . $this->image->name) : null,
                'category' => $this->category->name,
                default => $this->$attribute
            };
        }

        return array_filter($data, fn ($attribute) => $attribute);
    }
}
