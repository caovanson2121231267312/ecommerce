<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "avatar" => $this->avatar ?? "images/users/avatar.png",
            "phone_number" => $this->phone_number,
            "note" => $this->note,
            // "dob" => $this->dob ? $this->dob->format('d/m/Y') : null,
            "dob" => $this->dob ? date('d-m-Y', strtotime($this->dob)) : null,
            "status" => $this->status,
            "roles" => RoleResource::collection($this->roles),
            "created_at" => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            "updated_at" => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}