<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'id' => $this->id ?? null,
            'name' => $this->name,
            'roles' => $this->roles_count,
            'users' => $this->users_count,
            'created_at' => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}
