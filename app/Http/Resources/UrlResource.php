<?php

namespace App\Http\Resources;

use App\Models\Url;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{

    public function toArray($request): array
    {
        /** @var Url $item */
        $item = $this->resource;


        return [
            'destination' => $item->destination,
            'slug' => $item->slug,
            'update_at' => $item->updated_at,
            'created_at' => $item->created_at,
            'id' => $item->id,
            'shortened_url' => $item->shortened_url
        ];
    }
}
