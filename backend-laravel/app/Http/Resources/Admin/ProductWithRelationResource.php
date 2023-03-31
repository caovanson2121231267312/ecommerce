<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\TagResource;
use App\Http\Resources\Admin\ImageResource;

class ProductWithRelationResource extends JsonResource
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
            'images' => $this->images,
            'description' => $this->description,
            'content' => $this->content,
            'sale' => $this->sale,
            'time_sale' => $this->time_sale,
            'quantity' => $this->quantity,
            'rates_count' => $this->rates_count,
            'status' => $this->status,
            'avg_rate' => round($this->avg_rate, 1),
            'created_at' => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
            'tags' => TagResource::collection($this->tags),
            'product_detail' => ProductDetailResource::collection($this->details),
            'category' => new CategoryResource($this->category),
            'brand' => new BrandResource($this->brand),
            'user' => $this->user,
        ];
    }
}