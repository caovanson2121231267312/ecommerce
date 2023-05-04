<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'card_name' => $this->card_name,
            'card_number' => $this->card_number,
            'qr' => $this->qr ?? null,
            'user_name' => $this->user_name ?? null,
            'phone_number' => $this->phone_number,
            'hash' => $this->hash,
            'created_at' => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}
