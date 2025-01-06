<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'users' => UserResource::collection($this->whenLoaded('users')),
            'usersCount' => $this->users_count,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
