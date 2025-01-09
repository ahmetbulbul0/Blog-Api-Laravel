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
    const READER = 'reader';

    // Varsayılan rol açıklamaları
    const ROLE_DESCRIPTIONS = [
        self::ADMIN => 'Tüm platform ayarlarını yönetebilir ve tam yetkiye sahiptir.',
        self::AUTHOR => 'Blog yazıları paylaşabilir ve kendi yazılarına gelen yorumları yönetebilir.',
        self::READER => 'Yazarları takip edebilir ve blog yazılarına yorum yapabilir.'
    ];

    // Rol kontrol metodları
    public function isAdmin()
    {
        return $this->name === self::ADMIN;
    }

    public function isAuthor()
    {
        return $this->name === self::AUTHOR;
    }

    public function isReader()
    {
        return $this->name === self::READER;
    }

    // Varsayılan rolleri oluşturmak için kullanılacak metod
    public static function createDefaultRoles()
    {
        foreach (self::ROLE_DESCRIPTIONS as $roleName => $description) {
            self::firstOrCreate(
                ['name' => $roleName],
                ['description' => $description]
            );
        }
    }
}
