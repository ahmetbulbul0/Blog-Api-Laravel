<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Rol sabitleri
    const ADMIN = 'admin';
    const AUTHOR = 'author';
    const VISITOR = 'visitor';

    // Rol kontrol metodları
    public function isAdmin()
    {
        return $this->name === self::ADMIN;
    }

    public function isAuthor()
    {
        return $this->name === self::AUTHOR;
    }

    public function isVisitor()
    {
        return $this->name === self::VISITOR;
    }
}
