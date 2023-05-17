<?php

namespace App\Http\Resources\Admin;

use App\Enums\StatusOrder;
use App\Enums\StatusPayment;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'quantity' => $this->quantity ?? 0,
            'products_count' => $this->products_count,
            'note' => $this->note,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'ip_address' => $this->ip_address,
            'ref' => $this->ref,
            'card' => $this->card,
            'status' => $this->status,
            'products' => ProductResource::collection($this->products),
            'status_order_description' => StatusOrder::getDescription($this->status),
            'status_payment' => $this->status_payment,
            'status_payment_description' => StatusPayment::getDescription($this->status_payment),
            'created_at' => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}
