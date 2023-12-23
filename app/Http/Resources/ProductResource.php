<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'in_stock' => $this->in_stock,
            'price' => $this->price,
            'price_before' => $this->price_before,
            'has_offer' => $this->has_offer,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'media' => $url,
        ];
    }
}
