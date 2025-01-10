<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "roleId" => $this->role_id,
            "firstName" => Str::title($this->first_name),
            "lastName" => Str::title($this->last_name),
            "username" => $this->username,
            "email" => $this->email,
            "profilePicture" => $this->profile_picture,
            "occupation" => Str::title($this->occupation),
            "dateOfBirth" => $this->date_of_birth,
            "location" => $this->location,
            "preferredLanguage" => $this->preferred_language,
            "gender" => $this->gender,
            "bio" => $this->bio,

            'role' => new RoleResource($this->whenLoaded('role')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
