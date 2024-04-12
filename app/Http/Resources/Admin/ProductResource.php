<?php

namespace App\Http\Resources\Admin;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_in_cents' => $this->price_in_cents,
            'formatted_price' => $this->formatted_price,
            'created_at' => $this->created_at,

            'photos' => JsonResource::make($this->whenLoaded('photos'))
        ];
    }
}
