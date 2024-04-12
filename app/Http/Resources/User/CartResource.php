<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'amount_in_cents' => $this->amount_in_cents,
            'formatted_amount' => $this->formatted_amount,
            'quantity' => $this->quantity,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'user' => JsonResource::make($this->whenLoaded('user'))
        ];
    }
}
