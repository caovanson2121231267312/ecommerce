<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'image' => $this->image ? asset('images/products/' . $this->image) : null,
            'description' => $this->description,
            'detail' => $this->detail,
            'note' => $this->note,
            'pivot_quantity' => $this->pivot->quantity,
            'pivot_price' => $this->pivot->price,
            'pivot_sale' => $this->pivot->sale,
            'created_at' => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}
