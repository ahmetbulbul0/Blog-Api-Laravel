<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "role_id",
        "first_name",
        "last_name",
        "username",
        "email",
        "email_verified_at",
        "password",
        "profile_picture",
        "occupation",
        "date_of_birth",
        "location",
        "preferred_language",
        "gender",
        "bio",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'user_interests');
    }

    public function followedAuthors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'author_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'author_id', 'follower_id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role->name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isAuthor(): bool
    {
        return $this->hasRole(Role::AUTHOR);
    }

    public function isReader(): bool
    {
        return $this->hasRole(Role::READER);
    }
}
