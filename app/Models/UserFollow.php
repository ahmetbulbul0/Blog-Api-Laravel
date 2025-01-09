<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserFollow extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'author_id'
    ];
}
