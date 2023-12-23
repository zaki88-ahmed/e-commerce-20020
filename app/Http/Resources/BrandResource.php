<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = [];
        foreach ($this->medias as $media){
            $url[] = new MediaResource($media);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'media' => $url,
        ];
    }
}
