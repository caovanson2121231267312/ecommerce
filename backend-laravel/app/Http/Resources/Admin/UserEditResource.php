<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
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
            "avatar" => $this->avatar  ? 'images/users/' . $this->avatar : "images/users/avatar.png",
            "phone_number" => $this->phone_number,
            "note" => $this->note,
            "gender" => $this->gender,
            "dob" => $this->dob ? date('Y-m-y', strtotime($this->dob)) : null,
            "status" => $this->status,
            "roles" => RoleResource::collection($this->roles),
            "permissions" => PermissionResource::collection($this->permissions),
            "created_at" => $this->created_at ? $this->created_at->format('H:i:s d/m/Y') : null,
            "updated_at" => $this->updated_at ? $this->updated_at->format('H:i:s d/m/Y') : null,
        ];
    }
}
